<?php
/**
 * Plugin Name: JM Heights Content Setup
 * Description: Creates all pages and menus for the JM Heights website. Activate to set up content, then deactivate.
 * Version: 1.0.0
 * Author: JM Heights
 */

if (!defined('ABSPATH')) exit;

register_activation_hook(__FILE__, 'jmheights_setup_content');

function jmheights_setup_content() {
    // Set up reading settings
    $front_page = jmheights_create_front_page();

    // Create all pages
    jmheights_create_all_pages();

    // Create menus
    jmheights_create_menus();

    // Set front page
    update_option('show_on_front', 'page');
    update_option('page_on_front', $front_page);

    // Set permalink structure
    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules();

    // Activate theme
    switch_theme('jmheights');

    // Set site title and tagline
    update_option('blogname', 'JM Heights Cooling Corp.');
    update_option('blogdescription', 'Top Rated HVAC & Plumbing | North Jersey');
}

function jmheights_create_front_page() {
    $existing = get_page_by_path('home');
    if ($existing) return $existing->ID;

    return wp_insert_post([
        'post_title'   => 'Home',
        'post_name'    => 'home',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
        'page_template' => '',
        'menu_order'   => 0,
    ]);
}

function jmheights_create_all_pages() {
    $pages = jmheights_get_page_data();

    foreach ($pages as $page_data) {
        jmheights_create_page_recursive($page_data, 0);
    }
}

function jmheights_create_page_recursive($page_data, $parent_id) {
    $slug = $page_data['slug'];
    $existing = get_page_by_path($slug);

    if ($existing) {
        $page_id = $existing->ID;
    } else {
        $args = [
            'post_title'   => $page_data['title'],
            'post_name'    => basename($slug),
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => $page_data['content'] ?? '',
            'post_parent'  => $parent_id,
            'menu_order'   => $page_data['order'] ?? 0,
        ];

        if (!empty($page_data['template'])) {
            $args['page_template'] = $page_data['template'];
        }

        $page_id = wp_insert_post($args);
    }

    if (!empty($page_data['children'])) {
        foreach ($page_data['children'] as $child) {
            jmheights_create_page_recursive($child, $page_id);
        }
    }

    return $page_id;
}

