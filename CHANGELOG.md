# Changelog – PHPPayroll

All notable changes to **PHPPayroll – Open Source HR & Payroll Software** will be documented in this file.

This project follows **Semantic Versioning** (`MAJOR.MINOR.PATCH`).

---

## [v3.0.0] – Initial Public Stable Release

### ✨ Added
- Modern dashboard with key statistics
  - Total employees
  - Active employees
  - Today’s attendance
  - Pending leave requests
- Employee management module
  - Add employees
  - View employee list
- Attendance management
  - Daily attendance marking
  - Attendance records view
- Leave management system
  - Leave request submission
  - Pending leave tracking
- Payroll module
  - Payroll generation functionality
- User authentication system
  - Secure login
  - Change password
  - Logout functionality

### 🔐 Security
- Password hashing implemented for user accounts
- Session-based authentication
- Restricted access to sensitive modules

### 🛠 Technical
- Built using PHP and MySQL
- MVC-based application structure
- Bootstrap-based responsive UI
- Optimized database schema

---

## [v2.x] – Legacy Versions

### ⚠️ Status
- Deprecated
- No longer supported
- Security updates discontinued

---

## 📌 Upgrade Notes
- Fresh installation recommended when upgrading from v2.x to v3.0.0
- Ensure database field `password_hash` is `VARCHAR(255)`
- Remove old installation SQL files after upgrade

---

## 🔮 Upcoming (Planned)
- Payslip PDF generation
- Role-based access control (RBAC)
- Advanced payroll reports
- Tax & deduction modules
- REST API (optional)

---

**End of Changelog**
