# 🧪 Ejemplos de Uso de la API

## Requisitos Previos

1. Instalar dependencias:
```bash
composer install
```

2. Iniciar el servidor:
```bash
php -S localhost:8000 -t public
```

## Probar los Endpoints

### 1. Búsqueda de Libros

#### Buscar por "shakespeare"
```bash
curl "http://localhost:8000/api/books?search=shakespeare"
```

**Respuesta esperada:**
```json
[
  {
    "id": 1513,
    "title": "Romeo and Juliet",
    "subjects": [
      "Conflict of generations -- Drama",
      "Juliet (Fictitious character) -- Drama",
      "Romeo (Fictitious character) -- Drama",
      "Tragedies",
      "Vendetta -- Drama",
      "Verona (Italy) -- Drama",
      "Youth -- Drama"
    ],
    "authors": [
      {
        "name": "Shakespeare, William",
        "birth_year": 1564,
        "death_year": 1616
      }
    ]
  },
  ...
]
```

#### Buscar por "dickens"
```bash
curl "http://localhost:8000/api/books?search=dickens"
```

#### Buscar por "python"
```bash
curl "http://localhost:8000/api/books?search=python"
```

### 2. Obtener Libro por ID

#### Pride and Prejudice (ID: 1342)
```bash
curl "http://localhost:8000/api/books/1342"
```

**Respuesta esperada:**
```json
{
  "id": 1342,
  "title": "Pride and Prejudice",
  "subjects": [
    "Courtship -- Fiction",
    "Domestic fiction",
    "England -- Fiction",
    "Love stories",
    "Sisters -- Fiction",
    "Young women -- Fiction"
  ],
  "authors": [
    {
      "name": "Austen, Jane",
      "birth_year": 1775,
      "death_year": 1817
    }
  ]
}
```

#### Alice's Adventures in Wonderland (ID: 11)
```bash
curl "http://localhost:8000/api/books/11"
```

#### Moby Dick (ID: 2701)
```bash
curl "http://localhost:8000/api/books/2701"
```

### 3. Probar Validaciones

#### Sin parámetro de búsqueda (Error 400)
```bash
curl "http://localhost:8000/api/books"
```

**Respuesta:**
```json
{
  "error": "Search parameter is required"
}
```

#### Libro inexistente (Error 404)
```bash
curl "http://localhost:8000/api/books/999999999"
```

**Respuesta:**
```json
{
  "error": "Book with ID 999999999 not found"
}
```

## Probar desde el Navegador

Simplemente abre estas URLs en tu navegador:

1. **Búsqueda**:
   - http://localhost:8000/api/books?search=shakespeare
   - http://localhost:8000/api/books?search=python
   - http://localhost:8000/api/books?search=alice

2. **Por ID**:
   - http://localhost:8000/api/books/1342
   - http://localhost:8000/api/books/11
   - http://localhost:8000/api/books/84

3. **Documentación**:
   - http://localhost:8000/api/doc

## Probar con PowerShell

```powershell
# Búsqueda
Invoke-RestMethod -Uri "http://localhost:8000/api/books?search=shakespeare" | ConvertTo-Json

# Por ID
Invoke-RestMethod -Uri "http://localhost:8000/api/books/1342" | ConvertTo-Json
```

## Probar con JavaScript (Fetch API)

```javascript
// Búsqueda
fetch('http://localhost:8000/api/books?search=shakespeare')
  .then(response => response.json())
  .then(data => console.log(data));

// Por ID
fetch('http://localhost:8000/api/books/1342')
  .then(response => response.json())
  .then(data => console.log(data));
```

## IDs de Libros Populares para Probar

| ID | Título | Autor |
|----|--------|-------|
| 11 | Alice's Adventures in Wonderland | Lewis Carroll |
| 84 | Frankenstein | Mary Shelley |
| 1342 | Pride and Prejudice | Jane Austen |
| 1513 | Romeo and Juliet | William Shakespeare |
| 2701 | Moby Dick | Herman Melville |
| 1661 | The Adventures of Sherlock Holmes | Arthur Conan Doyle |
| 98 | A Tale of Two Cities | Charles Dickens |
| 174 | The Picture of Dorian Gray | Oscar Wilde |
| 1952 | The Yellow Wallpaper | Charlotte Perkins Gilman |
| 16 | Peter Pan | J. M. Barrie |

## Verificar Caché

El sistema cachea las respuestas por 1 hora. Para verificar:

1. Primera petición (hace llamada a Gutendex):
```bash
curl "http://localhost:8000/api/books/1342"
```

2. Segunda petición inmediata (usa caché):
```bash
curl "http://localhost:8000/api/books/1342"
```

La segunda debería ser mucho más rápida.

## Limpiar Caché

```bash
# Windows
Remove-Item -Recurse -Force var/cache/*

# Linux/Mac
rm -rf var/cache/*
```

## Headers de la Respuesta

Para ver los headers HTTP:

```bash
curl -i "http://localhost:8000/api/books/1342"
```

Deberías ver:
- `Content-Type: application/json`
- `HTTP/1.1 200 OK` (para éxito)
- `HTTP/1.1 404 Not Found` (para libro no encontrado)

---

**¡Disfruta probando la API!** 🚀
