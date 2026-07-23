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

  // Contact form -> real submission via the theme's REST endpoint
  // (uf/v1/contact, registered in functions.php). Endpoint URL + nonce are
  // injected by wp_localize_script as UF_CONTACT.
  const form = document.querySelector("#contact-form");
  if (form) {
    const successEl = document.querySelector("#form-success");
    const errorEl = document.querySelector("#form-error");

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalLabel = submitBtn ? submitBtn.textContent : "";
      const restore = () => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = originalLabel;
        }
      };
      const showError = (msg) => {
        if (errorEl) {
          errorEl.textContent = msg;
          errorEl.classList.add("show");
        }
        restore();
      };

      if (errorEl) errorEl.classList.remove("show");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = "Sending…";
      }

      // Bail gracefully if the localized endpoint isn't present.
      if (typeof UF_CONTACT === "undefined" || !UF_CONTACT.url) {
        showError("Sorry — the form isn't available right now. Please email info@ultimatumfinesse.co.bw.");
        return;
      }

      const val = (sel) => {
        const el = form.querySelector(sel);
        return el ? el.value : "";
      };
      const payload = {
        name: val("#name"),
        email: val("#email"),
        phone: val("#phone"),
        service: val("#service"),
        message: val("#message"),
        company_url: val('[name="company_url"]'), // honeypot — should stay empty
      };

      try {
        const res = await fetch(UF_CONTACT.url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-WP-Nonce": UF_CONTACT.nonce,
          },
          body: JSON.stringify(payload),
        });
        let data = {};
        try {
          data = await res.json();
        } catch (_) {
          /* non-JSON response */
        }
        if (res.ok && data.ok !== false) {
          if (successEl) successEl.classList.add("show");
          form.reset();
          restore();
        } else {
          showError((data && data.message) || "Sorry — your message couldn't be sent. Please try again or email info@ultimatumfinesse.co.bw.");
        }
      } catch (err) {
        showError("Network error — please check your connection and try again, or email info@ultimatumfinesse.co.bw.");
      }
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
