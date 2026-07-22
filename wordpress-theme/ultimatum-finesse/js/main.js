// Shared UI behaviour: sticky header, mobile nav, scroll reveals, animated counters, contact form.

document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector(".site-header");
  const toggle = document.querySelector(".nav-toggle");
  const nav = document.querySelector(".main-nav");

  const onScroll = () => {
    if (!header) return;
    header.classList.toggle("is-scrolled", window.scrollY > 20);
  };
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });

  if (toggle && nav) {
    if (!nav.id) nav.id = "main-nav";
    toggle.setAttribute("aria-controls", nav.id);
    toggle.setAttribute("aria-expanded", "false");
    const closeNav = () => {
      toggle.classList.remove("is-open");
      nav.classList.remove("is-open");
      toggle.setAttribute("aria-expanded", "false");
    };
    toggle.addEventListener("click", () => {
      const isOpen = toggle.classList.toggle("is-open");
      nav.classList.toggle("is-open", isOpen);
      toggle.setAttribute("aria-expanded", String(isOpen));
    });
    nav.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", closeNav);
    });
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeNav();
    });
  }

  // Decorative icons: every inline SVG on this site accompanies text or sits
  // inside an aria-labelled control, so none carry unique meaning on their own.
  document.querySelectorAll("svg:not([aria-hidden]):not([role])").forEach((svg) => {
    svg.setAttribute("aria-hidden", "true");
  });

  // Scroll reveal.
  // Bugfix: the previous logic used threshold:0.15, so a .reveal element taller
  // than the viewport — e.g. the single .page-content-block wrapper on the
  // About/Insights pages that holds ALL of the pasted content — never reached
  // 15% visibility on load and stayed hidden (blank page) until the user
  // scrolled. Now we reveal anything already in the viewport at load regardless
  // of its size, observe the rest with threshold:0 so they still animate in on
  // scroll, and force-reveal everything as a backstop so nothing can get stuck.
  const revealEls = document.querySelectorAll(".reveal");
  if (revealEls.length) {
    const reveal = (el) => el.classList.add("in-view");
    const inViewport = (el) => {
      const r = el.getBoundingClientRect();
      const vh = window.innerHeight || document.documentElement.clientHeight;
      const vw = window.innerWidth || document.documentElement.clientWidth;
      // true if ANY part of the element overlaps the viewport (handles elements
      // that are much taller than the screen, which is the About/Insights case)
      return r.bottom > 0 && r.top < vh && r.right > 0 && r.left < vw;
    };

    if ("IntersectionObserver" in window) {
      const io = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              reveal(entry.target);
              io.unobserve(entry.target);
            }
          });
        },
        { threshold: 0, rootMargin: "0px 0px -8% 0px" }
      );
      revealEls.forEach((el) => {
        if (inViewport(el)) {
          reveal(el); // already on screen at load — show immediately, no scroll needed
        } else {
          io.observe(el); // below the fold — reveal when scrolled into view
        }
      });
    } else {
      // No IntersectionObserver support: show everything.
      revealEls.forEach(reveal);
    }

    // Safety net — guarantee content can never stay invisible (observer never
    // fires, layout shift, oversized wrapper, etc.): force-reveal all shortly
    // after load, plus an absolute fallback timer.
    const revealAll = () => revealEls.forEach(reveal);
    window.addEventListener("load", () => setTimeout(revealAll, 1500));
    setTimeout(revealAll, 3000);
  }

  // Animated counters
  const counters = document.querySelectorAll("[data-count]");
  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  if (counters.length) {
    const animate = (el) => {
      const target = parseInt(el.dataset.count, 10);
      const suffix = el.dataset.suffix || "";
      if (prefersReducedMotion) {
        el.textContent = target.toLocaleString() + suffix;
        return;
      }
      const duration = 1400;
      const start = performance.now();
      const step = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(eased * target).toLocaleString() + suffix;
        if (progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };
    if ("IntersectionObserver" in window) {
      const cio = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              animate(entry.target);
              cio.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.5 }
      );
      counters.forEach((el) => cio.observe(el));
    } else {
      counters.forEach(animate);
    }
  }

  // Contact form is front-end only for now; no backend is wired up yet.
  const form = document.querySelector("#contact-form");
  if (form) {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalLabel = submitBtn?.textContent;
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = "Sending…";
      }
      setTimeout(() => {
        document.querySelector("#form-success")?.classList.add("show");
        form.reset();
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = originalLabel;
        }
      }, 500);
    });
  }

  // Set active nav link based on current page
  const path = window.location.pathname.split("/").pop() || "index.html";
  document.querySelectorAll(".main-nav a").forEach((link) => {
    const href = link.getAttribute("href");
    if (href === path || (path === "" && href === "index.html")) {
      link.classList.add("active");
    }
  });
});
