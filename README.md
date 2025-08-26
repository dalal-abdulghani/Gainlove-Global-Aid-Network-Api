
# GainLove API

## 1. Requirements
- PHP >= 8.0  
- MySQL / MariaDB  
- Composer  
- Local server (Laragon, XAMPP, WAMP, etc.)

---

## 2. Installation
1. Clone the repository:  
```bash
git clone <repo-url>
cd GainLove-api
````

2. Install dependencies:

```bash
composer install
```

3. Create the database:

```sql
CREATE DATABASE GainLove_api;
```

4. Configure `.env` or `config/config.php`:

```php
define("DB_HOST", "localhost");
define("DB_NAME", "GainLove_api");
define("DB_USER", "root");
define("DB_PASS", "");
define("JWT_SECRET", "mySuperSecretKey");
define("APP_ENV", "development");
define("APP_DEBUG", true);
define("APP_URL", "http://localhost");
```

5. Run migrations to create tables:

```bash
php database/migrations/001_create_users_table.php
php database/migrations/002_create_programs_table.php
php database/migrations/003_create_messages_table.php
php database/migrations/004_create_news_table.php
php database/migrations/005_create_partners_table.php
php database/seeders/AdminSeeder.php
```

---

## 3. Running the Project

* Serve the `public` directory via local server
* Example URL: `http://localhost/GainLove-api/public`

---

## 4. Authentication

### Login

**POST** `/auth/login`
**Request Body (JSON):**

```json
{
  "username": "admin",
  "password": "123"
}
```

**Response:**

```json
{
  "token": "<JWT_TOKEN>"
}
```

Use the token in Authorization header for Admin-protected endpoints:

```
Authorization: Bearer <JWT_TOKEN>
```

---

## 5. API Endpoints

### Users (Admin only)

* **GET** `/users` → List all users
* **GET** `/users/{id}` → Retrieve a single user
* **POST** `/users` → Create a new user
* **PUT** `/users/{id}` → Update a user
* **DELETE** `/users/{id}` → Delete a user

---

### Programs

* **GET** `/programs` → Retrieve last 3 programs
* **GET** `/programs/{id}` → Retrieve a single program
* **POST** `/programs` → Create a new program
  **Form-Data**:

  * `title` (string)
  * `description` (string)
  * `image` (file)
* **PUT** `/programs/{id}` → Update a program
* **DELETE** `/programs/{id}` → Delete a program

---

### News

* **GET** `/news` → Retrieve last 3 news items
* **GET** `/news/{id}` → Retrieve a single news item
* **POST** `/news` → Create a news item
  **Form-Data**:

  * `title` (string)
  * `date` (YYYY-MM-DD)
  * `image` (file)
* **PUT** `/news/{id}` → Update a news item
* **DELETE** `/news/{id}` → Delete a news item

---

### Partners

* **GET** `/partners` → List all partners
* **GET** `/partners/{id}` → Retrieve a single partner
* **POST** `/partners` → Create a partner
  **Form-Data**:

  * `image` (file)
* **PUT** `/partners/{id}` → Update a partner
* **DELETE** `/partners/{id}` → Delete a partner

---

### Messages

* **GET** `/messages` → List all messages
* **GET** `/messages/{id}` → Retrieve a single message
* **POST** `/messages` → Send a message
  **Request Body (JSON):**

```json
{
  "name": "John Doe",
  "phone": "123456789",
  "email": "john@example.com",
  "question": "Your question here"
}
```

* **PUT** `/messages/{id}` → Update a message
* **DELETE** `/messages/{id}` → Delete a message

---

## 6. Logging

* Errors and activity logs are saved in `logs/app.log`
* Examples: Creating programs, updating news, deleting partners, etc.

---

## 7. Notes

* Input validation is applied for all create/update operations.
* File uploads are stored in:

  * `public/uploads/programs/`
  * `public/uploads/news/`
  * `public/uploads/partners/`


