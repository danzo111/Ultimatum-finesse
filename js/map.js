// Interactive Leaflet map of sample project sites across Botswana.
// Free OpenStreetMap tiles — no API key required. Illustrative sample data for demo purposes.

const UF_CATEGORIES = {
  gis: { label: "GIS Applications", color: "#17b892" },
  lidar: { label: "Aerial & Mobile LiDAR", color: "#f5a524" },
  scan3d: { label: "3D Laser Scanning", color: "#8b5cf6" },
  bim: { label: "Building Information Modelling", color: "#3b82f6" },
  photo: { label: "Aerial Photography & Photogrammetry", color: "#f43f5e" },
  survey: { label: "Surveying & Mapping", color: "#06b6d4" },
};

const UF_PROJECTS = [
  {
    name: "Corporate Park Utility Network Mapping",
    place: "Gaborone",
    coords: [-24.6282, 25.9231],
    category: "gis",
    desc: "Full underground utility GIS dataset for a commercial business park, integrated into a live asset register.",
  },
  {
    name: "Transmission Corridor LiDAR Survey",
    place: "Francistown",
    coords: [-21.1670, 27.5084],
    category: "lidar",
    desc: "Powerline corridor scanned by aerial LiDAR to flag vegetation encroachment and sag clearance risk.",
  },
  {
    name: "Okavango Delta Flood Mapping",
    place: "Maun",
    coords: [-19.9953, 23.4162],
    category: "lidar",
    desc: "Seasonal catchment and flood-extent mapping across delta channels using drone-mounted LiDAR.",
  },
  {
    name: "Riverfront Topographic Survey",
    place: "Kasane",
    coords: [-17.8145, 25.1547],
    category: "survey",
    desc: "Static and RTK topographic survey of the Chobe riverfront ahead of a lodge development.",
  },
  {
    name: "Open-Pit Volume Calculation Scan",
    place: "Selebi-Phikwe",
    coords: [-21.9786, 27.8493],
    category: "scan3d",
    desc: "3D high-definition laser scanning used to calculate monthly extraction volumes to survey-grade accuracy.",
  },
  {
    name: "Industrial Facility As-Built BIM",
    place: "Palapye",
    coords: [-22.5497, 27.1281],
    category: "bim",
    desc: "Point cloud to as-built BIM conversion for facilities management and future renovation planning.",
  },
  {
    name: "Rangeland Aerial Photogrammetry",
    place: "Ghanzi",
    coords: [-21.6944, 21.6339],
    category: "photo",
    desc: "Orthomosaic and 3D terrain model generated from aerial photography for precision agriculture planning.",
  },
  {
    name: "Mine Infrastructure Audit",
    place: "Jwaneng",
    coords: [-24.6019, 24.7256],
    category: "gis",
    desc: "Infrastructure geospatial audit mapping assets, access roads and drainage across the concession.",
  },
];

function ufMarkerIcon(color) {
  return L.divIcon({
    className: "uf-marker",
    html: `<span style="
      display:block;width:16px;height:16px;border-radius:50%;
      background:${color};border:3px solid #fff;
      box-shadow:0 2px 8px rgba(6,13,26,0.35);"></span>`,
    iconSize: [16, 16],
    iconAnchor: [8, 8],
    popupAnchor: [0, -10],
  });
}

/**
 * Initialise a Leaflet map inside `elId`.
 * options.interactive = false renders a lightweight non-scrollzoom preview (used in the hero).
 * options.filters = true adds category filter buttons wired to `filterBarId`.
 */
function initUfMap(elId, options = {}) {
  const el = document.getElementById(elId);
  if (!el || typeof L === "undefined") return null;

  const map = L.map(elId, {
    scrollWheelZoom: options.interactive !== false,
    zoomControl: options.interactive !== false,
    dragging: options.interactive !== false || !L.Browser.mobile,
    attributionControl: options.interactive !== false,
  }).setView(options.center || [-22.3, 24.5], options.zoom || 5.6);

  L.tileLayer("https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png", {
    attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
    subdomains: "abcd",
    maxZoom: 19,
  }).addTo(map);

  const markers = {};
  UF_PROJECTS.forEach((p) => {
    const cat = UF_CATEGORIES[p.category];
    const marker = L.marker(p.coords, { icon: ufMarkerIcon(cat.color) }).addTo(map);
    marker.bindPopup(`
      <div class="popup-card">
        <span class="cat" style="color:${cat.color}">${cat.label}</span>
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
