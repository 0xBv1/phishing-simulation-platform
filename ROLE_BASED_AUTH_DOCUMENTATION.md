# 🔐 Role-Based Authentication System

## Overview

The Phishing Simulation Platform now includes a comprehensive role-based authentication system with different dashboards and access levels for admin, developer, and client users.

## User Roles

### 1. **Admin** 
- Full access to platform administration
- Can view all companies, campaigns, and revenue
- Access to admin dashboard with system-wide statistics
- Can access all features including client features

### 2. **Developer**
- Access to API documentation
- Can view and test API endpoints
- Redirected to Swagger documentation on login

### 3. **Client** (Default)
- Standard company access
- Can manage their own campaigns
- View their company statistics
- Access to client dashboard

## Login Credentials

### Admin Account
- **Email**: admin@acme.com
- **Password**: password123
- **Dashboard**: /admin/dashboard

### Developer Account
- **Email**: developer@phishing-platform.com
- **Password**: password123
- **Dashboard**: Redirects to /api/documentation

### Client Accounts
- **Email**: admin@techstart.com
- **Password**: password123
- **Dashboard**: /dashboard

- **Email**: admin@globalenterprises.com
- **Password**: password123
- **Dashboard**: /dashboard

## Routes

### Public Routes
- `/` - Home page with platform information
- `/login` - Login form
- `/register` - Registration form

### Protected Routes

#### Admin Only
- `/admin/dashboard` - Admin dashboard with system statistics

#### Client Routes (Admin can also access)
- `/dashboard` - Client dashboard with company statistics

#### Developer Routes (Admin can also access)
- `/api-documentation` - Redirects to Swagger API documentation

## Features

### Home Page (`/`)
- Welcome message and platform overview
- Features showcase
- Pricing plans
- Quick links to login/register or dashboard

### Login System
- Email and password authentication
- Remember me functionality
- Role-based redirects after login
- Demo credentials displayed

### Registration
- Company name, email, password
- Plan selection
- Automatic client role assignment
- Redirect to client dashboard after registration

### Admin Dashboard
- Total companies, campaigns, users, and revenue
- Recent companies table
- Recent payments table
- System overview statistics
- Monthly metrics

### Client Dashboard
- Company-specific statistics
- Recent campaigns with status
- Current plan information
- Quick actions (create campaign, view templates, etc.)
- Campaign performance overview

### Navigation
- Dynamic navbar based on authentication status
- User dropdown menu with profile, settings, and logout
- Role-specific menu items (API Docs for developers)

## Security Features

### Middleware
- `auth:company` - Ensures user is authenticated
- `check.role:role1,role2` - Validates user has one of the specified roles
- `guest:company` - Prevents authenticated users from accessing login/register

### Authentication Guards
- `company` guard for company authentication
- Session-based authentication
- Password hashing using bcrypt

### Access Control
- Role-based route protection
- 403 Forbidden for unauthorized access
- Automatic redirects based on user role

## Implementation Details

### Models
- `Company` model extends `Authenticatable`
- Role field: enum('admin', 'developer', 'client')
- Password field is hashed and hidden

### Controllers
- `HomeController` - Handles home page and dashboards
- `Web\AuthController` - Handles login, registration, and logout

### Views
- `layouts/app.blade.php` - Main layout with navbar
- `home.blade.php` - Landing page
- `auth/login.blade.php` - Login form
- `auth/register.blade.php` - Registration form
- `admin/dashboard.blade.php` - Admin dashboard
- `client/dashboard.blade.php` - Client dashboard

### Styling
- Clean, modern design using inline styles
- Responsive grid layouts
- Gradient cards for statistics
- Professional color scheme

## Setup Instructions

1. **Run Migrations**
   ```bash
   php artisan migrate
   ```

2. **Seed the Database**
   ```bash
   php artisan db:seed
   php artisan db:seed --class=AdminRoleSeeder
   ```

3. **Clear Caches**
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

4. **Start the Server**
   ```bash
   php artisan serve
   ```

5. **Access the Platform**
   - Visit: http://localhost:8000
   - Login with credentials above

## Testing the System

1. **Test Admin Access**
   - Login as admin@acme.com
   - Should redirect to /admin/dashboard
   - Can access both admin and client features

2. **Test Developer Access**
   - Login as developer@phishing-platform.com
   - Should redirect to API documentation
   - Can access developer-specific features

3. **Test Client Access**
   - Login as any client account
   - Should redirect to /dashboard
   - Can only access client features

4. **Test Registration**
   - Register a new company
   - Should be assigned client role
   - Should redirect to client dashboard

## Customization

### Adding New Roles
1. Update the role enum in the migration
2. Add role to CheckRole middleware logic
3. Create role-specific routes and views
4. Update role-based redirects in controllers

### Modifying Dashboards
- Edit views in `resources/views/admin/` or `resources/views/client/`
- Add new statistics or widgets
- Customize styling and layout

### Changing Redirects
- Update `HomeController@index` for initial redirects
- Update `AuthController@login` for post-login redirects
- Modify role-based logic as needed

## Troubleshooting

### Common Issues

1. **"Class Company does not exist" error**
   - Run: `composer dump-autoload`

2. **"Auth guard [company] is not defined" error**
   - Clear config cache: `php artisan config:clear`

3. **Role column doesn't exist**
   - Check migrations have run: `php artisan migrate:status`

4. **Can't access protected routes**
   - Ensure middleware is registered in `bootstrap/app.php`
   - Check role assignment in database

### Debug Tips
- Check current user: `Auth::guard('company')->user()`
- Check user role: `Auth::guard('company')->user()->role`
- View route list: `php artisan route:list`

The role-based authentication system provides a secure and flexible foundation for managing different user types in the Phishing Simulation Platform!
