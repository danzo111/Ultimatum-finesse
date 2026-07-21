// Animated 3D terrain backdrop for the homepage hero.
// Coloured in Botswana's national palette -- the flag's own black-and-white
// band on a sky-blue field -- mapped as a hypsometric tint (dark low ground
// rising through blue to white high ground), the same way real elevation
// data is coloured. This *is* what the company's own LiDAR/photogrammetry
// deliverables look like, rendered live rather than as a flat image.
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
    scene.fog = new THREE.Fog(BOTSWANA_BLUE, 16, 40);

    const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 100);
    camera.position.set(0, 7.2, 12.5);
    camera.lookAt(0, -0.5, -3);

    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.6));

    // Terrain: a finely subdivided plane displaced by a few layered sine
    // waves into rolling elevation -- irregular enough to read as real
    // terrain, not a mathematical dome.
    const size = 36;
    const segments = 110;
    const geometry = new THREE.PlaneGeometry(size, size, segments, segments);
    geometry.rotateX(-Math.PI / 2);

    const heightAt = (x, z) =>
      1.6 * Math.sin(x * 0.22 + 1.1) * Math.cos(z * 0.19) +
      0.9 * Math.sin(x * 0.5 - z * 0.35 + 2.4) +
      0.5 * Math.sin(x * 0.9 + z * 0.8) +
      0.25 * Math.sin(x * 1.8 - z * 1.4 + 0.6);

    const pos = geometry.attributes.position;
    const heights = new Array(pos.count);
    let minH = Infinity;
    let maxH = -Infinity;
    for (let i = 0; i < pos.count; i++) {
      const h = heightAt(pos.getX(i), pos.getZ(i));
      heights[i] = h;
      if (h < minH) minH = h;
      if (h > maxH) maxH = h;
    }

    const black = new THREE.Color(BOTSWANA_BLACK);
    const blue = new THREE.Color(BOTSWANA_BLUE);
    const white = new THREE.Color(BOTSWANA_WHITE);
    const colors = new Float32Array(pos.count * 3);
    const tmp = new THREE.Color();
    for (let i = 0; i < pos.count; i++) {
      pos.setY(i, heights[i]);
      const t = (heights[i] - minH) / (maxH - minH);
      if (t < 0.55) tmp.copy(black).lerp(blue, t / 0.55);
      else tmp.copy(blue).lerp(white, (t - 0.55) / 0.45);
      colors[i * 3] = tmp.r;
      colors[i * 3 + 1] = tmp.g;
      colors[i * 3 + 2] = tmp.b;
    }
    geometry.setAttribute("color", new THREE.BufferAttribute(colors, 3));
    geometry.computeVertexNormals();

    const material = new THREE.MeshStandardMaterial({
      vertexColors: true,
      roughness: 0.9,
      metalness: 0.05,
    });
    const terrain = new THREE.Mesh(geometry, material);
    terrain.position.y = -2.6;
    scene.add(terrain);

    scene.add(new THREE.AmbientLight(0xffffff, 0.6));
    const sun = new THREE.DirectionalLight(0xffffff, 1.15);
    sun.position.set(-6, 10, 4);
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
      terrain.rotation.y = 0.18;
      renderer.render(scene, camera);
      return;
    }

    // Slow, gentle sway -- roughly one full back-and-forth every 2.5
    // minutes. The point is ambient depth, not a spinning logo. Paused
    // whenever the hero is scrolled out of view or the tab isn't visible.
    const clock = new THREE.Clock();
    const tick = () => {
      requestAnimationFrame(tick);
      if (!heroVisible || document.hidden) return;
      const t = clock.getElapsedTime();
      terrain.rotation.y = 0.18 + Math.sin(t * 0.042) * 0.12;
      renderer.render(scene, camera);
    };
    tick();
  } catch (e) {
    // Fails silently to the CSS gradient fallback already on .hero --
    // a broken hero background shouldn't ever break the rest of the page.
  }
})();
