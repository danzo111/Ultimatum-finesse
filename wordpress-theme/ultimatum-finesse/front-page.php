<?php get_header(); ?>

<section class="hero">
  <canvas id="hero-3d" aria-hidden="true"></canvas>
  <div class="container">
    <div class="hero-grid">
      <div>
        <div class="eyebrow">Providing Geospatial Knowledge</div>
        <h1>Precision mapping for <span class="accent">Botswana&rsquo;s</span> boldest projects</h1>
        <p class="hero-lede">From LiDAR surveys of Lotsane and Gaborone Dams to aerial mapping of the Karowe mine lease, Ultimatum Finesse turns raw terrain into decision-ready geospatial data.</p>
        <div class="hero-actions">
          <a href="<?php echo esc_url( home_url( '/our-projects/' ) ); ?>" class="btn btn-primary">
            View Live Project Map
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
          <a href="<?php echo esc_url( home_url( '/our-services/' ) ); ?>" class="btn btn-outline">Our Services</a>
        </div>
        <div class="hero-badges">
          <span class="hero-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
            Citizen-owned, est. 2013
          </span>
          <span class="hero-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
            50+ projects delivered
          </span>
          <span class="hero-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
            CAAB-certified drone operations
          </span>
        </div>
      </div>
      <div class="hero-panel">
        <span class="hero-panel-tag"><span class="pulse-dot"></span> Live project sites</span>
        <div id="hero-map" class="map-embed"></div>
        <span class="hero-panel-coords" aria-hidden="true"><span class="deg">24.6581&deg;S</span> 25.9089&deg;E &middot; GABORONE HQ</span>
      </div>
    </div>
  </div>
</section>

<div class="stats-bar">
  <div class="container">
    <div class="stats-grid">
      <div class="stat"><div class="stat-num" data-count="20" data-suffix="+">0</div><div class="stat-label">Happy Clients</div></div>
      <div class="stat"><div class="stat-num" data-count="50" data-suffix="+">0</div><div class="stat-label">Completed Projects</div></div>
      <div class="stat"><div class="stat-num" data-count="13" data-suffix="+">0</div><div class="stat-label">Years in Operation</div></div>
      <div class="stat"><div class="stat-num" data-count="7" >0</div><div class="stat-label">Service Disciplines</div></div>
    </div>
  </div>
</div>

