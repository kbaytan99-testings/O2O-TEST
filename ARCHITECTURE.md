# Books API - Architecture & Design

## System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                         Client Layer                             │
│  ┌──────────────────┐              ┌─────────────────────────┐  │
│  │   Web Browser    │              │   API Client (curl)     │  │
│  │  (client.html)   │              │   Mobile App            │  │
│  └────────┬─────────┘              └───────────┬─────────────┘  │
│           │                                    │                │
│           └────────────────┬───────────────────┘                │
└────────────────────────────┼──────────────────────────────────────┘
                             │ HTTP/JSON
┌────────────────────────────┼──────────────────────────────────────┐
│                         UI Layer                                  │
│                            │                                      │
│         ┌──────────────────▼────────────────────┐                │
│         │     BookController (REST API)         │                │
│         │  - GET /api/books?search={query}      │                │
│         │  - GET /api/books/{id}                │                │
│         └──────────────────┬────────────────────┘                │
└────────────────────────────┼──────────────────────────────────────┘
                             │
┌────────────────────────────┼──────────────────────────────────────┐
│                    Application Layer                              │
│                            │                                      │
│  ┌─────────────────────────▼────────────────────────────────┐    │
│  │              Use Cases (Business Logic)                   │    │
│  │  ┌───────────────────────┐  ┌─────────────────────────┐  │    │
│  │  │ SearchBooksUseCase    │  │ GetBookByIdUseCase      │  │    │
│  │  │ - execute(query)      │  │ - execute(id)           │  │    │
│  │  └───────────────────────┘  └─────────────────────────┘  │    │
│  │                                                           │    │
│  │  ┌────────────────────────────────────────────────────┐  │    │
│  │  │           DTOs (Data Transfer Objects)             │  │    │
│  │  │  - BookDTO                                         │  │    │
│  │  │  - PersonDTO                                       │  │    │
│  │  └────────────────────────────────────────────────────┘  │    │
│  └───────────────────────────┬───────────────────────────────┘    │
└────────────────────────────────┼──────────────────────────────────┘
                                 │
┌────────────────────────────────┼──────────────────────────────────┐
│                       Domain Layer                                │
│                                │                                  │
│  ┌─────────────────────────────▼──────────────────────────────┐  │
│  │                    Repository Interface                     │  │
│  │         (Ports - Hexagonal Architecture)                    │  │
│  │  ┌──────────────────────────────────────────────────────┐   │  │
│  │  │      BookRepositoryInterface                         │   │  │
│  │  │  - searchBooks(query): Book[]                        │   │  │
│  │  │  - findById(id): Book|null                           │   │  │
│  │  └──────────────────────────────────────────────────────┘   │  │
│  └─────────────────────────────────────────────────────────────┘  │
│                                                                   │
│  ┌────────────────────────────────────────────────────────────┐  │
│  │              Domain Entities                               │  │
│  │  ┌──────────────┐              ┌──────────────────────┐    │  │
│  │  │    Book      │              │      Person          │    │  │
│  │  │ - id         │              │ - name               │    │  │
│  │  │ - title      │  contains    │ - birthYear          │    │  │
│  │  │ - subjects[] │─────────────▶│ - deathYear          │    │  │
│  │  │ - authors[]  │              └──────────────────────┘    │  │
│  │  └──────────────┘                                           │  │
│  └────────────────────────────────────────────────────────────┘  │
│                                                                   │
│  ┌────────────────────────────────────────────────────────────┐  │
│  │              Domain Exceptions                             │  │
│  │  - BookNotFoundException                                   │  │
│  └────────────────────────────────────────────────────────────┘  │
└───────────────────────────────────────────────────────────────────┘
                                 │
