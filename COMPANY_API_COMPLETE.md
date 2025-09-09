# Complete Company API Documentation

## 🚀 All Company API Endpoints Added

The Phishing Simulation Platform now has **7 comprehensive Company API endpoints** with complete Swagger documentation.

**Swagger UI**: http://localhost:8000/api/documentation

---

## 📋 Complete Company API List

### ✅ **1. Company Dashboard**
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
            }
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
            }
        ]
    }
}
```

---

### ✅ **2. List All Companies**
**Endpoint**: `GET /api/companies`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required (Admin only)

#### Query Parameters
- `page` (optional): Page number for pagination (default: 1)
- `per_page` (optional): Number of companies per page (default: 15)
- `search` (optional): Search companies by name or email

#### Response (200 OK)
```json
{
    "message": "Companies retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Acme Corporation",
            "email": "admin@acme.com",
            "plan_id": 1,
            "plan": {
                "id": 1,
                "name": "Free",
                "price": 0.00,
                "employee_limit": 10
            },
            "created_at": "2025-09-06T10:00:00.000000Z",
            "updated_at": "2025-09-06T10:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 15,
        "total": 75
    }
}
```

---

### ✅ **3. Create New Company**
**Endpoint**: `POST /api/companies`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required (Admin only)

#### Request Body
```json
{
    "name": "New Corporation",
    "email": "admin@newcorp.com",
    "password": "password123",
    "password_confirmation": "password123",
    "plan_id": 1
}
```

#### Response (201 Created)
```json
{
    "message": "Company created successfully",
    "data": {
        "id": 2,
        "name": "New Corporation",
        "email": "admin@newcorp.com",
        "plan_id": 1,
        "plan": {
            "id": 1,
            "name": "Free",
            "price": 0.00,
            "employee_limit": 10
        },
        "created_at": "2025-09-06T10:00:00.000000Z",
        "updated_at": "2025-09-06T10:00:00.000000Z"
    }
}
```

#### Error Responses
- **422 Validation Error**: Invalid input data
- **403 Forbidden**: Admin access required

---

### ✅ **4. Get Company Details**
**Endpoint**: `GET /api/companies/{id}`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Company details retrieved successfully",
    "data": {
        "id": 1,
        "name": "Acme Corporation",
        "email": "admin@acme.com",
        "plan_id": 1,
        "plan": {
            "id": 1,
            "name": "Free",
            "price": 0.00,
            "employee_limit": 10
        },
        "statistics": {
            "campaigns_count": 5,
            "users_count": 25,
            "payments_count": 3,
            "total_spent": 150.00
        },
        "created_at": "2025-09-06T10:00:00.000000Z",
        "updated_at": "2025-09-06T10:00:00.000000Z"
    }
}
```

#### Error Responses
- **404 Not Found**: Company not found
- **403 Forbidden**: Access denied

---

### ✅ **5. Update Company Information**
**Endpoint**: `PUT /api/companies/{id}`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Request Body
```json
{
    "name": "Updated Corporation Name",
    "email": "newadmin@company.com",
    "plan_id": 2
}
```

#### Response (200 OK)
```json
{
    "message": "Company updated successfully",
    "data": {
        "id": 1,
        "name": "Updated Corporation Name",
        "email": "newadmin@company.com",
        "plan_id": 2,
        "plan": {
            "id": 2,
            "name": "Basic",
            "price": 10.00,
            "employee_limit": 50
        },
        "updated_at": "2025-09-06T10:00:00.000000Z"
    }
}
```

#### Error Responses
- **404 Not Found**: Company not found
- **422 Validation Error**: Invalid input data
- **403 Forbidden**: Access denied

---

### ✅ **6. Delete Company**
**Endpoint**: `DELETE /api/companies/{id}`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required (Admin only)

#### Response (200 OK)
```json
{
    "message": "Company deleted successfully",
    "data": {
        "deleted_company_id": 1,
        "deleted_at": "2025-09-06T10:00:00.000000Z",
        "cascade_deleted": {
            "campaigns": 5,
            "users": 25,
            "payments": 3,
            "interactions": 150
        }
    }
}
```

#### Error Responses
- **404 Not Found**: Company not found
- **403 Forbidden**: Admin access required

---

### ✅ **7. Get Company Statistics**
**Endpoint**: `GET /api/companies/{id}/statistics`  
**Rate Limit**: 100 requests/minute per user  
**Authentication**: Bearer Token required

#### Response (200 OK)
```json
{
    "message": "Company statistics retrieved successfully",
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
            "most_vulnerable_employees": [],
            "most_secure_employees": []
        }
    }
}
```

#### Error Responses
- **404 Not Found**: Company not found
- **403 Forbidden**: Access denied

---

## 🔧 **Technical Implementation**

### **Route Configuration**
```php
// routes/api.php
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // Company Dashboard
    Route::get('/company/dashboard', [DashboardController::class, 'dashboard']);
    
    // Company Routes
    Route::prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'index']);
        Route::post('/', [CompanyController::class, 'store']);
        Route::get('/{company}', [CompanyController::class, 'show']);
        Route::put('/{company}', [CompanyController::class, 'update']);
        Route::delete('/{company}', [CompanyController::class, 'destroy']);
        Route::get('/{company}/statistics', [CompanyController::class, 'statistics']);
    });
});
```

