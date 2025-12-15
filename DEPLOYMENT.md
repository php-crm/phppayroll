# PHPPayroll – Deployment Guide

This guide explains how to deploy **PHPPayroll – Open Source HR & Payroll Software** on a **production (live) server**.

---

## 📋 Pre‑Deployment Checklist

Before deploying, ensure:

- PHP 7.4+ (PHP 8+ recommended)
- MySQL / MariaDB database available
- Domain or subdomain configured
- SSL certificate (HTTPS) enabled
- FTP / SSH access to server

---

## 🚀 Deployment Methods

### Option 1: Shared Hosting (cPanel)

#### 1. Upload Files
- Compress the PHPPayroll project into a ZIP file
- Upload it via **cPanel → File Manager**
- Extract into:
  ```
  public_html/phppayroll
  ```

#### 2. Set Document Root
You have two choices:

**A. Subfolder (Recommended)**
```
https://yourdomain.com/phppayroll/public/
```

**B. Root Domain**
- Move contents of `/public` into `public_html`
- Keep `/app` and `/database` outside public_html

---

### Option 2: VPS / Dedicated Server (Apache)

#### 1. Upload Project
```bash
cd /var/www/html
git clone https://github.com/your-repo/phppayroll.git
```

#### 2. Configure Virtual Host
Set document root to:
```
/var/www/html/phppayroll/public
```

Restart Apache:
```bash
sudo systemctl restart apache2
```

---

### Option 3: Nginx Server

Set root to:
```
/var/www/phppayroll/public
```

Sample config:
```nginx
server {
    server_name yourdomain.com;
    root /var/www/phppayroll/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;
    }
}
```

---

## 🗄 Database Setup (Production)

1. Create a production database
2. Import:
```
/database/phppayroll_install.sql
```
3. Update:
```
/app/config/database.php
```

Use strong credentials.

---

## 🔐 File & Folder Permissions

Set secure permissions:

```bash
chmod -R 755 phppayroll
chmod -R 775 public/uploads
chmod -R 775 app/logs
```

Never allow `777` in production.

---

## 🔒 Security Hardening

- Enable HTTPS (force SSL)
- Disable PHP error display:
  ```
  display_errors = Off
  ```
- Block sensitive folders:
  - `/app/config`
  - `/database`
- Delete installation SQL file after setup

---

## 🔁 Post‑Deployment Checklist

- ✔ Login with admin account
- ✔ Change default password
- ✔ Test attendance, payroll, and leave modules
- ✔ Verify email & session handling
- ✔ Backup database regularly

---

## 📦 Backup Strategy (Recommended)

- Daily database backups
- Weekly full project backup
- Store backups off‑server

---

## 🧩 Common Deployment Issues

### 403 / 404 Errors
- Check document root points to `/public`
- Enable `mod_rewrite`

### Database Connection Error
- Verify DB credentials
- Check DB host and permissions

---

## 📄 License

PHPPayroll is licensed under the **MIT License**.

---

**Deployment completed successfully. Welcome to PHPPayroll!** 🚀
