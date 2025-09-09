# Phishing Simulation Platform - Complete API Documentation

## 🚀 Quick Start

**Swagger UI**: http://localhost:8000/api/documentation  
**Base URL**: http://localhost:8000/api  
**Authentication**: Bearer Token (Laravel Sanctum)

---

## 📋 Table of Contents

1. [Authentication](#authentication)
2. [Company Management](#company-management)
3. [Campaign Management](#campaign-management)
4. [Payment & Subscriptions](#payment--subscriptions)
5. [Reports & Analytics](#reports--analytics)
6. [AI Analysis](#ai-analysis)
7. [Email Tracking](#email-tracking)
8. [Error Handling](#error-handling)
9. [Rate Limiting](#rate-limiting)
10. [Security](#security)

---

## 🔐 Authentication

### Register Company
**Endpoint**: `POST /api/auth/register`  
**Rate Limit**: 5 requests/minute per IP  
**Authentication**: None required

#### Request Body
```json
{
    "name": "Acme Corporation",
    "email": "admin@acme.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Response (201 Created)
```json
{
    "message": "Company registered successfully",
    "data": {
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "email": "admin@acme.com",
            "plan_id": 1,
            "created_at": "2025-09-06T10:00:00.000000Z",
            "updated_at": "2025-09-06T10:00:00.000000Z"
        },
        "token": "1|abc123def456ghi789jkl012mno345pqr678stu901vwx234yz"
    }
}
```

#### Validation Rules
- `name`: required|string|max:255
- `email`: required|email|unique:companies,email|max:255
- `password`: required|string|min:8|confirmed
- `password_confirmation`: required|string|same:password

---

### Login Company
**Endpoint**: `POST /api/auth/login`  
**Rate Limit**: 5 requests/minute per IP  
**Authentication**: None required

#### Request Body
```json
{
    "email": "admin@acme.com",
    "password": "password123"
}
```

#### Response (200 OK)
```json
{
    "message": "Login successful",
    "data": {
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "email": "admin@acme.com",
            "plan_id": 1,
            "plan": {
                "id": 1,
                "name": "Free",
                "price": 0.00,
                "employee_limit": 10
            }
        },
        "token": "2|xyz789abc123def456ghi789jkl012mno345pqr678stu901"
    }
}
```

#### Error Responses
- **401 Unauthorized**: Invalid credentials
- **422 Unprocessable Entity**: Validation errors

---

### Logout
**Endpoint**: `POST /api/auth/logout`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Headers
```
Authorization: Bearer {token}
```

#### Response (200 OK)
```json
{
    "message": "Logged out successfully"
}
```

---

### Refresh Token
**Endpoint**: `POST /api/auth/refresh`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Token refreshed successfully",
    "data": {
        "token": "3|new123token456def789ghi012jkl345mno678pqr901stu234"
    }
}
```

---

## 🏢 Company Management

### Get Company Dashboard
**Endpoint**: `GET /api/company/dashboard`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Dashboard data retrieved successfully",
    "data": {
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "email": "admin@acme.com",
            "plan_id": 2,
            "plan": {
                "id": 2,
                "name": "Basic",
                "price": 10.00,
                "employee_limit": 50
            },
            "created_at": "2025-09-06T10:00:00.000000Z"
        },
        "statistics": {
            "total_campaigns": 5,
            "active_campaigns": 2,
            "completed_campaigns": 3,
            "total_targets": 150,
            "total_interactions": 450,
            "successful_simulations": 4,
            "vulnerable_employees": 12
        },
        "recent_activity": [
            {
                "type": "campaign_completed",
                "message": "Phishing Campaign #3 completed",
                "timestamp": "2025-09-06T14:30:00.000000Z"
            },
            {
                "type": "employee_trained",
                "message": "John Doe completed security training",
                "timestamp": "2025-09-06T13:15:00.000000Z"
            }
        ]
    }
}
```

---

## 📧 Campaign Management

### List Email Templates
**Endpoint**: `GET /api/campaign/templates`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Templates retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Password Reset",
            "type": "phishing",
            "subject": "Urgent: Password Reset Required",
            "html_content": "<html>...</html>",
            "created_at": "2025-09-06T10:00:00.000000Z"
        },
        {
            "id": 2,
            "name": "IT Support",
            "type": "phishing",
            "subject": "IT Support Request - Action Required",
            "html_content": "<html>...</html>",
            "created_at": "2025-09-06T10:00:00.000000Z"
        },
        {
            "id": 3,
            "name": "Security Alert",
            "type": "phishing",
            "subject": "Security Alert: Unusual Login Detected",
            "html_content": "<html>...</html>",
            "created_at": "2025-09-06T10:00:00.000000Z"
        },
        {
            "id": 4,
            "name": "HR Update",
            "type": "phishing",
            "subject": "HR Update: New Policy Implementation",
            "html_content": "<html>...</html>",
            "created_at": "2025-09-06T10:00:00.000000Z"
        },
        {
            "id": 5,
            "name": "CEO Message",
            "type": "phishing",
            "subject": "Important Message from CEO",
            "html_content": "<html>...</html>",
            "created_at": "2025-09-06T10:00:00.000000Z"
        }
    ]
}
```

---

### Create Campaign
**Endpoint**: `POST /api/campaign/create`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Request Body
```json
{
    "type": "phishing",
    "start_date": "2025-09-06",
    "end_date": "2025-09-13"
}
```

#### Validation Rules
- `type`: required|string|in:phishing,awareness,training
- `start_date`: required|date|after_or_equal:today
- `end_date`: required|date|after:start_date

#### Response (201 Created)
```json
{
    "message": "Campaign created successfully",
    "data": {
        "id": 1,
        "company_id": 1,
        "type": "phishing",
        "status": "draft",
        "start_date": "2025-09-06",
        "end_date": "2025-09-13",
        "created_at": "2025-09-06T10:00:00.000000Z",
        "updated_at": "2025-09-06T10:00:00.000000Z",
        "targets_count": 0,
        "interactions_count": 0
    }
}
```

---

### Add Targets to Campaign
**Endpoint**: `POST /api/campaign/add-targets`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Request Body
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
        },
        {
            "name": "Bob Johnson",
            "email": "bob.johnson@company.com"
        }
    ]
}
```

#### Validation Rules
- `campaign_id`: required|integer|exists:campaigns,id
- `targets`: required|array|min:1|max:1000
- `targets.*.name`: required|string|max:255
- `targets.*.email`: required|email|max:255

#### Response (201 Created)
```json
{
    "message": "Targets added successfully",
    "data": {
        "campaign_id": 1,
        "added_count": 3,
        "targets": [
            {
                "id": 1,
                "campaign_id": 1,
                "name": "John Doe",
                "email": "john.doe@company.com",
                "created_at": "2025-09-06T10:00:00.000000Z"
            },
            {
                "id": 2,
                "campaign_id": 1,
                "name": "Jane Smith",
                "email": "jane.smith@company.com",
                "created_at": "2025-09-06T10:00:00.000000Z"
            },
            {
                "id": 3,
                "campaign_id": 1,
                "name": "Bob Johnson",
                "email": "bob.johnson@company.com",
                "created_at": "2025-09-06T10:00:00.000000Z"
            }
        ]
    }
}
```

---

### Get Campaign Details
**Endpoint**: `GET /api/campaign/{id}/details`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Campaign details retrieved successfully",
    "data": {
        "id": 1,
        "company_id": 1,
        "type": "phishing",
        "status": "active",
        "start_date": "2025-09-06",
        "end_date": "2025-09-13",
        "created_at": "2025-09-06T10:00:00.000000Z",
        "updated_at": "2025-09-06T10:00:00.000000Z",
        "targets_count": 3,
        "interactions_count": 9,
        "targets": [
            {
                "id": 1,
                "name": "John Doe",
                "email": "john.doe@company.com",
                "interactions": [
                    {
                        "action_type": "sent",
                        "timestamp": "2025-09-06T10:30:00.000000Z"
                    },
                    {
                        "action_type": "opened",
                        "timestamp": "2025-09-06T11:15:00.000000Z"
                    },
                    {
                        "action_type": "clicked",
                        "timestamp": "2025-09-06T11:20:00.000000Z"
                    },
                    {
                        "action_type": "submitted",
                        "timestamp": "2025-09-06T11:25:00.000000Z"
                    }
                ]
            }
        ],
        "interactions": [
            {
                "id": 1,
                "email": "john.doe@company.com",
                "action_type": "sent",
                "timestamp": "2025-09-06T10:30:00.000000Z"
            }
        ]
    }
}
```

---

### Send Campaign Emails
**Endpoint**: `POST /api/campaign/{id}/send-emails`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Emails queued for sending successfully",
    "data": {
        "campaign_id": 1,
        "emails_queued": 3,
        "estimated_delivery": "2025-09-06T10:35:00.000000Z",
        "status": "queued"
    }
}
```

---

### Get Campaign Statistics
**Endpoint**: `GET /api/campaign/{id}/stats`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Campaign statistics retrieved successfully",
    "data": {
        "campaign_id": 1,
        "total_targets": 3,
        "total_sent": 3,
        "total_opened": 2,
        "total_clicked": 1,
        "total_submitted": 1,
        "total_failed": 0,
        "open_rate": 66.67,
        "click_rate": 33.33,
        "submit_rate": 33.33,
        "vulnerability_rate": 33.33,
        "vulnerable_employees": [
            {
                "name": "John Doe",
                "email": "john.doe@company.com",
                "risk_level": "high",
                "actions": ["sent", "opened", "clicked", "submitted"]
            }
        ]
    }
}
```

---

### Resend Email to Target
**Endpoint**: `POST /api/campaign/{campaignId}/resend-email/{targetId}`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Email resent successfully",
    "data": {
        "target_id": 1,
        "campaign_id": 1,
        "email": "john.doe@company.com",
        "status": "queued",
        "estimated_delivery": "2025-09-06T10:40:00.000000Z"
    }
}
```

---

## 🧠 AI Analysis

### Get AI Analysis for Campaign
**Endpoint**: `GET /api/campaign/{id}/ai-analysis`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "AI analysis completed successfully",
    "data": {
        "campaign_id": 1,
        "campaign_type": "phishing",
        "analysis_date": "2025-09-06T12:22:31.861730Z",
        "current_performance": {
            "total_targets": 3,
            "total_sent": 3,
            "total_opened": 2,
            "total_clicked": 1,
            "total_submitted": 1,
            "total_failed": 0,
            "open_rate": 66.67,
            "click_rate": 33.33,
            "submit_rate": 33.33,
            "vulnerability_rate": 33.33,
            "vulnerable_employees": [
                {
                    "name": "John Doe",
                    "email": "john.doe@company.com",
                    "actions": ["sent", "opened", "clicked", "submitted"],
                    "risk_level": "high",
                    "last_action": "2025-09-06T11:25:00.000000Z"
                }
            ]
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
                    "Social Engineering Awareness",
                    "Incident Reporting Procedures"
                ]
            },
            {
                "type": "warning",
                "title": "Additional Security Training Recommended",
                "description": "1 employee(s) clicked on suspicious links. Additional training is recommended.",
                "priority": "medium",
                "action_required": true,
                "employees": ["Jane Smith"],
                "training_modules": [
                    "Phishing Recognition",
                    "Link Verification",
                    "Email Security Best Practices"
                ]
            },
            {
                "type": "info",
                "title": "Phishing Simulation Results",
                "description": "This phishing simulation tested employee awareness of suspicious emails. Review results with your security team.",
                "priority": "medium",
                "action_required": false
            },
            {
                "type": "info",
                "title": "Ongoing Security Awareness",
                "description": "Continue regular phishing simulations and security awareness training to maintain a strong security culture.",
                "priority": "low",
                "action_required": false
            }
        ],
        "improvement": "This is your first campaign. Use this as a baseline for future comparisons.",
        "risk_level": {
            "level": "high",
            "description": "High risk: Many employees are vulnerable to phishing attacks. Immediate action required.",
            "submit_rate": 33.33,
            "click_rate": 33.33,
            "vulnerability_rate": 33.33
        },
        "recommendations": [
            {
                "category": "training",
                "title": "Implement Mandatory Security Training",
                "description": "High submission rate indicates need for comprehensive security training program.",
                "priority": "high"
            },
            {
                "category": "awareness",
                "title": "Enhance Phishing Awareness",
                "description": "High click rate suggests employees need better training on identifying suspicious links.",
                "priority": "medium"
            }
        ],
        "performance_analysis": {
            "trend": "baseline",
            "description": "This is the first campaign. No previous data for comparison.",
            "submit_trend": "baseline",
            "click_trend": "baseline",
            "previous_average_submit": null,
            "previous_average_click": null
        }
    }
}
```

---

## 💳 Payment & Subscriptions

### List Available Plans
**Endpoint**: `GET /api/plans`  
**Rate Limit**: 60 requests/minute per IP  
**Authentication**: None required

#### Response (200 OK)
```json
{
    "message": "Plans retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Free",
            "price": 0.00,
            "employee_limit": 10,
            "features": [
                "10 employees",
                "Basic templates",
                "Email support"
            ]
        },
        {
            "id": 2,
            "name": "Basic",
            "price": 10.00,
            "employee_limit": 50,
            "features": [
                "50 employees",
                "Advanced templates",
                "Priority support",
                "Basic analytics"
            ]
        },
        {
            "id": 3,
            "name": "Standard",
            "price": 30.00,
            "employee_limit": 200,
            "features": [
                "200 employees",
                "Premium templates",
                "24/7 support",
                "Advanced analytics",
                "AI analysis"
            ]
        },
        {
            "id": 4,
            "name": "Premium",
            "price": 50.00,
            "employee_limit": 999999,
            "features": [
                "Unlimited employees",
                "Custom templates",
                "Dedicated support",
                "Full analytics suite",
                "AI analysis",
                "Custom integrations"
            ]
        }
    ]
}
```

---

### Initialize Payment
**Endpoint**: `POST /api/payment/checkout`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Request Body
```json
{
    "plan_id": 2
}
```

#### Validation Rules
- `plan_id`: required|integer|exists:plans,id

#### Response (200 OK)
```json
{
    "message": "Payment initialized successfully",
    "data": {
        "transaction_id": "txn_123456789abcdef",
        "checkout_url": "https://payment-gateway.com/checkout/txn_123456789abcdef",
        "amount": 10.00,
        "plan": {
            "id": 2,
            "name": "Basic",
            "price": 10.00,
            "employee_limit": 50
        },
        "expires_at": "2025-09-06T11:00:00.000000Z"
    }
}
```

---

### Confirm Payment
**Endpoint**: `POST /api/payment/confirm`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Request Body
```json
{
    "transaction_id": "txn_123456789abcdef"
}
```

#### Validation Rules
- `transaction_id`: required|string|exists:payments,transaction_id

#### Response (200 OK)
```json
{
    "message": "Payment confirmed successfully",
    "data": {
        "payment_id": 1,
        "transaction_id": "txn_123456789abcdef",
        "status": "completed",
        "amount": 10.00,
        "plan": {
            "id": 2,
            "name": "Basic",
            "employee_limit": 50
        },
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "plan_id": 2
        },
        "completed_at": "2025-09-06T10:45:00.000000Z"
    }
}
```

---

### Get Payment Status
**Endpoint**: `GET /api/payment/status/{transactionId}`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Payment status retrieved successfully",
    "data": {
        "transaction_id": "txn_123456789abcdef",
        "status": "completed",
        "amount": 10.00,
        "plan_name": "Basic",
        "created_at": "2025-09-06T10:30:00.000000Z",
        "completed_at": "2025-09-06T10:45:00.000000Z"
    }
}
```

---

### Cancel Payment
**Endpoint**: `POST /api/payment/cancel/{transactionId}`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Payment cancelled successfully",
    "data": {
        "transaction_id": "txn_123456789abcdef",
        "status": "cancelled",
        "cancelled_at": "2025-09-06T10:50:00.000000Z"
    }
}
```