function jmheights_get_page_data() {
    return [
        // About
        [
            'title' => 'About JM Heights',
            'slug' => 'about',
            'order' => 1,
            'content' => jmheights_about_content(),
            'children' => [
                ['title' => 'Our Story — Family-Owned Since 1969', 'slug' => 'about/our-story', 'order' => 1, 'content' => jmheights_our_story_content()],
                ['title' => 'Licenses & Credentials', 'slug' => 'about/licenses', 'order' => 2, 'content' => jmheights_licenses_content()],
                ['title' => 'Our Team', 'slug' => 'about/team', 'order' => 3, 'content' => jmheights_team_content()],
            ],
        ],

        // Why Choose JM Heights
        [
            'title' => 'Why Choose JM Heights',
            'slug' => 'why-jm-heights',
            'order' => 2,
            'content' => jmheights_why_choose_content(),
        ],

        // Plumbing
        [
            'title' => 'Plumbing',
            'slug' => 'plumbing',
            'order' => 3,
            'content' => jmheights_plumbing_content(),
            'children' => [
                [
                    'title' => 'Water Heaters',
                    'slug' => 'plumbing/water-heaters',
                    'order' => 1,
                    'content' => jmheights_water_heaters_content(),
                    'children' => [
                        ['title' => 'Water Heater Repair', 'slug' => 'plumbing/water-heaters/repair', 'order' => 1, 'content' => jmheights_service_page_content('Water Heater Repair', 'Our expert technicians diagnose and repair all types of water heaters — tank, tankless, gas, and electric. We carry common parts on our trucks for fast, same-day repairs whenever possible.', ['Diagnosis & troubleshooting', 'Thermostat & element replacement', 'Anode rod replacement', 'Leak repair', 'Gas valve & igniter repair', 'Sediment flush & maintenance'])],
                        ['title' => 'Water Heater Installation', 'slug' => 'plumbing/water-heaters/installation', 'order' => 2, 'content' => jmheights_service_page_content('Water Heater Installation', 'Whether you\'re upgrading your current system or installing a water heater in a new build, our licensed plumbers ensure proper sizing, code-compliant installation, and reliable performance.', ['Tank & tankless options', 'Gas & electric systems', 'Proper sizing for your home', 'Code-compliant installation', 'Permits & inspection coordination', 'Old unit removal & disposal'])],
                        ['title' => 'Water Heater Replacement', 'slug' => 'plumbing/water-heaters/replacement', 'order' => 3, 'content' => jmheights_service_page_content('Water Heater Replacement', 'When repair isn\'t cost-effective, we help you choose and install the right replacement water heater. We\'ll walk you through your options and handle everything from removal to installation.', ['Expert replacement recommendations', 'Energy-efficient upgrades', 'Same-day replacement available', 'Old unit disposal included', 'All major brands', 'Financing available'])],
                        ['title' => 'Tankless Water Heater Installation', 'slug' => 'plumbing/water-heaters/tankless-installation', 'order' => 4, 'content' => jmheights_service_page_content('Tankless Water Heater Installation', 'Go tankless for endless hot water and lower energy bills. Our team handles the complete installation process, including gas line upgrades and venting modifications.', ['Endless hot water on demand', 'Energy savings up to 34%', 'Compact wall-mounted design', 'Gas line sizing & upgrades', 'Proper venting installation', '20+ year lifespan'])],
                        ['title' => 'Tankless Water Heater Repair', 'slug' => 'plumbing/water-heaters/tankless-repair', 'order' => 5, 'content' => jmheights_service_page_content('Tankless Water Heater Repair', 'Experienced with all major tankless brands — Navien, Rinnai, Noritz, and more. We diagnose and fix error codes, flow sensor issues, ignition problems, and scale buildup.', ['All major brands serviced', 'Error code diagnosis', 'Descaling & flushing', 'Flow sensor repair', 'Ignition system repair', 'Heat exchanger service'])],
                    ],
                ],
                [
                    'title' => 'Sewer Services',
                    'slug' => 'plumbing/sewer-services',
                    'order' => 2,
                    'content' => jmheights_service_page_content('Sewer Services', 'Complete sewer solutions from inspection to repair and replacement. Our experienced plumbers handle everything from routine maintenance to emergency sewer problems.', ['Full sewer diagnostics', 'Camera inspection', 'Line repair & replacement', 'Trenchless technology', 'Cleaning & jetting', 'Emergency service']),
                    'children' => [
                        ['title' => 'Sewer Line Repair', 'slug' => 'plumbing/sewer-services/line-repair', 'order' => 1, 'content' => jmheights_service_page_content('Sewer Line Repair', 'Expert sewer line repair using both traditional and trenchless methods. We diagnose the problem with camera inspection and recommend the most cost-effective solution.', ['Camera-guided diagnosis', 'Spot repairs', 'Pipe bursting', 'Cured-in-place pipe (CIPP)', 'Root removal', 'Emergency repairs'])],
                        ['title' => 'Sewer Line Replacement', 'slug' => 'plumbing/sewer-services/line-replacement', 'order' => 2, 'content' => jmheights_service_page_content('Sewer Line Replacement', 'When repair isn\'t an option, we provide full sewer line replacement with minimal disruption to your property. Traditional and trenchless options available.', ['Full line replacement', 'Trenchless options', 'Minimal property disruption', 'Code-compliant installation', 'Permits & inspections', 'Property restoration'])],
                        ['title' => 'Trenchless Sewer Repair', 'slug' => 'plumbing/sewer-services/trenchless-repair', 'order' => 3, 'content' => jmheights_service_page_content('Trenchless Sewer Repair', 'Repair your sewer line without digging up your yard. Our trenchless methods — including pipe lining and pipe bursting — save time, money, and your landscaping.', ['No excavation required', 'Pipe lining (CIPP)', 'Pipe bursting', 'Saves landscaping & hardscaping', 'Faster completion', 'Long-lasting results'])],
                        ['title' => 'Sewer Line Cleaning', 'slug' => 'plumbing/sewer-services/cleaning', 'order' => 4, 'content' => jmheights_service_page_content('Sewer Line Cleaning', 'Professional sewer cleaning to keep your lines flowing freely. We use hydro jetting and mechanical cleaning to remove buildup, roots, and blockages.', ['Hydro jetting', 'Mechanical cleaning', 'Root removal', 'Grease removal', 'Preventive maintenance', 'Camera verification'])],
                        ['title' => 'Sewer Camera Inspection', 'slug' => 'plumbing/sewer-services/camera-inspection', 'order' => 5, 'content' => jmheights_service_page_content('Sewer Camera Inspection', 'See exactly what\'s happening inside your sewer line with our HD camera inspection. We locate blockages, breaks, root intrusion, and other problems with precision.', ['HD video inspection', 'Precise problem location', 'Real-time viewing', 'Digital recording provided', 'Pre-purchase inspections', 'Post-repair verification'])],
                    ],
                ],
                [
                    'title' => 'Drain Services',
                    'slug' => 'plumbing/drain-services',
                    'order' => 3,
                    'content' => jmheights_service_page_content('Drain Services', 'Complete drain solutions for residential and commercial properties. From simple clogs to complex blockages, our plumbers have the tools and expertise to get your drains flowing.', ['Kitchen & bathroom drains', 'Floor drains', 'Main line clearing', 'Hydro jetting', 'Camera inspection', 'Emergency service']),
                    'children' => [
                        ['title' => 'Drain Cleaning', 'slug' => 'plumbing/drain-services/cleaning', 'order' => 1, 'content' => jmheights_service_page_content('Drain Cleaning', 'Professional drain cleaning for every type of drain in your home or business. We clear blockages fast and help prevent future problems.', ['Kitchen sink drains', 'Bathroom sink & tub drains', 'Shower drains', 'Floor drains', 'Laundry drains', 'Main sewer line'])],
                        ['title' => 'Hydro Jetting', 'slug' => 'plumbing/drain-services/hydro-jetting', 'order' => 2, 'content' => jmheights_service_page_content('Hydro Jetting', 'High-pressure water jetting to blast away grease, scale, roots, and debris from your drain and sewer lines. The most effective cleaning method available.', ['High-pressure water cleaning', 'Removes grease & scale', 'Cuts through roots', 'Safe for most pipes', 'Commercial & residential', 'Preventive maintenance'])],
                        ['title' => 'Clogged Drain Repair', 'slug' => 'plumbing/drain-services/clogged-drain-repair', 'order' => 3, 'content' => jmheights_service_page_content('Clogged Drain Repair', 'Fast, reliable clogged drain repair. We diagnose the cause and provide a lasting fix — not just a temporary solution.', ['Same-day service', 'Camera diagnosis available', 'Mechanical & hydro clearing', 'Pipe repair if needed', 'Preventive recommendations', 'Emergency availability'])],
                    ],
                ],
                [
                    'title' => 'Gas Line Services',
                    'slug' => 'plumbing/gas-line-services',
                    'order' => 4,
                    'content' => jmheights_service_page_content('Gas Line Services', 'Licensed gas line installation, repair, and leak detection. Safety is our top priority — if you smell gas, call us immediately.', ['Gas line installation', 'Gas line repair', 'Leak detection & testing', 'Gas appliance connections', 'Code compliance', 'Emergency service']),
                    'children' => [
                        ['title' => 'Gas Line Repair', 'slug' => 'plumbing/gas-line-services/repair', 'order' => 1, 'content' => jmheights_service_page_content('Gas Line Repair', 'Expert gas line repair by licensed technicians. We prioritize safety and ensure all repairs meet code requirements.', ['Emergency gas line repair', 'Leak repair', 'Pipe replacement', 'Valve replacement', 'Pressure testing', 'Code compliance'])],
                        ['title' => 'Gas Line Installation', 'slug' => 'plumbing/gas-line-services/installation', 'order' => 2, 'content' => jmheights_service_page_content('Gas Line Installation', 'Professional gas line installation for new appliances, renovations, and new construction. We handle permits, installation, and inspection.', ['New appliance connections', 'Kitchen gas line extensions', 'Outdoor gas lines (grills, fire pits)', 'Whole-house gas piping', 'Permits & inspections', 'Code-compliant installation'])],
                        ['title' => 'Gas Leak Detection', 'slug' => 'plumbing/gas-line-services/leak-detection', 'order' => 3, 'content' => jmheights_service_page_content('Gas Leak Detection', 'Professional gas leak detection to keep your family safe. If you suspect a gas leak, leave the area immediately and call us.', ['Electronic leak detection', 'Pressure testing', 'Visual inspection', 'Immediate repair available', 'Safety consultation', '24/7 emergency service'])],
                    ],
                ],
                ['title' => 'Sump Pump Services', 'slug' => 'plumbing/sump-pump-services', 'order' => 5, 'content' => jmheights_service_page_content('Sump Pump Services', 'Protect your basement from flooding with professional sump pump installation, repair, and maintenance. We keep your sump pump ready when you need it most.', ['Sump pump installation', 'Sump pump repair', 'Battery backup systems', 'Preventive maintenance', 'Pit installation', 'Emergency service'])],
                ['title' => 'Leak Detection', 'slug' => 'plumbing/leak-detection', 'order' => 6, 'content' => jmheights_service_page_content('Leak Detection', 'Advanced leak detection technology to find hidden leaks without destructive testing. We locate the source fast and fix it right.', ['Electronic leak detection', 'Thermal imaging', 'Acoustic detection', 'Slab leak detection', 'Underground leak detection', 'Non-invasive methods'])],
                ['title' => 'Toilet Repair & Installation', 'slug' => 'plumbing/toilet-repair-installation', 'order' => 7, 'content' => jmheights_service_page_content('Toilet Repair & Installation', 'Expert toilet repair and installation services. From running toilets to complete replacements, we handle it all.', ['Running toilet repair', 'Clog removal', 'Flapper & valve replacement', 'New toilet installation', 'Low-flow upgrades', 'Commercial toilets'])],
                ['title' => 'Faucet Repair & Installation', 'slug' => 'plumbing/faucet-repair-installation', 'order' => 8, 'content' => jmheights_service_page_content('Faucet Repair & Installation', 'Professional faucet repair and installation for kitchens, bathrooms, and utility sinks. We fix leaks, drips, and low pressure.', ['Leak repair', 'Cartridge & valve replacement', 'New faucet installation', 'Kitchen & bathroom faucets', 'Commercial faucets', 'All major brands'])],
                ['title' => 'Garbage Disposal Services', 'slug' => 'plumbing/garbage-disposal', 'order' => 9, 'content' => jmheights_service_page_content('Garbage Disposal Services', 'Garbage disposal installation, repair, and replacement. We\'ll get your kitchen sink working properly again.', ['New disposal installation', 'Disposal repair', 'Jam clearing', 'Motor replacement', 'Wiring & plumbing connections', 'All major brands'])],
                ['title' => 'Backflow Testing & Certification', 'slug' => 'plumbing/backflow-testing', 'order' => 10, 'content' => jmheights_service_page_content('Backflow Testing & Certification', 'Certified backflow prevention testing and repair. We help protect your water supply and keep you compliant with local regulations.', ['Annual backflow testing', 'Certification & reporting', 'Backflow preventer repair', 'New device installation', 'Compliance assistance', 'Commercial & residential'])],
            ],
        ],

        // HVAC
        [
            'title' => 'HVAC',
            'slug' => 'hvac',
            'order' => 4,
            'content' => jmheights_hvac_content(),
            'children' => [
                [
                    'title' => 'Heat Pumps',
                    'slug' => 'hvac/heat-pumps',
                    'order' => 1,
                    'content' => jmheights_service_page_content('Heat Pumps', 'Energy-efficient heating and cooling with a single system. Our heat pump experts handle installation, repair, and replacement for all types of heat pump systems.', ['Air source heat pumps', 'Ductless mini-split heat pumps', 'Dual fuel systems', 'Geothermal heat pumps', 'High-efficiency models', 'All major brands']),
                    'children' => [
                        ['title' => 'Heat Pump Repair', 'slug' => 'hvac/heat-pumps/repair', 'order' => 1, 'content' => jmheights_service_page_content('Heat Pump Repair', 'Fast, reliable heat pump repair by certified HVAC technicians. We diagnose and fix all heat pump issues — from refrigerant leaks to compressor failures.', ['All brands & models', 'Refrigerant leak repair', 'Compressor repair', 'Defrost cycle issues', 'Thermostat problems', 'Emergency service available'])],
                        ['title' => 'Heat Pump Installation', 'slug' => 'hvac/heat-pumps/installation', 'order' => 2, 'content' => jmheights_service_page_content('Heat Pump Installation', 'Professional heat pump installation with proper load calculation and system sizing. We ensure maximum efficiency and comfort.', ['Load calculation & sizing', 'Ductwork evaluation', 'Energy-efficient models', 'Rebate assistance', 'Permit coordination', 'Quality installation guarantee'])],
                        ['title' => 'Heat Pump Replacement', 'slug' => 'hvac/heat-pumps/replacement', 'order' => 3, 'content' => jmheights_service_page_content('Heat Pump Replacement', 'Upgrade to a new, high-efficiency heat pump. We help you choose the right system and handle the complete replacement process.', ['System evaluation', 'Right-sizing for your home', 'High-efficiency options', 'Old unit removal & disposal', 'Ductwork modifications', 'Financing available'])],
                    ],
                ],
                [
                    'title' => 'Indoor Air Quality',
                    'slug' => 'hvac/indoor-air-quality',
                    'order' => 2,
                    'content' => jmheights_service_page_content('Indoor Air Quality', 'Breathe cleaner, healthier air with professional indoor air quality solutions. We design and install systems tailored to your specific needs.', ['Air quality assessment', 'Filtration systems', 'Humidity control', 'Ventilation solutions', 'UV germicidal lights', 'Duct sealing & cleaning']),
                    'children' => [
                        ['title' => 'Whole-Home Humidifiers', 'slug' => 'hvac/indoor-air-quality/humidifiers', 'order' => 1, 'content' => jmheights_service_page_content('Whole-Home Humidifiers', 'Combat dry winter air with a whole-home humidifier. Protect your family\'s health, your home\'s woodwork, and your comfort.', ['Steam humidifiers', 'Bypass humidifiers', 'Fan-powered humidifiers', 'Automatic humidity control', 'Integration with existing HVAC', 'Annual maintenance'])],
                        ['title' => 'Air Purifiers', 'slug' => 'hvac/indoor-air-quality/air-purifiers', 'order' => 2, 'content' => jmheights_service_page_content('Air Purifiers', 'Whole-home air purification systems that remove allergens, bacteria, viruses, and odors. Breathe easier with professional-grade air cleaning.', ['HEPA filtration', 'UV germicidal lights', 'Electronic air cleaners', 'Carbon filtration', 'Allergen reduction', 'Odor elimination'])],
                        ['title' => 'Duct Cleaning', 'slug' => 'hvac/indoor-air-quality/duct-cleaning', 'order' => 3, 'content' => jmheights_service_page_content('Duct Cleaning', 'Professional duct cleaning to remove dust, debris, mold, and allergens from your ductwork. Improve air quality and system efficiency.', ['Complete duct cleaning', 'Vent & register cleaning', 'Mold remediation', 'Dust & debris removal', 'Before & after inspection', 'Sanitizing treatment'])],
                        ['title' => 'Dehumidifiers', 'slug' => 'hvac/indoor-air-quality/dehumidifiers', 'order' => 4, 'content' => jmheights_service_page_content('Dehumidifiers', 'Control excess moisture with whole-home dehumidifiers. Prevent mold growth, protect your home, and improve comfort.', ['Whole-home dehumidifiers', 'Basement dehumidifiers', 'Crawl space solutions', 'Automatic humidity control', 'Drainage options', 'Energy-efficient models'])],
                    ],
                ],
                ['title' => 'AC Repair', 'slug' => 'hvac/ac-repair', 'order' => 3, 'content' => jmheights_service_page_content('AC Repair', 'Fast, reliable AC repair when you need it most. Our certified technicians diagnose and fix all types of air conditioning problems.', ['All brands & models', 'Refrigerant recharge', 'Compressor repair', 'Fan motor replacement', 'Thermostat issues', 'Emergency AC repair'])],
                ['title' => 'AC Installation', 'slug' => 'hvac/ac-installation', 'order' => 4, 'content' => jmheights_service_page_content('AC Installation', 'Professional AC installation with proper load calculation and ductwork evaluation. We ensure your new system is sized correctly for maximum comfort and efficiency.', ['Load calculation & sizing', 'Central AC systems', 'Ductless mini-splits', 'Ductwork design & install', 'High-efficiency models', 'Rebate assistance'])],
                ['title' => 'AC Replacement', 'slug' => 'hvac/ac-replacement', 'order' => 5, 'content' => jmheights_service_page_content('AC Replacement', 'When it\'s time for a new AC, we help you choose the right system and handle the complete replacement. Upgrade to a more efficient, quieter system.', ['System evaluation', 'Energy-efficient upgrades', 'Proper sizing', 'Ductwork assessment', 'Old unit disposal', 'Financing available'])],
                ['title' => 'AC Maintenance', 'slug' => 'hvac/ac-maintenance', 'order' => 6, 'content' => jmheights_service_page_content('AC Maintenance', 'Keep your AC running efficiently with regular maintenance. Our comprehensive tune-up helps prevent breakdowns and extends system life.', ['Comprehensive inspection', 'Coil cleaning', 'Refrigerant check', 'Electrical testing', 'Filter replacement', 'Performance optimization'])],
                ['title' => 'Ductless Mini-Split', 'slug' => 'hvac/ductless-mini-split', 'order' => 7, 'content' => jmheights_service_page_content('Ductless Mini-Split', 'Ductless mini-split systems for efficient heating and cooling without ductwork. Perfect for room additions, sunrooms, garages, and older homes.', ['Single & multi-zone systems', 'Heating & cooling in one', 'No ductwork required', 'Energy-efficient operation', 'Quiet performance', 'Individual room control'])],
            ],
        ],

        // Heating
        [
            'title' => 'Heating',
            'slug' => 'heating',
            'order' => 5,
            'content' => jmheights_heating_content(),
            'children' => [
                [
                    'title' => 'Boilers',
                    'slug' => 'heating/boilers',
                    'order' => 1,
                    'content' => jmheights_service_page_content('Boilers', 'Complete boiler services — installation, repair, and replacement. We work with all types of boilers including steam, hot water, and high-efficiency condensing boilers.', ['Steam & hot water boilers', 'High-efficiency condensing', 'Gas & oil boilers', 'Installation & replacement', 'Repair & maintenance', 'All major brands']),
                    'children' => [
                        ['title' => 'Boiler Repair', 'slug' => 'heating/boilers/repair', 'order' => 1, 'content' => jmheights_service_page_content('Boiler Repair', 'Expert boiler repair for all types and brands. We diagnose and fix heating issues quickly to restore your comfort.', ['All boiler types', 'Circulator pump repair', 'Valve replacement', 'Leak repair', 'Control board issues', 'Emergency service'])],
                        ['title' => 'Boiler Installation', 'slug' => 'heating/boilers/installation', 'order' => 2, 'content' => jmheights_service_page_content('Boiler Installation', 'Professional boiler installation with proper sizing and system design. We handle everything from permits to final inspection.', ['System design & sizing', 'High-efficiency options', 'Steam & hot water systems', 'Piping & controls', 'Permits & inspections', 'Financing available'])],
                        ['title' => 'Boiler Replacement', 'slug' => 'heating/boilers/replacement', 'order' => 3, 'content' => jmheights_service_page_content('Boiler Replacement', 'Upgrade to a new, efficient boiler. We help you select the right system and handle the complete replacement process.', ['System evaluation', 'Energy-efficient upgrades', 'Oil-to-gas conversion', 'Old boiler removal', 'New piping if needed', 'Financing available'])],
                    ],
                ],
                [
                    'title' => 'Furnaces',
                    'slug' => 'heating/furnaces',
                    'order' => 2,
                    'content' => jmheights_service_page_content('Furnaces', 'Complete furnace services for gas, oil, and electric furnaces. Installation, repair, replacement, and maintenance by certified technicians.', ['Gas & oil furnaces', 'High-efficiency models', 'Installation & replacement', 'Repair & diagnostics', 'Annual maintenance', 'All major brands']),
                    'children' => [
                        ['title' => 'Furnace Repair', 'slug' => 'heating/furnaces/repair', 'order' => 1, 'content' => jmheights_service_page_content('Furnace Repair', 'Fast furnace repair to restore your heat. Our technicians diagnose and fix all furnace problems — from ignition issues to blower motor failures.', ['All brands & models', 'Ignition system repair', 'Blower motor replacement', 'Heat exchanger inspection', 'Gas valve repair', 'Emergency service'])],
                        ['title' => 'Furnace Installation', 'slug' => 'heating/furnaces/installation', 'order' => 2, 'content' => jmheights_service_page_content('Furnace Installation', 'Professional furnace installation with proper sizing and ductwork evaluation. We ensure maximum comfort and efficiency.', ['Load calculation & sizing', 'High-efficiency models', 'Ductwork evaluation', 'Gas line connections', 'Permits & inspections', 'Financing available'])],
                        ['title' => 'Furnace Replacement', 'slug' => 'heating/furnaces/replacement', 'order' => 3, 'content' => jmheights_service_page_content('Furnace Replacement', 'Upgrade to a new, efficient furnace. We help you choose the right system for your home and handle the complete replacement.', ['System evaluation', 'Energy-efficient options', 'Proper sizing', 'Old furnace removal', 'Ductwork modifications', 'Financing available'])],
                    ],
                ],
                ['title' => 'Radiant Floor Heating', 'slug' => 'heating/radiant-floor-heating', 'order' => 3, 'content' => jmheights_service_page_content('Radiant Floor Heating', 'Enjoy the ultimate comfort of radiant floor heating. We design and install hydronic and electric radiant heating systems.', ['Hydronic radiant heat', 'Electric radiant heat', 'New construction & retrofit', 'Bathroom & kitchen heating', 'Whole-home systems', 'Boiler integration'])],
                ['title' => 'Oil-to-Gas Conversion', 'slug' => 'heating/oil-to-gas-conversion', 'order' => 4, 'content' => jmheights_service_page_content('Oil-to-Gas Conversion', 'Switch from oil to natural gas for cleaner, more efficient heating. We handle the complete conversion process including new equipment, gas line installation, and oil tank removal.', ['Complete conversion service', 'New gas equipment', 'Gas line installation', 'Oil tank removal assistance', 'Rebate assistance', 'Lower heating costs'])],
                ['title' => 'Heating Maintenance', 'slug' => 'heating/heating-maintenance', 'order' => 5, 'content' => jmheights_service_page_content('Heating Maintenance', 'Annual heating maintenance to keep your system running safely and efficiently. Our comprehensive tune-up helps prevent breakdowns and extends system life.', ['Comprehensive system inspection', 'Safety checks', 'Cleaning & adjustments', 'Filter replacement', 'Efficiency optimization', 'Priority scheduling'])],
            ],
        ],

        // Commercial
        [
            'title' => 'Commercial',
            'slug' => 'commercial',
            'order' => 6,
            'content' => jmheights_commercial_content(),
            'children' => [
                ['title' => 'Commercial Plumbing', 'slug' => 'commercial/plumbing', 'order' => 1, 'content' => jmheights_service_page_content('Commercial Plumbing', 'Licensed commercial plumbing services for businesses, restaurants, offices, and industrial facilities. We understand the unique needs of commercial plumbing systems.', ['Pipe repair & replacement', 'Fixture installation', 'Backflow prevention', 'Water heater systems', 'Emergency service', 'Preventive maintenance'])],
                ['title' => 'Commercial HVAC', 'slug' => 'commercial/hvac', 'order' => 2, 'content' => jmheights_service_page_content('Commercial HVAC', 'Commercial and industrial HVAC installation, repair, and maintenance. We keep your business comfortable and your systems running efficiently.', ['Rooftop units (RTUs)', 'Split systems', 'VRF/VRV systems', 'Building automation', 'Energy management', 'Preventive maintenance'])],
                ['title' => 'Commercial Refrigeration', 'slug' => 'commercial/refrigeration', 'order' => 3, 'content' => jmheights_service_page_content('Commercial Refrigeration', 'Commercial refrigeration services for restaurants, supermarkets, and food service businesses. We install, repair, and maintain all types of commercial refrigeration.', ['Walk-in coolers & freezers', 'Reach-in refrigerators', 'Display cases', 'Ice machines', 'Refrigeration repair', 'Preventive maintenance'])],
                ['title' => 'Commercial Boilers', 'slug' => 'commercial/boilers', 'order' => 4, 'content' => jmheights_service_page_content('Commercial Boilers', 'Commercial boiler installation, repair, and maintenance. We work with all types and sizes of commercial boiler systems.', ['Steam & hot water boilers', 'High-efficiency systems', 'Installation & replacement', 'Repair & diagnostics', 'Annual inspections', 'Maintenance contracts'])],
                ['title' => 'Commercial Water Heaters', 'slug' => 'commercial/water-heaters', 'order' => 5, 'content' => jmheights_service_page_content('Commercial Water Heaters', 'Commercial water heater installation and service for businesses of all sizes. Tank, tankless, and high-volume systems.', ['Tank systems', 'Tankless systems', 'High-volume solutions', 'Installation & replacement', 'Repair & maintenance', 'Energy-efficient options'])],
                ['title' => 'Preventive Maintenance Programs', 'slug' => 'commercial/preventive-maintenance', 'order' => 6, 'content' => jmheights_service_page_content('Preventive Maintenance Programs', 'Customized maintenance programs for commercial and industrial clients. Protect your investment and minimize downtime with regular professional maintenance.', ['Customized maintenance plans', 'Priority scheduling', 'Discounted repairs', 'System inspections', 'Documentation & reporting', 'Emergency response'])],
            ],
        ],

        // Service Areas
        [
            'title' => 'Service Areas',
            'slug' => 'service-areas',
            'order' => 7,
            'template' => 'page-templates/template-service-areas.php',
            'content' => '',
            'children' => [
                ['title' => 'Bergen County', 'slug' => 'service-areas/bergen-county', 'order' => 1, 'content' => jmheights_county_content('Bergen County')],
                ['title' => 'Passaic County', 'slug' => 'service-areas/passaic-county', 'order' => 2, 'content' => jmheights_county_content('Passaic County')],
            ],
        ],

        // Maintenance Plans
        [
            'title' => 'Maintenance Plans',
            'slug' => 'maintenance-plans',
            'order' => 8,
            'content' => jmheights_maintenance_plans_content(),
        ],

        // Emergency Service
        [
            'title' => 'Emergency Service',
            'slug' => 'emergency-service',
            'order' => 9,
            'content' => jmheights_emergency_content(),
        ],

        // Contact
        [
            'title' => 'Contact Us',
            'slug' => 'contact',
            'order' => 10,
            'template' => 'page-templates/template-contact.php',
            'content' => '',
        ],

        // Footer-linked pages
        ['title' => 'Customer Reviews', 'slug' => 'reviews', 'order' => 11, 'content' => jmheights_reviews_content()],
        ['title' => 'Financing', 'slug' => 'financing', 'order' => 12, 'content' => jmheights_financing_page_content()],
        ['title' => 'Coupons & Specials', 'slug' => 'coupons', 'order' => 13, 'content' => jmheights_coupons_content()],
        ['title' => 'FAQs', 'slug' => 'faqs', 'order' => 14, 'content' => jmheights_faqs_content()],
        ['title' => 'Terms of Use', 'slug' => 'terms', 'order' => 15, 'content' => '<h2>Terms of Use</h2><p>Please review our terms of use. By using this website, you agree to the following terms and conditions.</p>'],
        ['title' => 'Privacy Policy', 'slug' => 'privacy', 'order' => 16, 'content' => '<h2>Privacy Policy</h2><p>Your privacy is important to us. This policy outlines how we collect, use, and protect your personal information.</p>'],
    ];
}

