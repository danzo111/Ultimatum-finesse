  </main>

<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" style="margin-bottom:16px;">
          <span class="brand-logo-badge"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/logo-full.jpg' ); ?>" width="1200" height="335" alt="Ultimatum Finesse: Providing Geospatial Knowledge"></span>
        </a>
        <p>We provide geospatial knowledge suited to your needs: GIS, LiDAR, laser scanning, BIM, photogrammetry and survey services across Botswana.</p>
        <div class="social-row">
          <a href="https://www.linkedin.com/company/ultimatum-finesse/" target="_blank" rel="noopener" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor" style="color:#fff"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21h-4v-5.6c0-1.34-.02-3.07-1.87-3.07-1.87 0-2.16 1.46-2.16 2.97V21H9z"/></svg></a>
          <a href="https://web.facebook.com/UltimatumFinesse" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor" style="color:#fff"><path d="M13.5 21v-8h2.7l.4-3.2h-3.1V7.7c0-.93.26-1.56 1.6-1.56h1.7V3.3C15.8 3.14 14.9 3 13.9 3c-2.4 0-4 1.46-4 4.15v2.65H7.2v3.2h2.7v8z"/></svg></a>
          <a href="https://www.instagram.com/ultimatumfinesse/" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">About Us</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-services/' ) ); ?>">Services</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-projects/' ) ); ?>">Projects</a></li>
          <li><a href="<?php echo esc_url( home_url( '/insights/' ) ); ?>">Insights</a></li>
          <li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Contact</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Services</h4>
        <ul>
          <li><a href="<?php echo esc_url( home_url( '/our-services/#gis' ) ); ?>">GIS Applications</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-services/#lidar' ) ); ?>">Aerial &amp; Mobile LiDAR</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-services/#scan3d' ) ); ?>">3D Laser Scanning</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-services/#survey' ) ); ?>">Surveying &amp; Mapping</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Get in Touch</h4>
        <ul>
          <li><a href="https://www.google.com/maps/dir/?api=1&destination=-24.6721551,25.9063727" target="_blank" rel="noopener">FFN 104, Loapi House, Plot 1272,<br>Old Lobatse Rd, Gaborone</a></li>
          <li><a href="mailto:info@ultimatumfinesse.co.bw">info@ultimatumfinesse.co.bw</a></li>
          <li><a href="tel:+2673960383">Office: +267 396 0383</a></li>
          <li><a href="tel:+26773397937">Cell: +267 73 397 937</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Ultimatum Finesse. All rights reserved.</span>
      <span>Site designed and built by Daniel Kimani Njoroge</span>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