---

## 📊 Reports & Analytics

### Get Campaign Report
**Endpoint**: `GET /api/reports/campaign/{id}`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Campaign report retrieved successfully",
    "data": {
        "campaign": {
            "id": 1,
            "type": "phishing",
            "status": "completed",
            "start_date": "2025-09-06",
            "end_date": "2025-09-13",
            "created_at": "2025-09-06T10:00:00.000000Z"
        },
        "summary": {
            "total_targets": 3,
            "total_sent": 3,
            "total_opened": 2,
            "total_clicked": 1,
            "total_submitted": 1,
            "total_failed": 0,
            "open_rate": 66.67,
            "click_rate": 33.33,
            "submit_rate": 33.33,
            "vulnerability_rate": 33.33
        },
        "interaction_details": [
            {
                "email": "john.doe@company.com",
                "name": "John Doe",
                "actions": [
                    {
                        "action_type": "sent",
                        "timestamp": "2025-09-06T10:30:00.000000Z"
                    },
                    {
                        "action_type": "opened",
                        "timestamp": "2025-09-06T11:15:00.000000Z"
                    },
                    {
                        "action_type": "clicked",
                        "timestamp": "2025-09-06T11:20:00.000000Z"
                    },
                    {
                        "action_type": "submitted",
                        "timestamp": "2025-09-06T11:25:00.000000Z"
                    }
                ],
                "risk_level": "high",
                "response_time": "55 minutes"
            }
        ],
        "time_analytics": {
            "average_response_time": "45 minutes",
            "fastest_response": "5 minutes",
            "slowest_response": "2 hours",
            "peak_activity_hour": "11:00 AM",
            "daily_breakdown": [
                {
                    "date": "2025-09-06",
                    "opened": 2,
                    "clicked": 1,
                    "submitted": 1
                }
            ]
        },
        "target_analytics": {
            "most_vulnerable_department": "IT",
            "vulnerability_by_department": {
                "IT": 100.0,
                "HR": 0.0,
                "Finance": 0.0
            },
            "risk_distribution": {
                "high": 1,
                "medium": 0,
                "low": 1,
                "none": 1
            }
        },
        "charts_data": {
            "interaction_timeline": [
                {
                    "timestamp": "2025-09-06T10:30:00.000000Z",
                    "sent": 3,
                    "opened": 0,
                    "clicked": 0,
                    "submitted": 0
                },
                {
                    "timestamp": "2025-09-06T11:15:00.000000Z",
                    "sent": 3,
                    "opened": 2,
                    "clicked": 0,
                    "submitted": 0
                },
                {
                    "timestamp": "2025-09-06T11:20:00.000000Z",
                    "sent": 3,
                    "opened": 2,
                    "clicked": 1,
                    "submitted": 0
                },
                {
                    "timestamp": "2025-09-06T11:25:00.000000Z",
                    "sent": 3,
                    "opened": 2,
                    "clicked": 1,
                    "submitted": 1
                }
            ],
            "department_breakdown": [
                {
                    "department": "IT",
                    "total": 1,
                    "vulnerable": 1,
                    "vulnerability_rate": 100.0
                }
            ],
            "risk_level_distribution": [
                {
                    "risk_level": "high",
                    "count": 1,
                    "percentage": 33.33
                },
                {
                    "risk_level": "low",
                    "count": 1,
                    "percentage": 33.33
                },
                {
                    "risk_level": "none",
                    "count": 1,
                    "percentage": 33.33
                }
            ]
        }
    }
}
```

---

### Get Company Report
**Endpoint**: `GET /api/reports/companies/{company}`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Company report retrieved successfully",
    "data": {
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "plan": {
                "name": "Basic",
                "employee_limit": 50
            }
        },
        "overview": {
            "total_campaigns": 5,
            "total_targets": 150,
            "total_interactions": 450,
            "average_vulnerability_rate": 25.5,
            "improvement_trend": "positive"
        },
        "campaign_performance": [
            {
                "campaign_id": 1,
                "type": "phishing",
                "status": "completed",
                "vulnerability_rate": 33.33,
                "improvement": "+5%"
            }
        ],
        "employee_insights": {
            "most_vulnerable_employees": [
                {
                    "name": "John Doe",
                    "email": "john.doe@company.com",
                    "risk_level": "high",
                    "campaigns_participated": 3,
                    "vulnerability_rate": 100.0
                }
            ],
            "most_secure_employees": [
                {
                    "name": "Bob Johnson",
                    "email": "bob.johnson@company.com",
                    "risk_level": "none",
                    "campaigns_participated": 3,
                    "vulnerability_rate": 0.0
                }
            ]
        }
    }
}
```

