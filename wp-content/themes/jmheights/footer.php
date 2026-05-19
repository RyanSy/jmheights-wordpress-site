</main><!-- #main-content -->

<footer class="site-footer">
    <!-- Footer CTA -->
    <div class="footer-cta">
        <div class="container">
            <p>No heat? No AC? We're here. Call or text — fast response, honest service.</p>
            <div class="btn-group">
                <a href="tel:+12018243272" class="btn-cta">
                    <?php echo jmheights_icon('phone'); ?>
                    (201) 824-3272
                </a>
                <a href="sms:+12018243272" class="btn-cta btn-outline">
                    <?php echo jmheights_icon('text'); ?>
                    Text Us
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Main -->
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand Column -->
                <div class="footer-brand">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                        <?php if (has_custom_logo()): ?>
                            <?php
                            $logo_id = get_theme_mod('custom_logo');
                            $logo_url = wp_get_attachment_image_url($logo_id, 'thumbnail');
                            ?>
                            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>">
                        <?php else: ?>
                            <img src="<?php echo JMHEIGHTS_URI; ?>/images/logo-placeholder.svg" alt="<?php bloginfo('name'); ?>">
                        <?php endif; ?>
                        <div class="logo-text">
                            JM Heights<span>Cooling Corp.</span>
                        </div>
                    </a>
                    <p>Top rated, family owned HVAC & plumbing company serving North Jersey with 56+ years of experience.</p>
                    <div class="footer-licenses">
                        HVAC License: 9370<br>
                        Plumbing License: 12023
                    </div>
                </div>

                <!-- Services Column -->
                <div class="footer-col">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="<?php echo home_url('/plumbing/'); ?>">Plumbing</a></li>
                        <li><a href="<?php echo home_url('/hvac/'); ?>">HVAC</a></li>
                        <li><a href="<?php echo home_url('/heating/'); ?>">Heating</a></li>
                        <li><a href="<?php echo home_url('/commercial/'); ?>">Commercial</a></li>
                        <li><a href="<?php echo home_url('/hvac/indoor-air-quality/'); ?>">Indoor Air Quality</a></li>
                        <li><a href="<?php echo home_url('/plumbing/drain-services/'); ?>">Drain Services</a></li>
                    </ul>
                </div>

                <!-- Quick Links Column -->
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                        <li><a href="<?php echo home_url('/about/'); ?>">About Us</a></li>
                        <li><a href="<?php echo home_url('/why-jm-heights/'); ?>">Why JM Heights</a></li>
                        <li><a href="<?php echo home_url('/service-areas/'); ?>">Service Areas</a></li>
                        <li><a href="<?php echo home_url('/maintenance-plans/'); ?>">Maintenance Plans</a></li>
                        <li><a href="<?php echo home_url('/contact/'); ?>">Contact</a></li>
                    </ul>
                    <a href="https://www.synchrony.com/mmc/S6223259807" class="btn-link" target="_blank" rel="noopener">
                        Apply for Financing <?php echo jmheights_icon('arrow-right'); ?>
                    </a>
                </div>

                <!-- Contact Column -->
                <div class="footer-col">
                    <h4>Contact Us</h4>
                    <div class="footer-contact-item">
                        <?php echo jmheights_icon('phone'); ?>
                        <div>
                            <div>Call or Text</div>
                            <a href="tel:+12018243272">(201) 824-3272</a>
                        </div>
                    </div>
                    <div class="footer-hours">
                        <h5>Hours</h5>
                        <p>Monday - Saturday<br>8AM - 7PM</p>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> JM Heights Cooling Corp. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="<?php echo home_url('/terms/'); ?>">Terms of Use</a>
                    <a href="<?php echo home_url('/privacy/'); ?>">Privacy Policy</a>
                    <span>HVAC 9370 | Plumbing 12023</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
