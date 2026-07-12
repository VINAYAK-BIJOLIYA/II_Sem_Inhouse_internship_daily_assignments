# Day 10 - Building a Secure Login System

## Assignment: Complete Authentication System

This assignment covers PHP session-based authentication:

- Session management (session_start, session_destroy)
- Login form with server-side validation
- User registration with email uniqueness check
- Password verification against MySQL database
- Protected dashboard page (redirects to login if not authenticated)
- Welcome message displaying logged-in user's name
- Logout functionality that destroys session
- Redirect back to login after logout

## Files
- `login.php` — Login form with authentication logic
- `register.php` — Registration form with validation
- `dashboard.php` — Protected page requiring login
- `logout.php` — Session destruction and redirect
- `db_connect.php` — Database connection

## Running
Requires Day 9 database setup. Place in XAMPP htdocs/day10/ and access via localhost/day10/login.php.