---

### Export Reports
**Endpoint**: `GET /api/reports/export/{type}`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Parameters
- `type`: csv|pdf|excel

#### Response (200 OK)
```json
{
    "message": "Report exported successfully",
    "data": {
        "download_url": "https://api.example.com/exports/report_123456.csv",
        "expires_at": "2025-09-06T12:00:00.000000Z",
        "file_size": "2.5 MB",
        "format": "csv"
    }
}
```

---

## 📧 Email Tracking (Public Endpoints)

### Track Email Open
**Endpoint**: `GET /api/track/{token}/opened`  
**Rate Limit**: 60 requests/minute per IP  
**Authentication**: None required

#### Description
Returns a 1x1 pixel image for tracking email opens. This endpoint is called automatically when the tracking pixel in emails is loaded.

#### Response (200 OK)
Returns a 1x1 transparent PNG image with appropriate headers.

---

### Track Email Click
**Endpoint**: `GET /api/track/{token}/clicked`  
**Rate Limit**: 60 requests/minute per IP  
**Authentication**: None required

#### Description
Tracks when a user clicks on a link in a phishing email and redirects them to the phishing simulation page.

#### Response (302 Redirect)
Redirects to `/api/campaign/{token}` (the phishing simulation page).

---

### Show Phishing Page
**Endpoint**: `GET /api/campaign/{token}`  
**Rate Limit**: 30 requests/minute per IP  
**Authentication**: None required

