# Multi POS System

Un sistema integral de Punto de Venta (POS) construido con Laravel y AdminLTE que permite a múltiples tiendas gestionar sus operaciones comerciales a través de una moderna interfaz web.

## 🌟 Características Principales

### 🏪 Gestión Multi-Tienda
- Cada propietario puede registrar y gestionar su propia tienda
- Datos aislados por tienda con controles de acceso seguros
- Asistente de configuración para nuevos registros
- Gestión de perfil de tienda con carga de logo

### 🔐 Autenticación y Autorización
- **Integración con Google OAuth** - Registro rápido con cuentas de Google
- **Email/Contraseña tradicional** - Método de autenticación estándar
- **Control de acceso basado en roles** - Propietarios, empleados y super administrador
- **Middleware seguro** - Rutas protegidas con autorización apropiada

### 📦 Gestión de Inventario
- **Gestión de productos** - Agregar, editar, eliminar productos con imágenes
- **Organización por categorías** - Organizar productos por categorías
- **Seguimiento de stock** - Inventario en tiempo real con alertas de stock bajo
- **Operaciones por lotes** - Gestionar múltiples productos eficientemente

### 💰 Punto de Venta (POS)
- **Interfaz POS moderna** - Diseño limpio y responsivo para ventas rápidas
- **Búsqueda de productos** - Búsqueda rápida por nombre o código de barras
- **Carrito de compras** - Agregar/quitar artículos con ajustes de cantidad
- **Múltiples métodos de pago** - Efectivo, tarjeta, transferencia y otros
- **Gestión de clientes** - Asignación opcional de clientes a ventas
- **Cálculos en tiempo real** - Totales automáticos, impuestos y cambio

### 🧾 Ventas y Reportes
- **Historial de ventas** - Registros completos de transacciones
- **Generación de recibos** - Imprimir o generar PDFs
- **Dashboard de analíticas** - Tendencias de ventas, productos principales y KPIs
- **Filtrado y búsqueda** - Encontrar ventas específicas por fecha, cliente o producto
- **Opciones de exportación** - Generar reportes para análisis

### 👥 Gestión de Clientes
- **Base de datos de clientes** - Almacenar información de clientes
- **Historial de compras** - Seguimiento de patrones de compra
- **Gestión de contactos** - Registros de email, teléfono y dirección

### 🎛️ Panel de Administración (Super Admin)
- **Monitoreo de tiendas** - Ver todas las tiendas registradas
- **Gestión de pagos** - Seguimiento de pagos de suscripción
- **Suspensión de tiendas** - Suspender/activar tiendas según estado de pago
- **Analíticas del sistema** - Estadísticas generales de la plataforma

### 🎨 UI/UX Moderna
- **Integración AdminLTE** - Interfaz profesional de dashboard
- **Framework Bootstrap** - Responsivo y compatible con móviles
- **Componentes interactivos** - Interacciones modernas con JavaScript
- **Integración Chart.js** - Hermosas visualizaciones de datos
- **Iconos FontAwesome** - Biblioteca completa de iconos

## 🛠️ Stack Tecnológico

- **Backend**: Laravel 11 (PHP 8.4)
- **Frontend**: AdminLTE 3, Bootstrap 5, jQuery
- **Base de datos**: SQLite (configurable para MySQL/PostgreSQL)
- **Autenticación**: Laravel Socialite (Google OAuth)
- **Generación PDF**: DOMPDF
- **Almacenamiento**: Laravel Storage con disco público
- **Gráficos**: Chart.js para visualizaciones

## 📋 Requisitos del Sistema

### Requisitos Mínimos
- **PHP**: 8.1 o superior (recomendado 8.4)
- **Composer**: Última versión
- **Node.js**: 16 o superior
- **NPM**: 7 o superior
- **Base de datos**: SQLite, MySQL 8.0+ o PostgreSQL 13+
- **Extensiones PHP**: 
  - BCMath
  - Ctype
  - cURL
  - DOM
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PCRE
  - PDO
  - Tokenizer
  - XML
  - Zip

