# Phishing Simulation Platform API Documentation

## 🚀 Swagger UI Access

The API documentation is available through Swagger UI at:
- **Local Development**: http://localhost:8000/api/documentation
- **Production**: https://yourdomain.com/api/documentation

## 📋 API Overview

The Phishing Simulation Platform provides a comprehensive REST API for managing phishing simulation campaigns, employee training, and security awareness programs.

### Base URL
```
http://localhost:8000/api
```

### Authentication
The API uses Laravel Sanctum for authentication. Include the Bearer token in the Authorization header:
```
Authorization: Bearer {your-token}
```

## 🔐 Authentication Endpoints

### Register Company
```http
POST /api/auth/register
```

**Request Body:**
```json
{
    "name": "Acme Corporation",
    "email": "admin@acme.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response:**
```json
{
    "message": "Company registered successfully",
    "data": {
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "email": "admin@acme.com",
            "plan_id": 1
        },
        "token": "1|abc123..."
    }
}
```

### Login Company
```http
POST /api/auth/login
```

**Request Body:**
```json
{
    "email": "admin@acme.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "message": "Login successful",
    "data": {
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "email": "admin@acme.com",
            "plan_id": 1
        },
        "token": "1|abc123..."
    }
}
```

### Logout
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

### Refresh Token
```http
POST /api/auth/refresh
Authorization: Bearer {token}
```

## 🏢 Company Management

### Get Company Dashboard
```http
GET /api/company/dashboard
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Dashboard data retrieved successfully",
    "data": {
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "email": "admin@acme.com",
            "plan": {
                "id": 1,
                "name": "Basic",
                "price": 10.00,
                "employee_limit": 50
            }
        },
        "statistics": {
            "total_campaigns": 5,
            "active_campaigns": 2,
            "total_targets": 150,
            "total_interactions": 450
        }
    }
}
```

## 📧 Campaign Management

### List Email Templates
```http
GET /api/campaign/templates
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Templates retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Password Reset",
            "type": "phishing",
            "subject": "Urgent: Password Reset Required",
            "created_at": "2025-09-06T10:00:00.000000Z"
        }
    ]
}
```

### Create Campaign
```http
POST /api/campaign/create
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "type": "phishing",
    "start_date": "2025-09-06",
    "end_date": "2025-09-13"
}
```

**Response:**
```json
{
    "message": "Campaign created successfully",
    "data": {
        "id": 1,
        "type": "phishing",
        "status": "draft",
        "start_date": "2025-09-06",
        "end_date": "2025-09-13",
        "created_at": "2025-09-06T10:00:00.000000Z"
    }
}
```

### Add Targets to Campaign
```http
POST /api/campaign/add-targets
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "campaign_id": 1,
    "targets": [
        {
            "name": "John Doe",
            "email": "john.doe@company.com"
        },
        {
            "name": "Jane Smith",
            "email": "jane.smith@company.com"
        }
    ]
}
```

### Get Campaign Details
```http
GET /api/campaign/{id}/details
Authorization: Bearer {token}
```

### Send Campaign Emails
```http
POST /api/campaign/{id}/send-emails
Authorization: Bearer {token}
```

### Get Campaign Statistics
```http
GET /api/campaign/{id}/stats
Authorization: Bearer {token}
```

### Get AI Analysis
```http
GET /api/campaign/{id}/ai-analysis
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "AI analysis completed successfully",
    "data": {
        "campaign_id": 1,
        "campaign_type": "phishing",
        "analysis_date": "2025-09-06T12:22:31.861730Z",
        "current_performance": {
            "total_targets": 10,
            "open_rate": 85.5,
            "click_rate": 25.0,
            "submit_rate": 5.0
        },
        "suggestions": [
            {
                "type": "critical",
                "title": "Immediate Security Training Required",
                "description": "1 employee(s) submitted credentials to the phishing simulation. Immediate security training is required.",
                "priority": "high",
                "action_required": true,
                "employees": ["John Doe"],
                "training_modules": [
                    "Phishing Recognition",
                    "Password Security",
                    "Social Engineering Awareness"
                ]
            }
        ],
        "improvement": "10% better than last campaign - fewer employees submitted credentials",
        "risk_level": {
            "level": "medium",
            "description": "Some employees are vulnerable. Additional training recommended."
        }
    }
}
```

## 💳 Payment Management

### List Available Plans
```http
GET /api/plans
```

**Response:**
```json
{
    "message": "Plans retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Basic",
            "price": 10.00,
            "employee_limit": 50,
            "features": [
                "50 employees",
                "Basic templates",
                "Email support"
            ]
        },
        {
            "id": 2,
            "name": "Standard",
            "price": 30.00,
            "employee_limit": 200,
            "features": [
                "200 employees",
                "Advanced templates",
                "Priority support"
            ]
        },
        {
            "id": 3,
            "name": "Premium",
            "price": 50.00,
            "employee_limit": 999999,
            "features": [
                "Unlimited employees",
                "Custom templates",
                "24/7 support"
            ]
        }
    ]
}
```

### Initialize Payment
```http
POST /api/payment/checkout
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "plan_id": 2
}
```

**Response:**
```json
{
    "message": "Payment initialized successfully",
    "data": {
        "transaction_id": "txn_123456789",
        "checkout_url": "https://payment-gateway.com/checkout/txn_123456789",
        "amount": 30.00,
        "plan": {
            "id": 2,
            "name": "Standard",
            "employee_limit": 200
        }
    }
}
```

### Confirm Payment
```http
POST /api/payment/confirm
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "transaction_id": "txn_123456789"
}
```

## 📊 Reports and Analytics

### Get Campaign Report
```http
GET /api/reports/campaign/{id}
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Campaign report retrieved successfully",
    "data": {
        "campaign": {
            "id": 1,
            "type": "phishing",
            "status": "completed",
            "start_date": "2025-09-06",
            "end_date": "2025-09-13"
        },
        "summary": {
            "total_targets": 10,
            "total_sent": 10,
            "total_opened": 8,
            "total_clicked": 3,
            "total_submitted": 1,
            "open_rate": 80.0,
            "click_rate": 30.0,
            "submit_rate": 10.0
        },
        "interaction_details": [
            {
                "email": "john.doe@company.com",
                "name": "John Doe",
                "actions": ["sent", "opened", "clicked", "submitted"],
                "risk_level": "high",
                "last_action": "2025-09-06T14:30:00.000000Z"
            }
        ],
        "charts_data": {
            "daily_interactions": [
                {
                    "date": "2025-09-06",
                    "opened": 5,
                    "clicked": 2,
                    "submitted": 1
                }
            ]
        }
    }
}
```

## 📧 Email Tracking (Public Endpoints)

### Track Email Open
```http
GET /api/track/{token}/opened
```

Returns a 1x1 pixel image for tracking email opens.

### Track Email Click
```http
GET /api/track/{token}/clicked
```

Redirects to the phishing simulation page.

### Show Phishing Page
```http
GET /api/campaign/{token}
```

Displays the phishing simulation page based on the campaign template.

### Submit Phishing Form
```http
POST /api/campaign/{token}/submit
```

**Request Body:**
```json
{
    "email": "employee@company.com",
    "password": "[REDACTED - NOT STORED]",
    "department": "IT",
    "timestamp": "2025-09-06T14:30:00.000Z",
    "campaign_type": "phishing",
    "template_name": "Password Reset"
}
```

**Response:**
```json
{
    "message": "Submission tracked successfully",
    "success": true,
    "note": "No real credentials were stored"
}
```

## 🔒 Security Features

### Rate Limiting
- **Authentication Routes**: 5 requests per minute per IP
- **Tracking Routes**: 60 requests per minute per IP
- **Campaign Routes**: 30 requests per minute per IP
- **API Routes**: 100 requests per minute per user/IP

### Authentication
- All sensitive endpoints require Bearer token authentication
- Company-based access control ensures data isolation
- Laravel Policies enforce authorization rules

### Input Validation
- All endpoints use Form Request validation
- Comprehensive validation rules for all inputs
- Custom error messages for better user experience

### Credential Protection
- No real credentials are stored from phishing simulations
- Passwords are redacted with `[REDACTED - NOT STORED]`
- Clear warnings on all phishing simulation pages

## 📝 Error Responses

### Validation Error (422)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ]
    }
}
```