#### Description
Displays the phishing simulation page based on the campaign template. This is the page that employees see when they click on links in phishing emails.

#### Response (200 OK)
Returns an HTML page with a phishing simulation form. The page includes:
- Company branding (if configured)
- Phishing form with email/password fields
- Clear warnings that this is a simulation
- JavaScript to handle form submission without storing real credentials

#### Example HTML Response
```html
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Required</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Phishing page styles */
    </style>
</head>
<body>
    <div class="phishing-container">
        <h1>Password Reset Required</h1>
        <form id="phishingForm">
            <input type="email" id="email" value="employee@company.com" readonly>
            <input type="password" id="password" placeholder="Enter your password">
            <button type="submit">Verify Account</button>
        </form>
        <div class="warning">
            <strong>⚠️ This is a Phishing Simulation!</strong><br>
            This page is part of a security awareness training exercise. 
            No real credentials were collected or stored.
        </div>
    </div>
    <script>
        // Form submission handling
    </script>
</body>
</html>
```

---

### Submit Phishing Form
**Endpoint**: `POST /api/campaign/{token}/submit`  
**Rate Limit**: 30 requests/minute per IP  
**Authentication**: None required

#### Request Body
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

#### Validation Rules
- `email`: required|email|max:255
- `password`: nullable|string|max:255 (not stored anyway)
- `department`: nullable|string|max:255
- `timestamp`: required|date
- `campaign_type`: nullable|string|max:50
- `template_name`: nullable|string|max:255