### **Rate Limiting**
- **All Company Endpoints**: 100 requests/minute per user
- **Authentication Required**: Bearer token for all endpoints
- **Admin Endpoints**: List, Create, Delete (admin access required)

### **Security Features**
- **Laravel Sanctum**: Bearer token authentication
- **Company Policies**: Access control for company data
- **Input Validation**: Comprehensive validation for all inputs
- **Cascade Deletion**: Safe deletion with related data cleanup

---

## 🎯 **Swagger Documentation Features**

### **Complete Coverage**
- ✅ **All 7 endpoints** fully documented
- ✅ **Request/Response examples** with realistic data
- ✅ **Error responses** comprehensively documented
- ✅ **Authentication requirements** clearly specified
- ✅ **Rate limiting** information included

### **Interactive Testing**
- ✅ **Try It Out**: Test all endpoints directly from Swagger UI
- ✅ **Authentication**: Bearer token authentication integrated
- ✅ **Request Builder**: Easy request construction
- ✅ **Response Viewer**: Formatted response display

### **Professional Quality**
- ✅ **OpenAPI 3.0**: Latest specification compliance
- ✅ **Consistent Formatting**: Professional documentation style
- ✅ **Complete Schemas**: Full request/response documentation
- ✅ **Error Handling**: Comprehensive error response coverage

---

## 🚀 **Usage Examples**

### **Complete Company Management Flow**

#### **1. Get Company Dashboard**
```bash
curl -X GET http://localhost:8000/api/company/dashboard \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### **2. List All Companies (Admin)**
```bash
curl -X GET "http://localhost:8000/api/companies?page=1&per_page=15&search=Acme" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### **3. Create New Company (Admin)**
```bash
curl -X POST http://localhost:8000/api/companies \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "name": "New Corporation",
    "email": "admin@newcorp.com",
    "password": "password123",
    "password_confirmation": "password123",
    "plan_id": 1
  }'
```

#### **4. Get Company Details**
```bash
curl -X GET http://localhost:8000/api/companies/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### **5. Update Company Information**
```bash
curl -X PUT http://localhost:8000/api/companies/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "name": "Updated Corporation Name",
    "email": "newadmin@company.com",
    "plan_id": 2
  }'
```

#### **6. Get Company Statistics**
```bash
curl -X GET http://localhost:8000/api/companies/1/statistics \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### **7. Delete Company (Admin)**
```bash
curl -X DELETE http://localhost:8000/api/companies/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🔒 **Security Implementation**

### **Authentication Security**
- **Bearer Token**: Laravel Sanctum integration
- **Company Isolation**: Companies can only access their own data
- **Admin Access**: Special permissions for admin operations
- **Token Validation**: All protected endpoints validate tokens

### **Authorization Security**
- **Laravel Policies**: Company-based access control
- **Resource Isolation**: Companies can only access their own data
- **Permission Checks**: Granular permissions for different operations
- **Admin Verification**: Admin-only endpoints properly protected

### **Data Protection**
- **Input Validation**: All inputs sanitized and validated
- **Password Security**: Secure password handling
- **Cascade Deletion**: Safe deletion with data cleanup
- **Error Handling**: Secure error messages without information leakage

---

## 📊 **API Endpoint Summary**

| Endpoint | Method | Auth Required | Admin Required | Rate Limit | Description |
|----------|--------|---------------|----------------|------------|-------------|
| `/api/company/dashboard` | GET | Yes | No | 100/min User | Get company dashboard |
| `/api/companies` | GET | Yes | Yes | 100/min User | List all companies |
| `/api/companies` | POST | Yes | Yes | 100/min User | Create new company |
| `/api/companies/{id}` | GET | Yes | No | 100/min User | Get company details |
| `/api/companies/{id}` | PUT | Yes | No | 100/min User | Update company |
| `/api/companies/{id}` | DELETE | Yes | Yes | 100/min User | Delete company |
| `/api/companies/{id}/statistics` | GET | Yes | No | 100/min User | Get company statistics |

**Total**: 7 company endpoints

---

## 🎉 **Ready for Production**

The Company API is now:
- ✅ **Fully Functional**: All 7 endpoints working and tested
- ✅ **Comprehensively Documented**: Complete Swagger documentation
- ✅ **Security Hardened**: Enterprise-grade security implementation
- ✅ **Rate Limited**: Protection against abuse
- ✅ **Interactive**: Real-time testing capability
- ✅ **Production-Ready**: Professional implementation standards

---

## 🚀 **Access Your Documentation**

**Swagger UI**: http://localhost:8000/api/documentation

1. **Open the documentation** in your browser
2. **Click "Authorize"** and enter your Bearer token
3. **Test any endpoint** using the "Try it out" buttons
4. **View real-time responses** from your API

---

**Last Updated**: September 6, 2025  
**Total Company Endpoints**: 7  
**Documentation Status**: ✅ Complete and Live  
**Security Status**: ✅ Production-Ready

The Phishing Simulation Platform now has a complete, secure, and professionally documented company management system that provides everything needed for company administration, profile management, and comprehensive analytics!
