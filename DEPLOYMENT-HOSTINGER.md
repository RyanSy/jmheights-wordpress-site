# Deploying JM Heights WordPress Site on Hostinger

Step-by-step guide to develop the site for free, then go live on Hostinger when ready.

---

## Part A: Free Development (No Cost)

Build, test, and preview the site before paying for hosting. Two free options:

### Option 1: Local Development with Docker (Recommended)

This repo includes a `docker-compose.yml` for running WordPress locally — no hosting account needed.

1. **Install Docker** if you haven't already: [docker.com/get-docker](https://docs.docker.com/get-docker/)
2. **Clone the repo and start the site**:
   ```bash
   git clone https://github.com/RyanSy/jmheights-wordpress-site.git
   cd jmheights-wordpress-site
   docker compose up -d
   ```
3. **Open** `http://localhost:8080` in your browser
4. **Complete WordPress setup** — set admin username/password
5. **Activate the theme**: Appearance → Themes → Activate **JM Heights**
6. **Activate the plugin**: Plugins → Activate **JM Heights Content Setup**
   - This auto-creates all 80+ pages (including 64 town pages) and the navigation menu
7. **Configure settings**:
   - Settings → Reading → "A static page" → Homepage: **Home** → Save
   - Settings → Permalinks → **Post name** → Save

**Pros**: Full WordPress environment, no internet needed, unlimited storage, no restrictions
**Cons**: Only accessible on your machine (not shareable via URL)

### Option 2: InfinityFree (Free Online Hosting)