### Hosting Recomendado
- **Memoria RAM**: Mínimo 512MB (recomendado 1GB+)
- **Espacio en disco**: Mínimo 500MB para el código + espacio para uploads
- **PHP**: Versión 8.1+ con todas las extensiones
- **Base de datos**: MySQL 8.0+ o PostgreSQL 13+
- **SSL**: Certificado SSL para HTTPS (requerido para OAuth)

## 🚀 Guía de Instalación Paso a Paso

### Paso 1: Preparar el Entorno de Desarrollo

#### En Windows:
1. **Instalar XAMPP**:
   - Descargar desde https://www.apachefriends.org/
   - Instalar con PHP 8.1+, MySQL y Apache
   - Iniciar Apache y MySQL desde el panel de control

2. **Instalar Composer**:
   - Descargar desde https://getcomposer.org/download/
   - Ejecutar el instalador y seguir las instrucciones
   - Verificar en CMD: `composer --version`

3. **Instalar Node.js**:
   - Descargar desde https://nodejs.org/
   - Instalar la versión LTS
   - Verificar en CMD: `node --version` y `npm --version`

#### En macOS:
1. **Instalar Homebrew** (si no lo tienes):
   ```bash
   /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
   ```

2. **Instalar PHP y Composer**:
   ```bash
   brew install php@8.4 composer
   brew install mysql # O usar MAMP
   ```

3. **Instalar Node.js**:
   ```bash
   brew install node
   ```

#### En Linux (Ubuntu/Debian):
1. **Actualizar el sistema**:
   ```bash
   sudo apt update && sudo apt upgrade -y
   ```

2. **Instalar PHP y extensiones**:
   ```bash
   sudo apt install php8.4 php8.4-cli php8.4-mbstring php8.4-xml php8.4-curl php8.4-zip php8.4-bcmath php8.4-sqlite3 php8.4-mysql unzip curl -y
   ```

3. **Instalar Composer**:
   ```bash
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   ```

4. **Instalar Node.js**:
   ```bash
   curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
   sudo apt-get install -y nodejs
   ```

5. **Instalar MySQL** (opcional):
   ```bash
   sudo apt install mysql-server
   sudo mysql_secure_installation
   ```

### Paso 2: Clonar y Configurar el Proyecto

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/tu-usuario/multi-pos-system.git
   cd multi-pos-system
   ```

2. **Instalar dependencias de PHP**:
   ```bash
   composer install
   ```

3. **Instalar dependencias de Node.js**:
   ```bash
   npm install
   ```

4. **Configurar el archivo de entorno**:
   ```bash
   cp .env.example .env
   ```

5. **Generar la clave de aplicación**:
   ```bash
   php artisan key:generate
   ```

### Paso 3: Configurar la Base de Datos

#### Opción A: SQLite (Más fácil para desarrollo)
1. **Crear el archivo de base de datos**:
   ```bash
   touch database/database.sqlite
   ```

2. **En el archivo .env, asegurar que esté configurado**:
   ```
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

#### Opción B: MySQL (Recomendado para producción)
1. **Crear una base de datos**:
   ```sql
   CREATE DATABASE multipos_system;
   CREATE USER 'multipos_user'@'localhost' IDENTIFIED BY 'tu_password_segura';
   GRANT ALL PRIVILEGES ON multipos_system.* TO 'multipos_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

2. **Configurar en .env**:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=multipos_system
   DB_USERNAME=multipos_user
   DB_PASSWORD=tu_password_segura
   ```

### Paso 4: Configurar Google OAuth (Opcional pero Recomendado)

1. **Ir a Google Cloud Console**:
   - Visitar https://console.cloud.google.com/
   - Crear un nuevo proyecto o seleccionar uno existente

2. **Habilitar APIs**:
   - Buscar "Google+ API" y habilitarla
   - Ir a "Credenciales" > "Crear credenciales" > "ID de cliente OAuth 2.0"

3. **Configurar OAuth**:
   - Tipo de aplicación: "Aplicación web"
   - URIs de redirección autorizadas: `http://tu-dominio.com/auth/google/callback`
   - Para desarrollo local: `http://localhost:8000/auth/google/callback`

