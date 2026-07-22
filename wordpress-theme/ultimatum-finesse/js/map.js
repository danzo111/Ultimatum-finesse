// Interactive Leaflet map of Ultimatum Finesse project sites across Botswana.
// Free Esri World Imagery satellite tiles, no API key required.
// Project data is bundled in the theme as JSON (assets/data/projects.json)
// and fetched at runtime rather than hardcoded here, so it's editable
// without touching this file. Pin locations are approximate (town/site level).

const UF_CATEGORIES = {
  lidar: { label: "LiDAR & Dam Surveys", color: "#e8930c" },
  survey: { label: "Surveying & Mapping", color: "#0891b2" },
  photo: { label: "Aerial & Photogrammetry", color: "#e11d48" },
  gis: { label: "Data Processing & GIS", color: "#81ad1c" },
};

let UF_PROJECTS = [];
const ufProjectsCache = {};

function ufMarkerIcon(color) {
  return L.divIcon({
    className: "uf-marker",
    html: `<span style="
      display:block;width:16px;height:16px;border-radius:50%;
      background:${color};border:3px solid #fff;
      box-shadow:0 2px 8px rgba(11,20,5,0.35);"></span>`,
    // Container is larger than the visible dot so the tap/click target
    // meets the WCAG 2.5.8 minimum (24x24px); the dot stays centered inside it.
    iconSize: [26, 26],
    iconAnchor: [13, 13],
    popupAnchor: [0, -14],
  });
}

function loadUfProjects(dataUrl) {
  if (ufProjectsCache[dataUrl]) return ufProjectsCache[dataUrl];
  ufProjectsCache[dataUrl] = fetch(dataUrl)
    .then((res) => res.json())
    .then((data) => {
      UF_PROJECTS = data;
      return data;
    });
  return ufProjectsCache[dataUrl];
}

/**
 * Initialise a Leaflet map inside `elId`.
 * options.interactive = false renders a lightweight non-scrollzoom preview (used in the hero).
 * options.filters = id of a filter-button container, wires up category filtering.
 * options.dataUrl = URL to the projects.json file (required; passed from PHP via wp_localize_script).
 */
async function initUfMap(elId, options = {}) {
  const el = document.getElementById(elId);
  if (!el || typeof L === "undefined") return null;

  const map = L.map(elId, {
    scrollWheelZoom: options.interactive !== false,
    zoomControl: options.interactive !== false,
    dragging: options.interactive !== false || !L.Browser.mobile,
    attributionControl: options.interactive !== false,
  }).setView(options.center || [-22.5, 25.0], options.zoom || 5.6);

  L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
    attribution: "Tiles &copy; Esri",
    maxZoom: 19,
  }).addTo(map);

  L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}", {
    maxZoom: 19,
  }).addTo(map);

  const projects = options.dataUrl ? await loadUfProjects(options.dataUrl) : UF_PROJECTS;

  const markers = {};
  projects.forEach((p) => {
    const cat = UF_CATEGORIES[p.category];
    const marker = L.marker(p.coords, {
      icon: ufMarkerIcon(cat.color),
      alt: `${p.name} project marker`,
    }).addTo(map);
    const markerEl = marker.getElement();
    if (markerEl) markerEl.setAttribute("aria-label", `${p.name}, ${p.place}`);
    const statusTag = p.status
      ? `<span style="display:inline-block;background:#81ad1c;color:#fff;font-size:10px;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;padding:2px 8px;border-radius:999px;margin-bottom:5px;">${p.status}</span><br>`
      : "";
    marker.bindPopup(`
      <div class="popup-card">
        ${statusTag}<span class="cat" style="color:${cat.color}">${cat.label}</span>
        <h4>${p.name}</h4>
        <p>${p.place}, Botswana &mdash; ${p.desc}</p>
      </div>
    `);
    marker.categoryKey = p.category;
    markers[p.name] = marker;
  });

  if (options.filters) {
    const bar = document.getElementById(options.filters);
    if (bar) {
      bar.addEventListener("click", (e) => {
        const btn = e.target.closest("[data-filter]");
        if (!btn) return;
        bar.querySelectorAll("[data-filter]").forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        const filter = btn.dataset.filter;
        Object.values(markers).forEach((marker) => {
          if (filter === "all" || marker.categoryKey === filter) {
            map.addLayer(marker);
          } else {
            map.removeLayer(marker);
          }
        });
      });
    }
  }

  return map;
}
