// Interactive Leaflet map of Ultimatum Finesse project sites across Botswana.
// Free OpenStreetMap/CARTO tiles — no API key required.
// Projects sourced from the Ultimatum Finesse Company Profile 2026 and current
// works advised by the company; pin locations are approximate (town/site level).

const UF_CATEGORIES = {
  lidar: { label: "LiDAR & Dam Surveys", color: "#e8930c" },
  survey: { label: "Surveying & Mapping", color: "#0891b2" },
  photo: { label: "Aerial & Photogrammetry", color: "#e11d48" },
  gis: { label: "Data Processing & GIS", color: "#81ad1c" },
};

const UF_PROJECTS = [
  {
    name: "Lotsane Dam & River LiDAR Survey",
    place: "Maunatlala",
    coords: [-22.68, 27.43],
    category: "lidar",
    status: "Ongoing",
    desc: "LiDAR scanning and surveying of Lotsane Dam and 30 km of the river downstream.",
  },
  {
    name: "Gaborone Dam & River LiDAR Survey",
    place: "Gaborone",
    coords: [-24.7167, 25.9167],
    category: "lidar",
    status: "Ongoing",
    desc: "LiDAR scanning and surveying of Gaborone Dam and 25 km of the river downstream.",
  },
  {
    name: "Phokojwe–Kazungula Powerline Survey",
    place: "Kazungula",
    coords: [-17.85, 25.2],
    category: "survey",
    desc: "Cadastral and infrastructure survey of the proposed 754 km powerline at 500 m intervals, 2023–2024, for Geoflux.",
  },
  {
    name: "Kanye Water Network & Pipelines",
    place: "Kanye",
    coords: [-24.9833, 25.3333],
    category: "survey",
    desc: "QA/QC surveying during the water network emergency works (2023–2024); 64.6 km pipeline corridor topo and reservoir bottom-level surveys, for Geoflux.",
  },
  {
    name: "Moshupa Feeder Pipeline Survey",
    place: "Moshupa",
    coords: [-24.7667, 25.4167],
    category: "survey",
    desc: "Topographic survey of 37.6 km of supply and feeder pipelines on a 50 m corridor (2019), for Geoflux.",
  },
  {
    name: "Karowe Mine Aerial Survey",
    place: "Letlhakane",
    coords: [-21.51, 25.48],
    category: "photo",
    desc: "Aerial survey of the full Lucara Karowe mine lease, aerial control network, and levelling of 10 in-pit benchmarks.",
  },
  {
    name: "BUAN Master Plan Topographic Survey",
    place: "Sebele, Gaborone",
    coords: [-24.5667, 25.9333],
    category: "survey",
    desc: "371 Ha topographic survey for the Botswana University of Agriculture & Natural Resources master plan (2022–2023), for Urban Heights.",
  },
  {
    name: "Serowe–Tshikinyega Cadastral Survey",
    place: "Serowe",
    coords: [-22.3875, 26.7108],
    category: "survey",
    desc: "Cadastral survey of 279 plots (2023), for Stet Surveying.",
  },
  {
    name: "Gantsi SEZA Topographic Survey",
    place: "Ghanzi",
    coords: [-21.6986, 21.6458],
    category: "photo",
    desc: "700 Ha drone topographic survey behind Gantsi airport, with Trail Surveys.",
  },
  {
    name: "Lobatse SEZA Topographic Survey",
    place: "Lobatse",
    coords: [-25.2167, 25.6833],
    category: "survey",
    desc: "350 Ha topographic survey of the Lobatse Special Economic Zone site, for Geosurv.",
  },
  {
    name: "Shakawe Solar Power Survey",
    place: "Shakawe",
    coords: [-18.3667, 21.85],
    category: "survey",
    desc: "10 Ha topographic survey for the Shakawe solar power site, for Geosurv.",
  },
  {
    name: "Kanye Junction–Jwaneng Road Surveys",
    place: "Jwaneng",
    coords: [-24.6017, 24.7281],
    category: "photo",
    desc: "Aerial surveys for the 72.57 km output & performance-based road contract, plus the Seherelela, Sesung and Sese borrow pits, with Asphalt.",
  },
  {
    name: "Mathathane–Platjan Road Project",
    place: "Mathathane",
    coords: [-22.3, 28.72],
    category: "gis",
    desc: "30 km road project consultation (2023, Champs Botswana) with drone data processing and CAD drafting alongside Trail Surveys.",
  },
  {
    name: "Drone Data Processing & CAD Drafting",
    place: "Palapye / Morupule",
    coords: [-22.5461, 27.1256],
    category: "gis",
    desc: "Drone data processing and CAD drafting across Morupule, Lentsweletau–Medie and Mapoka road designs, with Trail Surveys.",
  },
  {
    name: "Gamodubu Pipeline Corridor Survey",
    place: "Gamodubu",
    coords: [-24.53, 25.67],
    category: "survey",
    desc: "Topographic survey of the proposed 5 km pipeline on a 200 m wide corridor, for Envirosolve.",
  },
  {
    name: "Otse & Manong Lodge Orthophoto Mapping",
    place: "Otse",
    coords: [-25.0167, 25.7333],
    category: "photo",
    desc: "Orthophoto mapping for planning: Manong Lodge (15 Ha) and farm properties at Otse (40 Ha), for J.S Planning.",
  },
];

function ufMarkerIcon(color) {
  return L.divIcon({
    className: "uf-marker",
    html: `<span style="
      display:block;width:16px;height:16px;border-radius:50%;
      background:${color};border:3px solid #fff;
      box-shadow:0 2px 8px rgba(11,20,5,0.35);"></span>`,
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
  }).setView(options.center || [-22.5, 25.0], options.zoom || 5.6);

  L.tileLayer("https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png", {
    attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
    subdomains: "abcd",
    maxZoom: 19,
  }).addTo(map);

  const markers = {};
  UF_PROJECTS.forEach((p) => {
    const cat = UF_CATEGORIES[p.category];
    const marker = L.marker(p.coords, { icon: ufMarkerIcon(cat.color) }).addTo(map);
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
