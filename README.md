# Práctica 7 - Hola Mundo con PHP y MySQL usando Docker Compose

Aplicación web "Hola Mundo" escrita en PHP que se conecta a una base de datos MySQL. Ambos servicios se ejecutan en contenedores con Docker Compose.

## Estructura del proyecto

```
.
├── docker-compose.yml   # Definición de los servicios app y db
├── src/                 # Código fuente de la aplicación
│   ├── index.php        # Página Hola Mundo que consulta la BD
│   └── Dockerfile       # Imagen PHP 8.3 + Apache con extensión pdo_mysql
└── db/
    └── init.sql         # Crea la tabla `mensajes` e inserta datos de ejemplo
```

## Servicios

| Servicio | Imagen | Puerto (host:contenedor) | Descripción |
|----------|--------|--------------------------|-------------|
| `app` | PHP 8.3 + Apache (construida desde `src/Dockerfile`) | `8080:80` | Servidor de aplicación |
| `db` | `mysql:8.0` | `3307:3306` | Base de datos MySQL |

## Requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (incluye Docker Compose)

## Ejecución

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/Jeyson-Dev/practica7-electiva.git
   cd practica7-electiva
   ```

2. Construir y levantar los contenedores:

   ```bash
   docker compose up -d --build
   ```

   El servicio `app` espera a que MySQL esté listo antes de iniciar (healthcheck).

3. Abrir en el navegador: <http://localhost:8080>

   Debe mostrarse el mensaje **¡Hola Mundo!**, la confirmación de conexión a MySQL y los registros de la tabla `mensajes`.

## Comandos útiles

```bash
docker compose ps              # Ver el estado de los contenedores
docker compose logs -f app     # Ver los logs de la aplicación
docker compose down            # Detener y eliminar los contenedores
docker compose down -v         # Detener y eliminar también los datos de la BD
```

> El script `db/init.sql` solo se ejecuta la primera vez que se crea el volumen de datos. Para volver a ejecutarlo, usar `docker compose down -v` y levantar de nuevo.

## Conexión a la base de datos

| Parámetro | Valor |
|-----------|-------|
| Host (desde la app) | `db` |
| Host (desde la PC) | `localhost:3307` |
| Base de datos | `holamundo` |
| Usuario | `app` |
| Contraseña | `app123` |
| Contraseña root | `root123` |
