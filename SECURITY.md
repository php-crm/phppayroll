# Security Policy – PHPPayroll

PHPPayroll is committed to providing a secure and reliable **Open Source HR & Payroll Management System**.  
This document outlines security practices, recommendations, and how to report vulnerabilities.

---

## 🔐 Security Best Practices

### 1. Authentication & Passwords
- Passwords are stored using **secure hashing** (recommended: `password_hash()`).
- Ensure the database field for passwords is `VARCHAR(255)` to avoid truncation.
- Always change the **default admin password** immediately after installation.
- Use strong passwords for all user accounts.

---

### 2. Database Security
- Use **prepared statements** to prevent SQL injection.
- Never expose database credentials publicly.
- Restrict database user privileges to only what is required.
- Use `utf8mb4` charset to prevent encoding-related vulnerabilities.

---

### 3. File & Folder Protection
The following directories should **NOT** be publicly accessible:

- `/app/config`
- `/database`
- `/app/logs`

Recommended:
- Use `.htaccess` or server rules to block access.
- Delete `/database/phppayroll_install.sql` after installation.

---

### 4. Server Configuration
- Enable HTTPS (SSL/TLS) on production servers.
- Disable PHP error display in production:
  ```
  display_errors = Off
  ```
- Keep PHP, database, and server software up to date.
- Disable unused PHP extensions.

---

### 5. Session Security
- Use secure PHP session handling.
- Enable:
  ```
  session.cookie_httponly = On
  session.cookie_secure = On (HTTPS only)
  ```
- Regenerate session IDs after login.

---

### 6. File Upload Safety (If Enabled)
- Restrict allowed file types.
- Validate file MIME types and extensions.
- Store uploaded files outside the public root if possible.
- Rename uploaded files to avoid execution.

---

### 7. Access Control
- Validate user roles and permissions for each module.
- Prevent unauthorized access to admin-only routes.
- Always verify session login state before processing requests.

---

## 🚨 Reporting a Security Vulnerability

If you discover a security vulnerability, please **do not open a public GitHub issue**.

Instead, report it responsibly:

- 📧 Email: security@phppayroll.com  
- 📝 Include:
  - Description of the issue
  - Steps to reproduce
  - Potential impact
  - Screenshots or logs (if available)

We aim to respond within **48 hours**.

---

## 🛡 Supported Versions

| Version | Supported |
|--------|----------|
| v3.x   | ✅ Yes |
| v2.x   | ❌ No |
| Older | ❌ No |

Only the latest major version receives security updates.

---

## 📄 License

PHPPayroll is released under the **MIT License**.  
You are free to audit, modify, and enhance security as needed.

---

**Thank you for helping keep PHPPayroll secure.**
