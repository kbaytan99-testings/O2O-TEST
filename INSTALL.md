# Instrucciones de Instalación Rápida

## Si no tienes Composer instalado

### Windows

1. **Descargar Composer**:
   - Visita: https://getcomposer.org/download/
   - Descarga el instalador de Windows: `Composer-Setup.exe`
   - Ejecuta el instalador y sigue las instrucciones

2. **Verificar instalación**:
   ```powershell
   composer --version
   ```

3. **Instalar dependencias del proyecto**:
   ```powershell
   cd "c:\Users\kaan\Documents\O2O prueba"
   composer install
   ```

4. **Ejecutar el servidor**:
   ```powershell
   php -S localhost:8000 -t public
   ```

5. **Probar la API**:
   - Búsqueda: http://localhost:8000/api/books?search=shakespeare
   - Por ID: http://localhost:8000/api/books/1342
   - Documentación: http://localhost:8000/api/doc

## Alternativa: Usar Docker

Si prefieres usar Docker sin instalar PHP ni Composer localmente:

```bash
docker run --rm -v ${PWD}:/app composer install
docker run -p 8000:8000 -v ${PWD}:/app -w /app php:8.1-cli php -S 0.0.0.0:8000 -t public
```

## Ejecutar Tests

```bash
# Tests unitarios
php vendor/bin/phpunit

# Tests funcionales
php vendor/bin/behat

# Verificar PSR-2
php vendor/bin/phpcs
```

## Comandos Git

```bash
# Inicializar repositorio
git init
git add .
git commit -m "Initial commit - Books API with Hexagonal Architecture"

# Conectar con repositorio remoto
git remote add origin <tu-repositorio-url>
git push -u origin main
```
