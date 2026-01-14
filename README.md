<div align="center">
  <img src=".github/social-preview.png" alt="O2O-TEST" width="600">
  
  # Books API - Symfony with Hexagonal Architecture

  [![CI/CD](https://img.shields.io/badge/CI%2FCD-GitHub%20Actions-2088FF?logo=github-actions&logoColor=white)](/.github/workflows/ci.yml)
  [![PHP](https://img.shields.io/badge/PHP-8.0-777BB4?logo=php&logoColor=white)](https://www.php.net/)
  [![Symfony](https://img.shields.io/badge/Symfony-5.4-000000?logo=symfony&logoColor=white)](https://symfony.com/)
  [![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)](Dockerfile)
  [![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)
  [![Architecture](https://img.shields.io/badge/Architecture-Hexagonal-green)](ARCHITECTURE.md)
  [![PSR-2](https://img.shields.io/badge/Code%20Style-PSR--2-blue)](phpcs.xml)

  REST API for searching and querying books using the [Gutendex](https://gutendex.com/) API.
</div>

## 📋 Description

This project implements a REST API that allows:
- **Search books** by a query string
- **Get details of a specific book** by its ID
- **Web Client** with modern Bootstrap UI
- **Docker support** for easy deployment

Data is obtained from the Gutendex API (Project Gutenberg).

## 🏗️ Architecture

The project is built following the principles of **Hexagonal Architecture (Ports and Adapters)** and **Domain-Driven Design (DDD)**:

```
src/
├── Domain/              # Domain Layer
│   ├── Entity/          # Domain entities
│   ├── Repository/      # Repository interfaces
│   └── Exception/       # Domain exceptions
├── Application/         # Application Layer
│   ├── UseCase/         # Use cases
│   └── DTO/             # Data Transfer Objects
├── Infrastructure/      # Infrastructure Layer
│   ├── Client/          # HTTP Client for Gutendex
│   └── Repository/      # Repository implementations
└── UI/                  # Capa de Presentación
    └── Controller/      # Controladores REST
```

### Layers

1. **Domain**: Contains pure business logic, entities and contracts (interfaces)
2. **Application**: Use cases that orchestrate domain logic
3. **Infrastructure**: Concrete implementations (HTTP client, repositories)
4. **UI (User Interface)**: Controllers that expose the REST API

## 🚀 Requirements

- PHP >= 8.0
- Composer
- Symfony 5.4

**Or use Docker** (no PHP/Composer installation needed):
- Docker
- Docker Compose

## 📦 Installation

### Option 1: Docker (Recommended)

1. Clone the repository:
```bash
git clone <repository-url>
cd "O2O prueba"
```

2. Start with Docker:
```bash
docker-compose up -d
```

3. Access the API:
- API: http://localhost:8000/api/books
- Web Client: http://localhost:8000/client.html

### Option 2: Local PHP

1. Clone the repository:
```bash
git clone <repository-url>
cd "O2O prueba"
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment variables:
```bash
cp .env .env.local
```

Edit `.env.local` if necessary (default configuration works correctly).

## 🔌 API Endpoints

### 1. Search books

**Endpoint**: `GET /api/books?search={query}`

**Parameters**:
- `search` (string, required): Search query

**Example**:
```bash
GET /api/books?search=shakespeare
```

**Respuesta exitosa (200)**:
```json
[
  {
    "id": 1513,
    "title": "Romeo and Juliet",
    "subjects": ["Drama", "Tragedy"],
    "authors": [
      {
        "name": "Shakespeare, William",
        "birth_year": 1564,
        "death_year": 1616
      }
    ]
  }
]
```

### 2. Get book by ID

**Endpoint**: `GET /api/books/{id}`

**Parameters**:
- `id` (integer, required): Book ID (Project Gutenberg ID)

**Example**:
```bash
GET /api/books/1342
```

**Respuesta exitosa (200)**:
```json
{
  "id": 1342,
  "title": "Pride and Prejudice",
  "subjects": ["England -- Fiction", "Romance"],
  "authors": [
    {
      "name": "Austen, Jane",
      "birth_year": 1775,
      "death_year": 1817
    }
  ]
}
```

**Error response (404)**:
```json
{
  "error": "Book with ID 999 not found"
}
```

## 🌐 Web Client

The project includes a modern web interface built with Bootstrap 5:

**Access**: http://localhost:8000/client.html

**Features**:
- 🎨 Modern gradient design with animations
- 🔍 Live search with quick search buttons
- 📚 Interactive book cards with hover effects
- 👁️ Modal for detailed book view
- 📱 Fully responsive (mobile-friendly)
- ⚡ Real-time API integration

**Screenshot**:
Search for books by title, author, or subject. Click on any book to see full details including authors, birth/death years, and all subjects.

## 🧪 Tests

### Unit Tests

The project includes comprehensive unit tests with **mocks** to avoid hitting the external API:

```bash
php vendor/bin/phpunit
```

Included tests:
- ✅ Domain entities (Book, Person)
- ✅ Use cases (SearchBooksUseCase, GetBookByIdUseCase)
- ✅ HTTP client with mocks
- ✅ Repositories

### Functional Tests (Behat)

End-to-end behavior tests:

```bash
php vendor/bin/behat
```

Scenarios:
- ✅ Search books by query
- ✅ Get book by ID
- ✅ Parameter validation
- ✅ Error handling

## 📝 Code Standards

The project complies with **PSR-2** (PHP Standards Recommendations).

To verify compliance:
```bash
php vendor/bin/phpcs
```

To auto-fix:
```bash
php vendor/bin/phpcbf
```

## 💾 Cache

The application implements **request caching** to Gutendex to improve performance:

- **Default adapter**: FileSystem
- **TTL**: 3600 seconds (1 hour)
- **Location**: `var/cache/`

### Redis Configuration (Optional)

To use Redis instead of FileSystem, edit `.env.local`:

```env
CACHE_ADAPTER=cache.adapter.redis
REDIS_URL=redis://localhost:6379
```

## 📚 API Documentation (OpenAPI)

The API is documented using **OpenAPI** with NelmioAPIDocBundle.

Access the documentation at:
```
http://localhost:8000/api/doc
```

## 🏃 Run the Server

### Option 1: Docker (Recommended)
```bash
# Start
docker-compose up -d

# Stop
docker-compose down

# View logs
docker logs books-api

# Restart
docker-compose restart
```

### Option 2: Symfony development server
```bash
symfony server:start
```

### Option 3: PHP built-in server
```bash
php -S localhost:8000 -t public
```

The API will be available at: `http://localhost:8000/api`

The Web Client will be available at: `http://localhost:8000/client.html`

## 📂 Project Structure

```
.
├── config/                 # Symfony configuration
│   ├── packages/          # Bundle configuration
│   ├── routes.yaml        # Routes
│   └── services.yaml      # Service definitions
├── features/              # Behat functional tests
├── public/                # Public entry point
│   ├── index.php          # API entry point
│   └── client.html        # Web Client UI
├── src/
│   ├── Domain/            # Domain Layer
│   ├── Application/       # Application Layer
│   ├── Infrastructure/    # Infrastructure Layer
│   ├── UI/                # Presentation Layer
│   └── Kernel.php         # Symfony Kernel
├── tests/                 # Unit tests
│   ├── Unit/              # Unit tests
│   └── Behat/             # Behat contexts
├── .env                   # Environment variables
├── behat.yml              # Behat configuration
├── composer.json          # Dependencies
├── phpcs.xml              # PSR-2 configuration
├── phpunit.xml.dist       # PHPUnit configuration
├── Dockerfile             # Docker image definition
└── docker-compose.yml     # Docker Compose configuration
```

## 🎯 Implemented Features

### Basic Requirements
- ✅ Symfony as Framework
- ✅ REST API with JSON format
- ✅ Specified fields: id, title, subjects, authors
- ✅ Hexagonal Architecture and DDD
- ✅ PSR-2 compliance
- ✅ Unit tests with mocks (no external API calls)

### Extra Features Implemented
- ✅ Cache with FileSystem/Redis
- ✅ OpenAPI documentation (NelmioAPIDocBundle)
- ✅ Functional tests with Behat
- ✅ **Modern Web Client with Bootstrap 5**
- ✅ **Docker support with docker-compose**
- ✅ **Fully responsive UI**
- ✅ **Interactive book search and details**

## 🔧 Technologies Used

- **Symfony 5.4 LTS**: PHP Framework
- **PHPUnit 9.5**: Unit testing
- **Behat 3.13**: Functional/BDD testing
- **Symfony HTTP Client**: HTTP client
- **Symfony Cache**: Caching system
- **NelmioAPIDocBundle**: OpenAPI documentation
- **Bootstrap 5**: Modern UI framework
- **Docker**: Containerization
- **PHP 8.0**: Programming language

## 👨‍💻 Development

### Adding New Features

1. **Domain**: Create entities and contracts in `src/Domain/`
2. **Application**: Implement use cases in `src/Application/UseCase/`
3. **Infrastructure**: Create adapters in `src/Infrastructure/`
4. **UI**: Expose endpoints in `src/UI/Controller/`
5. **Tests**: Add unit tests in `tests/Unit/`

### Followed Principles

- **Separation of concerns**: Each layer has a specific purpose
- **Dependency inversion**: Domain doesn't depend on infrastructure
- **Dependency injection**: All dependencies are injected
- **Testable**: Use of interfaces and mocks to facilitate testing

## 📄 License

This project is for private/proprietary use.

## 👤 Author

Developed as a technical interview exercise.

---

**Note**: This project uses the public Gutendex API (https://gutendex.com/), which provides free access to Project Gutenberg books.
