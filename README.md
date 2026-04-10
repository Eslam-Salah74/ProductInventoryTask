# Product Inventory Management System

A comprehensive RESTful API for managing product inventory, built with **Laravel 11**, **Docker**, **Redis**, and **PostgreSQL**.

## Features
- **Full Product CRUD:** Create, Read, Update, and Soft Delete.
- **Advanced Filtering & Pagination:** Filter products by name, SKU, price, and status.
- **Stock Management:** Adjust stock quantities (increment/decrement) with low-stock alerts.
- **Performance Optimization:** Redis caching (using tags) for search results and product details.
- **Standardized API Responses:** Consistent JSON format with professional error handling.
- **Automated Testing:** Feature tests covering all core operations.
- **Swagger Documentation:** Interactive API documentation using Swagger UI.

---

## Prerequisites
The only requirement for running this project is:
- [Docker Desktop](https://www.docker.com/products/docker-desktop)

**Note:** You do NOT need PHP or Composer installed locally. Everything runs inside Docker containers.

---

## Getting Started (Docker Only)

### 1. Clone the Project
```bash
git clone https://github.com/Eslam-Salah74/ProductInventoryTask.git
cd ProductInventoryTask
```

### 2. Set Up Environment Variables
Copy the `.env.example` file to create a new `.env` file (this file contains pre-configured Docker settings):
```bash
cp .env.example .env
```

### 3. Build and Start the Containers
Run the following command to build the images and start the services. This process will automatically install all PHP dependencies (vendor folder) inside the container:
```bash
docker-compose up -d --build
```
The following services will be started:
- **Laravel App:** (PHP-FPM) container where your code and dependencies live.
- **Nginx:** Web server (accessible at [http://localhost:8000](http://localhost:8000)).
- **PostgreSQL:** Database server.
- **Redis:** Cache and queue server.

### 4. Application Setup
Once the containers are running, execute these commands in order:

**A. Generate Application Key:**
```bash
docker-compose exec app php artisan key:generate
```

**B. Run Database Migrations and Seed Data:**
This will create the tables and populate the database with 50 sample products.
```bash
docker-compose exec app php artisan migrate --seed
```

**C. Run Automated Tests:**
To ensure everything is installed and working correctly:
```bash
docker-compose exec app php artisan test
```

---

## Important Links
- **Application URL:** [http://localhost:8000](http://localhost:8000)
- **Swagger Documentation:** [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

---

## Common Commands

**Run Specific Tests:**
```bash
docker-compose exec app php artisan test --filter ProductTest
```

**Generate Swagger Documentation (after code changes):**
```bash
docker-compose exec app php artisan l5-swagger:generate
```

**Monitor Low Stock Alerts:**
Alerts are logged in the Laravel log file when stock falls below the threshold:
```bash
docker-compose exec app tail -f storage/logs/laravel.log
```

---

## API Endpoints

| Feature | Endpoint (URL) | Method |
| :--- | :--- | :--- |
| List All Products | `/api/products` | `GET` |
| Get Single Product | `/api/products/{id}` | `GET` |
| Create Product | `/api/products` | `POST` |
| Update Product | `/api/products/{id}` | `PUT` |
| Delete Product (Soft Delete) | `/api/products/{id}` | `DELETE` |
| Adjust Stock | `/api/products/{id}/stock` | `POST` |
| List Low Stock Products | `/api/products/low-stock` | `GET` |

---
Developed with the help of Trae IDE AI Assistant.
