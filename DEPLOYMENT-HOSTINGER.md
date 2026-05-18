# Deploying JM Heights WordPress Site on Hostinger

Step-by-step guide to deploy the JM Heights WordPress site on Hostinger and preview it before transferring the domain.

---

## Step 1: Sign Up for Hostinger

1. Go to [hostinger.com](https://www.hostinger.com/) and pick a WordPress hosting plan
   - **Premium** or **Business** plans include a free domain and staging tools
   - All plans include 1-click WordPress install, free SSL, and email
2. During signup, you'll get a temporary Hostinger subdomain (e.g. `srv12345.hstgr.cloud`) — use this to preview the site before transferring your domain

## Step 2: Install WordPress

1. Log in to **hPanel** (Hostinger's control panel)
2. Go to **Websites** → **Create or Migrate a Website**
3. Select **WordPress** → click **Select**
4. Set up your admin account:
   - **Admin email**: your email
   - **Admin username**: choose a username (not `admin` for security)
   - **Admin password**: choose a strong password
5. Choose your temporary domain or the free domain from your plan
6. Click **Submit** — WordPress will be installed in a few minutes

## Step 3: Upload the Custom Theme

1. In hPanel, go to **Files** → **File Manager**
2. Navigate to `public_html/wp-content/themes/`
3. Click **Upload** → upload the entire `jmheights` theme folder
   - **Alternative**: Use FTP (FileZilla or similar)
     - Host: your Hostinger server IP (found in hPanel → Hosting → SSH Access)
     - Username/Password: found in hPanel → Hosting → FTP Accounts
     - Upload `wp-content/themes/jmheights/` to `/public_html/wp-content/themes/`
4. In WordPress Admin → **Appearance** → **Themes** → Activate **JM Heights**

## Step 4: Upload & Activate the Setup Plugin

1. In File Manager, navigate to `public_html/wp-content/plugins/`
2. Upload the entire `jmheights-setup` folder
   - Or use FTP to upload `wp-content/plugins/jmheights-setup/` to `/public_html/wp-content/plugins/`
3. In WordPress Admin → **Plugins** → Activate **JM Heights Content Setup**
   - This automatically creates all 80+ pages (including 64 town pages) and the navigation menu

## Step 5: Configure WordPress Settings

1. **Set the homepage**:
   - Settings → Reading → select "A static page"
   - Homepage: **Home**
   - Posts page: leave blank (or pick "Blog" if you want one later)
   - Save Changes

2. **Set permalinks**:
   - Settings → Permalinks → select **Post name**
   - Save Changes
   - This gives you clean URLs like `/plumbing/`, `/service-areas/hackensack/`, etc.

3. **Set site title**:
   - Settings → General
   - Site Title: **JM Heights Cooling Corp.**
   - Tagline: **Comfort You Can Count On — Since 1969**
   - Save Changes

## Step 6: Upload Images

1. Download images from the current site at [jmheights.com](https://jmheights.com)
2. In WordPress Admin → **Media** → **Add New** → upload all images
3. Update image references in theme template files if needed (hero background, about section, etc.)

## Step 7: Configure Email (Contact Form)

The contact form uses AJAX and requires a mail plugin to actually send emails:

1. Install **WP Mail SMTP** plugin:
   - Plugins → Add New → search "WP Mail SMTP" → Install & Activate
2. Go to **WP Mail SMTP** → **Settings**
3. Configure with your email provider:
   - **Gmail**: Use the Gmail mailer, authenticate with your Google account
   - **Other SMTP**: Use your email provider's SMTP settings
   - **SendGrid/Mailgun**: Enter your API key
4. Send a test email from WP Mail SMTP → Tools → Email Test

## Step 8: Set Up Google Analytics

1. Go to Settings → General → scroll to **Google Analytics ID**
2. Enter your GA4 Measurement ID (e.g. `G-XXXXXXXXXX`)
3. Save Changes
4. Verify in [Google Analytics Realtime](https://analytics.google.com/) that data is flowing

## Step 9: Install Yoast SEO

1. Plugins → Add New → search "Yoast SEO" → Install & Activate
2. Follow the Yoast setup wizard
3. Verify sitemap at `https://your-domain.com/sitemap_index.xml`
4. Submit the sitemap to [Google Search Console](https://search.google.com/search-console)

## Step 10: Preview & Test

Your site is now live at the temporary Hostinger URL (e.g. `srv12345.hstgr.cloud`). Test everything:

- [ ] Homepage loads with hero, services, about sections
- [ ] Navigation works — About dropdown, Services dropdown, all top-level links
- [ ] Service pages load (e.g. `/plumbing/`, `/hvac/ac-repair/`)
- [ ] Town pages load (e.g. `/service-areas/hackensack/`, `/service-areas/wayne/`)
- [ ] Contact form submits and sends email
- [ ] Mobile responsive — hamburger menu works
- [ ] Footer shows license numbers and links

## Step 11: Transfer Domain to Hostinger

Once you're happy with the staging site:

1. In hPanel → **Domains** → **Transfer Domain**
2. Enter `jmheights.com`
3. You'll need the **EPP/Auth code** from your current registrar (GoDaddy, Namecheap, etc.)
   - Log in to your current registrar → Domain Settings → get the transfer/auth code
4. Enter the EPP code in Hostinger → confirm transfer
5. Domain transfer takes 5–7 days to complete

**Alternative — just point DNS (faster, no transfer needed):**

1. Log in to your current domain registrar
2. Update the **A record** for `jmheights.com` to point to your Hostinger server IP
   - Find the IP in hPanel → **Hosting** → **Plan Details** → Server IP
3. Update or remove the old CNAME/A record pointing to Vercel
4. DNS propagation takes 1–48 hours

## Step 12: Post-Launch

1. **Enable SSL**: hPanel → SSL → install free SSL certificate (usually auto-enabled)
2. **Force HTTPS**: hPanel → Hosting → Redirects → force HTTPS redirect
3. **Install security plugin**: Wordfence or Sucuri (Plugins → Add New)
4. **Enable caching**: Hostinger has built-in LiteSpeed Cache — activate the **LiteSpeed Cache** plugin
5. **Set up backups**: hPanel → Files → Backups (Hostinger includes weekly backups; upgrade for daily)
6. **Decommission Next.js**: Remove the old site from Vercel once DNS has propagated

---

## Quick Reference

| Item | Value |
|------|-------|
| Hostinger hPanel | [hpanel.hostinger.com](https://hpanel.hostinger.com) |
| WordPress Admin | `your-domain.com/wp-admin/` |
| Theme directory | `public_html/wp-content/themes/jmheights/` |
| Plugin directory | `public_html/wp-content/plugins/jmheights-setup/` |
| GA4 setting | Settings → General → Google Analytics ID |
| Sitemap URL | `/sitemap_index.xml` (requires Yoast SEO) |
| Contact form | AJAX via `admin-ajax.php`, action: `jmheights_contact` |
| Permalinks | Settings → Permalinks → Post name |

---

## Hostinger-Specific Tips

- **Staging**: Business plan and above include a staging environment — use it to test changes before pushing live
- **LiteSpeed Cache**: Hostinger runs LiteSpeed servers — use the LiteSpeed Cache plugin instead of W3 Total Cache for best performance
- **PHP Version**: Make sure PHP 8.2+ is selected (hPanel → Advanced → PHP Configuration)
- **File Manager**: hPanel's built-in file manager works well for uploading theme/plugin folders — no FTP client needed
- **SSH Access**: Available on Business plan and above if you prefer command-line deployment
