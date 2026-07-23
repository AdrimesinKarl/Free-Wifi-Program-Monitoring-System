# Free Wifi Program Monitoring System (FWPMS)

A web-based system developed to monitor and manage Free Wifi Program locations.  
The system provides dashboard analytics, location management, location mapping, and project status monitoring.

# 1. System Requirements

Before installing the system, make sure the computer has the following installed:

## Required Software

- Laravel Herd
- PHP 8.2 or higher
- Composer
- Node.js
- NPM
- TablePlus (for database management)
- MYSQL

# 2. Project Setup

## Step 1: Copy the Project

Copy the project folder to your computer.

Example:

```
C:\Users\YourName\Herd\freewifi-monitoring-system
```

Open the project folder using Terminal or Command Prompt.

# Step 3: Install Laravel Dependencies

Run:

```bash
composer install
```

This will install all required Laravel packages.

# Step 4: Install Frontend Dependencies

Run:

```bash
npm install
```

This will install frontend packages required by Vite.

# Step 5: Configure Environment File

Create the environment file:

```bash
cp .env.example .env
```

Generate Laravel application key:

```bash
php artisan key:generate
```

---

# Step 6: Configure Database Using TablePlus

Open **TablePlus**.

Create a new MySQL database:

```
freewifi_monitoring
```

Open the `.env` file and update:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=freewifi_monitoring
DB_USERNAME=root
DB_PASSWORD=
```

Make sure the database connection matches your local MySQL configuration.

# Step 7: Create Database Tables

Run Laravel migrations:

```bash
php artisan migrate
```

This will create the required tables:

- regions
- provinces
- municipalities
- statuses
- locations

# Step 8: Run Frontend Assets

Start Vite:

```bash
npm run dev
```

Keep this terminal running.

# Step 10: Run the Application Using Laravel Herd

Because the project uses Laravel Herd:

1. Open Laravel Herd.
2. Make sure the project folder is inside your Herd directory.
3. Open the project URL provided by Herd.

Example:

```
http://freewifi-monitoring-system.test
```

The application should now be accessible in your browser.

# System Usage Guide

## Dashboard

The dashboard displays:

- Total Free Wifi Sites
- Active Wifi Sites
- Sites for Renewal
- Terminated Sites

Users can filter information by:

- Region
- Province
- Status

## Location Management

The system stores Free Wifi site information:

- Site Name
- Barangay
- Municipality
- Province
- Region
- Status
- Latitude
- Longitude

Available actions:

- Add locations
- Import CSV location data
- Reset location records

## Location Mapping

Steps:

1. Open Location Mapping.
3. Select a Region.
4. View available locations.
5. View Free Wifi sites on the map.

## Project Status Monitoring

Users can:

- View all Free Wifi projects
- Monitor project status

# Database Structure

The system follows:

```
Region
   |
   Province
        |
        Municipality
             |
             Location
```

# Common Problems

## Database Connection Error

Check:

- MySQL is running
- TablePlus connection settings
- `.env` database configuration

## Changes Not Appearing

Run:

```bash
npm run dev
```

Clear Laravel cache:

```bash
php artisan optimize:clear
```

# Technology Stack

## Backend

- Laravel 12
- PHP
- MySQL

## Frontend

- Blade Templates
- Tailwind CSS
- JavaScript
- ApexCharts
- Tom Select
- Lucide Icons

## Development Tools

- Laravel Herd
- TablePlus
- Composer
- Node.js
- NPM
- Vite
