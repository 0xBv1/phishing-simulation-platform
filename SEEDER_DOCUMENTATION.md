# 🌱 Database Seeders Documentation

## 📋 **Overview**

This document provides comprehensive information about all database seeders in the Phishing Simulation Platform. The seeders create realistic test data for development, testing, and demonstration purposes.

---

## 🗂️ **Seeder Files**

### **1. CompleteSeeder.php**
**Purpose**: All-in-one seeder that creates complete test data for all services
**Usage**: `php artisan db:seed --class=CompleteSeeder`

**Creates**:
- 5 subscription plans (Free, Basic, Standard, Premium, Enterprise)
- 7 email templates (phishing, awareness, training)
- 5 companies with different plans
- Users for each company
- Payment records
- Campaigns for each company
- Campaign targets
- User interactions

### **2. DatabaseSeeder.php**
**Purpose**: Main seeder that calls all individual seeders in correct order
**Usage**: `php artisan db:seed`

**Calls**:
- PlanSeeder
- EmailTemplateSeeder
- CompanySeeder
- UserSeeder
- PaymentSeeder
- CampaignSeeder
- CampaignTargetSeeder
- InteractionSeeder

### **3. PlanSeeder.php**
**Purpose**: Creates subscription plans
**Usage**: `php artisan db:seed --class=PlanSeeder`

**Creates**:
- Free Plan (0 employees, $0)
- Basic Plan (50 employees, $29.99)
- Standard Plan (200 employees, $79.99)
- Premium Plan (1000 employees, $199.99)
- Enterprise Plan (unlimited employees, $499.99)

### **4. EmailTemplateSeeder.php**
**Purpose**: Creates email templates for different campaign types
**Usage**: `php artisan db:seed --class=EmailTemplateSeeder`

**Creates**:
- Password Reset Request (phishing)
- IT Security Alert (phishing)
- Invoice Payment (phishing)
- HR Benefits Update (phishing)
- CEO Executive Update (phishing)
- Security Awareness Training (awareness)
- Phishing Simulation Results (training)

### **5. CompanySeeder.php**
**Purpose**: Creates test companies
**Usage**: `php artisan db:seed --class=CompanySeeder`

**Creates**:
- Acme Corporation (Basic plan)
- TechStart Inc (Standard plan)
- Global Enterprises Ltd (Premium plan)
- StartupXYZ (Free plan)
- MegaCorp International (Enterprise plan)

### **6. UserSeeder.php**
**Purpose**: Creates users for companies
**Usage**: `php artisan db:seed --class=UserSeeder`

**Creates**:
- Admin users for each company
- Additional users based on company plan
- Test users with realistic names and emails

### **7. PaymentSeeder.php**
**Purpose**: Creates payment records
**Usage**: `php artisan db:seed --class=PaymentSeeder`

**Creates**:
- Initial payments for paid plans
- Recurring monthly payments
- Failed payments for testing
- Different payment statuses

### **8. CampaignSeeder.php**
**Purpose**: Creates campaigns for companies
**Usage**: `php artisan db:seed --class=CampaignSeeder`

**Creates**:
- Multiple campaigns per company
- Different campaign types (phishing, awareness, training)
- Various campaign statuses (draft, active, completed, paused)
- Realistic date ranges

### **9. CampaignTargetSeeder.php**
**Purpose**: Creates targets for campaigns
**Usage**: `php artisan db:seed --class=CampaignTargetSeeder`

**Creates**:
- Multiple targets per campaign
- Realistic employee names and emails
- Department assignments
- Target count based on campaign type and company plan

### **10. InteractionSeeder.php**
**Purpose**: Creates user interactions
**Usage**: `php artisan db:seed --class=InteractionSeeder`

**Creates**:
- Email sent interactions
- Email opened interactions
- Link clicked interactions
- Form submitted interactions
- Realistic timing and rates

---

## 🚀 **Usage Instructions**

### **Seed All Data**
```bash
# Seed all data using the main seeder
php artisan db:seed

# Or use the complete seeder
php artisan db:seed --class=CompleteSeeder
```

### **Seed Individual Services**
```bash
# Seed only plans
php artisan db:seed --class=PlanSeeder

# Seed only companies
php artisan db:seed --class=CompanySeeder

# Seed only campaigns
php artisan db:seed --class=CampaignSeeder
```

### **Fresh Database with Seeding**
```bash
# Drop all tables and recreate with seed data
php artisan migrate:fresh --seed
```

