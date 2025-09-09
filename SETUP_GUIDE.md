# 🚀 Phishing Simulation Platform - Complete Setup Guide

## 📋 **Table of Contents**

1. [Prerequisites](#prerequisites)
2. [Installation Steps](#installation-steps)
3. [Environment Configuration](#environment-configuration)
4. [Database Setup](#database-setup)
5. [Application Configuration](#application-configuration)
6. [Running the Application](#running-the-application)
7. [Testing the Setup](#testing-the-setup)
8. [Troubleshooting](#troubleshooting)
9. [Production Deployment](#production-deployment)

---

## 🔧 **Prerequisites**

### **System Requirements**
- **PHP**: 8.2 or higher
- **Composer**: Latest version
- **Node.js**: 18.x or higher
- **NPM**: Latest version
- **Database**: MySQL 8.0+ or PostgreSQL 13+
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Operating System**: Windows 10+, macOS 10.15+, or Linux

### **Required PHP Extensions**
```bash
php-curl
php-dom
php-fileinfo
php-filter
php-hash
php-mbstring
php-openssl
php-pcre
php-pdo
php-session
php-tokenizer
php-xml
php-zip
php-gd
php-mysql (for MySQL) or php-pgsql (for PostgreSQL)
```

### **Development Tools (Optional)**
- **Git**: For version control
- **VS Code**: Recommended IDE
- **Postman**: For API testing
- **MySQL Workbench**: For database management

---

## 📥 **Installation Steps**

### **Step 1: Clone the Repository**

```bash
# Clone the repository
git clone https://github.com/0xBv1/phishing-simulation-platform.git

# Navigate to the project directory
cd phishing-simulation-platform
```

### **Step 2: Install PHP Dependencies**

```bash
# Install Composer dependencies
composer install

# Install Node.js dependencies
npm install
```

### **Step 3: Environment Setup**

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **Step 4: Database Configuration**

```bash
# Create database (MySQL example)
mysql -u root -p
CREATE DATABASE phishing_simulation;
exit

# Or for PostgreSQL
psql -U postgres
CREATE DATABASE phishing_simulation;
\q
```

---

## ⚙️ **Environment Configuration**

### **Edit `.env` File**

```env
# Application Configuration
APP_NAME="Phishing Simulation Platform"
APP_ENV=local
APP_KEY=base64:your_generated_key_here
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000

# Database Configuration (MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phishing_simulation
DB_USERNAME=root
DB_PASSWORD=your_password

# Database Configuration (PostgreSQL)
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=phishing_simulation
# DB_USERNAME=postgres
# DB_PASSWORD=your_password

# Mail Configuration (Mailtrap for testing)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@phishing-simulation.com"
MAIL_FROM_NAME="${APP_NAME}"

# Queue Configuration
QUEUE_CONNECTION=database

# Cache Configuration
CACHE_STORE=database

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Sanctum Configuration
SANCTUM_STATEFUL_DOMAINS=localhost:8000,127.0.0.1:8000
```

### **Mailtrap Setup (for Email Testing)**

1. **Sign up** at [Mailtrap.io](https://mailtrap.io)
2. **Create** a new inbox
3. **Copy** the SMTP credentials
4. **Update** the `.env` file with your credentials

---

## 🗄️ **Database Setup**

### **Step 1: Run Migrations**

```bash
# Run database migrations
php artisan migrate

# Seed the database with initial data
php artisan db:seed
```

### **Step 2: Verify Database Tables**

The following tables should be created:
- `companies` - Company information
- `users` - User accounts
- `plans` - Subscription plans
- `payments` - Payment records
- `campaigns` - Phishing campaigns
- `campaign_targets` - Campaign targets
- `email_templates` - Email templates
- `interactions` - User interactions
- `jobs` - Queue jobs
- `failed_jobs` - Failed queue jobs
- `cache` - Cache storage
- `sessions` - Session storage
- `personal_access_tokens` - API tokens

### **Step 3: Check Seeded Data**

```bash
# Check if data was seeded successfully
php artisan tinker

# In tinker, run:
>>> App\Models\Plan::count()
>>> App\Models\EmailTemplate::count()
>>> App\Models\Company::count()
>>> exit
```

---

## 🚀 **Application Configuration**

### **Step 1: Generate Swagger Documentation**

```bash
# Generate Swagger API documentation
php artisan l5-swagger:generate
```

### **Step 2: Build Frontend Assets**

```bash
# Build CSS and JavaScript assets
npm run build

# Or for development with hot reload
npm run dev
```

### **Step 3: Set Permissions (Linux/macOS)**

```bash
# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## 🏃 **Running the Application**

### **Development Server**

```bash
# Start the Laravel development server
php artisan serve

# The application will be available at:
# http://localhost:8000
```

### **Queue Worker (Required for Email Sending)**

```bash
# Start the queue worker in a separate terminal
php artisan queue:work

# Or for development with auto-restart
php artisan queue:work --tries=3 --timeout=60
```

### **Web Server Configuration**

#### **Apache Configuration**

Create a virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName phishing-simulation.local
    DocumentRoot /path/to/phishing-simulation-platform/public
    
    <Directory /path/to/phishing-simulation-platform/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/phishing-simulation_error.log
    CustomLog ${APACHE_LOG_DIR}/phishing-simulation_access.log combined
</VirtualHost>
```

#### **Nginx Configuration**

```nginx
server {
    listen 80;
    server_name phishing-simulation.local;
    root /path/to/phishing-simulation-platform/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

## 🧪 **Testing the Setup**

### **Step 1: Check Application Status**

```bash
# Check if the application is running
curl http://localhost:8000

# Should return the Laravel welcome page
```

### **Step 2: Test API Documentation**

```bash
# Visit Swagger documentation
# http://localhost:8000/api/documentation
```

### **Step 3: Test Database Connection**

```bash
# Test database connection
php artisan tinker

# In tinker:
>>> DB::connection()->getPdo();
>>> exit
```

### **Step 4: Test Email Configuration**

```bash
# Test email configuration
php artisan tinker

# In tinker:
>>> Mail::raw('Test email', function($message) {
>>>     $message->to('test@example.com')->subject('Test');
>>> });
>>> exit
```

### **Step 5: Test Queue System**

```bash
# Test queue system
php artisan tinker

# In tinker:
>>> dispatch(new App\Jobs\SendPhishingEmailJob(
>>>     'test@example.com',
>>>     'Test User',
>>>     App\Models\Campaign::first(),
>>>     App\Models\EmailTemplate::first(),
>>>     'test_token',
>>>     1
>>> ));
>>> exit
```

---

## 🔍 **API Testing**

### **Step 1: Register a Company**

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Company",
    "email": "admin@testcompany.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### **Step 2: Login and Get Token**

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@testcompany.com",
    "password": "password123"
  }'
```

### **Step 3: Test Protected Endpoints**

```bash
# Use the token from login response
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 🐛 **Troubleshooting**

### **Common Issues and Solutions**

#### **1. Composer Install Fails**

```bash
# Clear Composer cache
composer clear-cache

# Update Composer
composer self-update

# Try installing again
composer install --no-dev --optimize-autoloader
```

#### **2. Database Connection Issues**

```bash
# Check database credentials in .env
# Verify database server is running
# Test connection manually

# MySQL
mysql -u root -p -e "SHOW DATABASES;"

# PostgreSQL
psql -U postgres -c "\l"
```

#### **3. Permission Issues (Linux/macOS)**

```bash
# Fix storage permissions
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache

# Or for your user
sudo chown -R $USER:$USER storage
sudo chown -R $USER:$USER bootstrap/cache
```

#### **4. Queue Worker Issues**

```bash
# Clear failed jobs
php artisan queue:clear

# Restart queue worker
php artisan queue:restart

# Check queue status
php artisan queue:monitor
```

#### **5. Swagger Documentation Issues**

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Regenerate documentation
php artisan l5-swagger:generate
```

#### **6. Email Sending Issues**

```bash
# Check mail configuration
php artisan tinker
>>> config('mail')

# Test mail configuration
>>> Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });
```

### **Log Files**

Check these log files for errors:
- `storage/logs/laravel.log` - Application logs
- `storage/logs/queue.log` - Queue worker logs
- Web server error logs (Apache/Nginx)

---

## 🚀 **Production Deployment**

### **Step 1: Environment Configuration**

```env
# Production .env settings
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Use Redis for production
CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

# Production database
DB_CONNECTION=mysql
DB_HOST=your-production-db-host
DB_DATABASE=phishing_simulation_prod
DB_USERNAME=your-production-user
DB_PASSWORD=your-secure-password

# Production mail (use real SMTP)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-smtp-username
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
```

### **Step 2: Optimize Application**

```bash
# Optimize for production
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### **Step 3: Set Up Queue Workers**

```bash
# Use Supervisor for queue workers
sudo apt-get install supervisor

# Create supervisor configuration
sudo nano /etc/supervisor/conf.d/phishing-simulation-worker.conf
```

Supervisor configuration:
```ini
[program:phishing-simulation-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/phishing-simulation-platform/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/phishing-simulation-platform/storage/logs/worker.log
stopwaitsecs=3600
```

### **Step 4: Set Up Cron Jobs**

```bash
# Add to crontab
crontab -e

# Add this line
* * * * * cd /path/to/phishing-simulation-platform && php artisan schedule:run >> /dev/null 2>&1
```

### **Step 5: SSL Certificate**

```bash
# Using Let's Encrypt
sudo apt-get install certbot python3-certbot-apache

# Get certificate
sudo certbot --apache -d your-domain.com
```

---

## 📚 **Additional Resources**

### **Documentation Files**
- `README.md` - Project overview
- `API_DOCUMENTATION.md` - Quick API reference
- `FULL_API_DOCUMENTATION.md` - Complete API documentation
- `SECURITY.md` - Security implementation guide

### **Useful Commands**

```bash
# Clear all caches
php artisan optimize:clear

# Check application status
php artisan about

# Generate IDE helper files
php artisan ide-helper:generate

# Check routes
php artisan route:list

# Check configuration
php artisan config:show

# Check environment
php artisan env
```

### **Development Tools**

```bash
# Install Laravel Debugbar (development only)
composer require barryvdh/laravel-debugbar --dev

# Install Laravel Telescope (development only)
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

---

## 🎯 **Quick Start Checklist**

- [ ] Clone repository
- [ ] Install PHP dependencies (`composer install`)
- [ ] Install Node.js dependencies (`npm install`)
- [ ] Copy `.env.example` to `.env`
- [ ] Generate application key (`php artisan key:generate`)
- [ ] Configure database in `.env`
- [ ] Run migrations (`php artisan migrate`)
- [ ] Seed database (`php artisan db:seed`)
- [ ] Generate Swagger docs (`php artisan l5-swagger:generate`)
- [ ] Start development server (`php artisan serve`)
- [ ] Start queue worker (`php artisan queue:work`)
- [ ] Test API at `http://localhost:8000/api/documentation`

---

## 🆘 **Getting Help**

If you encounter issues:

1. **Check the logs**: `storage/logs/laravel.log`
2. **Verify configuration**: `php artisan config:show`
3. **Test database connection**: `php artisan tinker`
4. **Check queue status**: `php artisan queue:monitor`
5. **Review this guide**: Go through each step carefully

**Repository**: https://github.com/0xBv1/phishing-simulation-platform

---

**Last Updated**: September 6, 2025  
**Version**: 1.0.0  
**Laravel Version**: 11.x

Your phishing simulation platform should now be running successfully! 🎉
