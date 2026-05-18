# Migration Guide: Next.js → WordPress

Steps to convert the current jmheights.com (Next.js) site to the WordPress version.

---

## Phase 1: Set Up Hosting

1. **Get WordPress hosting** — WP Engine, SiteGround, Bluehost, or a VPS (DigitalOcean/Linode) with Docker
2. **Point a staging subdomain** (e.g. `staging.jmheights.com`) to the new host for testing before going live

## Phase 2: Deploy the WordPress Site

3. **Install WordPress** on the server (most hosts offer 1-click install)
4. **Upload the custom theme** — copy `wp-content/themes/jmheights/` to the server via FTP/SFTP or host file manager
5. **Upload the setup plugin** — copy `wp-content/plugins/jmheights-setup/` the same way
6. **Activate the theme** — WordPress Admin → Appearance → Themes → Activate "JM Heights"
7. **Activate the plugin** — WordPress Admin → Plugins → Activate "JM Heights Setup"
   - This auto-creates all 80+ pages and navigation menus
8. **Set the homepage** — Settings → Reading → "A static page" → select "Home"
9. **Set permalinks** — Settings → Permalinks → "Post name" (so URLs match `/plumbing/`, `/contact/`, etc.)

## Phase 3: Migrate Content & Assets

10. **Copy images** from the Next.js site to WordPress Media Library
    - Download images from jmheights.com
    - Upload via Media → Add New
11. **Update image references** in the theme templates to use WordPress media URLs instead of placeholders
12. **Configure contact form email** — install [WP Mail SMTP](https://wordpress.org/plugins/wp-mail-smtp/) and configure with your email provider (Gmail, SendGrid, etc.)

## Phase 4: Google Analytics

13. **Get your GA4 Measurement ID** from [Google Analytics](https://analytics.google.com/) → Admin → Data Streams → your property
14. **Enter the ID in WordPress** — go to Settings → General → scroll to "Google Analytics ID" field → paste your `G-XXXXXXXXXX` ID → Save
    - Alternatively, add to `wp-config.php`: `define('JMHEIGHTS_GA_ID', 'G-XXXXXXXXXX');`
15. **Verify tracking** — visit the site, then check Google Analytics → Realtime to confirm data is flowing

## Phase 5: Yoast SEO & XML Sitemap

16. **Install Yoast SEO** — WordPress Admin → Plugins → Add New → search "Yoast SEO" → Install & Activate
    - A dashboard notice will prompt you to install it if not already active
17. **Run the Yoast setup wizard** — follow the on-screen prompts to configure site type, organization name, and social profiles
18. **Verify XML sitemap** — visit `https://jmheights.com/sitemap_index.xml` to confirm it's generated
19. **Submit sitemap to Google Search Console** — go to [Search Console](https://search.google.com/search-console) → Sitemaps → enter `sitemap_index.xml` → Submit

## Phase 6: DNS Cutover

20. **Test everything on staging** — verify all pages, navigation, contact form, mobile layout, analytics tracking
21. **Update DNS** — change the A record (or CNAME) for `jmheights.com` from your Next.js host (Vercel) to the WordPress server's IP
22. **Decommission the Next.js app** — remove from Vercel once DNS has propagated (24–48 hours)

## Phase 7: Post-Migration

23. **Install SSL certificate** — most hosts offer free Let's Encrypt; or use Cloudflare
24. **Set up redirects** if any URL structures changed (unlikely since paths were matched)
25. **Install security plugin** — [Wordfence](https://wordpress.org/plugins/wordfence/) or [Sucuri](https://wordpress.org/plugins/sucuri-scanner/)
26. **Install caching plugin** — [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/) or [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/)
27. **Set up backups** — [UpdraftPlus](https://wordpress.org/plugins/updraftplus/) or host-provided backups

---

## Quick Reference

| Item | Value |
|------|-------|
| WordPress Admin | `/wp-admin/` |
| Theme directory | `wp-content/themes/jmheights/` |
| Setup plugin | `wp-content/plugins/jmheights-setup/` |
| GA4 setting | Settings → General → Google Analytics ID |
| Sitemap URL | `/sitemap_index.xml` (requires Yoast SEO) |
| Contact form handler | AJAX via `admin-ajax.php`, action: `jmheights_contact` |
| Permalinks | Settings → Permalinks → "Post name" |
