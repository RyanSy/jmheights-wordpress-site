<section class="section contact-section" id="contact">
    <div class="container">
        <div class="section-label">Get In Touch</div>
        <h2 class="section-title">Request a <span class="highlight">Free Estimate</span></h2>
        <p class="section-subtitle">
            Fill out the form and we'll get back to you fast. Prefer to talk? Call or text us directly at
            <a href="tel:+12018243272">(201) 824-3272</a>.
        </p>

        <div class="contact-grid">
            <!-- Contact Info -->
            <div class="contact-info">
                <h3>Contact Info</h3>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <?php echo jmheights_icon('phone'); ?>
                    </div>
                    <div>
                        <h4>Call Us</h4>
                        <a href="tel:+12018243272">(201) 824-3272</a>
                        <div class="meta">Monday - Saturday, 8AM - 7PM</div>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <?php echo jmheights_icon('text'); ?>
                    </div>
                    <div>
                        <h4>Text Us</h4>
                        <a href="sms:+12018243272">Text (201) 824-3272</a>
                        <div class="meta">Fast response guaranteed</div>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <?php echo jmheights_icon('alert'); ?>
                    </div>
                    <div>
                        <h4>Emergency</h4>
                        <a href="tel:+12018243272">Call</a>
                        <div class="meta">24/7 emergency HVAC service</div>
                    </div>
                </div>

                <div class="license-badge">
                    <?php echo jmheights_icon('shield'); ?>
                    <div>
                        <h4>Licensed & Insured</h4>
                        <p>HVAC License #9370 · Plumbing License #12023<br>Serving all of North Jersey.</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <form class="contact-form" id="jmheights-contact-form">
                    <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

                    <div class="form-group">
                        <label for="contact-name">Full Name *</label>
                        <input type="text" id="contact-name" name="name" placeholder="John Smith" required>
                    </div>

                    <div class="form-group">
                        <label for="contact-phone">Phone Number *</label>
                        <input type="tel" id="contact-phone" name="phone" placeholder="(555) 123-4567" required>
                    </div>

                    <div class="form-group">
                        <label for="contact-email">Email Address *</label>
                        <input type="email" id="contact-email" name="email" placeholder="john@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="contact-service">Service Needed</label>
                        <select id="contact-service" name="service">
                            <option value="" disabled selected>Select a service…</option>
                            <option value="AC Installation / Replacement">AC Installation / Replacement</option>
                            <option value="AC Repair & Tune-Up">AC Repair & Tune-Up</option>
                            <option value="Ductless Mini-Split">Ductless Mini-Split</option>
                            <option value="Heating / Boiler / Furnace">Heating / Boiler / Furnace</option>
                            <option value="Heat Pump">Heat Pump</option>
                            <option value="Commercial HVAC">Commercial HVAC</option>
                            <option value="Indoor Air Quality">Indoor Air Quality</option>
                            <option value="Plumbing">Plumbing</option>
                            <option value="Emergency Service">Emergency Service</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contact-message">Message / Project Details *</label>
                        <textarea id="contact-message" name="message" placeholder="Tell us about your project — type of work, home size, urgency, any concerns…" required></textarea>
                    </div>

                    <p class="form-disclaimer">
                        Your information is never shared or sold. By submitting, you agree to be contacted by JM Heights regarding your inquiry.
                    </p>

                    <button type="submit" class="btn-cta" style="width: 100%;">
                        <?php echo jmheights_icon('mail'); ?>
                        Send Message
                    </button>

                    <div class="form-message" id="form-message" style="display:none; margin-top: 16px; padding: 16px; text-align: center;"></div>
                </form>
            </div>
        </div>
    </div>
</section>