### Unauthorized (401)
```json
{
    "message": "Unauthenticated."
}
```

### Not Found (404)
```json
{
    "message": "Campaign not found."
}
```

### Rate Limited (429)
```json
{
    "message": "Too Many Attempts."
}
```

## 🚀 Getting Started

1. **Register a Company**: Use the `/api/auth/register` endpoint
2. **Login**: Use the `/api/auth/login` endpoint to get your token
3. **Set Authorization Header**: Include `Authorization: Bearer {token}` in all requests
4. **Create Campaign**: Use the campaign endpoints to create and manage campaigns
5. **View Analytics**: Use the reports and AI analysis endpoints for insights

## 📚 Additional Resources

- **Swagger UI**: http://localhost:8000/api/documentation
- **Security Documentation**: See `SECURITY.md`
- **Rate Limiting**: Configured in `bootstrap/app.php`
- **Policies**: Defined in `app/Policies/`

## 🔧 Development

### Local Development
```bash
# Start the development server
php artisan serve

# Access Swagger UI
http://localhost:8000/api/documentation

# Generate documentation
php artisan l5-swagger:generate
```

### Testing
```bash
# Run tests
php artisan test

# Test specific functionality
php artisan test:ai-analysis
```

---

**Note**: This API is designed for phishing simulation and security awareness training. All phishing simulations are clearly marked and no real credentials are stored or processed.