// Content generation functions
function jmheights_service_page_content($title, $description, $features = []) {
    $content = "<h2>$title</h2>\n<p>$description</p>\n";

    if (!empty($features)) {
        $content .= "\n<h3>What We Offer</h3>\n<ul>\n";
        foreach ($features as $feature) {
            $content .= "<li>$feature</li>\n";
        }
        $content .= "</ul>\n";
    }

    $content .= "\n<h3>Why Choose JM Heights?</h3>\n";
    $content .= "<p>With over 56 years of experience, JM Heights Cooling Corp. is North Jersey's trusted choice for HVAC and plumbing services. We're family-owned, fully licensed, and committed to honest, quality work.</p>\n";
    $content .= "<ul>\n";
    $content .= "<li>Family owned & operated since 1969</li>\n";
    $content .= "<li>Licensed HVAC (#9370) and Plumbing (#12023)</li>\n";
    $content .= "<li>On-staff mechanical engineer</li>\n";
    $content .= "<li>Financing available through Synchrony</li>\n";
    $content .= "<li>Emergency service available</li>\n";
    $content .= "</ul>\n";

    $content .= "\n<h3>Schedule Your Service</h3>\n";
    $content .= "<p>Ready to get started? Call us at <a href=\"tel:+12018243272\">(201) 824-3272</a> or <a href=\"/contact/\">request a free estimate online</a>. We serve all of North Jersey including Bergen County and Passaic County.</p>\n";

    return $content;
}