┌────────────────────────────────┼──────────────────────────────────┐
│                   Infrastructure Layer                            │
│                                │                                  │
│  ┌─────────────────────────────▼──────────────────────────────┐  │
│  │         Repository Implementation (Adapter)                │  │
│  │  ┌──────────────────────────────────────────────────────┐  │  │
│  │  │      GutendexBookRepository                          │  │  │
│  │  │  implements BookRepositoryInterface                  │  │  │
│  │  └─────────────────────┬────────────────────────────────┘  │  │
│  └────────────────────────┼───────────────────────────────────┘  │
│                           │                                      │
│  ┌────────────────────────▼───────────────────────────────────┐  │
│  │              HTTP Client (External API)                    │  │
│  │  ┌──────────────────────────────────────────────────────┐  │  │
│  │  │         GutendexClient                               │  │  │
│  │  │  - searchBooks(query): array                         │  │  │
│  │  │  - getBookById(id): array                            │  │  │
│  │  │                                                       │  │  │
│  │  │  ┌────────────────────────────────────────────────┐  │  │  │
│  │  │  │         Cache Layer (PSR-6)                    │  │  │  │
│  │  │  │  - FileSystem (default)                        │  │  │  │
│  │  │  │  - Redis (optional)                            │  │  │  │
│  │  │  │  - TTL: 3600s                                  │  │  │  │
│  │  │  └────────────────────────────────────────────────┘  │  │  │
│  │  └──────────────────────────────────────────────────────┘  │  │
│  └────────────────────────────────────────────────────────────┘  │
│                           │                                      │
│                           │ HTTPS                                │
│                           ▼                                      │
│              ┌──────────────────────────┐                        │
│              │   Gutendex API           │                        │
│              │ gutendex.com/books       │                        │
│              └──────────────────────────┘                        │
└───────────────────────────────────────────────────────────────────┘
```

## Hexagonal Architecture (Ports & Adapters)

### Core Principles

1. **Domain Independence**: Business logic doesn't depend on external systems
2. **Ports**: Interfaces (contracts) in the domain layer
3. **Adapters**: Implementations in the infrastructure layer
4. **Dependency Inversion**: Dependencies point inward toward the domain

### Flow Example: Search Books

```
1. HTTP Request → BookController (UI Layer)
   ↓
2. Controller → SearchBooksUseCase (Application Layer)
   ↓
3. UseCase → BookRepositoryInterface (Domain Port)
   ↓
4. Interface ← GutendexBookRepository (Infrastructure Adapter)
   ↓
5. Repository → GutendexClient (Infrastructure)
   ↓
6. Client → Cache Layer → External API
   ↓
7. Response bubbles back up through layers
   ↓
8. Controller → JSON Response
```

## Domain-Driven Design (DDD)

### Entities

**Book** - Aggregate Root
- Identity: ID (Gutendex ID)
- Value Objects: Title, Subjects
- Relationships: Authors (Person collection)

**Person** - Entity
- Identity: Name + Birth Year
- Value Objects: Birth Year, Death Year

### Repository Pattern

```php
interface BookRepositoryInterface {
    public function searchBooks(string $query): array;
    public function findById(int $id): ?Book;
}
```

- Abstracts data access
- Domain defines the contract
- Infrastructure provides implementation

### Use Cases

Encapsulate business operations:
- **SearchBooksUseCase**: Orchestrates book search
- **GetBookByIdUseCase**: Retrieves single book

## Data Flow

### Request Flow (Detailed)

```
Client Request
    │
    ├─▶ [Router] routes.yaml
    │       │
    │       └─▶ [Controller] BookController
    │               │
    │               ├─▶ Validate Request
    │               │
    │               └─▶ [Use Case] SearchBooksUseCase
    │                       │
    │                       ├─▶ [Repository] BookRepositoryInterface
    │                       │       │
    │                       │       └─▶ [Implementation] GutendexBookRepository
    │                       │               │
    │                       │               └─▶ [HTTP Client] GutendexClient
    │                       │                       │
    │                       │                       ├─▶ Check Cache
    │                       │                       │   │
    │                       │                       │   ├─▶ Hit: Return cached
    │                       │                       │   └─▶ Miss: ↓
    │                       │                       │
    │                       │                       └─▶ Call External API
    │                       │                           │
    │                       │                           └─▶ Store in Cache
    │                       │
    │                       └─▶ Map to Domain Entities
    │                           │
    │                           └─▶ Convert to DTOs
    │
    └─▶ JSON Response
```

## Caching Strategy

```
┌─────────────────────────────────────────────────┐
│            Cache Decorator Pattern              │
│                                                 │
│  GutendexClient                                 │
│    │                                            │
│    ├─▶ searchBooks(query)                      │
│    │       │                                    │
│    │       ├─▶ cacheKey = md5(query)           │
│    │       │                                    │
│    │       ├─▶ Check Cache                     │
│    │       │   ├─▶ Hit: return cached          │
│    │       │   └─▶ Miss:                       │
│    │       │         ├─▶ Call API              │
│    │       │         ├─▶ Store (TTL: 3600s)    │
│    │       │         └─▶ return data           │
│    │       │                                    │
│    └─▶ getBookById(id)                         │
│            └─▶ Similar flow                    │
│                                                 │
│  Cache Adapters:                                │
│    - FilesystemAdapter (default)                │
│    - RedisAdapter (production)                  │
└─────────────────────────────────────────────────┘
```

## Error Handling

```
Try/Catch at Multiple Levels:

