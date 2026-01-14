# Contributing to Books API

First off, thank you for considering contributing to this project! 

## This is a Technical Interview Project

Please note that this project was created as a technical interview exercise to demonstrate:
- Clean code practices
- Hexagonal Architecture
- Domain-Driven Design
- Test-Driven Development
- Professional documentation

While contributions are welcome for learning purposes, this is primarily a showcase project.

## How to Contribute

### Reporting Bugs

If you find a bug:

1. Check if it's already reported in [Issues](https://github.com/kbaytan99-testings/O2O-TEST/issues)
2. If not, create a new issue with:
   - Clear title and description
   - Steps to reproduce
   - Expected vs actual behavior
   - Your environment (PHP version, OS, etc.)
   - Code samples or error messages

### Suggesting Enhancements

Enhancement suggestions are welcome! Please:

1. Check existing issues to avoid duplicates
2. Clearly describe the enhancement
3. Explain why it would be useful
4. Provide examples if possible

### Pull Requests

If you want to contribute code:

1. **Fork the repository**
   ```bash
   git clone https://github.com/kbaytan99-testings/O2O-TEST.git
   cd O2O-TEST
   ```

2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make your changes**
   - Follow the existing code style (PSR-2)
   - Add tests for new features
   - Update documentation if needed

4. **Run quality checks**
   ```bash
   composer lint          # PSR-2 compliance
   composer test          # All tests
   composer analyse       # Static analysis
   ```

5. **Commit your changes**
   ```bash
   git commit -m "feat: add new feature"
   ```
   
   Use semantic commit messages:
   - `feat:` - New feature
   - `fix:` - Bug fix
   - `docs:` - Documentation
   - `test:` - Tests
   - `refactor:` - Code refactoring
   - `perf:` - Performance improvement
   - `chore:` - Maintenance

6. **Push and create PR**
   ```bash
   git push origin feature/your-feature-name
   ```

## Development Guidelines

### Code Style

- Follow **PSR-2** coding standard
- Use **strict types**: `declare(strict_types=1);`
- Add **type hints** for parameters and return values
- Write **descriptive variable names**
- Keep methods **small and focused**

### Architecture

- Respect **Hexagonal Architecture** layers
- Follow **DDD principles**
- Maintain **separation of concerns**
- Use **dependency injection**
- Keep **domain logic pure** (no framework dependencies)

### Testing

- Write **unit tests** for business logic
- Mock **external dependencies**
- Add **functional tests** for API endpoints
- Aim for **high coverage** of use cases
- Tests should be **fast and isolated**

### Documentation

- Update **README.md** for major changes
- Add **docblocks** to classes and methods
- Update **CHANGELOG.md** following [Keep a Changelog](https://keepachangelog.com/)
- Include **examples** for new features

## Project Structure

```
src/
├── Domain/          # Business logic, entities, interfaces
├── Application/     # Use cases, DTOs
├── Infrastructure/  # External integrations, implementations
└── UI/             # Controllers, presentation layer
```

**Important Rules:**
- Domain never depends on Infrastructure or UI
- Application depends only on Domain
- Infrastructure implements Domain interfaces
- UI depends on Application

## Testing Your Changes

Before submitting:

```bash
# Install dependencies
composer install

# Run all quality checks
composer check

# Run specific tests
composer test:unit        # Unit tests only
composer test:behat       # Functional tests
composer test:coverage    # Generate coverage report

# Check code style
composer lint

# Run static analysis
composer analyse

# Test with Docker
composer docker:up
# Test the API manually
composer docker:down
```

## Questions?

Feel free to:
- Open an issue for discussion
- Check existing documentation in the repository
- Review the [ARCHITECTURE.md](ARCHITECTURE.md) for design decisions

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

**Thank you for your interest in improving this project!** 🚀
