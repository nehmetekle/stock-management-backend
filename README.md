# Stock Management Backend

REST API backend for a stock management application built with CodeIgniter 4 and MySQL.

## Project Context

This project is a backend API for managing stock in a shop.

It provides product management, category management, supplier management, business rules, filtering, and supplier stock summary.

The backend is designed to be connected later to an Angular frontend.

## Tech Stack

- PHP
- CodeIgniter 4
- MySQL
- XAMPP
- REST API

## Architecture

The project follows a layered architecture:

```txt
Controller
-> Service Interface
-> Service Implementation
-> Repository Interface
-> Repository Implementation
-> Model
-> Database
```

Main folders:

```txt
app/
├── Controllers/
├── Services/
│   ├── Interfaces/
│   └── Implementations/
├── Repositories/
│   ├── Interfaces/
│   └── Implementations/
├── Models/
│   ├── Requests/
│   └── Responses/
└── Database/
    ├── Migrations/
    └── Seeds/
```

## Features

- Product CRUD
- Category CRUD
- Supplier CRUD
- Soft delete using `is_deleted`
- Product filtering by category, supplier, and maximum price
- Product list with category name and supplier name using SQL joins
- Product business flags:
  - `is_heavy_and_cheap`: `weight > 1000` and `price < 50`
  - `is_low_stock`: `stock_quantity < 10`
- Supplier summary:
  - number of products per supplier
  - total stock value using `SUM(price * stock_quantity)`
- Backend validation
- Consistent JSON responses
- Database migrations and seeders

## Database Schema

### categories

```txt
id
name
description
created_at
is_deleted
```

### suppliers

```txt
id
company_name
email
phone
country
created_at
is_deleted
```

### products

```txt
id
name
sku
weight
price
stock_quantity
category_id
supplier_id
created_at
updated_at
is_deleted
```

## Database Field Type Justification

The database field types were chosen based on the expected data size, data meaning, and future maintainability of the project.

### categories

| Field | Type | Justification |
|---|---|---|
| `id` | `INT UNSIGNED AUTO_INCREMENT` | Positive numeric identifier used as the primary key. `UNSIGNED` avoids negative IDs. |
| `name` | `VARCHAR(100)` | Category names are short text values. `100` characters is enough while keeping the field efficient. |
| `description` | `TEXT` | Descriptions can be longer than a simple name, so `TEXT` gives more flexibility. |
| `created_at` | `DATETIME` | Stores the creation date and time of the category. |
| `is_deleted` | `TINYINT(1)` | Boolean-style soft delete flag: `0` means active, `1` means deleted. |

### suppliers

| Field | Type | Justification |
|---|---|---|
| `id` | `INT UNSIGNED AUTO_INCREMENT` | Positive numeric identifier used as the primary key. |
| `company_name` | `VARCHAR(150)` | Company names can be longer than category names, so `150` characters gives enough space. |
| `email` | `VARCHAR(150)` | Emails are text values with variable length. `150` is enough for most professional email addresses. |
| `phone` | `VARCHAR(30)` | Phone numbers are stored as text because they can contain `+`, spaces, and country codes. |
| `country` | `VARCHAR(100)` | Country names are short text values, and `100` characters is sufficient. |
| `created_at` | `DATETIME` | Stores the creation date and time of the supplier. |
| `is_deleted` | `TINYINT(1)` | Boolean-style soft delete flag: `0` means active, `1` means deleted. |

### products

| Field | Type | Justification |
|---|---|---|
| `id` | `INT UNSIGNED AUTO_INCREMENT` | Positive numeric identifier used as the primary key. |
| `name` | `VARCHAR(150)` | Product names can be longer than category names, so `150` characters gives enough flexibility. |
| `sku` | `VARCHAR(80)` + `UNIQUE` | SKU is a unique product reference. `80` characters is enough for structured references while staying efficient. |
| `weight` | `INT UNSIGNED` | Weight is stored in grams as a whole number. `UNSIGNED` prevents negative values. |
| `price` | `DECIMAL(10,2)` | Prices require exact decimal precision. `DECIMAL` avoids floating-point rounding issues. |
| `stock_quantity` | `INT UNSIGNED` | Stock quantity is a whole number and cannot be negative. |
| `category_id` | `INT UNSIGNED` | Foreign key referencing `categories.id`. |
| `supplier_id` | `INT UNSIGNED` | Foreign key referencing `suppliers.id`. |
| `created_at` | `DATETIME` | Stores when the product was created. |
| `updated_at` | `DATETIME` | Stores when the product was last updated. |
| `is_deleted` | `TINYINT(1)` | Boolean-style soft delete flag: `0` means active, `1` means deleted. |

