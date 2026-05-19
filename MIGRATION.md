# Migration Guide: Next.js → WordPress on Oracle Cloud Free Tier

Step-by-step guide to deploy the JM Heights WordPress site on Oracle Cloud's always-free tier and connect your custom domain.

---

## Part A: Local Development

Test the site locally before deploying to the cloud.

1. **Clone the repo**:
   ```bash
   git clone https://github.com/RyanSy/jmheights-wordpress-site.git
   cd jmheights-wordpress-site
   ```

2. **Start Docker**:
   ```bash
   docker compose up -d
   ```

3. **Open** `http://localhost:8080` and complete the WordPress setup

4. **Activate the theme**: Appearance → Themes → Activate **JM Heights**

5. **Activate the plugin**: Plugins → Activate **JM Heights Content Setup**
   - Auto-creates 80+ pages and navigation menus

6. **Configure settings**:
   - Settings → Reading → "A static page" → Homepage: **Home** → Save
   - Settings → Permalinks → **Post name** → Save

7. **Import Google Docs content** (optional):
   - Place `site-structure.md` in the project root
   - Tools → Import Google Docs → Import Content

---

## Part B: Set Up Oracle Cloud Free Tier

Oracle Cloud offers an always-free VM — no credit card charges, no expiration.

### Step 1: Create an Oracle Cloud Account

