# Despliegue en una máquina virtual de Azure

Guía para instalar la plataforma en una VM **Ubuntu Server 24.04 LTS** con Nginx, PHP 8.3, MySQL 8 y Node 22.
Todos los comandos se ejecutan en la VM (por SSH) salvo el paso 1, que se hace en el portal de Azure.

---

## 1. Abrir los puertos en Azure (portal)

En el portal de Azure: **Máquina virtual → Redes → Configuración de red → Reglas de puerto de entrada → Agregar regla**.

| Puerto | Protocolo | Origen | Para qué |
|---|---|---|---|
| 22 | TCP | **Tu IP** (no "Any") | Entrar por SSH |
| 80 | TCP | Any | Sitio web (HTTP) |
| 443 | TCP | Any | Sitio web con HTTPS |

No abras el puerto 3306 (MySQL): la base solo debe aceptar conexiones desde la misma VM.

Opcional pero recomendado: en **Información general → Nombre DNS** asigna un nombre (queda como
`tu-nombre.<region>.cloudapp.azure.com`). Se necesita un nombre para el certificado HTTPS.

## 2. Firewall dentro de la VM

```bash
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'   # 80 y 443 (ejecutar después de instalar Nginx en el paso 3)
sudo ufw enable
sudo ufw status
```

## 3. Instalar el software

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx mysql-server git unzip curl \
  php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml php8.3-zip \
  php8.3-gd php8.3-curl php8.3-bcmath php8.3-intl

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Node 22 (Vite 8 requiere Node 20.19 o superior)
curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -
sudo apt install -y nodejs

php -v && composer -V && node -v
```

## 4. Base de datos

```bash
sudo mysql
```

Dentro de MySQL (cambia la contraseña):

```sql
CREATE DATABASE practicas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'practicas'@'localhost' IDENTIFIED BY 'UNA_CONTRASEÑA_SEGURA';
GRANT ALL PRIVILEGES ON practicas.* TO 'practicas'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## 5. Clonar el repositorio

```bash
sudo mkdir -p /var/www && sudo chown $USER:$USER /var/www
cd /var/www
git clone https://github.com/ELNARMOTON79/Plataforma-Practicas-Profesionales.git practicas
cd practicas
```

Si el repositorio es privado, GitHub pedirá usuario y un **token personal** (no tu contraseña):
GitHub → Settings → Developer settings → Personal access tokens.

## 6. Configurar el `.env`

```bash
cp .env.example .env
nano .env
```

Valores de producción (ajusta los marcados):

```dotenv
APP_NAME="Plataforma de Prácticas Profesionales"
APP_ENV=production
APP_DEBUG=false                       # IMPORTANTE: con true se muestran contraseñas en los errores
APP_URL=http://TU_IP_O_DOMINIO        # con https:// cuando tengas certificado
APP_LOCALE=es

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=practicas
DB_USERNAME=practicas
DB_PASSWORD=UNA_CONTRASEÑA_SEGURA

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=false           # true cuando el sitio use HTTPS
CACHE_STORE=database
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local

MAIL_MAILER=smtp
MAIL_SCHEME=smtps
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=CUENTA_DE_CORREO@gmail.com
MAIL_PASSWORD=CONTRASEÑA_DE_APLICACION   # contraseña de aplicación de Google, no la normal
MAIL_FROM_ADDRESS="CUENTA_DE_CORREO@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Se recomienda una cuenta de correo exclusiva para la plataforma (Gmail limita a unos 500 correos al día).

## 7. Instalar la aplicación

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force

# Base de datos desde cero: primero el esquema completo, luego las migraciones incrementales
php artisan migrate --path=database/migrations/esquema_completo --force
php artisan migrate --force

# Solo los roles. No ejecutes "php artisan db:seed" completo: carga usuarios de prueba.
php artisan db:seed --class=RoleSeeder --force

# Estilos y scripts
npm ci
npm run build

# Enlace para los PDF de proyecto que suben los alumnos
php artisan storage:link

# Cachés de producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permisos: el servidor web escribe en storage y bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## 8. Crear el administrador

```bash
php artisan tinker --execute '
$u = App\Models\User::create(["correo" => "admin@ucol.mx", "contraseña" => "CAMBIA_ESTA_CONTRASEÑA", "activo" => true, "rol_id" => 1]);
$p = new App\Models\Coordinador(); $p->usuario_id = $u->id; $p->nombre_completo = "Administrador"; $p->save();
echo "Administrador creado";
'
```

Después entra como administrador y:
1. Cambia la contraseña en **Configuración → Perfil y Seguridad**.
2. Captura al director en **Configuración → Documentos Oficiales**.
3. Da de alta al coordinador en **Usuarios** (recibe sus credenciales por correo).

## 9. Configurar Nginx

```bash
sudo nano /etc/nginx/sites-available/practicas
```

```nginx
server {
    listen 80;
    server_name TU_IP_O_DOMINIO;
    root /var/www/practicas/public;
    index index.php;

    client_max_body_size 20M;   # los documentos pesan hasta 10 MB

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_read_timeout 120;   # margen para cargas masivas que envían varios correos
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/practicas /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t && sudo systemctl reload nginx
```

Ajusta también PHP para archivos y cargas masivas:

```bash
sudo sed -i 's/^upload_max_filesize.*/upload_max_filesize = 20M/; s/^post_max_size.*/post_max_size = 25M/; s/^max_execution_time.*/max_execution_time = 120/' /etc/php/8.3/fpm/php.ini
sudo systemctl restart php8.3-fpm
```

La plataforma ya responde en `http://TU_IP_O_DOMINIO`.

## 10. HTTPS (requiere el nombre DNS del paso 1)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d tu-nombre.<region>.cloudapp.azure.com
```

Luego en `.env`: `APP_URL=https://...` y `SESSION_SECURE_COOKIE=true`, y vuelve a ejecutar
`php artisan config:cache`. Certbot renueva el certificado automáticamente.

## Actualizar la plataforma después de un cambio en GitHub

```bash
cd /var/www/practicas
php artisan down
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm ci && npm run build
php artisan config:cache && php artisan route:cache && php artisan view:cache
php artisan up
```

## Si algo falla

- Errores de la aplicación: `tail -n 50 storage/logs/laravel.log`
- Errores de Nginx: `sudo tail -n 50 /var/log/nginx/error.log`
- Página en blanco o error 500 justo después de instalar: casi siempre son permisos de `storage` (paso 7).
- Los correos no salen: revisa `MAIL_*` en `.env` y que la contraseña sea de aplicación de Google.