function jmheights_about_content() {
    return '<h2>About JM Heights Cooling Corp.</h2>
<p>JM Heights Cooling Corp. is a top-rated, family-owned HVAC and plumbing company that has been serving North Jersey since 1969. With over 56 years of experience, we\'ve built a reputation on honest work, expert knowledge, and treating every customer like a neighbor — because they usually are.</p>

<p>We\'re a true one-stop shop: heating, cooling, and plumbing under one roof, with an on-staff mechanical engineer for custom system design. No subcontracting, no runaround — just the right solution done right the first time.</p>

<h3>What Sets Us Apart</h3>
<ul>
<li>Family owned & operated since 1969 — not a franchise</li>
<li>56+ years serving North Jersey residential, commercial & industrial</li>
<li>On-staff mechanical engineer for system design</li>
<li>Licensed HVAC (9370) and Plumbing (12023) contractor</li>
<li>One contractor for heating, cooling, and plumbing</li>
<li>Financing available through Synchrony</li>
<li>Emergency service — call anytime</li>
<li>Honest diagnosis, no unnecessary upselling</li>
</ul>';
}

function jmheights_our_story_content() {
    return '<h2>Our Story — Family-Owned Since 1969</h2>
<p>JM Heights Cooling Corp. was founded in 1969 with a simple mission: provide honest, expert HVAC and plumbing services to our North Jersey neighbors. Over 56 years later, that mission hasn\'t changed — but we\'ve grown from a small family operation to one of the most trusted names in the industry.</p>

<p>From our humble beginnings, we\'ve always believed that the best business is built on relationships, not transactions. That\'s why our customers come back year after year, and why their children and grandchildren call us too.</p>

<h3>Our Values</h3>
<ul>
<li>Honesty in every diagnosis and recommendation</li>
<li>Quality work that stands the test of time</li>
<li>Fair pricing with no hidden fees</li>
<li>Respect for your home and your time</li>
<li>Continuous training and education</li>
<li>Community involvement and support</li>
</ul>';
}

