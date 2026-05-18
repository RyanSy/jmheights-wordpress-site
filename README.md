# JM Heights Cooling Corp. — WordPress Site

A custom WordPress site for JM Heights Cooling Corp., North Jersey's trusted HVAC & plumbing company since 1969.

## Quick Start

### Prerequisites
- Docker & Docker Compose

### Setup

```bash
# Start WordPress and MySQL
docker compose up -d

# Wait ~30 seconds for MySQL to initialize, then visit:
# http://localhost:8080

# Complete the WordPress installation wizard:
# - Site Title: JM Heights Cooling Corp.
# - Username: admin
# - Password: (your choice)
# - Email: (your email)

# After installation, activate the theme and plugin:
# 1. Go to Appearance → Themes → Activate "JM Heights"
# 2. Go to Plugins → Activate "JM Heights Content Setup"
#    (This automatically creates all pages, menus, and sets the homepage)
# 3. Go to Settings → Permalinks → Select "Post name" → Save Changes
```

### What's Included

#### Custom Theme (`wp-content/themes/jmheights/`)
- Styled to match jmheights.com design (dark navy, orange accents, Barlow Condensed typography)
- Responsive design with mobile menu
- Page templates: Front Page, Contact, Service Areas
- Service page layout with sidebar navigation
- Contact form with AJAX submission
- Custom SVG icon system

#### Content Setup Plugin (`wp-content/plugins/jmheights-setup/`)
On activation, this plugin automatically creates:
- **80+ pages** matching the full site structure
- Primary navigation menu with dropdowns
- Sets homepage and permalink structure
- All service pages with content for Plumbing, HVAC, Heating, Commercial
- Service area pages for Bergen County and Passaic County towns
- Footer-linked pages (Reviews, Financing, Coupons, FAQs)

### Site Structure

```
Home (/)
├── About JM Heights (/about/)
│   ├── Our Story (/about/our-story/)
│   ├── Licenses & Credentials (/about/licenses/)
│   └── Our Team (/about/team/)
├── Why Choose JM Heights (/why-jm-heights/)
├── Plumbing (/plumbing/) — 15+ sub-pages
├── HVAC (/hvac/) — 12+ sub-pages
├── Heating (/heating/) — 10+ sub-pages
├── Commercial (/commercial/) — 6 sub-pages
├── Service Areas (/service-areas/) — 60+ town pages
├── Maintenance Plans (/maintenance-plans/)
├── Emergency Service (/emergency-service/)
├── Contact Us (/contact/)
└── Footer: Reviews, Financing, Coupons, FAQs
```

### Deployment

For production deployment:

1. Export the WordPress site using a migration plugin (e.g., All-in-One WP Migration, Duplicator)
2. Import on your production server
3. Update URLs in Settings → General
4. Upload the actual company logo via Appearance → Customize → Site Identity

Alternatively, deploy the Docker setup directly to any Docker-compatible hosting (DigitalOcean, AWS ECS, etc.).

### Design System

| Element | Value |
|---------|-------|
| Primary BG | `#0a1628` (Dark Navy) |
| Accent | `#e8701a` (Orange) |
| Blue Accent | `#2563eb` |
| Heading Font | Barlow Condensed (800/900) |
| Body Font | Inter (400/500/600) |
| Border Style | Sharp corners, orange top borders |

### Customization

- **Logo**: Appearance → Customize → Site Identity → Upload Logo
- **Menus**: Appearance → Menus
- **Pages**: Edit any page content via Pages in the admin
- **Contact Info**: Update phone numbers in `header.php`, `footer.php`, and `front-page.php`
- **Synchrony Link**: Update the financing URL in `front-page.php` and `footer.php`

## License

All rights reserved — JM Heights Cooling Corp.
