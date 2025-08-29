## TRABAJO FINAL: AUDITORÍA Y PRESENTACIÓN DE UN PROYECTO CON POLÍTICAS DE SEGURIDAD EN EL CÓDIGO
#### PROYECTO: SISTEMA DE FERTIRRIGACIÓN AUTOMATIZADA Y COMERCIO DIGITAL DE CULTIVO DE LECHUGA EN LA LOCALIDAD DE PIRHUAS – SIPE SIPE

Este proyecto está siendo desarrollado en Laravel Framework 10.48.29.

## Acerca de Laravel

Laravel es un framework de aplicaciones web con una sintaxis expresiva y elegante. 
Laravel is a web application framework with expressive, elegant syntax, lo que hace del desarrollo de software una experiencia agradable y creativa para ser verdaderamente gratificante. Laravel simplifica el desarrollo al facilitar tareas comunes en muchos proyectos web, como:

- [Motor de enrutamiento simple y rápido](https://laravel.com/docs/routing).
- [Potente contenedor de inyección de dependencias](https://laravel.com/docs/container).
- Múltiples back-ends para almacenamiento de [sesiones](https://laravel.com/docs/session) y [caché](https://laravel.com/docs/cache).
- [Base de Datos ORM](https://laravel.com/docs/eloquent) expressiva e intuitiva.
- [Migraciones de esquemas ](https://laravel.com/docs/migrations) independientes de la base de datos.
- [Procesamiento robusto de trabajos en segundo plano](https://laravel.com/docs/queues).
- [Transmisión de eventos en tiempo real](https://laravel.com/docs/broadcasting).

Laravel es accesible, potente y proporciona las herramientas necesarias para aplicaciones grandes y robustas.

## Instrucciones para la instalación y ejecución del proyecto

1. Clonar el repositorio.
2. Ubicarse en el directorio donde se encuentra el proyecto.
2. Abrir la consola de comandos.
3. Ejecutar el comando:
```bash
    composer install
```
4. Copiar el archivo `.env.example` a `.env`
5. Generar la clave con el comando:
```bash
    php artisan key:generate
```
6. Ejecutar migraciones con el comando:
```bash
    php artisan migrate
```
7. Generar algunos registros en la tabla de usuarios con el comando:
```bash
    php artisan db:seed
```
8. Levantar el servidor con el comando:
```bash
    php artisan serve
```
9. Escribir la url `http://127.0.0.1:8000` en un navegador web
10. Ingresar al sistema como administrador con las siguientes credenciales: username: `admin` y password: `Password1!`