function jmheights_licenses_content() {
    return '<h2>Licenses & Credentials</h2>
<p>JM Heights Cooling Corp. is fully licensed and insured to perform HVAC and plumbing work throughout New Jersey.</p>

<h3>Our Licenses</h3>
<ul>
<li>HVAC License: #9370</li>
<li>Plumbing License: #12023</li>
<li>Fully insured — liability and workers\' compensation</li>
</ul>

<h3>Certifications & Affiliations</h3>
<ul>
<li>EPA certified technicians</li>
<li>Factory authorized dealer for major brands</li>
<li>Continuing education and training</li>
</ul>';
}

function jmheights_team_content() {
    return '<h2>Our Team</h2>
<p>The JM Heights team is made up of experienced, certified technicians who take pride in their work. Every member of our team shares our commitment to quality, honesty, and customer satisfaction.</p>

<h3>Why Our Team Is Different</h3>
<ul>
<li>Average 15+ years of experience per technician</li>
<li>On-staff mechanical engineer</li>
<li>Ongoing training and certification</li>
<li>Background-checked and drug-tested</li>
<li>Uniformed and professional</li>
<li>Respectful of your home and property</li>
</ul>';
}

function jmheights_why_choose_content() {
    return '<h2>Why Choose JM Heights</h2>
<p>When it comes to HVAC and plumbing, you have choices. Here\'s why North Jersey homeowners and businesses choose JM Heights Cooling Corp.</p>

<h3>56+ Years of Experience</h3>
<p>Since 1969, we\'ve been serving North Jersey families and businesses. Our experience means we\'ve seen it all and can handle any challenge.</p>

<h3>True One-Stop Shop</h3>
<p>Heating, cooling, and plumbing — all under one roof. One call, one contractor, one relationship. No need to juggle multiple companies.</p>

<h3>On-Staff Mechanical Engineer</h3>
<p>Most HVAC companies don\'t have an engineer on staff. We do. This means custom system design, accurate load calculations, and solutions that actually work.</p>

<h3>Family Owned, Not a Franchise</h3>
<p>We\'re not a faceless corporation. We\'re your neighbors. Our reputation is everything to us.</p>

<h3>Licensed & Insured</h3>
<p>HVAC License #9370, Plumbing License #12023. Fully insured for your protection.</p>

<h3>Financing Available</h3>
<p>Don\'t let budget stop your comfort. We offer financing through Synchrony with flexible payment options.</p>';
}

