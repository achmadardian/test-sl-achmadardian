# Laravel + Vue Fullstack App

This is a full-stack web application using:

- **Backend**: Laravel (PHP 8.2.28)
- **Frontend**: Vue 3 with Bun (1.2.16)
- **Database**: MySQL 8.3

---

## Project Structure

```
root/
├── api/ # Laravel backend
└── web/ # Vue frontend
```

---

## Requirements

Make sure the following are installed on your local machine:

- PHP 8.2.28
- Composer
- MySQL 8.3
- Bun 1.2.16 or NodeJS

---

## Backend Setup (Laravel)

### 1. Set up environment

Assuming in root folder

```bash
cd api
```

```bash
cp .env.example .env
```

### 2. Create database

Before running migrations, create the database using your preferred method based on `.env`(e.g., MySQL CLI, PhpMyAdmin, TablePlus, etc.)

```bash
CREATE DATABASE db_name;
```

### 3. Install dependecies

```bash
composer install
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Run migrations and seeder

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

### 6. Run server

```bash
php artisan serve
```

Laravel will be available at: `http://localhost:8000`

## API Available

| Endpoint          | Method | Description                   | Auth Required |
| ----------------- | ------ | ----------------------------- | ------------- |
| `/auth/login`     | POST   | Log in and receive auth token | ❌            |
| `/auth/logout`    | GET    | Log out and revoke token      | ✅            |
| `/positions`      | GET    | List all positions            | ✅            |
| `/positions`      | POST   | Create a new position         | ✅            |
| `/positions/{id}` | GET    | Get a single position         | ✅            |
| `/positions/{id}` | PUT    | Update a position             | ✅            |
| `/positions/{id}` | DELETE | Delete a position             | ✅            |
| `/employees`      | GET    | List all employees            | ✅            |
| `/employees`      | POST   | Create a new employee         | ✅            |
| `/employees/{id}` | GET    | Get a single employee         | ✅            |
| `/employees/{id}` | PUT    | Update an employee            | ✅            |
| `/employees/{id}` | DELETE | Delete an employee            | ✅            |

---

Frontend Setup (Vue + Bun)

### 1. Install dependencies

Assuming in root folder

```bash
cd web
```

```bash
bun install
```

### 2. Start app

```bash
bun run dev
```

Web will be available at: `http://localhost:5173/`

Default login account

```
Email: admin@gmail.com
Password: password
```
