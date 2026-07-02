# Ultimatum Finesse — Redesign Concept

A redesign concept for [ultimatumfinesse.co.bw](https://ultimatumfinesse.co.bw), a Gaborone, Botswana geospatial services company (GIS, aerial & mobile LiDAR, 3D laser scanning, BIM, aerial photography/photogrammetry, surveying & mapping).

Built as a portfolio/demo piece — plain HTML/CSS/JS, no build step, no framework.

## Pages

- `index.html` — home
- `about.html` — company story, values, process
- `services.html` — the six service disciplines in detail
- `projects.html` — an interactive Leaflet map of sample project sites across Botswana, filterable by service category
- `insights.html` — field-notes style content hub
- `contact.html` — contact details, form, office map

## Notes

- Real service photography and client logos are sourced from the live site to ground the concept in the company's actual work.
- The interactive map (`js/map.js`) uses free OpenStreetMap/CARTO tiles — no API key required. Project site coordinates are illustrative sample data, not exact survey locations.
- The contact form is front-end only; it does not submit anywhere.

## Running locally

No build step — open `index.html` directly, or serve the folder with any static file server, e.g.:

```
python -m http.server 8000
```