function jmheights_plumbing_content() {
    return '<h2>Plumbing Services</h2>
<p>JM Heights Cooling Corp. provides comprehensive plumbing services for residential and commercial properties throughout North Jersey. Our licensed plumbers handle everything from routine repairs to complete system installations.</p>

<h3>Our Plumbing Services</h3>
<ul>
<li>Water heater installation, repair & replacement</li>
<li>Sewer line services — repair, replacement & cleaning</li>
<li>Drain cleaning & hydro jetting</li>
<li>Gas line installation, repair & leak detection</li>
<li>Sump pump installation & repair</li>
<li>Leak detection</li>
<li>Toilet repair & installation</li>
<li>Faucet repair & installation</li>
<li>Garbage disposal services</li>
<li>Backflow testing & certification</li>
</ul>

<h3>Licensed & Experienced</h3>
<p>With Plumbing License #12023 and over 56 years of experience, you can trust JM Heights for all your plumbing needs. We\'re a true one-stop shop — HVAC and plumbing under one roof.</p>';
}

function jmheights_hvac_content() {
    return '<h2>HVAC Services</h2>
<p>From installation to repair and maintenance, JM Heights Cooling Corp. provides complete HVAC services for homes and businesses across North Jersey. Our certified technicians work with all major brands and systems.</p>

<h3>Our HVAC Services</h3>
<ul>
<li>Heat pump installation, repair & replacement</li>
<li>Indoor air quality solutions</li>
<li>AC repair, installation & replacement</li>
<li>AC maintenance & tune-ups</li>
<li>Ductless mini-split systems</li>
</ul>

<h3>Expert Service Since 1969</h3>
<p>With HVAC License #9370 and an on-staff mechanical engineer, JM Heights delivers expert HVAC solutions tailored to your specific needs. We handle everything from routine maintenance to complete system design and installation.</p>';
}