#### Response (200 OK)
```json
{
    "message": "Submission tracked successfully",
    "success": true,
    "note": "No real credentials were stored",
    "data": {
        "tracking_id": "track_123456789",
        "timestamp": "2025-09-06T14:30:00.000Z",
        "campaign_id": 1,
        "target_email": "employee@company.com"
    }
}
```

---

### Show Fake Phishing Page
**Endpoint**: `GET /api/fake-phishing-page`  
**Rate Limit**: 30 requests/minute per IP  
**Authentication**: None required

#### Description
Shows a generic fake phishing page for demonstration purposes.

#### Response (200 OK)
Returns a simple HTML page with a basic phishing simulation form.

---

## ❌ Error Handling

### Standard Error Response Format
All API errors follow a consistent format:

```json
{
    "message": "Error description",
    "errors": {
        "field_name": [
            "Specific error message"
        ]
    }
}
```

### HTTP Status Codes

#### 200 OK
Successful request with data returned.

#### 201 Created
Resource created successfully.

#### 400 Bad Request
Invalid request data or parameters.

#### 401 Unauthorized
Authentication required or invalid token.

#### 403 Forbidden
Insufficient permissions to access resource.

#### 404 Not Found
Resource not found.

#### 422 Unprocessable Entity
Validation errors in request data.