4. **Actualizar .env**:
   ```
   GOOGLE_CLIENT_ID=tu_google_client_id
   GOOGLE_CLIENT_SECRET=tu_google_client_secret
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

### Paso 5: Ejecutar Migraciones y Seeders

1. **Ejecutar migraciones**:
   ```bash
   php artisan migrate
   ```

2. **Crear usuario super administrador**:
   ```bash
   php artisan db:seed --class=SuperAdminSeeder
   ```

3. **Crear enlace de almacenamiento**:
   ```bash
   php artisan storage:link
   ```

### Paso 6: Configurar Permisos (Solo Linux/macOS)

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

O si usas tu usuario:
```bash
chmod -R 775 storage bootstrap/cache
```

### Paso 7: Probar en Desarrollo

1. **Iniciar el servidor de desarrollo**:
   ```bash
   php artisan serve
   ```

2. **Acceder a la aplicación**:
   - Abrir navegador en http://localhost:8000
   - Probar login con las credenciales del archivo `database_info_plain.txt`

## 🌐 Despliegue en Producción

### Preparación para Producción

1. **Optimizar la aplicación**:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```

2. **Configurar .env para producción**:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://tu-dominio.com
   
   # Base de datos de producción
   DB_CONNECTION=mysql
   DB_HOST=tu_host_mysql
   DB_PORT=3306
   DB_DATABASE=tu_base_datos
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_password_segura
   
   # Configuración de mail
   MAIL_MAILER=smtp
   MAIL_HOST=tu_servidor_smtp
   MAIL_PORT=587
   MAIL_USERNAME=tu_email
   MAIL_PASSWORD=tu_password_email
   MAIL_ENCRYPTION=tls
   
   # Google OAuth para producción
   GOOGLE_REDIRECT_URI=https://tu-dominio.com/auth/google/callback
   ```

### Hosting Compartido (cPanel)

1. **Subir archivos**:
   - Comprimir el proyecto (excepto node_modules)
   - Subir al directorio público del hosting
   - Descomprimir en el servidor

2. **Configurar el directorio público**:
   - Mover contenido de `/public` al directorio público del hosting
   - Actualizar `index.php` para apuntar a la carpeta correcta

3. **Instalar dependencias** (si el hosting lo permite):
   ```bash
   composer install --no-dev
   ```

4. **Configurar base de datos**:
   - Crear base de datos desde cPanel
   - Actualizar .env con las credenciales
   - Ejecutar migraciones: `php artisan migrate --force`

### VPS (Servidor Virtual Privado)

#### Usando Ubuntu 20.04/22.04

1. **Conectar al servidor**:
   ```bash
   ssh usuario@tu-servidor-ip
   ```

2. **Instalar dependencias del servidor**:
   ```bash
   sudo apt update
   sudo apt install nginx mysql-server php8.4-fpm php8.4-mysql php8.4-mbstring php8.4-xml php8.4-curl php8.4-zip php8.4-bcmath unzip git -y
   ```

3. **Configurar MySQL**:
   ```bash
   sudo mysql_secure_installation
   sudo mysql -u root -p
   ```
   ```sql
   CREATE DATABASE multipos_production;
   CREATE USER 'multipos'@'localhost' IDENTIFIED BY 'password_muy_segura';
   GRANT ALL ON multipos_production.* TO 'multipos'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

4. **Clonar y configurar el proyecto**:
   ```bash
   cd /var/www
   sudo git clone https://github.com/tu-usuario/multi-pos-system.git
   sudo chown -R www-data:www-data multi-pos-system
   cd multi-pos-system
   sudo -u www-data composer install --no-dev
   sudo -u www-data cp .env.example .env
   sudo -u www-data php artisan key:generate
   ```

5. **Configurar Nginx**:
   ```bash
   sudo nano /etc/nginx/sites-available/multipos
   ```
   
   Contenido del archivo:
   ```nginx
   server {
       listen 80;
       server_name tu-dominio.com;
       root /var/www/multi-pos-system/public;
       
       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";
       
       index index.php;
       
       charset utf-8;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }
       
       error_page 404 /index.php;
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
       
       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

6. **Habilitar el sitio**:
   ```bash
   sudo ln -s /etc/nginx/sites-available/multipos /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl restart nginx
   ```

7. **Configurar SSL con Let's Encrypt**:
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d tu-dominio.com
   ```