## Database Configuration

Create the database:

```sql
CREATE DATABASE stock_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Recommended setup, using the SQL deliverable:

```bash
mysql -u root -p stock_management < stock_management.sql
```

Or for XAMPP/phpMyAdmin:

You can also create the database in phpMyAdmin and import `stock_management.sql` from the Import tab.

Alternative setup, using CodeIgniter migrations and seeders:

```bash
php spark migrate
php spark db:seed StockSeeder
```

Copy the environment file:

```bash
cp env .env
```

Configure the `.env` file:

```env
CI_ENVIRONMENT = development

database.default.hostname = 127.0.0.1
database.default.database = stock_management
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

If you are using XAMPP, make sure Apache and MySQL are running.

## Installation

Install PHP dependencies:

```bash
composer install
```

Start the backend server:

```bash
php spark serve --port 8080
```

Base URL:

```txt
http://localhost:8080
```

## API Endpoints

### Products

```txt
GET    /products
GET    /products/detail?id=1
POST   /products
PUT    /products
DELETE /products
```

Filtering endpoint:

```txt
GET /products?category=1&supplier=1&maxPrice=50
```

### Categories

```txt
GET    /categories
GET    /categories/detail?id=1
POST   /categories
PUT    /categories
DELETE /categories
```

### Suppliers

```txt
GET    /suppliers
GET    /suppliers/detail?id=1
POST   /suppliers
PUT    /suppliers
DELETE /suppliers
GET    /suppliers/summary
```

## Example Requests

### Create Product

```http
POST /products
```

```json
{
  "name": "Laptop Stand",
  "sku": "STAND-001",
  "weight": 1300,
  "price": 34.99,
  "stock_quantity": 6,
  "category_id": 1,
  "supplier_id": 1
}
```

### Update Product

```http
PUT /products
```

```json
{
  "id": 1,
  "name": "Laptop Stand Updated",
  "sku": "STAND-001",
  "weight": 1300,
  "price": 39.99,
  "stock_quantity": 8,
  "category_id": 1,
  "supplier_id": 1
}
```

### Delete Product

```http
DELETE /products
```

```json
{
  "id": 1
}
```

## Example Response

```json
{
  "success": true,
  "statusCode": 200,
  "message": "Products retrieved successfully",
  "data": [],
  "errors": null
}
```

## Business Rules

### Heavy and Cheap Product

A product is flagged as heavy and cheap when:

```txt
weight > 1000g
price < 50
```

The API returns:

```json
"is_heavy_and_cheap": true
```

### Low Stock

A product is marked as low stock when:

```txt
stock_quantity < 10
```

The API returns:

```json
"is_low_stock": true
```

## Supplier Summary

The supplier summary endpoint returns, for each supplier:

```txt
supplier name
number of products
total stock value
```

The total stock value is calculated with:

```sql
SUM(products.price * products.stock_quantity)
```

Endpoint:

```txt
GET /suppliers/summary
```

## Error Handling

The API handles:

- Missing required fields
- Invalid email format
- Negative numeric values
- Duplicate SKU
- Duplicate category name
- Duplicate supplier email
- Product not found
- Category not found
- Supplier not found

Response codes:

- `200`: successful read, update, or delete
- `201`: successful create
- `400`: validation error or duplicate value
- `404`: resource not found

Example error response:

```json
{
  "success": false,
  "statusCode": 400,
  "message": "Validation failed",
  "data": null,
  "errors": {
    "name": "Product name is required"
  }
}
```