### **Reset and Reseed**
```bash
# Reset database and seed
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

---

## 📊 **Data Statistics**

### **Plans**
- **Total Plans**: 5
- **Price Range**: $0 - $499.99
- **Employee Limits**: 10 - Unlimited

### **Companies**
- **Total Companies**: 5
- **Plan Distribution**: 1 Free, 1 Basic, 1 Standard, 1 Premium, 1 Enterprise
- **Creation Dates**: Spread over last 30 days

### **Users**
- **Total Users**: ~50-100 (varies by plan)
- **Roles**: Admin, Manager, User
- **Distribution**: Based on company plan limits

### **Campaigns**
- **Total Campaigns**: ~50-100
- **Types**: Phishing, Awareness, Training
- **Statuses**: Draft, Active, Completed, Paused

### **Targets**
- **Total Targets**: ~500-2000
- **Departments**: 14 different departments
- **Distribution**: Based on campaign type and company plan

### **Interactions**
- **Total Interactions**: ~1000-5000
- **Types**: Sent, Opened, Clicked, Submitted
- **Rates**: Realistic interaction rates by department

### **Payments**
- **Total Payments**: ~50-100
- **Statuses**: Completed, Pending, Failed
- **History**: Up to 12 months of payment history

---

## 🎯 **Realistic Data Features**

### **Email Templates**
- **Professional HTML**: Complete HTML email templates
- **Placeholder Variables**: {{name}}, {{email}}, {{fake_link}}, {{tracking_pixel}}
- **Realistic Content**: Professional-looking phishing and training emails
- **Multiple Types**: Phishing, awareness, and training templates

### **Company Data**
- **Realistic Names**: Professional company names
- **Email Domains**: Matching email domains
- **Plan Distribution**: Realistic plan selection
- **Creation Dates**: Spread over time

### **User Data**
- **Realistic Names**: Common first and last names
- **Email Generation**: Proper email format with company domains
- **Role Distribution**: Appropriate role assignments
- **Department Assignment**: Realistic department names

### **Campaign Data**
- **Date Ranges**: Realistic start and end dates
- **Status Logic**: Status based on current date
- **Type Distribution**: Mix of campaign types
- **Target Counts**: Based on company plan and campaign type

### **Interaction Data**
- **Realistic Rates**: Industry-standard interaction rates
- **Department-Based**: Different rates by department
- **Timing Logic**: Realistic interaction timing
- **Sequential Actions**: Proper interaction sequence

---

## 🔧 **Customization**

### **Modifying Data Volume**
Edit the seeder files to adjust:
- Number of companies created
- Campaigns per company
- Targets per campaign
- Interaction rates

### **Adding New Data**
To add new test data:
1. Create a new seeder class
2. Add it to DatabaseSeeder.php
3. Ensure proper foreign key order

### **Modifying Templates**
Edit EmailTemplateSeeder.php to:
- Add new email templates
- Modify existing templates
- Change template content

---

## 🧪 **Testing Data**

### **Login Credentials**
All seeded companies use:
- **Email**: admin@[company-domain].com
- **Password**: password123

### **Test Companies**
1. **Acme Corporation**
   - Email: admin@acme.com
   - Plan: Basic ($29.99/month)

2. **TechStart Inc**
   - Email: admin@techstart.com
   - Plan: Standard ($79.99/month)

3. **Global Enterprises Ltd**
   - Email: admin@globalenterprises.com
   - Plan: Premium ($199.99/month)

4. **StartupXYZ**
   - Email: admin@startupxyz.com
   - Plan: Free ($0/month)

5. **MegaCorp International**
   - Email: admin@megacorp.com
   - Plan: Enterprise ($499.99/month)

### **API Testing**
Use these credentials to test API endpoints:
```bash
# Login to get token
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@acme.com", "password": "password123"}'
```

---

## 🚨 **Important Notes**

### **Data Relationships**
- Seeders respect foreign key constraints
- Data is created in proper order
- Relationships are maintained

### **Realistic Rates**
- Interaction rates match industry standards
- Department-based vulnerability levels
- Campaign performance varies by type

### **Security**
- No real credentials in test data
- All passwords are hashed
- Test data only for development

### **Performance**
- Seeders are optimized for speed
- Batch operations where possible
- Minimal database queries

---

## 🔍 **Troubleshooting**

### **Common Issues**

#### **Foreign Key Errors**
```bash
# Ensure proper seeder order in DatabaseSeeder.php
# Run seeders individually to identify issues
```

#### **Memory Issues**
```bash
# Increase PHP memory limit
php -d memory_limit=512M artisan db:seed
```

#### **Duplicate Data**
```bash
# Use fresh migration
php artisan migrate:fresh --seed
```

### **Debugging**
```bash
# Run with verbose output
php artisan db:seed -v

# Check specific seeder
php artisan db:seed --class=CompanySeeder -v
```

---

## 📈 **Performance Metrics**

### **Seeding Time**
- **Complete Seeder**: ~30-60 seconds
- **Individual Seeders**: ~5-10 seconds each
- **Total Records**: ~2000-5000 records

### **Memory Usage**
- **Peak Memory**: ~128MB
- **Recommended**: 256MB+ for large datasets

### **Database Size**
- **After Seeding**: ~10-50MB
- **Indexes**: Optimized for performance

---

**Last Updated**: September 6, 2025  
**Version**: 1.0.0  
**Total Seeders**: 10

The database seeders provide comprehensive test data for all services in the Phishing Simulation Platform, enabling thorough testing and demonstration of all features! 🌱