<section class="section" id="services">
  <div class="container">
    <div class="section-head center reveal">
      <div class="eyebrow" style="justify-content:center">What We Do</div>
      <h2>Geospatial knowledge for every terrain</h2>
      <p>Seven integrated service lines share one dataset, from acquisition in the field to analysis-ready deliverables.</p>
    </div>

    <div class="services-grid">
      <div class="service-card service-card--photo reveal">
        <div class="service-card-photo">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/bim-diagram.png' ); ?>" width="600" height="350" loading="lazy" alt="Annotated GIS project boundary map, Gaborone">
          <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6.5l6-2 6 2 6-2v13l-6 2-6-2-6 2z"/><path d="M9 4.5v13M15 6.5v13"/></svg></div>
        </div>
        <div class="service-card-body">
          <h3>GIS Applications</h3>
          <p>We manage geospatial data for archaeology, banking, agriculture, utilities and infrastructure audits.</p>
          <div class="tag-row"><span class="tag">Utility Mapping</span><span class="tag">Natural Resources</span><span class="tag">Infrastructure Audits</span></div>
          <a href="<?php echo esc_url( home_url( '/our-services/#gis' ) ); ?>" class="service-link">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
      </div>

      <div class="service-card service-card--photo reveal">
        <div class="service-card-photo">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/drone-services.jpg' ); ?>" width="810" height="1080" loading="lazy" alt="Ultimatum Finesse technician launching a survey drone">
          <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="6" height="6" rx="1"/><path d="M9 9L4 4M15 9l5-5M9 15l-5 5M15 15l5 5"/><circle cx="4" cy="4" r="1.4"/><circle cx="20" cy="4" r="1.4"/><circle cx="4" cy="20" r="1.4"/><circle cx="20" cy="20" r="1.4"/></svg></div>
        </div>
        <div class="service-card-body">
          <h3>Aerial &amp; Mobile LiDAR</h3>
          <p>Drone and vehicle-mounted LiDAR covers topographic, powerline, flood and dam surveys at scale.</p>
          <div class="tag-row"><span class="tag">Powerline Inspection</span><span class="tag">Flood Mapping</span><span class="tag">Mining</span></div>
          <a href="<?php echo esc_url( home_url( '/our-services/#lidar' ) ); ?>" class="service-link">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
      </div>

      <div class="service-card service-card--photo reveal">
        <div class="service-card-photo">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/survey-1.jpg' ); ?>" width="600" height="350" loading="lazy" alt="3D point cloud reconstruction of a stockpile site">
          <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4.5v9L12 20l-8-4.5v-9z"/><path d="M12 2v18M4 6.5l8 4.5 8-4.5"/></svg></div>
        </div>
        <div class="service-card-body">
          <h3>3D Laser Scanning</h3>
          <p>High-definition point clouds support volume calculation and as-built documentation, including handheld LiDAR for stockpiles.</p>
          <div class="tag-row"><span class="tag">Stockpile Scanning</span><span class="tag">Volume Calc</span><span class="tag">Heritage</span></div>
          <a href="<?php echo esc_url( home_url( '/our-services/#scan3d' ) ); ?>" class="service-link">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
      </div>

      <div class="service-card service-card--photo reveal">
        <div class="service-card-photo">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/survey-4.jpg' ); ?>" width="600" height="350" loading="lazy" alt="3D as-built building reconstruction model">
          <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="9" height="18"/><rect x="14" y="9" width="5" height="12"/><path d="M8 7h2M8 11h2M8 15h2"/></svg></div>
        </div>
        <div class="service-card-body">
          <h3>Building Information Modelling</h3>
          <p>As-built BIM supports facilities management, renovation planning and detailed design documentation.</p>
          <div class="tag-row"><span class="tag">As-Built</span><span class="tag">Facilities Mgmt</span><span class="tag">Documentation</span></div>
          <a href="<?php echo esc_url( home_url( '/our-services/#bim' ) ); ?>" class="service-link">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
      </div>

      <div class="service-card service-card--photo reveal">
        <div class="service-card-photo">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/aerial-imagery.jpg' ); ?>" width="600" height="350" loading="lazy" alt="Ortho-rectified aerial photograph of a commercial building">
          <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8h3l1.5-2h7L17 8h3a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13" r="3.3"/></svg></div>
        </div>
        <div class="service-card-body">
          <h3>Aerial Photography &amp; Photogrammetry</h3>
          <p>We build orthomosaics and 3D terrain models for cartography, disaster relief and property assessment.</p>
          <div class="tag-row"><span class="tag">Cartography</span><span class="tag">Disaster Relief</span><span class="tag">Property</span></div>
          <a href="<?php echo esc_url( home_url( '/our-services/#photo' ) ); ?>" class="service-link">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
      </div>

      <div class="service-card service-card--photo reveal">
        <div class="service-card-photo photo-focus-low">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/gps-surveying.jpg' ); ?>" width="684" height="912" loading="lazy" alt="RTK GPS rover survey on a construction site">
          <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M15 9l-2 6-4 2 2-6z"/></svg></div>
        </div>
        <div class="service-card-body">
          <h3>Surveying &amp; Mapping</h3>
          <p>Static, dynamic and real-time kinematic surveys cover utility infrastructure and land quantities.</p>
          <div class="tag-row"><span class="tag">RTK Survey</span><span class="tag">Land Quantities</span><span class="tag">Change Detection</span></div>
          <a href="<?php echo esc_url( home_url( '/our-services/#survey' ) ); ?>" class="service-link">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section--dark">
  <div class="container">
    <div class="about-grid">
      <div class="reveal">
        <div class="eyebrow">About Ultimatum Finesse</div>
        <h2>Ground truth, delivered as data since 2013</h2>
        <p>We are a proudly citizen-owned, Gaborone-based geospatial firm providing GIS, LiDAR, laser scanning, BIM and survey services across Botswana. We build every deliverable to be used, not just viewed.</p>
        <a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" class="btn btn-outline">More About Us
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
      <div class="reveal">
        <div class="about-media">
          <div class="photo-frame"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/survey-2.jpg' ); ?>" width="600" height="350" loading="lazy" alt="Photogrammetry point cloud of a quarry stockpile"></div>
          <div class="photo-frame"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/survey-3.jpg' ); ?>" width="600" height="350" loading="lazy" alt="Aerial orthomosaic reconstruction of a road junction"></div>
        </div>
        <div class="value-list-plain">
          <div class="value-row">
            <span class="value-index">Precision</span>
            <div><h4>Field-tested accuracy</h4><p>Survey-grade accuracy validated against ground control on every project.</p></div>
          </div>
          <div class="value-row">
            <span class="value-index">Technology</span>
            <div><h4>Modern capture equipment</h4><p>Drone LiDAR, mobile mapping and 3D laser scanning kept current with the industry.</p></div>
          </div>
          <div class="value-row">
            <span class="value-index">Terrain</span>
            <div><h4>Local knowledge</h4><p>Deep familiarity with Botswana&rsquo;s landscape, from the Kalahari to the Okavango Delta.</p></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="container">
    <div class="section-head center reveal">
      <div class="eyebrow" style="justify-content:center">Trusted By</div>
      <h2>Organisations who rely on our data</h2>
    </div>
    <div class="logo-marquee reveal" aria-label="Companies that trust our data">
      <div class="logo-track">
        <?php for ( $i = 0; $i < 2; $i++ ) : ?>
        <div class="logo-track-group"<?php echo $i === 1 ? ' aria-hidden="true"' : ''; ?>>
          <div class="logo-slide"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/client-lucara.png' ); ?>" width="225" height="225" loading="lazy" alt=""><span class="logo-slide-name">Lucara Diamond</span></div>
          <div class="logo-slide"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/client-champs.png' ); ?>" width="816" height="510" loading="lazy" alt=""><span class="logo-slide-name">Champs Botswana</span></div>
          <div class="logo-slide"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/client-geoflux.jpeg' ); ?>" width="350" height="342" loading="lazy" alt=""><span class="logo-slide-name">Geoflux</span></div>
          <div class="logo-slide"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/client-wildafrica.png' ); ?>" width="300" height="47" loading="lazy" alt=""><span class="logo-slide-name">Wild Africa</span></div>
          <div class="logo-slide"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/client-envirosolve.png' ); ?>" width="495" height="102" loading="lazy" alt=""><span class="logo-slide-name">Envirosolve</span></div>
          <div class="logo-slide"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/client-mgt.png' ); ?>" width="119" height="91" loading="lazy" alt=""><span class="logo-slide-name">MGT</span></div>
          <div class="logo-slide"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/client-urbanheights.jpg' ); ?>" width="1180" height="891" loading="lazy" alt="" style="border-radius:8px;"><span class="logo-slide-name">Urban Heights</span></div>
        </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <h2>Have a project that needs mapping?</h2>
        <p>Tell us the terrain and the deadline. We&rsquo;ll tell you the best way to capture it.</p>
      </div>
      <div class="cta-band-actions">
        <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="btn btn-primary">Start a Conversation</a>
        <a href="<?php echo esc_url( home_url( '/our-projects/' ) ); ?>" class="btn btn-outline">See Our Work</a>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    initUfMap('hero-map', { interactive: false, zoom: 5.3, dataUrl: ufMapData.projectsUrl });
  });
</script>

<?php get_footer(); ?>
