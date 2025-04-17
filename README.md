# Laravel App Installation Guide

## Prerequisites

Ensure the following software is installed on your Linux system:

1. **[PHP](https://www.php.net/downloads.php)**: Version 8.1 or higher
2. **[Composer](https://getcomposer.org/download/)**: Dependency management tool for PHP
3. **[Web Server](https://httpd.apache.org/download.cgi) (Apache)** or **[Nginx](https://nginx.org/en/download.html)**
4. **[MySQL](https://dev.mysql.com/downloads/)** or **[PostgreSQL](https://www.postgresql.org/download/)**
5. **[Node.js](https://nodejs.org/en/download/)** & **[npm](https://www.npmjs.com/get-npm)**: Required for frontend asset compilation
6. **[Git](https://git-scm.com/download/linux)**: To clone the repository

---

## Installation Steps

### 1. Clone the Repository

Run the following command to clone the repository to your local system:

    git clone https://github.com/AryaMerlet/evaluation_laravel.git
    cd evaluation_laravel

### 2. Install PHP Dependencies

Use Composer to install dependencies   

    composer install

### 3. Set Permissions

Ensure the storage and bootstrap/cache directories are writable by your server:

    chmod -R 775 storage bootstrap/cache

### 4. Set Up Environment Variables

Create a .env file by copying the example .env.example file:

    cp .env.example .env

Edit the .env file to configure your database environment:

    nano .env

update those lines to match your configuration

###### DB_HOST=127.0.0.1
###### DB_PORT=3306
###### DB_DATABASE=evaluation_laravel
###### DB_USERNAME=root
###### DB_PASSWORD=

### 5. Generate Application Key

Run the following command to generate the application key:

    php artisan key:generate

### 6. Set Up Database

Run migrations to set up the database schema:

    php artisan migrate

(Optional) Seed the database with sample data:

    php artisan db:seed

### 7. Frontend Assets
    
Install and run NPM :

    npm install
    npm run build

Start the Laravel development server:

    php artisan serve



