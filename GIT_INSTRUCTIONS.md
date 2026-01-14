# 🚀 Cómo Subir el Proyecto a Git (GitHub/GitLab/Bitbucket)

El proyecto ya está inicializado con Git y tiene un historial completo de commits.

## Ver Historial de Commits

```bash
git log --oneline
```

**Commits creados:**
1. `chore: initial project setup with configuration files`
2. `feat: add Symfony framework structure and configuration`
3. `feat: implement Domain layer with entities and repository interface`
4. `feat: implement Application layer with use cases and DTOs`
5. `feat: implement Infrastructure layer with Gutendex client and repository`
6. `feat: implement REST API controllers for books endpoints`
7. `test: add comprehensive unit tests with mocks for all layers`
8. `test: add Behat functional tests for API endpoints`
9. `docs: add comprehensive documentation and project summary`

## Opción 1: GitHub

### 1. Crear repositorio en GitHub
- Ve a https://github.com/new
- Nombre del repositorio: `books-api-symfony`
- Descripción: `API REST de libros con Arquitectura Hexagonal y DDD`
- **NO** inicialices con README (ya lo tenemos)
- Click en "Create repository"

### 2. Conectar y subir
```bash
cd "c:\Users\kaan\Documents\O2O prueba"
git remote add origin https://github.com/TU-USUARIO/books-api-symfony.git
git branch -M main
git push -u origin main
```

## Opción 2: GitLab

### 1. Crear repositorio en GitLab
- Ve a https://gitlab.com/projects/new
- Nombre: `books-api-symfony`
- Visibility: Private o Public
- **Desmarca** "Initialize repository with a README"
- Click en "Create project"

### 2. Conectar y subir
```bash
cd "c:\Users\kaan\Documents\O2O prueba"
git remote add origin https://gitlab.com/TU-USUARIO/books-api-symfony.git
git branch -M main
git push -u origin main
```

## Opción 3: Bitbucket

### 1. Crear repositorio en Bitbucket
- Ve a https://bitbucket.org/repo/create
- Nombre: `books-api-symfony`
- **Desmarca** "Include a README"
- Click en "Create repository"

### 2. Conectar y subir
```bash
cd "c:\Users\kaan\Documents\O2O prueba"
git remote add origin https://TU-USUARIO@bitbucket.org/TU-USUARIO/books-api-symfony.git
git branch -M main
git push -u origin main
```

## Verificar que todo se subió correctamente

Después de hacer `git push`, verifica en la web que:

✅ Todos los archivos están presentes
✅ Hay 9 commits en el historial
✅ El README.md se muestra correctamente
✅ La estructura de carpetas es visible

## Compartir el Repositorio

Una vez subido, comparte la URL del repositorio:
- GitHub: `https://github.com/TU-USUARIO/books-api-symfony`
- GitLab: `https://gitlab.com/TU-USUARIO/books-api-symfony`
- Bitbucket: `https://bitbucket.org/TU-USUARIO/books-api-symfony`

## Notas Importantes

- ⚠️ **No subas** la carpeta `vendor/` (ya está en .gitignore)
- ⚠️ **No subas** archivos `.env.local` con credenciales (ya está en .gitignore)
- ✅ El archivo `.env` sí se sube porque solo contiene valores de ejemplo
- ✅ El historial de Git muestra el desarrollo incremental del proyecto

## Comandos Útiles

```bash
# Ver estado del repositorio
git status

# Ver archivos trackeados
git ls-files

# Ver commits
git log --oneline --graph

# Ver cambios no commiteados
git diff

# Agregar más commits
git add .
git commit -m "feat: nueva funcionalidad"
git push
```

---

**¡El proyecto está listo para ser entregado!** 🎉
