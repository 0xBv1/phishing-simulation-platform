# Security Implementation Guide

This document outlines the comprehensive security measures implemented in the Phishing Simulation Platform.

## 🔐 Authentication & Authorization

### Laravel Sanctum Integration
- **API Token Authentication**: All sensitive endpoints require Sanctum authentication
- **Company-based Authentication**: Companies authenticate with email/password
- **Token Management**: Secure token generation, validation, and refresh

### Laravel Policies
- **CampaignPolicy**: Ensures companies can only access their own campaigns
- **CompanyPolicy**: Ensures companies can only access their own data
- **Authorization Methods**:
  - `view()`: Check campaign ownership
  - `update()`: Verify company owns the resource
  - `delete()`: Confirm ownership before deletion
  - `sendEmails()`: Validate campaign ownership for email operations
  - `viewStats()`: Ensure access to campaign statistics
  - `viewAiAnalysis()`: Control AI analysis access
  - `addTargets()`: Verify campaign ownership for target management

### Route Protection
```php
// All sensitive routes protected with Sanctum middleware
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // Protected routes here
});
```

## 🚦 API Rate Limiting

### Custom Rate Limiters
- **Authentication Routes**: 5 requests per minute per IP
- **Tracking Routes**: 60 requests per minute per IP
- **Campaign Routes**: 30 requests per minute per IP
- **API Routes**: 100 requests per minute per user/IP

### Implementation
```php
// Rate limiting configuration in bootstrap/app.php
$middleware->throttleWithRedis('auth', function () {
    return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by(request()->ip());
});
```

## ✅ Input Validation

### Form Requests
All API endpoints use dedicated Form Request classes for validation:

#### Authentication
- **RegisterRequest**: Company registration validation
- **LoginRequest**: Login credential validation

#### Campaign Management
- **CreateCampaignRequest**: Campaign creation validation
- **AddTargetsRequest**: Target addition validation

#### Payment Processing
- **CheckoutRequest**: Payment initialization validation
- **ConfirmPaymentRequest**: Payment confirmation validation

#### Email Tracking
- **SubmitFormRequest**: Form submission validation (public endpoint)

### Validation Rules
```php
// Example: Email tracking form validation
public function rules(): array
{
    return [
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|max:255', // Not stored anyway
        'department' => 'nullable|string|max:255',
        'timestamp' => 'required|date',
        'campaign_type' => 'nullable|string|max:50',
        'template_name' => 'nullable|string|max:255',
    ];
}
```

## 🛡️ Credential Protection

### Phishing Simulation Security
- **No Real Storage**: Credentials are never stored in the database
- **Redaction**: Passwords are replaced with `[REDACTED - NOT STORED]`
- **Logging Only**: Only submission attempts are logged, not actual data
- **Clear Warnings**: All phishing pages display simulation warnings

### Implementation Details
```javascript
// Frontend credential redaction
const formData = {
    email: document.getElementById('email').value,
    password: '[REDACTED - NOT STORED]', // Never sent
    department: document.getElementById('department')?.value || '',
    timestamp: new Date().toISOString(),
    campaign_type: '{{ $campaign->type }}',
    template_name: '{{ $template->name }}'
};
```

### Database Security
- **No Credential Fields**: Database schema doesn't include password storage for phishing
- **Interaction Tracking**: Only tracks action types (opened, clicked, submitted)
- **Audit Trail**: Comprehensive logging without sensitive data

## 🔒 Data Isolation

### Company-based Access Control
- **Campaign Isolation**: Companies can only see their own campaigns
- **Target Isolation**: Campaign targets are scoped to company campaigns
- **Payment Isolation**: Payment history is company-specific
- **Report Isolation**: Analytics and reports are company-scoped

### Policy Implementation
```php
// Campaign ownership verification
public function view(Company $company, Campaign $campaign): bool
{
    return $company->id === $campaign->company_id;
}
```

## 🚨 Security Headers & CSRF Protection

### CSRF Protection
- **Token Validation**: All form submissions include CSRF tokens
- **Meta Tag**: CSRF token included in page headers
- **API Protection**: Sanctum handles CSRF for API routes

### Security Headers
- **Content Security Policy**: Prevents XSS attacks
- **X-Frame-Options**: Prevents clickjacking
- **X-Content-Type-Options**: Prevents MIME sniffing
- **Strict-Transport-Security**: Enforces HTTPS

## 📊 Monitoring & Logging

### Security Logging
- **Authentication Events**: Login attempts, token generation
- **Authorization Failures**: Access denied events
- **Rate Limiting**: Throttled requests logged
- **Phishing Interactions**: Submission attempts (without credentials)

### Log Examples
```php
// Phishing interaction logging (secure)
Log::info('Phishing form submission tracked', [
    'token' => $token,
    'campaign_id' => $tokenData['campaign_id'],
    'target_email' => $target->email,
    'target_name' => $target->name,
    'timestamp' => now(),
    'note' => 'No real credentials were stored'
]);
```

## 🔧 Security Best Practices

### Code Security
- **Input Sanitization**: All inputs validated and sanitized
- **SQL Injection Prevention**: Eloquent ORM with parameterized queries
- **XSS Prevention**: Output escaping in Blade templates
- **File Upload Security**: No file upload functionality (not needed)

### Environment Security
- **Environment Variables**: Sensitive data in .env file
- **Database Credentials**: Secure database connection
- **API Keys**: External service keys properly secured
- **Debug Mode**: Disabled in production

### Deployment Security
- **HTTPS Enforcement**: All communications encrypted
- **Database Encryption**: Sensitive data encrypted at rest
- **Backup Security**: Regular secure backups
- **Access Control**: Limited server access

## 🚀 Security Checklist

### Pre-deployment
- [ ] All routes protected with appropriate middleware
- [ ] Rate limiting configured and tested
- [ ] Form validation implemented for all endpoints
- [ ] Policies created and enforced
- [ ] Credential protection verified
- [ ] CSRF protection enabled
- [ ] Security headers configured
- [ ] Logging implemented
- [ ] Environment variables secured
- [ ] Database permissions configured

### Post-deployment
- [ ] Security monitoring enabled
- [ ] Regular security audits scheduled
- [ ] Backup and recovery tested
- [ ] Incident response plan in place
- [ ] Security training for team members
- [ ] Regular dependency updates
- [ ] Penetration testing scheduled

## 📞 Security Incident Response

### Immediate Actions
1. **Identify**: Determine scope and impact
2. **Contain**: Isolate affected systems
3. **Eradicate**: Remove threat vectors
4. **Recover**: Restore normal operations
5. **Learn**: Document lessons learned

### Contact Information
- **Security Team**: security@company.com
- **Emergency Contact**: +1-XXX-XXX-XXXX
- **Incident Response**: incident@company.com

---

**Note**: This security implementation follows industry best practices and should be regularly reviewed and updated to address emerging threats.
