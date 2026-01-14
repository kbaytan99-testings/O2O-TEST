# Security Policy

## Supported Versions

This is a demonstration project for a technical interview. Security updates are not actively maintained.

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |

## Reporting a Vulnerability

If you discover a security vulnerability in this project, please follow these steps:

1. **Do not** open a public issue
2. Send details to: [your-email@example.com]
3. Include:
   - Description of the vulnerability
   - Steps to reproduce
   - Potential impact
   - Suggested fix (if any)

### What to expect

- **Initial Response**: Within 48 hours
- **Status Update**: Within 7 days
- **Fix Timeline**: Depends on severity

## Security Best Practices Implemented

### ✅ Input Validation
- All user inputs validated
- Type checking on parameters
- Query string sanitization

### ✅ Error Handling
- No sensitive information in error messages
- Stack traces disabled in production
- Generic error responses to users

### ✅ Dependencies
- Regular updates via Composer
- Vulnerability scanning with GitHub Dependabot
- Locked versions in composer.lock

### ✅ Environment Variables
- Secrets stored in .env.local (gitignored)
- No hardcoded credentials
- Environment-based configuration

### ✅ HTTP Security
- HTTPS recommended for production
- CORS can be configured if needed
- Rate limiting recommended for production

## Known Limitations

This is a demonstration project with the following security considerations:

1. **No Authentication**: API is public (as per requirements)
2. **No Rate Limiting**: Should be added for production
3. **No CSRF Protection**: Not needed for stateless JSON API
4. **Development Server**: Use proper web server in production

## Production Security Checklist

Before deploying to production:

- [ ] Enable HTTPS
- [ ] Configure CORS properly
- [ ] Implement rate limiting
- [ ] Set up monitoring and logging
- [ ] Review and update dependencies
- [ ] Configure firewall rules
- [ ] Use environment-specific .env files
- [ ] Disable debug mode
- [ ] Set secure PHP settings (opcache, etc.)
- [ ] Implement API authentication if needed

## Security Resources

- [Symfony Security Best Practices](https://symfony.com/doc/current/security.html)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://www.php.net/manual/en/security.php)

---

**Disclaimer:** This project is for demonstration purposes. It has not undergone a professional security audit.
