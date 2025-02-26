## Reliance International BD - Laravel Project

This is a Laravel-based web application for Reliance International BD. The project includes features such as routing, database migrations, seeding, and more.

- [Simple, fast routing engine](https://laravel.com/docs/routing).

## Table of Contents

- Prerequisites
- Installation
- Configuration
- Running Migrations and Seeders
- Serving the Application
- Contributing
- License

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- PHP (version 8.0 or higher)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/en/) (optional, for frontend dependencies)
- [MySQL](https://www.mysql.com/) or any other supported database
- [Git](https://git-scm.com/)

## Installation

Clone the Repository
--------------------

Clone the repository using the following command:

git clone <repository-url>
cd <project-directory>

Replace `<repository-url>` with the URL of your Git repository and `<project-directory>` with the name of your project folder.

Install Dependencies
-------------------

### Install PHP Dependencies

Install PHP dependencies using Composer:

composer install

### Install Frontend Dependencies (Optional)

If your project uses frontend dependencies (e.g., npm), install them as well:

npm install

### Configuration

1. Set Up Environment File

Copy the `.env.example` file to `.env`:

Generate Application Key
------------------------

Generate a unique application key using the following command:

php artisan key:generate

Configure Database
-------------------

Open the `.env` file and update the database credentials using the following format:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

Replace the placeholders with your actual database credentials.

## Running Migrations and Seeders

Run Database Migrations
-------------------------------

Run the database migrations using the following command:

php artisan migrate

Run Database Seeders
------------------------------

Run the database seeders using the following command:

php artisan db:seed

## Serving the Application  

Run the Laravel Application
--------------------------      

Run the Laravel application using the following command:

php artisan serve

Access the Application
------------------------------

You can now access the application at [http://localhost:8000](http://localhost:8000) in your web browser.   

## Contributing

Contributing to Reliance International BD Laravel Project
----------------------------------------------------------------------------------------------------------------------