1. Controller Level
   ├─▶ Catch BookNotFoundException → 404 Response
   └─▶ Catch Generic Exception → 500 Response

2. Use Case Level
   └─▶ Business logic validation

3. Repository Level
   └─▶ Data access errors

4. Client Level
   ├─▶ HTTP errors (timeouts, 404, etc.)
   └─▶ Network failures
```

## Dependency Injection

```yaml
# config/services.yaml

services:
    # Auto-wire by type
    _defaults:
        autowire: true
        autoconfigure: true

    # Controllers
    App\UI\Controller\:
        resource: '../src/UI/Controller'
        tags: ['controller.service_arguments']

    # Use Cases
    App\Application\UseCase\SearchBooksUseCase:
        arguments:
            $repository: '@App\Domain\Repository\BookRepositoryInterface'

    # Repository (bind interface to implementation)
    App\Domain\Repository\BookRepositoryInterface:
        class: App\Infrastructure\Repository\GutendexBookRepository

    # HTTP Client
    App\Infrastructure\Client\GutendexClient:
        arguments:
            $baseUrl: '%env(GUTENDEX_API_URL)%'
            $cacheTtl: 3600
```

## Design Patterns Used

1. **Hexagonal Architecture** - Overall structure
2. **Repository Pattern** - Data access abstraction
3. **Use Case Pattern** - Application logic encapsulation
4. **DTO Pattern** - Data transfer between layers
5. **Dependency Injection** - Loose coupling
6. **Adapter Pattern** - External API integration
7. **Decorator Pattern** - Caching layer
8. **Factory Pattern** - Entity creation
9. **Strategy Pattern** - Cache adapters (FileSystem/Redis)

## SOLID Principles

✅ **Single Responsibility**
- Each class has one reason to change
- Controllers handle HTTP, Use Cases handle logic

✅ **Open/Closed**
- Open for extension (new use cases, repositories)
- Closed for modification (interfaces stable)

✅ **Liskov Substitution**
- Any BookRepositoryInterface implementation works
- Cache adapters interchangeable

✅ **Interface Segregation**
- Small, focused interfaces
- BookRepositoryInterface has only needed methods

✅ **Dependency Inversion**
- High-level modules don't depend on low-level
- Both depend on abstractions (interfaces)

## Performance Considerations

1. **Caching**
   - API responses cached for 1 hour
   - Reduces external API calls by ~95%

2. **HTTP Client**
   - Symfony HTTP Client (async capable)
   - Connection pooling
   - Timeout configuration

3. **Optimized Autoloading**
   - Composer dump-autoload --optimize
   - Class map generation

4. **Docker**
   - Multi-stage builds (if needed)
   - Layer caching
   - Minimal base image

## Security

1. **Input Validation**
   - Search query sanitization
   - ID parameter type validation

2. **CORS** (if needed)
   - Configure allowed origins
   - Whitelist methods

3. **Rate Limiting** (future)
   - Prevent API abuse
   - Per-IP throttling

4. **Environment Variables**
   - Secrets in .env.local
   - Never commit credentials

## Testing Strategy

```
Testing Pyramid:

        ┌──────────┐
        │    E2E   │  ← Behat (few)
        │  (Behat) │
        ├──────────┤
        │Integration│  ← HTTP tests (some)
        ├──────────┤
        │   Unit    │  ← PHPUnit + Mocks (many)
        │ (PHPUnit) │
        └──────────┘

Unit Tests:
- Entities
- Use Cases (with mocked repositories)
- DTOs
- Controllers (with mocked use cases)

Functional Tests:
- Full API endpoints
- Request/Response validation
- Error scenarios
```

## Scalability

### Horizontal Scaling
- Stateless application
- Multiple Docker containers behind load balancer
- Shared Redis cache

### Vertical Scaling
- Increase container resources
- PHP-FPM with more workers
- Opcache enabled

### Database Future
- Add persistent layer
- User favorites, history
- PostgreSQL/MySQL

---

**This architecture ensures maintainability, testability, and scalability.** 🏗️