function jmheights_heating_content() {
    return '<h2>Heating Services</h2>
<p>Stay warm all winter with JM Heights Cooling Corp. We install, repair, and maintain all types of heating systems — boilers, furnaces, heat pumps, and radiant heating. Our experienced technicians keep North Jersey homes and businesses comfortable.</p>

<h3>Our Heating Services</h3>
<ul>
<li>Boiler installation, repair & replacement</li>
<li>Furnace installation, repair & replacement</li>
<li>Radiant floor heating</li>
<li>Oil-to-gas conversion</li>
<li>Heating maintenance & tune-ups</li>
<li>Emergency heating repair</li>
</ul>';
}

function jmheights_commercial_content() {
    return '<h2>Commercial Services</h2>
<p>JM Heights Cooling Corp. serves commercial and industrial clients with the same expertise and care as residential. From office buildings to restaurants, warehouses to manufacturing facilities — we handle it all.</p>

<h3>Our Commercial Services</h3>
<ul>
<li>Commercial plumbing</li>
<li>Commercial HVAC</li>
<li>Commercial refrigeration</li>
<li>Commercial boilers</li>
<li>Commercial water heaters</li>
<li>Preventive maintenance programs</li>
</ul>';
}

function jmheights_county_content($county) {
    return "<h2>HVAC & Plumbing Services in $county</h2>
<p>JM Heights Cooling Corp. proudly serves homeowners and businesses throughout $county. With over 56 years of experience, we're the trusted local choice for heating, cooling, and plumbing services.</p>

<h3>Services Available in $county</h3>
<ul>
<li>AC installation, repair & maintenance</li>
<li>Heating system installation & repair</li>
<li>Plumbing services</li>
<li>Drain cleaning & sewer services</li>
<li>Emergency HVAC & plumbing service</li>
<li>Commercial HVAC & plumbing</li>
</ul>

<h3>Why $county Trusts JM Heights</h3>
<p>We're your neighbors. Family owned and operated since 1969, we've been serving $county communities for over five decades. Licensed, insured, and committed to honest work at fair prices.</p>";
}