1. Go to [cloud.oracle.com/free](https://www.oracle.com/cloud/free/)
2. Click **Start for Free** and sign up
   - You'll need a credit card for identity verification, but the always-free tier is never charged
3. Choose your **home region** (pick the closest to your customers — e.g., US East for NJ)

### Step 2: Create a Free VM Instance

1. In the Oracle Cloud Console, go to **Compute** → **Instances** → **Create Instance**
2. Configure the instance:
   - **Name**: `jmheights-wordpress`
   - **Image**: **Canonical Ubuntu 22.04** (click "Change Image" if needed)
   - **Shape**: Click **Change Shape** → **Ampere** → **VM.Standard.A1.Flex**
     - OCPUs: **1** (free tier allows up to 4)
     - Memory: **6 GB** (free tier allows up to 24 GB)
   - **Networking**: Use the default VCN or create a new one
     - Check **Assign a public IPv4 address**
   - **SSH Keys**: Click **Generate a key pair** and download both keys, or paste your existing public key
3. Click **Create** — the instance will be ready in ~2 minutes
4. Note the **Public IP Address** from the instance details page

### Step 3: Open Firewall Ports

1. In the Oracle Console, go to your instance → **Subnet** → **Security Lists** → **Default Security List**
2. Click **Add Ingress Rules** and add these rules:

   | Source CIDR | Protocol | Dest Port | Description |
   |-------------|----------|-----------|-------------|
   | `0.0.0.0/0` | TCP | 80 | HTTP |
   | `0.0.0.0/0` | TCP | 443 | HTTPS |

3. SSH into your VM and also open the ports in Ubuntu's firewall:
   ```bash
   ssh -i ~/path/to/private-key ubuntu@YOUR_PUBLIC_IP
   sudo iptables -I INPUT 6 -m state --state NEW -p tcp --dport 80 -j ACCEPT
   sudo iptables -I INPUT 6 -m state --state NEW -p tcp --dport 443 -j ACCEPT
   sudo netfilter-persistent save
   ```

### Step 4: Install Docker on the VM

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Docker
curl -fsSL https://get.docker.com | sh
sudo usermod -aG docker $USER

# Log out and back in for group to take effect
exit
```

SSH back in:
```bash
ssh -i ~/path/to/private-key ubuntu@YOUR_PUBLIC_IP

# Verify Docker works
docker --version
docker compose version
```

### Step 5: Deploy the WordPress Site

```bash
# Clone the repo
git clone https://github.com/RyanSy/jmheights-wordpress-site.git
cd jmheights-wordpress-site

# Update docker-compose to use port 80
sed -i 's/8080:80/80:80/' docker-compose.yml

# Start the site
docker compose up -d
```

Visit `http://YOUR_PUBLIC_IP` — you should see the WordPress setup screen.

### Step 6: Complete WordPress Setup

1. Open `http://YOUR_PUBLIC_IP` in your browser
2. Complete the WordPress installation (set admin username/password)
3. **Activate the theme**: Appearance → Themes → Activate **JM Heights**
4. **Activate the plugin**: Plugins → Activate **JM Heights Content Setup**
5. **Set the homepage**: Settings → Reading → "A static page" → **Home** → Save
6. **Set permalinks**: Settings → Permalinks → **Post name** → Save
7. **Set site title**: Settings → General → **JM Heights Cooling Corp.** → Save

---

## Part C: Connect Your Custom Domain

### Step 7: Point DNS to Oracle Cloud

1. Log in to your domain registrar (wherever `jmheights.com` is registered — GoDaddy, Namecheap, Cloudflare, etc.)
2. Go to **DNS Settings** for `jmheights.com`
3. Update or create an **A record**:

   | Type | Host | Value | TTL |
   |------|------|-------|-----|
   | A | `@` | `YOUR_ORACLE_VM_IP` | 300 |
   | A | `www` | `YOUR_ORACLE_VM_IP` | 300 |

4. If there's an existing A record or CNAME pointing to Vercel, **delete it** first
5. DNS propagation takes 5 minutes to 48 hours (usually under 1 hour)

### Step 8: Install SSL Certificate (Free)

Once DNS is pointing to your server:

```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache -y

# Stop the Docker containers temporarily
cd ~/jmheights-wordpress-site
docker compose down

# Get the SSL certificate
sudo certbot certonly --standalone -d jmheights.com -d www.jmheights.com

# The certificates will be at:
#   /etc/letsencrypt/live/jmheights.com/fullchain.pem
#   /etc/letsencrypt/live/jmheights.com/privkey.pem
```

Now update Docker Compose to use SSL. Create an Nginx reverse proxy config:

```bash
mkdir -p nginx
```

Create `nginx/default.conf`:
```nginx
server {
    listen 80;
    server_name jmheights.com www.jmheights.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl;
    server_name jmheights.com www.jmheights.com;

    ssl_certificate /etc/letsencrypt/live/jmheights.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/jmheights.com/privkey.pem;

    location / {
        proxy_pass http://wordpress:80;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto https;
    }
}
```

Update `docker-compose.yml` to add Nginx:
```yaml
  nginx:
    image: nginx:alpine
    restart: unless-stopped
    depends_on:
      - wordpress
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./nginx/default.conf:/etc/nginx/conf.d/default.conf
      - /etc/letsencrypt:/etc/letsencrypt:ro
```

And change the WordPress service port from `80:80` to `8080:80` (so only Nginx is exposed):
```yaml
  wordpress:
    ports:
      - "8080:80"  # internal only, Nginx handles public traffic
```

Restart everything:
```bash
docker compose up -d
```

### Step 9: Auto-Renew SSL

Let's Encrypt certificates expire every 90 days. Set up auto-renewal:

```bash
# Add a cron job
sudo crontab -e
```

Add this line:
```
0 3 * * * certbot renew --pre-hook "cd /home/ubuntu/jmheights-wordpress-site && docker compose stop nginx" --post-hook "cd /home/ubuntu/jmheights-wordpress-site && docker compose start nginx" --quiet
```

### Step 10: Update WordPress URL Settings

After DNS propagates and SSL is working:

1. Go to WordPress Admin → Settings → General
2. Change both:
   - **WordPress Address (URL)**: `https://jmheights.com`
   - **Site Address (URL)**: `https://jmheights.com`
3. Save Changes

---

## Part D: Import Content & Configure

### Step 11: Import Google Docs Content

1. Copy `site-structure.md` to the server:
   ```bash
   scp -i ~/path/to/private-key site-structure.md ubuntu@YOUR_PUBLIC_IP:~/jmheights-wordpress-site/
   ```
2. Restart to pick up the file mount:
   ```bash
   docker compose down && docker compose up -d
   ```
3. Go to WordPress Admin → **Tools** → **Import Google Docs** → Import Content

### Step 12: Upload Images

1. Download images from the current [jmheights.com](https://jmheights.com)
2. WordPress Admin → **Media** → **Add New** → upload all images
3. Update image references in theme templates as needed

### Step 13: Configure Email (Contact Form)

1. Install **WP Mail SMTP**: Plugins → Add New → search "WP Mail SMTP" → Install & Activate
2. Configure with your email provider:
   - **Gmail**: Use the Gmail mailer, authenticate with your Google account
   - **SendGrid/Mailgun**: Enter your API key
3. Test: WP Mail SMTP → Tools → Email Test

### Step 14: Set Up Google Analytics

1. Settings → General → scroll to **Google Analytics ID**
2. Enter your GA4 Measurement ID (e.g. `G-XXXXXXXXXX`) → Save
3. Verify in [Google Analytics Realtime](https://analytics.google.com/)

### Step 15: Install Yoast SEO

1. Plugins → Add New → search "Yoast SEO" → Install & Activate
2. Follow the setup wizard
3. Verify sitemap at `https://jmheights.com/sitemap_index.xml`
4. Submit to [Google Search Console](https://search.google.com/search-console)

---

## Part E: Post-Launch

### Step 16: Security & Performance

1. **Install security plugin**: Wordfence or Sucuri (Plugins → Add New)
2. **Enable caching**: Install WP Super Cache or W3 Total Cache
3. **Set up backups**: Install [UpdraftPlus](https://wordpress.org/plugins/updraftplus/) and configure automatic backups to Google Drive or Dropbox

### Step 17: Decommission Next.js

1. Verify everything works on the new WordPress site
2. Remove the old site from Vercel
3. Done!

---

## Quick Reference

| Item | Value |
|------|-------|
| Oracle Cloud Console | [cloud.oracle.com](https://cloud.oracle.com) |
| VM Shape (free) | VM.Standard.A1.Flex (1 OCPU, 6 GB RAM) |
| WordPress Admin | `https://jmheights.com/wp-admin/` |
| Theme directory | `wp-content/themes/jmheights/` |
| Plugin directory | `wp-content/plugins/jmheights-setup/` |
| GA4 setting | Settings → General → Google Analytics ID |
| Sitemap URL | `/sitemap_index.xml` (requires Yoast SEO) |
| Contact form | AJAX via `admin-ajax.php`, action: `jmheights_contact` |
| Permalinks | Settings → Permalinks → Post name |
| SSL certificates | `/etc/letsencrypt/live/jmheights.com/` |
| SSL renewal | Auto via cron, every 90 days |

---

## Oracle Cloud Free Tier Limits

| Resource | Free Allowance |
|----------|---------------|
| Ampere A1 VMs | Up to 4 OCPUs, 24 GB RAM total |
| Boot volume | 200 GB total |
| Outbound data | 10 TB/month |
| Object storage | 20 GB |
| Always free? | Yes — no expiration, no charges |

This is more than enough for a WordPress site with moderate traffic.
