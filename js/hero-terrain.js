// Animated 3D contour-line backdrop for the homepage hero.
// This is a real 3D topographic model: the same concentric, irregular
// contour rings a printed elevation map would show, except each ring is
// stacked at its own physical height instead of flattened onto one plane
// -- the way a laser-cut layered contour model, or a GIS 3D contour
// view, actually looks. Coloured in Botswana's flag palette (black, sky
// blue, white) as a hypsometric tint: low rings dark, high rings light.
import * as THREE from "https://unpkg.com/three@0.160.0/build/three.module.js";

(function initHeroTerrain() {
  try {
    const canvas = document.getElementById("hero-3d");
    const heroSection = document.querySelector(".hero");
    if (!canvas || !heroSection) return;

    // Feature-detect WebGL on a throwaway canvas -- never call getContext()
    // on the real canvas before handing it to THREE.WebGLRenderer, since a
    // canvas can only ever bind one context for its lifetime, and the
    // renderer creating its own fails if a test call already claimed one.
    const supportsWebGL = (() => {
      try {
        const probe = document.createElement("canvas");
        return !!(probe.getContext("webgl2") || probe.getContext("webgl"));
      } catch (e) {
        return false;
      }
    })();
    if (!supportsWebGL) return;

    // Skip the render loop on small/low-power viewports -- protects battery
    // and the Lighthouse performance budget this site has been tuned for.
    // The CSS gradient already set on .hero covers this case visually.
    if (window.matchMedia("(max-width: 760px)").matches) return;

    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    const BOTSWANA_BLUE = 0x6ea8d8;
    const BOTSWANA_BLACK = 0x0a0e14;
    const BOTSWANA_WHITE = 0xf2f5f9;

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(BOTSWANA_BLUE);
    scene.fog = new THREE.Fog(BOTSWANA_BLUE, 18, 46);

    const camera = new THREE.PerspectiveCamera(40, 1, 0.1, 100);
    camera.position.set(0, 4.4, 15);
    camera.lookAt(0, 1.8, -3);

    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.6));

    // Deterministic seeded RNG (mulberry32) -- same ring shapes every load,
    // ported from the same "sum of sines" wobble used for the flat contour
    // artwork on the inner-page heroes, so the two feel like one family.
    function mulberry32(seed) {
      let a = seed;
      return function () {
        a |= 0;
        a = (a + 0x6d2b79f5) | 0;
        let t = Math.imul(a ^ (a >>> 15), 1 | a);
        t = (t + Math.imul(t ^ (t >>> 7), 61 | t)) ^ t;
        return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
      };
    }

    function ringPoints(cx, cz, baseR, wobble, seed, count = 64) {
      const rnd = mulberry32(seed);
      const harmonics = [
        [0.6 + rnd() * 0.4, 2 + Math.floor(rnd() * 2), rnd() * Math.PI * 2],
        [0.3 + rnd() * 0.3, 4 + Math.floor(rnd() * 3), rnd() * Math.PI * 2],
        [0.15 + rnd() * 0.15, 7 + Math.floor(rnd() * 4), rnd() * Math.PI * 2],
      ];
      const pts = [];
      for (let i = 0; i < count; i++) {
        const a = (i / count) * Math.PI * 2;
        let r = baseR;
        for (const [amp, freq, phase] of harmonics) r += wobble * amp * Math.sin(freq * a + phase);
        pts.push([cx + r * Math.cos(a), cz + r * Math.sin(a) * 0.62]);
      }
      return pts;
    }

    // Each cluster is one "hill": a stack of rings shrinking in radius as
    // they rise, exactly like reading a topo map from the base up to the
    // summit contour.
    function buildCluster(cx, cz, baseR, ringCount, seed, step) {
      const rnd = mulberry32(seed * 97);
      const rings = [];
      for (let i = 0; i < ringCount; i++) {
        const r = baseR - i * step;
        if (r < 1.2) break;
        const jx = cx + (rnd() - 0.5) * 2 * (i / ringCount);
        const jz = cz + (rnd() - 0.5) * 1.6 * (i / ringCount);
        rings.push({ points: ringPoints(jx, jz, r, r * 0.16, seed * 97 + i), level: i });
      }
      return rings;
    }

    const clusters = [
      buildCluster(3.2, -2, 8.4, 9, 11, 0.85),
      buildCluster(-6.5, 2.5, 6, 7, 42, 0.78),
      buildCluster(7.5, 4.5, 3.6, 5, 73, 0.62),
    ];

    const black = new THREE.Color(BOTSWANA_BLACK);
    const blue = new THREE.Color(BOTSWANA_BLUE);
    const white = new THREE.Color(BOTSWANA_WHITE);
    const RING_HEIGHT_STEP = 0.34;
    const TUBE_RADIUS = 0.028;

    const terrainGroup = new THREE.Group();
    clusters.forEach((rings) => {
      const maxLevel = rings.length - 1 || 1;
      rings.forEach((ring) => {
        const t = ring.level / maxLevel;
        const color = new THREE.Color();
        if (t < 0.55) color.copy(black).lerp(blue, t / 0.55);
        else color.copy(blue).lerp(white, (t - 0.55) / 0.45);

        const y = ring.level * RING_HEIGHT_STEP;
        const vec3s = ring.points.map(([x, z]) => new THREE.Vector3(x, y, z));
        const curve = new THREE.CatmullRomCurve3(vec3s, true, "catmullrom", 0.5);
        const tubeGeo = new THREE.TubeGeometry(curve, 90, TUBE_RADIUS, 6, true);
        const tubeMat = new THREE.MeshStandardMaterial({
          color,
          emissive: color,
          emissiveIntensity: 0.18,
          roughness: 0.55,
          metalness: 0.15,
        });
        terrainGroup.add(new THREE.Mesh(tubeGeo, tubeMat));
      });
    });
    terrainGroup.position.y = -2.2;
    scene.add(terrainGroup);

    scene.add(new THREE.AmbientLight(0xffffff, 0.65));
    const sun = new THREE.DirectionalLight(0xffffff, 1.2);
    sun.position.set(-6, 10, 5);
    scene.add(sun);

    function resize() {
      const w = heroSection.clientWidth;
      const h = heroSection.clientHeight;
      if (!w || !h) return;
      renderer.setSize(w, h, false);
      camera.aspect = w / h;
      camera.updateProjectionMatrix();
    }
    resize();
    window.addEventListener("resize", resize);

    let heroVisible = true;
    if ("IntersectionObserver" in window) {
      new IntersectionObserver((entries) => {
        heroVisible = entries[0].isIntersecting;
      }).observe(heroSection);
    }

    if (prefersReducedMotion) {
      terrainGroup.rotation.y = 0.22;
      renderer.render(scene, camera);
      return;
    }

    // Slow, gentle sway -- roughly one full back-and-forth every 2.5
    // minutes, which is enough to reveal the layering as it turns without
    // ever reading as a spinning showcase piece. Paused off-screen/hidden.
    const clock = new THREE.Clock();
    const tick = () => {
      requestAnimationFrame(tick);
      if (!heroVisible || document.hidden) return;
      const t = clock.getElapsedTime();
      terrainGroup.rotation.y = 0.22 + Math.sin(t * 0.042) * 0.14;
      renderer.render(scene, camera);
    };
    tick();
  } catch (e) {
    // Fails silently to the CSS gradient fallback already on .hero --
    // a broken hero background shouldn't ever break the rest of the page.
  }
})();