#### 429 Too Many Requests
Rate limit exceeded.

#### 500 Internal Server Error
Unexpected server error.

### Common Error Examples

#### Validation Error (422)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required.",
            "The email must be a valid email address."
        ],
        "password": [
            "The password field is required.",
            "The password must be at least 8 characters."
        ]
    }
}
```

#### Unauthorized (401)
```json
{
    "message": "Unauthenticated."
}
```

#### Forbidden (403)
```json
{
    "message": "This action is unauthorized."
}
```

#### Not Found (404)
```json
{
    "message": "Campaign not found."
}
```

#### Rate Limited (429)
```json
{
    "message": "Too Many Attempts."
}
```

---

## 🚦 Rate Limiting

### Rate Limit Configuration

| Endpoint Category | Rate Limit | Scope |
|------------------|------------|-------|
| Authentication | 5 requests/minute | Per IP |
| Email Tracking | 60 requests/minute | Per IP |
| Campaign Pages | 30 requests/minute | Per IP |
| API Endpoints | 100 requests/minute | Per User/IP |

### Rate Limit Headers
When rate limits are applied, the following headers are included in responses:

```
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1630929600
```

### Rate Limit Exceeded Response
```json
{
    "message": "Too Many Attempts."
}
```

---

## 🔒 Security

### Authentication
- **Laravel Sanctum**: Bearer token authentication
- **Token Expiration**: Configurable token lifetime
- **Token Refresh**: Automatic token refresh capability

### Authorization
- **Laravel Policies**: Company-based access control
- **Resource Isolation**: Companies can only access their own data
- **Permission Checks**: Granular permissions for different operations

### Input Validation
- **Form Requests**: Comprehensive validation for all endpoints
- **Sanitization**: All inputs are sanitized and validated
- **Type Safety**: Strong typing for all parameters

### Credential Protection
- **No Storage**: Real credentials are never stored
- **Redaction**: Passwords are redacted in logs and responses
- **Clear Warnings**: All phishing pages display simulation warnings

### Rate Limiting
- **IP-based**: Protection against brute force attacks
- **User-based**: Per-user rate limiting for authenticated endpoints
- **Endpoint-specific**: Different limits for different endpoint types

### CORS Configuration
```php
// Configured in config/cors.php
'allowed_origins' => ['*'], // Configure for production
'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
```

---

## 🚀 Getting Started Guide

### 1. Register a Company
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "My Company",
    "email": "admin@mycompany.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### 2. Login and Get Token
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@mycompany.com",
    "password": "password123"
  }'
```

