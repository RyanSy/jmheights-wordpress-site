<?php
/**
 * Template Name: Front Page
 * The front page template
 */
get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-decor-diamond"></div>
    <div class="hero-decor-dots">
        <span></span><span></span><span></span>
        <span></span><span></span><span></span>
        <span></span><span></span><span></span>
    </div>

    <div class="container">
        <div class="hero-content">
            <div class="hero-tagline">North Jersey's HVAC & Plumbing Experts</div>

            <h1 class="hero-title">
                COMFORT<br>
                <span class="highlight">YOU CAN</span><br>
                COUNT ON
            </h1>

            <div class="hero-underline">
                <span></span>
                <span></span>
            </div>

            <p class="hero-description">
                Family owned & operated with <strong>56+ years of experience</strong> serving
                residential, commercial & industrial clients across North Jersey. One call
                handles it all — heating, cooling, and plumbing.
            </p>

            <div class="hero-buttons">
                <a href="tel:+12018243272" class="btn-cta">
                    <?php echo jmheights_icon('phone'); ?>
                    (201) 824-3272
                </a>
                <a href="sms:+12018243272" class="btn-cta btn-outline">
                    <?php echo jmheights_icon('text'); ?>
                    Text Us
                </a>
            </div>

            <div class="hero-badges">
                <div class="hero-badge">
                    <?php echo jmheights_icon('shield'); ?>
                    Licensed & Insured
                </div>
                <div class="hero-badge">
                    <?php echo jmheights_icon('award'); ?>
                    56+ Years Experience
                </div>
                <div class="hero-badge">
                    <?php echo jmheights_icon('star'); ?>
                    5-Star Rated
                </div>
                <div class="hero-badge">
                    <?php echo jmheights_icon('heart'); ?>
                    Family Owned
                </div>
            </div>
        </div>
    </div>

    <div class="hero-logo-circle">
        <?php if (has_custom_logo()): ?>
            <?php
            $logo_id = get_theme_mod('custom_logo');
            $logo_url = wp_get_attachment_image_url($logo_id, 'hero-logo');
            ?>
            <img src="<?php echo esc_url($logo_url); ?>" alt="JM Heights Cooling Corp.">
        <?php else: ?>
            <img src="<?php echo JMHEIGHTS_URI; ?>/images/logo-placeholder.svg" alt="JM Heights Cooling Corp.">
        <?php endif; ?>
    </div>
</section>

