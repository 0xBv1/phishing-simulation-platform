# Complete Authentication API Documentation

## 🚀 All Authentication Endpoints Added

The Phishing Simulation Platform now has **6 comprehensive authentication endpoints** with complete Swagger documentation.

**Swagger UI**: http://localhost:8000/api/documentation

---

## 📋 Complete Authentication API List

### ✅ **1. Company Registration**
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
            "plan_id": 1
        },
        "token": "1|abc123def456ghi789jkl012mno345pqr678stu901vwx234yz"
    }
}
```

#### Error Responses
- **422 Validation Error**: Invalid input data
- **500 Server Error**: No default plan available

---

### ✅ **2. Company Login**
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
            "plan_id": 1
        },
        "token": "1|abc123def456ghi789jkl012mno345pqr678stu901vwx234yz"
    }
}
```

#### Error Responses
- **401 Unauthorized**: Invalid credentials
- **422 Validation Error**: Missing required fields

---

### ✅ **3. Company Logout**
**Endpoint**: `POST /api/auth/logout`  
**Rate Limit**: 5 requests/minute per IP  
**Authentication**: Bearer Token required

#### Headers
```
Authorization: Bearer {token}
```

#### Response (200 OK)
```json
{
    "message": "Logout successful"
}
```

#### Error Responses
- **401 Unauthorized**: Invalid or missing token

---

### ✅ **4. Token Refresh**
**Endpoint**: `POST /api/auth/refresh`  
**Rate Limit**: 5 requests/minute per IP  
**Authentication**: Bearer Token required

#### Headers
```
Authorization: Bearer {token}
```

#### Response (200 OK)
```json
{
    "message": "Token refreshed successfully",
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
        "token": "2|new123token456def789ghi012jkl345mno678pqr901stu234"
    }
}
```

#### Error Responses
- **401 Unauthorized**: Invalid or missing token

---

### ✅ **5. Get Company Profile**
**Endpoint**: `GET /api/auth/me`  
**Rate Limit**: 5 requests/minute per IP  
**Authentication**: Bearer Token required

#### Headers
```
Authorization: Bearer {token}
```

#### Response (200 OK)
```json
{
    "message": "Company profile retrieved successfully",
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
        "created_at": "2025-09-06T10:00:00.000000Z",
        "updated_at": "2025-09-06T10:00:00.000000Z"
    }
}
```

#### Error Responses
- **401 Unauthorized**: Invalid or missing token

---

### ✅ **6. Change Password**
**Endpoint**: `POST /api/auth/change-password`  
**Rate Limit**: 5 requests/minute per IP  
**Authentication**: Bearer Token required

#### Headers
```
Authorization: Bearer {token}
```

#### Request Body
```json
{
    "current_password": "oldpassword123",
    "new_password": "newpassword123",
    "new_password_confirmation": "newpassword123"
}
```

#### Response (200 OK)
```json
{
    "message": "Password changed successfully"
}
```

#### Error Responses
- **401 Unauthorized**: Invalid current password
- **422 Validation Error**: Password validation failed

---

## 🔧 **Technical Implementation**

### **Route Configuration**
```php
// routes/api.php
Route::prefix('auth')->middleware('throttle:auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    Route::post('change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
});
```

### **Rate Limiting**
- **Authentication Endpoints**: 5 requests/minute per IP
- **Protected Endpoints**: Require Bearer token authentication
- **Public Endpoints**: Register and login only

### **Security Features**
- **Laravel Sanctum**: Bearer token authentication
- **Password Hashing**: Secure password storage with bcrypt
- **Input Validation**: Comprehensive validation for all inputs
- **Token Management**: Secure token creation and revocation

---

## 🎯 **Swagger Documentation Features**

### **Complete Coverage**
- ✅ **All 6 endpoints** fully documented
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

### **Complete Authentication Flow**

#### **1. Register a New Company**
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

#### **2. Login and Get Token**
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@mycompany.com",
    "password": "password123"
  }'
```

#### **3. Get Company Profile**
```bash
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### **4. Change Password**
```bash
curl -X POST http://localhost:8000/api/auth/change-password \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "current_password": "password123",
    "new_password": "newpassword123",
    "new_password_confirmation": "newpassword123"
  }'
```

#### **5. Refresh Token**
```bash
curl -X POST http://localhost:8000/api/auth/refresh \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### **6. Logout**
```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🔒 **Security Implementation**

### **Authentication Security**
- **Bearer Token**: Laravel Sanctum integration
- **Token Expiration**: Configurable token lifetime
- **Token Refresh**: Secure token refresh mechanism
- **Password Security**: Bcrypt hashing with salt

### **Authorization Security**
- **Company Isolation**: Companies can only access their own data
- **Token Validation**: All protected endpoints validate tokens
- **Rate Limiting**: Protection against brute force attacks
- **Input Validation**: Comprehensive validation for all inputs

### **Data Protection**
- **Password Hashing**: Passwords never stored in plain text
- **Token Security**: Secure token generation and storage
- **Input Sanitization**: All inputs sanitized and validated
- **Error Handling**: Secure error messages without information leakage

---

## 📊 **API Endpoint Summary**

| Endpoint | Method | Auth Required | Rate Limit | Description |
|----------|--------|---------------|------------|-------------|
| `/api/auth/register` | POST | No | 5/min IP | Register new company |
| `/api/auth/login` | POST | No | 5/min IP | Login company |
| `/api/auth/logout` | POST | Yes | 5/min IP | Logout company |
| `/api/auth/refresh` | POST | Yes | 5/min IP | Refresh access token |
| `/api/auth/me` | GET | Yes | 5/min IP | Get company profile |
| `/api/auth/change-password` | POST | Yes | 5/min IP | Change password |

**Total**: 6 authentication endpoints

---

## 🎉 **Ready for Production**

The Authentication API is now:
- ✅ **Fully Functional**: All 6 endpoints working and tested
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
**Total Auth Endpoints**: 6  
**Documentation Status**: ✅ Complete and Live  
**Security Status**: ✅ Production-Ready

The Phishing Simulation Platform now has a complete, secure, and professionally documented authentication system that provides everything needed for company registration, login, profile management, and security operations!