Use [InfinityFree](https://www.infinityfree.com/) to get a free WordPress site with a public URL you can share.

1. **Sign up** at [infinityfree.com](https://www.infinityfree.com/) — completely free, no credit card
2. **Create a free account** → you'll get a free subdomain (e.g. `jmheights.infinityfreeapp.com`)
3. **Install WordPress**:
   - In your InfinityFree control panel → **Softaculous** → **WordPress** → Install
   - Set admin credentials and choose your free subdomain
4. **Upload the theme**:
   - Log in to WordPress Admin
   - Appearance → Themes → Add New → **Upload Theme**
   - Zip the theme folder first:
     ```bash
     cd wp-content/themes && zip -r jmheights.zip jmheights/
     ```
   - Upload `jmheights.zip` → Install → Activate
5. **Upload the plugin**:
   - Plugins → Add New → **Upload Plugin**
   - Zip the plugin folder first:
     ```bash
     cd wp-content/plugins && zip -r jmheights-setup.zip jmheights-setup/
     ```
   - Upload `jmheights-setup.zip` → Install → Activate
6. **Configure settings**:
   - Settings → Reading → "A static page" → Homepage: **Home** → Save
   - Settings → Permalinks → **Post name** → Save
   - Settings → General → Site Title: **JM Heights Cooling Corp.** → Save

**Pros**: Free public URL you can share, free SSL, custom domain support, unlimited storage
**Cons**: No SSH access, can throttle high-traffic sites, slower than paid hosting

### Step 1: Develop & Test for Free

Whichever option you chose, test everything:

- [ ] Verify all pages load correctly (80+ pages including 64 town pages)
- [ ] Test navigation — About dropdown, Services dropdown, all links
- [ ] Check service pages (e.g. `/plumbing/`, `/hvac/ac-repair/`)
- [ ] Check town pages (e.g. `/service-areas/hackensack/`, `/service-areas/wayne/`)
- [ ] Test mobile responsive layout
- [ ] Upload and adjust images from jmheights.com
- [ ] Test contact form
- [ ] Share with others for feedback (InfinityFree) or demo on your machine (Docker)

---

## Part B: Go Live on Hostinger (Paid Plan)

Once you're happy with the site, deploy it on Hostinger for production.

### Step 2: Sign Up for Hostinger

1. Go to [hostinger.com](https://www.hostinger.com/) and choose a **WordPress hosting** plan:
   - **Premium** ($2.99/mo) — 100 GB storage, free domain, free SSL, email, weekly backups
   - **Business** ($3.99/mo) — 200 GB storage, daily backups, staging environment, SSH access
   - **Cloud Startup** ($9.99/mo) — dedicated resources, best performance
2. **Recommended**: **Business** plan for the staging environment and daily backups
3. During checkout, you can register `jmheights.com` as a free domain (if transferring), or use your existing domain later
4. You'll get a temporary Hostinger subdomain (e.g. `srv12345.hstgr.cloud`) for previewing

### Step 3: Install WordPress on Hostinger

1. Log in to **hPanel** (Hostinger's control panel)
2. Go to **Websites** → **Create or Migrate a Website**
3. Select **WordPress** → click **Select**
4. Set up your admin account:
   - **Admin email**: your email
   - **Admin username**: choose a username (not `admin` for security)
   - **Admin password**: choose a strong password
5. Choose your temporary Hostinger subdomain
6. Click **Submit** — WordPress will be installed in a few minutes

### Step 4: Upload Theme & Plugin

1. In hPanel, go to **Files** → **File Manager**
2. Navigate to `public_html/wp-content/themes/`
3. Upload the entire `jmheights` theme folder
   - **Alternative**: Use FTP (FileZilla or similar)
     - Host: your Hostinger server IP (found in hPanel → Hosting → SSH Access)
     - Username/Password: found in hPanel → Hosting → FTP Accounts
     - Upload `wp-content/themes/jmheights/` to `/public_html/wp-content/themes/`
4. Navigate to `public_html/wp-content/plugins/`
5. Upload the entire `jmheights-setup` folder
6. In WordPress Admin:
   - **Appearance** → **Themes** → Activate **JM Heights**
   - **Plugins** → Activate **JM Heights Content Setup** (auto-creates 80+ pages and menus)

### Step 5: Configure WordPress Settings

1. **Set the homepage**:
   - Settings → Reading → select "A static page"
   - Homepage: **Home**
   - Posts page: leave blank
   - Save Changes

2. **Set permalinks**:
   - Settings → Permalinks → select **Post name**
   - Save Changes

3. **Set site title**:
   - Settings → General
   - Site Title: **JM Heights Cooling Corp.**
   - Tagline: **Comfort You Can Count On — Since 1969**
   - Save Changes

### Step 6: Upload Images

1. Download images from the current site at [jmheights.com](https://jmheights.com)
2. In WordPress Admin → **Media** → **Add New** → upload all images
3. Update image references in theme template files if needed (hero background, about section, etc.)

### Step 7: Configure Email (Contact Form)

The contact form uses AJAX and requires a mail plugin to actually send emails:

1. Install **WP Mail SMTP** plugin:
   - Plugins → Add New → search "WP Mail SMTP" → Install & Activate
2. Go to **WP Mail SMTP** → **Settings**
3. Configure with your email provider:
   - **Gmail**: Use the Gmail mailer, authenticate with your Google account
   - **Other SMTP**: Use your email provider's SMTP settings
   - **SendGrid/Mailgun**: Enter your API key
4. Send a test email from WP Mail SMTP → Tools → Email Test

### Step 8: Set Up Google Analytics

1. Go to Settings → General → scroll to **Google Analytics ID**
2. Enter your GA4 Measurement ID (e.g. `G-XXXXXXXXXX`)
3. Save Changes
4. Verify in [Google Analytics Realtime](https://analytics.google.com/) that data is flowing

### Step 9: Install Yoast SEO

1. Plugins → Add New → search "Yoast SEO" → Install & Activate
2. Follow the Yoast setup wizard
3. Verify sitemap at `https://your-domain.com/sitemap_index.xml`
4. Submit the sitemap to [Google Search Console](https://search.google.com/search-console)

### Step 10: Final Testing

Your site is live at the temporary Hostinger URL (e.g. `srv12345.hstgr.cloud`). Run final checks:

- [ ] Homepage loads with hero, services, about sections
- [ ] Navigation works — About dropdown, Services dropdown, all top-level links
- [ ] Service pages load (e.g. `/plumbing/`, `/hvac/ac-repair/`)
- [ ] Town pages load (e.g. `/service-areas/hackensack/`, `/service-areas/wayne/`)
- [ ] Contact form submits and sends email
- [ ] Mobile responsive — hamburger menu works
- [ ] Footer shows license numbers and links
- [ ] SSL certificate active (padlock in browser)
- [ ] Google Analytics tracking verified

### Step 11: Transfer Domain to Hostinger

Once everything is verified:

**Option A — Transfer the domain to Hostinger:**
1. In hPanel → **Domains** → **Transfer Domain**
2. Enter `jmheights.com`
3. Get the **EPP/Auth code** from your current registrar (GoDaddy, Namecheap, etc.)
   - Log in to your current registrar → Domain Settings → get the transfer/auth code
4. Enter the EPP code in Hostinger → confirm transfer
5. Domain transfer takes 5–7 days to complete

**Option B — Just point DNS (faster, no transfer needed):**
1. Log in to your current domain registrar
2. Update the **A record** for `jmheights.com` to point to your Hostinger server IP
   - Find the IP in hPanel → **Hosting** → **Plan Details** → Server IP
3. Update or remove the old CNAME/A record pointing to Vercel
4. DNS propagation takes 1–48 hours

### Step 12: Post-Launch

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
| InfinityFree (free) | [infinityfree.com](https://www.infinityfree.com/) |
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