<!-- Services Section -->
<section class="section section-light" id="services">
    <div class="container">
        <div class="section-label">What We Do</div>
        <h2 class="section-title">Our <span class="highlight">Services</span></h2>
        <p class="section-subtitle">
            Heating, cooling, plumbing, and everything in between — serving residential,
            commercial, and industrial clients across North Jersey since 1969.
        </p>

        <div class="services-grid">
            <!-- Cooling -->
            <div class="service-card">
                <div class="service-card-header">
                    <div class="service-card-icon">
                        <?php echo jmheights_get_service_icon('cooling'); ?>
                    </div>
                    <div class="service-card-number">01</div>
                </div>
                <h3>Cooling</h3>
                <p>From central AC to ductless mini-splits, we install, repair, tune up, and maintain every type of cooling system — keeping North Jersey homes and businesses comfortable all summer long.</p>
                <ul>
                    <li>Central & rooftop AC installation, repair & tune-up</li>
                    <li>Ductless mini-split systems</li>
                    <li>Air handler & evaporator coil services</li>
                    <li>Filter replacements</li>
                    <li>Refrigerant leak detection & repair</li>
                </ul>
                <a href="<?php echo home_url('/hvac/'); ?>" class="btn-link">
                    Get a Free Estimate <?php echo jmheights_icon('arrow-right'); ?>
                </a>
            </div>

            <!-- Heating -->
            <div class="service-card">
                <div class="service-card-header">
                    <div class="service-card-icon">
                        <?php echo jmheights_get_service_icon('heating'); ?>
                    </div>
                    <div class="service-card-number">02</div>
                </div>
                <h3>Heating</h3>
                <p>Whether it's a boiler, furnace, or heat pump, our technicians handle installation, maintenance, repair, and full replacement — so you're never left in the cold.</p>
                <ul>
                    <li>Boiler installation, maintenance & repair</li>
                    <li>Furnace & heater installation & replacement</li>
                    <li>Heat pump services</li>
                    <li>Emergency heating repair</li>
                    <li>Annual maintenance plans</li>
                </ul>
                <a href="<?php echo home_url('/heating/'); ?>" class="btn-link">
                    Get a Free Estimate <?php echo jmheights_icon('arrow-right'); ?>
                </a>
            </div>

            <!-- Commercial & Industrial -->
            <div class="service-card">
                <div class="service-card-header">
                    <div class="service-card-icon">
                        <?php echo jmheights_get_service_icon('commercial'); ?>
                    </div>
                    <div class="service-card-number">03</div>
                </div>
                <h3>Commercial & Industrial</h3>
                <p>We serve commercial and industrial clients with the same expertise and care as residential — from restaurant coolers to large-scale industrial HVAC and plumbing systems.</p>
                <ul>
                    <li>Commercial & industrial AC & heating</li>
                    <li>Coolers & freezers</li>
                    <li>Commercial & industrial plumbing</li>
                    <li>Preventive maintenance contracts</li>
                    <li>Emergency commercial service</li>
                </ul>
                <a href="<?php echo home_url('/commercial/'); ?>" class="btn-link">
                    Get a Free Estimate <?php echo jmheights_icon('arrow-right'); ?>
                </a>
            </div>

            <!-- Indoor Air Quality -->
            <div class="service-card">
                <div class="service-card-header">
                    <div class="service-card-icon">
                        <?php echo jmheights_get_service_icon('air-quality'); ?>
                    </div>
                    <div class="service-card-number">04</div>
                </div>
                <h3>Indoor Air Quality</h3>
                <p>Breathe easier with professional ductwork, filtration, and air treatment solutions. We design and install systems that keep the air in your home or business clean and healthy.</p>
                <ul>
                    <li>Ductwork repair & installation</li>
                    <li>Air cleaners & purifiers</li>
                    <li>Humidifiers & dehumidifiers</li>
                    <li>HEPA & media filter upgrades</li>
                    <li>Duct sealing & insulation</li>
                </ul>
                <a href="<?php echo home_url('/hvac/indoor-air-quality/'); ?>" class="btn-link">
                    Get a Free Estimate <?php echo jmheights_icon('arrow-right'); ?>
                </a>
            </div>

            <!-- Plumbing -->
            <div class="service-card">
                <div class="service-card-header">
                    <div class="service-card-icon">
                        <?php echo jmheights_get_service_icon('plumbing'); ?>
                    </div>
                    <div class="service-card-number">05</div>
                </div>
                <h3>Plumbing</h3>
                <p>Licensed plumbing services for residential and commercial properties. From routine repairs to full system installations — one contractor for your HVAC and plumbing needs.</p>
                <ul>
                    <li>Residential & commercial plumbing</li>
                    <li>Water heater installation & repair</li>
                    <li>Pipe repair & replacement</li>
                    <li>Emergency plumbing service</li>
                </ul>
                <a href="<?php echo home_url('/plumbing/'); ?>" class="btn-link">
                    Get a Free Estimate <?php echo jmheights_icon('arrow-right'); ?>
                </a>
            </div>

            <!-- Drain Cleaning -->
            <div class="service-card">
                <div class="service-card-header">
                    <div class="service-card-icon">
                        <?php echo jmheights_get_service_icon('drain'); ?>
                    </div>
                    <div class="service-card-number">06</div>
                </div>
                <h3>Drain Cleaning</h3>
                <p>Full-service drain and sewer solutions for residential and commercial properties — from routine clogs to complete sewer rehabilitation.</p>
                <ul>
                    <li>Sewer jetting</li>
                    <li>Camera inspection</li>
                    <li>Sewer repair & replacement</li>
                    <li>Pumps & grinder pumps</li>
                    <li>Pipe locating</li>
                    <li>Drain clogs</li>
                    <li>Mitigation & cleanup</li>
                </ul>
                <a href="<?php echo home_url('/plumbing/drain-services/'); ?>" class="btn-link">
                    Get a Free Estimate <?php echo jmheights_icon('arrow-right'); ?>
                </a>
            </div>

            <!-- Specialized Services -->
            <div class="service-card">
                <div class="service-card-header">
                    <div class="service-card-icon">
                        <?php echo jmheights_get_service_icon('specialized'); ?>
                    </div>
                    <div class="service-card-number">07</div>
                </div>
                <h3>Specialized Services</h3>
                <p>With an on-staff mechanical engineer, we offer custom system design, heat loss/gain calculations, and full electrical wiring for installs — capabilities most HVAC companies simply don't have.</p>
                <ul>
                    <li>Custom system design & builds</li>
                    <li>On-staff mechanical engineer</li>
                    <li>Heat loss/gain calculations</li>
                    <li>Wiring & electrical for installs</li>
                    <li>Permit & inspection assistance</li>
                </ul>
                <a href="<?php echo home_url('/contact/'); ?>" class="btn-link">
                    Get a Free Estimate <?php echo jmheights_icon('arrow-right'); ?>
                </a>
            </div>
        </div>

        <!-- Services CTA -->
        <div class="services-cta">
            <p>Not sure what you need? We'll diagnose it for free.</p>
            <div class="btn-group">
                <a href="tel:+12018243272" class="btn-cta">
                    Call (201) 824-3272
                </a>
                <a href="sms:+12018243272" class="btn-cta btn-outline">
                    Text Us Instead <?php echo jmheights_icon('arrow-right'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section about-section" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-image-wrapper">
                <img src="<?php echo JMHEIGHTS_URI; ?>/images/about-placeholder.jpg" alt="JM Heights Team" class="about-image">
                <div class="about-stat-badge">
                    <span class="stat-number">56+</span>
                    <span class="stat-label">Years in Business</span>
                </div>
            </div>

            <div class="about-content">
                <div class="section-label">About Us</div>
                <h2 class="section-title">Family Owned. <span class="highlight">North Jersey</span> Trusted.</h2>

                <p class="about-text">
                    JM Heights Cooling Corp. is a top-rated, family-owned HVAC and plumbing company that has been serving North Jersey since 1969. With over 56 years of experience, we've built a reputation on honest work, expert knowledge, and treating every customer like a neighbor — because they usually are.
                </p>
                <p class="about-text">
                    We're a true one-stop shop: heating, cooling, and plumbing under one roof, with an on-staff mechanical engineer for custom system design. No subcontracting, no runaround — just the right solution done right the first time.
                </p>

                <ul class="about-features">
                    <li><?php echo jmheights_icon('check'); ?> Family owned & operated since 1969 — not a franchise</li>
                    <li><?php echo jmheights_icon('check'); ?> 56+ years serving North Jersey residential, commercial & industrial</li>
                    <li><?php echo jmheights_icon('check'); ?> On-staff mechanical engineer for system design</li>
                    <li><?php echo jmheights_icon('check'); ?> Licensed HVAC (9370) and Plumbing (12023) contractor</li>
                    <li><?php echo jmheights_icon('check'); ?> One contractor for heating, cooling, and plumbing</li>
                    <li><?php echo jmheights_icon('check'); ?> Financing available through Synchrony</li>
                    <li><?php echo jmheights_icon('check'); ?> Emergency service — call anytime</li>
                    <li><?php echo jmheights_icon('check'); ?> Honest diagnosis, no unnecessary upselling</li>
                </ul>

                <a href="tel:+12018243272" class="btn-cta">
                    Call (201) 824-3272 <?php echo jmheights_icon('arrow-right'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Financing Section -->
<section class="section financing-section section-light" id="financing">
    <div class="container">
        <div class="financing-grid">
            <div class="financing-content">
                <div class="section-label" style="justify-content: flex-start;">Financing Available</div>
                <h2 class="section-title" style="text-align: left;">Don't Let Budget <span class="highlight">Stop</span> Your Comfort</h2>

                <p>Home repairs and system replacements can be daunting. That's why we've partnered with <strong>Synchrony</strong> to offer financing options that fit your budget and lifestyle — so you can get the right system installed now, not later.</p>

                <ul class="financing-features">
                    <li><?php echo jmheights_icon('check'); ?> Quick & straightforward online application</li>
                    <li><?php echo jmheights_icon('check'); ?> Flexible plans to fit your budget</li>
                    <li><?php echo jmheights_icon('check'); ?> No long waits — get approved fast</li>
                    <li><?php echo jmheights_icon('check'); ?> Use for any HVAC or plumbing installation</li>
                    <li><?php echo jmheights_icon('check'); ?> Deferred interest & fixed payment options</li>
                </ul>

                <a href="https://www.synchrony.com/mmc/S6223259807" class="btn-cta" target="_blank" rel="noopener">
                    <?php echo jmheights_icon('arrow-right'); ?>
                    Apply Now with Synchrony
                </a>
            </div>

            <div class="financing-card">
                <h3>Synchrony Financing</h3>
                <p class="subtitle">Powered by Synchrony Financial</p>
                <div class="financing-stats">
                    <div class="financing-stat">
                        <div class="label">Application</div>
                        <div class="value">Quick & Online</div>
                    </div>
                    <div class="financing-stat">
                        <div class="label">Decision</div>
                        <div class="value">Fast Approval</div>
                    </div>
                    <div class="financing-stat">
                        <div class="label">Plans</div>
                        <div class="value">Flexible Options</div>
                    </div>
                    <div class="financing-stat">
                        <div class="label">Use For</div>
                        <div class="value">Any Service</div>
                    </div>
                </div>
                <a href="https://www.synchrony.com/mmc/S6223259807" class="btn-cta" style="width:100%;" target="_blank" rel="noopener">
                    Apply Now &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-label">Ready to Get Started?</div>
        <h2>We Pick Up. We Show Up. <span class="highlight">We Get It Done.</span></h2>
        <p>Whether it's a routine tune-up, an emergency breakdown, or a full system replacement — JM Heights Cooling Corp. is ready. Call or text us today!</p>
        <div class="cta-buttons">
            <a href="tel:+12018243272" class="btn-cta">
                <?php echo jmheights_icon('phone'); ?>
                Call (201) 824-3272
            </a>
            <a href="sms:+12018243272" class="btn-cta btn-outline">
                <?php echo jmheights_icon('text'); ?>
                Text Us
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<?php get_template_part('template-parts/contact-form'); ?>

<?php get_footer(); ?>