### 3. Create a Campaign
```bash
curl -X POST http://localhost:8000/api/campaign/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "type": "phishing",
    "start_date": "2025-09-06",
    "end_date": "2025-09-13"
  }'
```

### 4. Add Targets
```bash
curl -X POST http://localhost:8000/api/campaign/add-targets \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "campaign_id": 1,
    "targets": [
      {
        "name": "John Doe",
        "email": "john@mycompany.com"
      }
    ]
  }'
```

### 5. Send Emails
```bash
curl -X POST http://localhost:8000/api/campaign/1/send-emails \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 6. View Results
```bash
curl -X GET http://localhost:8000/api/campaign/1/ai-analysis \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📚 Additional Resources

### Swagger UI
- **URL**: http://localhost:8000/api/documentation
- **Features**: Interactive API testing, request/response examples, authentication testing

### Postman Collection
Import the following collection for easy API testing:
```json
{
  "info": {
    "name": "Phishing Simulation Platform API",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "variable": [
    {
      "key": "baseUrl",
      "value": "http://localhost:8000/api"
    },
    {
      "key": "token",
      "value": "YOUR_BEARER_TOKEN"
    }
  ]
}
```

### SDK Examples
```javascript
// JavaScript SDK Example
const api = new PhishingSimulationAPI({
  baseUrl: 'http://localhost:8000/api',
  token: 'YOUR_BEARER_TOKEN'
});

// Create campaign
const campaign = await api.campaigns.create({
  type: 'phishing',
  start_date: '2025-09-06',
  end_date: '2025-09-13'
});

// Get AI analysis
const analysis = await api.campaigns.getAnalysis(campaign.id);
```

---

## 🔧 Development & Testing

### Local Development
```bash
# Start development server
php artisan serve

# Generate Swagger documentation
php artisan l5-swagger:generate

# Run tests
php artisan test

# Seed test data
php artisan db:seed
```

### Environment Variables
```env
# .env configuration
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
MAIL_MAILER=log
L5_SWAGGER_GENERATE_ALWAYS=true
```

### Testing Endpoints
```bash
# Test authentication
php artisan test:auth

# Test campaign creation
php artisan test:campaign

# Test AI analysis
php artisan test:ai-analysis
```

---

## 📞 Support

### API Support
- **Email**: support@phishingsim.com
- **Documentation**: http://localhost:8000/api/documentation
- **Status Page**: https://status.phishingsim.com

### Development Support
- **GitHub**: https://github.com/your-org/phishing-simulation-platform
- **Issues**: https://github.com/your-org/phishing-simulation-platform/issues
- **Discussions**: https://github.com/your-org/phishing-simulation-platform/discussions

---

**Last Updated**: September 6, 2025  
**API Version**: 1.0.0  
**Documentation Version**: 1.0.0
