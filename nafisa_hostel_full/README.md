# Nafisa Hostel Management System (Full)
This is a ready-to-run minimal hostel management system (local) with:
- PHP + PDO + MySQL
- Admin panel: Rooms, Students, Payments, Notices, Attendance, Meals
- Auth (register/login), basic security practices

## Setup (Local with XAMPP)
1. Install XAMPP (or LAMP).
2. Extract this project into `htdocs/nafisa_hostel_full`.
3. Start Apache & MySQL.
4. Open phpMyAdmin -> Import `sql/nafisa_hostel_full.sql`. (First create database if needed)
   - The sample admin password is not hashed in SQL; instead register a new admin via `/auth/register.php` or
     replace the password field in SQL with `<?php echo password_hash('admin123', PASSWORD_DEFAULT); ?>` executed elsewhere.
5. Edit `inc/config.php` if your DB credentials differ.
6. Visit: `http://localhost/nafisa_hostel_full/auth/login.php`

## Notes
- This is a minimal educational app. For production, add stronger access control, CSRF tokens, input sanitization,
  HTTPS, and properly hashed admin password in the SQL.
- To create an admin: use Register page and choose role 'Admin'.
