# Xavier Roster

Xavier Roster is a PHP/MySQL CRUD application for viewing and managing hero records. Public visitors can view the roster and hero details. Registered users can log in to create, update, and delete records.

## Requirements

- XAMPP with Apache, PHP, and MySQL
- A web browser

## Setup

1. Place the project folder inside XAMPP's `htdocs` folder:
   `C:\xampp\htdocs\Web-Dev-Farhaan-Sherif-Kimunila-`
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin/`.
4. Import `database/schema.sql`. This creates the `xmen_roster` database, both required tables, the sample heroes, and the default user.
5. If your MySQL username or password is different, update `config/db.php`.
6. Open the application at:
   `http://localhost/Web-Dev-Farhaan-Sherif-Kimunila-/`

## Default login

- Username: `admin`
- Password: `password123`

New users can also register through the Register link in the application.

## Repository

https://github.com/kimunilaz/Web-Dev-Farhaan-Sherif-Kimunila-