8. **Ejecutar migraciones**:
   ```bash
   cd /var/www/multi-pos-system
   sudo -u www-data php artisan migrate --force
   sudo -u www-data php artisan db:seed --class=SuperAdminSeeder
   sudo -u www-data php artisan storage:link
   ```

### Servicios en la Nube

#### DigitalOcean App Platform
1. Conectar repositorio de GitHub
2. Configurar variables de entorno
3. Configurar base de datos gestionada
4. Desplegar automáticamente

#### AWS Elastic Beanstalk
1. Crear aplicación Laravel
2. Configurar RDS para MySQL
3. Configurar variables de entorno
4. Desplegar zip del proyecto

#### Heroku
1. Instalar Heroku CLI
2. Crear aplicación: `heroku create tu-app-name`
3. Agregar MySQL: `heroku addons:create cleardb:ignite`
4. Configurar variables: `heroku config:set APP_KEY=...`
5. Desplegar: `git push heroku main`

## 🔧 Configuración Post-Instalación

### 1. Configurar Tareas Programadas (Opcional)
```bash
# Agregar al crontab del servidor
* * * * * cd /ruta/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

### 2. Configurar Queue Workers (Para mejor rendimiento)
```bash
# Instalar supervisor
sudo apt install supervisor

# Crear configuración
sudo nano /etc/supervisor/conf.d/laravel-worker.conf
```

### 3. Optimización de Rendimiento
```bash
# Cache de configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimizar autoloader
composer dump-autoload --optimize
```

## 📊 Monitoreo y Mantenimiento

### Respaldos Automáticos
```bash
#!/bin/bash
# Script de respaldo diario
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u usuario -p base_datos > backup_$DATE.sql
tar -czf backup_files_$DATE.tar.gz /var/www/multi-pos-system/storage
```

### Logs del Sistema
- **Laravel logs**: `storage/logs/laravel.log`
- **Nginx logs**: `/var/log/nginx/`
- **PHP logs**: `/var/log/php8.4-fpm.log`

### Actualizaciones
```bash
# Actualizar el código
git pull origin main
composer install --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔍 Solución de Problemas Comunes

### Error 500 - Internal Server Error
1. Verificar permisos de carpetas
2. Revisar logs de error
3. Verificar configuración de .env
4. Verificar que todas las extensiones PHP estén instaladas

### Problemas de Base de Datos
1. Verificar credenciales en .env
2. Verificar que la base de datos existe
3. Ejecutar migraciones: `php artisan migrate`

### Problemas de Autenticación Google
1. Verificar URLs de redirección en Google Console
2. Verificar que las credenciales estén correctas en .env
3. Verificar que Google+ API esté habilitada

### Problemas de Rendimiento
1. Habilitar caché de configuración
2. Optimizar consultas de base de datos
3. Usar CDN para archivos estáticos
4. Configurar Redis para sesiones

## 📚 Recursos Adicionales

- **Documentación de Laravel**: https://laravel.com/docs
- **AdminLTE**: https://adminlte.io/docs
- **Bootstrap**: https://getbootstrap.com/docs
- **Google OAuth Setup**: https://developers.google.com/identity/protocols/oauth2

## 🤝 Soporte y Contribuciones

### Reportar Problemas
1. Buscar problemas existentes en GitHub Issues
2. Crear un nuevo issue con:
   - Descripción detallada del problema
   - Pasos para reproducir
   - Información del entorno
   - Logs de error relevantes

### Contribuir
1. Fork del repositorio
2. Crear rama para la nueva característica
3. Hacer cambios y pruebas
4. Enviar Pull Request con descripción detallada

## 📄 Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo LICENSE para más detalles.

## 🏆 Reconocimientos

Construido con:
- Laravel Framework
- AdminLTE Template
- Bootstrap CSS Framework
- Chart.js para visualizaciones
- FontAwesome para iconos

---

**Multi POS System** - Potenciando negocios con tecnología moderna de punto de venta.