function jmheights_maintenance_plans_content() {
    return '<h2>Maintenance Plans</h2>
<p>Protect your HVAC and plumbing systems with a JM Heights maintenance plan. Regular maintenance prevents costly breakdowns, extends equipment life, and keeps your systems running at peak efficiency.</p>

<h3>Plan Benefits</h3>
<ul>
<li>Priority scheduling — skip the wait</li>
<li>Discounts on repairs</li>
<li>Annual system inspection and tune-up</li>
<li>Extended equipment life</li>
<li>Improved energy efficiency</li>
<li>Peace of mind</li>
</ul>

<h3>What\'s Included</h3>
<ul>
<li>Comprehensive system inspection</li>
<li>Safety checks</li>
<li>Cleaning and adjustments</li>
<li>Filter replacement</li>
<li>Performance optimization</li>
<li>Written report with recommendations</li>
</ul>

<p>Call <a href="tel:+12018243272">(201) 824-3272</a> to learn more about our maintenance plans and pricing.</p>';
}

function jmheights_emergency_content() {
    return '<h2>Emergency HVAC & Plumbing Service</h2>
<p>No heat? No AC? Burst pipe? JM Heights Cooling Corp. provides 24/7 emergency HVAC and plumbing service to North Jersey. When you need help fast, we\'re here.</p>

<h3>Emergency Services</h3>
<ul>
<li>No heat emergencies</li>
<li>AC breakdowns in extreme heat</li>
<li>Burst or frozen pipes</li>
<li>Gas leaks (call 911 first)</li>
<li>Sewer backups</li>
<li>Water heater failures</li>
<li>Boiler emergencies</li>
</ul>

<h3>Call Now</h3>
<p>For emergency service, call <a href="tel:+12018243272">(201) 824-3272</a> anytime — day or night, weekends and holidays. We\'ll get to you as fast as possible.</p>';
}

function jmheights_reviews_content() {
    return '<h2>Customer Reviews</h2>
<p>Don\'t just take our word for it — hear from our satisfied customers. JM Heights Cooling Corp. is proud to maintain a 5-star rating across review platforms.</p>

<p>We\'re grateful for every review and take feedback seriously. If you\'ve had a great experience with us, we\'d love to hear about it!</p>

<p>Ready to experience the JM Heights difference? Call <a href="tel:+12018243272">(201) 824-3272</a> today.</p>';
}

function jmheights_financing_page_content() {
    return '<h2>Financing Options</h2>
<p>Don\'t let budget stop your comfort. JM Heights Cooling Corp. has partnered with Synchrony to offer flexible financing options for HVAC and plumbing installations.</p>

<h3>Why Finance?</h3>
<ul>
<li>Get the system you need now, not later</li>
<li>Flexible monthly payment options</li>
<li>Quick online application</li>
<li>Fast approval process</li>
<li>Deferred interest options available</li>
<li>Use for any HVAC or plumbing installation</li>
</ul>

<h3>Apply Now</h3>
<p>Apply online through Synchrony: <a href="https://www.synchrony.com/mmc/S6223259807" target="_blank" rel="noopener">Apply for Financing</a></p>

<p>Questions about financing? Call us at <a href="tel:+12018243272">(201) 824-3272</a> and we\'ll help you through the process.</p>';
}

function jmheights_coupons_content() {
    return '<h2>Coupons & Specials</h2>
<p>Take advantage of our current offers and save on HVAC and plumbing services. Check back regularly for new specials!</p>

<p>To redeem any offer, mention the coupon when scheduling your service. Cannot be combined with other offers. Call <a href="tel:+12018243272">(201) 824-3272</a> for details.</p>';
}

function jmheights_faqs_content() {
    return '<h2>Frequently Asked Questions</h2>

<h3>What areas do you serve?</h3>
<p>We serve all of North Jersey, including Bergen County and Passaic County. See our <a href="/service-areas/">service areas page</a> for a complete list of towns.</p>

<h3>Are you licensed and insured?</h3>
<p>Yes. We hold HVAC License #9370 and Plumbing License #12023. We are fully insured with liability and workers\' compensation coverage.</p>

<h3>Do you offer emergency service?</h3>
<p>Yes. We provide 24/7 emergency HVAC and plumbing service. Call <a href="tel:+12018243272">(201) 824-3272</a> anytime.</p>

<h3>Do you offer financing?</h3>
<p>Yes. We offer financing through Synchrony with flexible payment options. <a href="https://www.synchrony.com/mmc/S6223259807" target="_blank" rel="noopener">Apply online</a> or call us for details.</p>

<h3>How long have you been in business?</h3>
<p>JM Heights Cooling Corp. has been family-owned and operated since 1969 — that\'s over 56 years of experience.</p>

<h3>Do you provide free estimates?</h3>
<p>Yes. We provide free estimates for most services. Call or <a href="/contact/">fill out our contact form</a> to get started.</p>

<h3>What brands do you work with?</h3>
<p>We work with all major HVAC and plumbing brands and are factory-authorized for many. Contact us for specifics about your equipment.</p>';
}

function jmheights_create_menus() {
    $menu_name = 'Primary Navigation';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if ($menu_exists) return;

    $menu_id = wp_create_nav_menu($menu_name);

    if (is_wp_error($menu_id)) return;

    // Home
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title' => 'Home',
        'menu-item-url' => home_url('/'),
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom',
    ]);

    // Services (dropdown)
    $services_id = wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title' => 'Services',
        'menu-item-url' => '#',
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom',
    ]);

    $service_items = [
        'Plumbing' => '/plumbing/',
        'HVAC' => '/hvac/',
        'Heating' => '/heating/',
        'Commercial' => '/commercial/',
    ];

    foreach ($service_items as $title => $url) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => $title,
            'menu-item-url' => home_url($url),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
            'menu-item-parent-id' => $services_id,
        ]);
    }

    // Financing
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title' => 'Financing',
        'menu-item-url' => home_url('/financing/'),
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom',
    ]);

    // Contact
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title' => 'Contact',
        'menu-item-url' => home_url('/contact/'),
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom',
    ]);

    // Assign to theme location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

function jmheights_water_heaters_content() {
    return jmheights_service_page_content('Water Heaters', 'Complete water heater services — installation, repair, and replacement for tank and tankless systems. Our licensed plumbers work with all major brands and handle both gas and electric units.', ['Tank water heaters', 'Tankless water heaters', 'Gas & electric systems', 'Installation & replacement', 'Repair & maintenance', 'Emergency service']);
}
