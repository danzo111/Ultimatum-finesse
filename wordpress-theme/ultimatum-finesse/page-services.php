<?php
/* Template Name: Services */
get_header();
?>

<section class="page-hero">
  <div class="container">
    <div class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / Services</div>
    <h1>Seven disciplines. One geospatial dataset.</h1>
    <p>Each service below can stand alone, or feed into the others from a single field capture. Explore what each discipline covers and where it&rsquo;s used.</p>
  </div>
</section>

<section class="section">
  <div class="container">

    <div class="service-detail reveal" id="gis">
      <div class="service-detail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6.5l6-2 6 2 6-2v13l-6 2-6-2-6 2z"/><path d="M9 4.5v13M15 6.5v13"/></svg></div>
      <div>
        <span class="index-no">01 / GIS APPLICATIONS</span>
        <h3>GIS Applications</h3>
        <p>Geographic Information Systems turn scattered field data into structured, queryable layers built for the sectors that depend on accurate spatial records.</p>
        <div class="tag-row">
          <span class="tag">Archaeology</span><span class="tag">Geology</span><span class="tag">Business</span>
          <span class="tag">Waste Management</span><span class="tag">Natural Resources Management</span>
          <span class="tag">Aviation &amp; Banking</span><span class="tag">Agriculture</span><span class="tag">Automobile</span>
          <span class="tag">Utility Data Management</span><span class="tag">Infrastructure Geospatial Data Management</span>
          <span class="tag">Infrastructure Audits</span>
        </div>
      </div>
      <div class="service-detail-photo"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/bim-diagram.png' ); ?>" width="600" height="350" loading="lazy" alt="Annotated GIS project boundary map, Gaborone"></div>
    </div>

    <div class="service-detail reveal" id="lidar">
      <div class="service-detail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="6" height="6" rx="1"/><path d="M9 9L4 4M15 9l5-5M9 15l-5 5M15 15l5 5"/><circle cx="4" cy="4" r="1.4"/><circle cx="20" cy="4" r="1.4"/><circle cx="4" cy="20" r="1.4"/><circle cx="20" cy="20" r="1.4"/></svg></div>
      <div>
        <span class="index-no">02 / AERIAL &amp; MOBILE LIDAR</span>
        <h3>Aerial and Mobile LIDAR</h3>
        <p>Drone-mounted and vehicle-mounted LiDAR captures dense, accurate elevation data over large or hard-to-reach areas in a fraction of the time of ground survey alone.</p>
        <div class="tag-row">
          <span class="tag">Land Surveying</span><span class="tag">Power Line Inspection</span>
          <span class="tag">Topographic &amp; Bathymetric Surveys</span><span class="tag">Forest &amp; Precision Agriculture</span>
          <span class="tag">Mining</span><span class="tag">Tunnel Surveying</span><span class="tag">Urban Planning</span>
          <span class="tag">Flood Mapping &amp; Catchment Survey</span><span class="tag">Dam Surveying</span>
        </div>
      </div>
      <div class="service-detail-photo is-portrait"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/drone-services.jpg' ); ?>" width="810" height="1080" loading="lazy" alt="Ultimatum Finesse technician launching a survey drone"></div>
    </div>

    <div class="service-detail reveal" id="scan3d">
      <div class="service-detail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4.5v9L12 20l-8-4.5v-9z"/><path d="M12 2v18M4 6.5l8 4.5 8-4.5"/></svg></div>
      <div>
        <span class="index-no">03 / 3D LASER SCANNING</span>
        <h3>3D High Definition Laser Scanning</h3>
        <p>Millimetre-accurate point clouds support volumetric measurement, as-built documentation and simulation, from single rooms to entire industrial sites.</p>
        <div class="tag-row">
          <span class="tag">Industries</span><span class="tag">Volume Calculation</span><span class="tag">Infrastructure</span>
          <span class="tag">Architecture</span><span class="tag">Heritage &amp; Monuments</span><span class="tag">Police</span>
          <span class="tag">Energy</span><span class="tag">Simulations</span><span class="tag">Tourism &amp; Leisure</span>
        </div>
      </div>
      <div class="service-detail-photo"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/survey-1.jpg' ); ?>" width="600" height="350" loading="lazy" alt="3D point cloud reconstruction of a stockpile site"></div>
    </div>

    <div class="service-detail reveal" id="bim">
      <div class="service-detail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="9" height="18"/><rect x="14" y="9" width="5" height="12"/><path d="M8 7h2M8 11h2M8 15h2"/></svg></div>
      <div>
        <span class="index-no">04 / BUILDING INFORMATION MODELLING</span>
        <h3>Building Information Modelling</h3>
        <p>We convert point cloud data into structured BIM models that support the full building lifecycle, from preliminary design through to facilities management.</p>
        <div class="tag-row">
          <span class="tag">Visualisation</span><span class="tag">As Built</span><span class="tag">Facilities Management</span>
          <span class="tag">Analysis</span><span class="tag">Documentation</span><span class="tag">Construction</span>
          <span class="tag">Renovation</span><span class="tag">Preliminary Design</span><span class="tag">Detailed Design</span>
        </div>
      </div>
      <div class="service-detail-photo"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/survey-4.jpg' ); ?>" width="600" height="350" loading="lazy" alt="3D as-built building reconstruction model"></div>
    </div>

    <div class="service-detail reveal" id="photo">
      <div class="service-detail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8h3l1.5-2h7L17 8h3a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13" r="3.3"/></svg></div>
      <div>
        <span class="index-no">05 / AERIAL PHOTOGRAPHY &amp; PHOTOGRAMMETRY</span>
        <h3>Aerial Photography and Photogrammetry</h3>
        <p>High-resolution aerial imagery processed into orthomosaics and 3D terrain models for planning, monitoring and reporting.</p>
        <div class="tag-row">
          <span class="tag">Land Surveying</span><span class="tag">Disaster Relief</span><span class="tag">Cartography</span>
          <span class="tag">Public Safety</span><span class="tag">Tourism</span><span class="tag">Property</span>
          <span class="tag">Construction</span><span class="tag">Mining</span>
        </div>
      </div>
      <div class="service-detail-photo"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/aerial-imagery.jpg' ); ?>" width="600" height="350" loading="lazy" alt="Ortho-rectified aerial photograph of a commercial building"></div>
    </div>

    <div class="service-detail reveal" id="survey">
      <div class="service-detail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M15 9l-2 6-4 2 2-6z"/></svg></div>
      <div>
        <span class="index-no">06 / SURVEYING &amp; MAPPING</span>
        <h3>Surveying and Mapping</h3>
        <p>We use static, dynamic and real-time kinematic survey methods to answer specific spatial questions: where, how much, how dense, and what has changed.</p>
        <div class="tag-row">
          <span class="tag">Static Surveys</span><span class="tag">Dynamic Surveys</span><span class="tag">Real-Time Kinematic Surveys</span>
          <span class="tag">Geospatial Data Collection</span><span class="tag">Utility Infrastructure Mapping</span>
          <span class="tag">Map Locations</span><span class="tag">Map Quantities</span><span class="tag">Map Densities</span>
          <span class="tag">Map Specific Areas</span><span class="tag">Map Change</span>
        </div>
      </div>
      <div class="service-detail-photo is-portrait"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/gps-surveying.jpg' ); ?>" width="684" height="912" loading="lazy" alt="RTK GPS rover survey on a construction site"></div>
    </div>

    <div class="service-detail reveal" id="stockpile">
      <div class="service-detail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20h18"/><path d="M5 20c0-3 2.5-6 7-6s7 3 7 6"/><path d="M8 14c0-2 1.5-4 4-4s4 2 4 4"/><path d="M12 3v4M9.5 5.5L12 3l2.5 2.5"/></svg></div>
      <div>
        <span class="index-no">07 / HANDHELD LIDAR STOCKPILE SCANNING</span>
        <h3>Handheld LiDAR Stockpile Scanning</h3>
        <p>Walk-around handheld LiDAR scanning captures stockpiles in minutes, giving mines, quarries and aggregate yards fast, repeatable volume measurements without shutting down the working area.</p>
        <div class="tag-row">
          <span class="tag">Stockpile Volumes</span><span class="tag">Mining</span><span class="tag">Quarries</span>
          <span class="tag">Aggregate Yards</span><span class="tag">Monthly Reconciliation</span>
          <span class="tag">Production Reporting</span><span class="tag">Rapid Capture</span>
        </div>
      </div>
      <div class="service-detail-photo"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/survey-2.jpg' ); ?>" width="600" height="350" loading="lazy" alt="Point cloud of stockpiles captured for volume calculation"></div>
    </div>

  </div>
</section>

<section class="section section--alt">
  <div class="container">
    <div class="cta-band reveal" style="background:linear-gradient(120deg, var(--navy-900), var(--navy-700));">
      <div>
        <h2>Not sure which service fits your project?</h2>
        <p>Send us the site, the scale and the deadline. We&rsquo;ll recommend the right capture method.</p>
      </div>
      <div class="cta-band-actions">
        <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="btn btn-primary">Ask a Question</a>
        <a href="<?php echo esc_url( home_url( '/our-projects/' ) ); ?>" class="btn btn-outline">See It In Action</a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
