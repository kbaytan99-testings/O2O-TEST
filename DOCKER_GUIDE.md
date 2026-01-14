# 🐳 Docker Guide

## Overview

This project includes complete Docker support for easy deployment without needing to install PHP or Composer locally.

## Quick Start

```bash
# Start the application
docker-compose up -d

# Access
- API: http://localhost:8000/api/books
- Web Client: http://localhost:8000/client.html
```

## Docker Files

### Dockerfile

Creates a PHP 8.0 image with:
- PHP 8.0 CLI
- Git, curl, zip, unzip
- Composer
- All project dependencies installed
- Optimized autoloader
- Writable cache directory

**Location**: `Dockerfile`

### docker-compose.yml

Defines the service:
- **Container name**: `books-api`
- **Port**: 8000 (host) → 8000 (container)
- **Volumes**: Current directory mounted to `/app`
- **Environment variables**: APP_ENV, GUTENDEX_API_URL
- **Restart policy**: unless-stopped

**Location**: `docker-compose.yml`

### .dockerignore

Excludes from Docker build:
- vendor/
- var/
- .git/
- .github/
- .env.local
- .env.*.local
- composer.phar
- phpunit.xml
- .phpunit.result.cache

**Location**: `.dockerignore`

## Commands

### Basic Operations

```bash
# Start container (detached mode)
docker-compose up -d

# Stop container
docker-compose down

# Restart container
docker-compose restart

# View logs
docker logs books-api

# Follow logs in real-time
docker logs -f books-api

# View container status
docker ps
```

### Development Operations

```bash
# Rebuild image after Dockerfile changes
docker-compose up -d --build

# Execute commands inside container
docker exec -it books-api bash

# Install new Composer package
docker exec -it books-api composer require package/name

# Run tests inside container
docker exec -it books-api php vendor/bin/phpunit

# Clear cache
docker exec -it books-api rm -rf var/cache/*
```

### Maintenance

```bash
# View container resource usage
docker stats books-api

# Inspect container configuration
docker inspect books-api

# View container IP address
docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' books-api

# Remove all stopped containers
docker container prune

# Remove unused images
docker image prune
```

## Architecture

### Container Structure

```
Container: books-api
├── PHP 8.0 CLI
├── Composer 2.x
├── Working Directory: /app
├── Exposed Port: 8000
└── Command: php -S 0.0.0.0:8000 -t public
```

### Volume Mounting

The current directory is mounted to `/app` inside the container:
- **Benefit**: Code changes reflect immediately
- **Location**: Host `.` → Container `/app`
- **Type**: Bind mount

### Networking

- **Host Port**: 8000
- **Container Port**: 8000
- **Access**: http://localhost:8000
- **Network**: Default bridge network

## Configuration

### Environment Variables

Set in `docker-compose.yml`:

```yaml
environment:
  - APP_ENV=dev
  - GUTENDEX_API_URL=https://gutendex.com/books
```

To override, create `.env.local` on host machine.

### PHP Configuration

The container uses PHP 8.0 CLI with default php.ini settings.

To customize, create `php.ini` and mount it:

```yaml
volumes:
  - .:/app
  - ./php.ini:/usr/local/etc/php/php.ini
```

### Composer Configuration

Composer is installed from the official image:
```dockerfile
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
```

## Troubleshooting

### Container won't start

```bash
# Check logs
docker logs books-api

# Check if port is in use
netstat -an | findstr :8000

# Kill process on port 8000 (Windows PowerShell)
Get-Process -Id (Get-NetTCPConnection -LocalPort 8000).OwningProcess | Stop-Process
```

### API returns 500 errors

```bash
# Check container logs
docker logs books-api

# Verify cache permissions
docker exec -it books-api ls -la var/

# Rebuild container
docker-compose down
docker-compose up -d --build
```

### Changes not reflecting

```bash
# Restart container
docker-compose restart

# Verify volume mount
docker inspect books-api | grep -A 10 Mounts

# Clear cache
docker exec -it books-api rm -rf var/cache/*
```

### Performance issues

```bash
# Check resource usage
docker stats books-api

# Allocate more resources in Docker Desktop:
# Settings → Resources → Advanced
# Increase CPU and Memory

# Optimize cache
docker exec -it books-api composer dump-autoload --optimize
```

## Production Deployment

### Build optimized image

```dockerfile
# Production Dockerfile additions
RUN composer install --no-dev --optimize-autoloader --no-scripts
ENV APP_ENV=prod
```

### Security

```yaml
# Don't mount source code in production
# Use environment variables for secrets
environment:
  - APP_ENV=prod
  - APP_SECRET=${APP_SECRET}
  - REDIS_URL=${REDIS_URL}
```

### Health Check

Add to `docker-compose.yml`:

```yaml
healthcheck:
  test: ["CMD", "curl", "-f", "http://localhost:8000/api/books?search=test"]
  interval: 30s
  timeout: 10s
  retries: 3
```

## Alternative: Docker without docker-compose

### Build image

```bash
docker build -t books-api:latest .
```

### Run container

```bash
docker run -d \
  --name books-api \
  -p 8000:8000 \
  -v "$(pwd)":/app \
  -e APP_ENV=dev \
  -e GUTENDEX_API_URL=https://gutendex.com/books \
  books-api:latest
```

### Stop container

```bash
docker stop books-api
docker rm books-api
```

## Multi-stage Build (Advanced)

For smaller production images:

```dockerfile
# Stage 1: Dependencies
FROM composer:latest AS deps
WORKDIR /app
COPY composer.* ./
RUN composer install --no-dev --no-scripts

# Stage 2: Runtime
FROM php:8.0-cli
WORKDIR /app
COPY --from=deps /app/vendor ./vendor
COPY . .
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
```

## Docker Compose Profiles

For different environments:

```yaml
services:
  books-api:
    profiles: ["dev"]
    # ... dev config
  
  books-api-prod:
    profiles: ["prod"]
    # ... prod config
```

Run specific profile:
```bash
docker-compose --profile dev up -d
```

## Integration with CI/CD

### GitHub Actions Example

```yaml
- name: Build Docker image
  run: docker build -t books-api:${{ github.sha }} .

- name: Test
  run: docker run books-api:${{ github.sha }} php vendor/bin/phpunit
```

## Benefits of Docker

✅ **No local PHP installation** required
✅ **Consistent environment** across machines
✅ **Easy deployment** - one command start
✅ **Isolated** - doesn't affect host system
✅ **Reproducible** - same setup everywhere
✅ **Version controlled** - infrastructure as code

---

**Docker makes deployment a breeze!** 🚀
