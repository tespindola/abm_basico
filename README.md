# Requerimientos

Composer
PHP > 7.3

# Instalacion

Tener instalado los paquetes de [composer](https://getcomposer.org/) y [npm](https://www.npmjs.com/) para poder ejecutar los siguientes comandos (instalan todas las dependencias del proyecto):

```bash
composer install && npm install
```

## Configuracion

Ejecutar los siguientes comandos:
```bash
php artisan migrate
php artisan db:seed
```
Crear el archivo .env en base al archivo .env.example y configurar la base de datos