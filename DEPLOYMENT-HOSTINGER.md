# Deploying JM Heights WordPress Site on Hostinger

Step-by-step guide to develop the site for free on Hostinger, then go live when ready.

---

## Part A: Free Development (No Cost)

Use Hostinger's free tier to build, test, and preview the site before paying for a production plan.

### Step 1: Create a Free Hostinger Account

1. Go to [hostinger.com](https://www.hostinger.com/) → click **Start for Free** (or sign up for the free plan)
   - Hostinger offers a **free website builder** tier — no credit card required
   - You'll get a free subdomain like `yoursite.hostingersite.com`
2. Alternatively, use **000webhost** (owned by Hostinger) at [000webhost.com](https://www.000webhost.com/):
   - Completely free WordPress hosting
   - Includes a free subdomain (e.g. `jmheights.000webhostapp.com`)
   - 300 MB storage, 3 GB bandwidth — plenty for development
   - 1-click WordPress install
   - Same Hostinger account works for both

### Step 2: Install WordPress (Free Tier)

**If using 000webhost:**
1. Log in to [000webhost.com](https://www.000webhost.com/)
2. Click **Create a Website** → choose **WordPress**
3. Set your admin credentials:
   - **Admin username**: choose a username (not `admin` for security)
   - **Admin password**: choose a strong password
4. WordPress installs automatically on your free subdomain

**If using Hostinger free tier:**
1. Log in to hPanel
2. Go to **Websites** → **Create a Website**
3. Select WordPress and follow the setup wizard
4. Use the free Hostinger subdomain provided

### Step 3: Upload Theme & Plugin

1. Log in to WordPress Admin at `yoursite.000webhostapp.com/wp-admin/` (or your Hostinger subdomain)
2. **Upload the theme**:
   - Go to **Appearance** → **Themes** → **Add New** → **Upload Theme**
   - Zip the `wp-content/themes/jmheights/` folder into `jmheights.zip`
     ```bash
     cd wp-content/themes && zip -r jmheights.zip jmheights/
     ```
   - Upload `jmheights.zip` → Install → Activate
3. **Upload the plugin**:
   - Go to **Plugins** → **Add New** → **Upload Plugin**
   - Zip the `wp-content/plugins/jmheights-setup/` folder into `jmheights-setup.zip`
     ```bash
     cd wp-content/plugins && zip -r jmheights-setup.zip jmheights-setup/
     ```
   - Upload `jmheights-setup.zip` → Install → Activate
   - This auto-creates all 80+ pages (including 64 town pages) and the navigation menu

### Step 4: Configure Settings (Free Tier)

1. **Set the homepage**:
   - Settings → Reading → select "A static page"
   - Homepage: **Home**
   - Save Changes

2. **Set permalinks**:
   - Settings → Permalinks → select **Post name**
   - Save Changes

3. **Set site title**:
   - Settings → General
   - Site Title: **JM Heights Cooling Corp.**
   - Tagline: **Comfort You Can Count On — Since 1969**
   - Save Changes

### Step 5: Develop & Test for Free

Your site is now live at your free subdomain. Use it to:

- [ ] Verify all pages load correctly (80+ pages including 64 town pages)
- [ ] Test navigation — About dropdown, Services dropdown, all links
- [ ] Check service pages (e.g. `/plumbing/`, `/hvac/ac-repair/`)
- [ ] Check town pages (e.g. `/service-areas/hackensack/`, `/service-areas/wayne/`)
- [ ] Test mobile responsive layout
- [ ] Upload and adjust images from jmheights.com
- [ ] Test contact form
- [ ] Share the free URL with others for feedback

**Free tier limitations to be aware of:**
- 000webhost: 300 MB storage, 3 GB bandwidth, no SSL, no custom domain, sites sleep after 1 hour of inactivity
- Hostinger free: limited features, no custom domain
- These are fine for development — you'll upgrade when going live

---

## Part B: Go Live on Hostinger (Paid Plan)

Once you're happy with the site on the free tier, upgrade to a paid plan and transfer your domain.

### Step 6: Upgrade to a Paid Hostinger Plan

1. Log in to [hostinger.com](https://www.hostinger.com/)
2. Choose a **WordPress hosting** plan:
   - **Premium** ($2.99/mo) — 100 GB storage, free domain, free SSL, email, weekly backups
   - **Business** ($3.99/mo) — 200 GB storage, daily backups, staging environment, SSH access
   - **Cloud Startup** ($9.99/mo) — dedicated resources, best performance
3. **Recommended**: **Business** plan for the staging environment and daily backups
4. During checkout, you can register `jmheights.com` as a free domain (if transferring), or use your existing domain later

### Step 7: Migrate from Free to Paid

**Option A — If upgrading within Hostinger:**
- Your free site may migrate automatically when you upgrade
- In hPanel → **Websites** → select your site → **Upgrade**

**Option B — If moving from 000webhost to Hostinger paid:**
1. In 000webhost → **Settings** → **Move to Hostinger** (built-in migration tool)
2. Or manually re-upload theme and plugin (Step 3) on the new paid hosting

**Option C — Fresh install on paid plan:**
1. Install WordPress on your paid plan (hPanel → Websites → Create)
2. Re-upload theme and plugin using File Manager or FTP:
   - Theme: `public_html/wp-content/themes/jmheights/`
   - Plugin: `public_html/wp-content/plugins/jmheights-setup/`
3. Activate theme and plugin, configure settings (Steps 4–5)

### Step 8: Upload Images

1. Download images from the current site at [jmheights.com](https://jmheights.com)
2. In WordPress Admin → **Media** → **Add New** → upload all images
3. Update image references in theme template files if needed (hero background, about section, etc.)

### Step 9: Configure Email (Contact Form)

The contact form uses AJAX and requires a mail plugin to actually send emails:

1. Install **WP Mail SMTP** plugin:
   - Plugins → Add New → search "WP Mail SMTP" → Install & Activate
2. Go to **WP Mail SMTP** → **Settings**
3. Configure with your email provider:
   - **Gmail**: Use the Gmail mailer, authenticate with your Google account
   - **Other SMTP**: Use your email provider's SMTP settings
   - **SendGrid/Mailgun**: Enter your API key
4. Send a test email from WP Mail SMTP → Tools → Email Test

### Step 10: Set Up Google Analytics

1. Go to Settings → General → scroll to **Google Analytics ID**
2. Enter your GA4 Measurement ID (e.g. `G-XXXXXXXXXX`)
3. Save Changes
4. Verify in [Google Analytics Realtime](https://analytics.google.com/) that data is flowing

### Step 11: Install Yoast SEO

1. Plugins → Add New → search "Yoast SEO" → Install & Activate
2. Follow the Yoast setup wizard
3. Verify sitemap at `https://your-domain.com/sitemap_index.xml`
4. Submit the sitemap to [Google Search Console](https://search.google.com/search-console)

### Step 12: Final Testing on Paid Plan

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

### Step 13: Transfer Domain to Hostinger

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

### Step 14: Post-Launch

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
| 000webhost (free) | [000webhost.com](https://www.000webhost.com/) |
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

- **Free → Paid migration**: 000webhost has a built-in "Move to Hostinger" button — makes upgrading seamless
- **Staging**: Business plan and above include a staging environment — use it to test changes before pushing live
- **LiteSpeed Cache**: Hostinger runs LiteSpeed servers — use the LiteSpeed Cache plugin instead of W3 Total Cache for best performance
- **PHP Version**: Make sure PHP 8.2+ is selected (hPanel → Advanced → PHP Configuration)
- **File Manager**: hPanel's built-in file manager works well for uploading theme/plugin folders — no FTP client needed
- **SSH Access**: Available on Business plan and above if you prefer command-line deployment
