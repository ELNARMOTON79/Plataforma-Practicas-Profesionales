<p align="center">
  <img src="public/images/logo_verde.png" width="200" alt="UdeC Logo">
</p>

# Plataforma de Prácticas Profesionales

Plataforma web desarrollada en Laravel para la gestión integral de las Prácticas Profesionales de la Universidad de Colima (UdeC). Esta herramienta facilita la interacción y administración entre estudiantes, empresas, coordinadores y administradores.

## 🚀 Características Principales

El sistema está diseñado con una arquitectura basada en roles, permitiendo flujos de trabajo específicos para cada tipo de usuario:

### 🎓 Estudiantes
- **Dashboard Personal:** Interfaz intuitiva para seguir el progreso de sus prácticas.
- **Consulta de Empresas:** Directorio de empresas y convenios disponibles.
- **Gestión de Solicitudes:** Capacidad de solicitar participación en programas de prácticas y monitorear su estado (pendiente, aceptado, rechazado).
- **Documentación:** Subida y seguimiento del estado de validación de documentos (cartas de aceptación, planes de trabajo, reportes, evaluaciones).
- **Métricas:** Monitoreo del progreso personal (días/horas acumuladas) y estado general (no iniciado, en progreso, acreditado).

### 🏢 Empresas
- Seguimiento de estudiantes en prácticas dentro de su organización.
- Validación de reportes y evaluación de desempeño.

### 👥 Coordinadores (Personal UdeC)
- Administración y validación de las solicitudes de los estudiantes.
- Revisión de la documentación entregada y seguimiento académico.

### ⚙️ Administradores
- Control total del sistema, gestión de usuarios, roles, empresas y catálogos generales.

## 🛠️ Tecnologías Utilizadas

- **Backend:** [Laravel](https://laravel.com/) (Framework PHP)
- **Frontend:** Blade Templates, [Tailwind CSS](https://tailwindcss.com/)
- **Base de Datos:** MySQL / MariaDB (Importar script SQL proporcionado)

## 📦 Instalación y Configuración Local

1. Clona el repositorio:
   ```bash
   git clone https://github.com/ELNARMOTON79/Plataforma-Practicas-Profesionales.git
   cd Plataforma-Practicas-Profesionales
   ```

2. Instala las dependencias de PHP y Node.js:
   ```bash
   composer install
   npm install
   ```

3. Configura el archivo de entorno:
   ```bash
   cp .env.example .env
   ```

4. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

5. Configura tu base de datos:
   - Crea una base de datos en tu gestor MySQL/MariaDB (por ejemplo, llamada `practicas`).
   - **Importante:** Importa el archivo SQL del proyecto (`database/practicas.sql`) a tu nueva base de datos. Puedes hacerlo mediante phpMyAdmin, DBeaver, o desde la terminal:
     ```bash
     mysql -u tu_usuario -p practicas < database/practicas.sql
     ```
   - Abre el archivo `.env` en la raíz del proyecto y ajusta las credenciales de conexión:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=practicas
     DB_USERNAME=tu_usuario
     DB_PASSWORD=tu_contraseña
     ```
   *(Nota: La estructura y los usuarios iniciales están en el archivo `practicas.sql`, por lo que **no** se debe ejecutar `php artisan migrate` ni seeders).*

6. Vincula el almacenamiento público (vital para visualizar y cargar documentos de estudiantes):
   ```bash
   php artisan storage:link
   ```

7. Compila los recursos del frontend (Tailwind CSS, JS):
   ```bash
   npm run dev
   ```

8. Inicia el servidor de desarrollo local:
   ```bash
   php artisan serve
   ```
   La aplicación estará disponible en `http://localhost:8000`.

## 🎨 Diseño y UI/UX

La interfaz ha sido diseñada para reflejar la identidad visual de la Universidad de Colima, empleando su paleta de colores distintiva. Incluye layouts modernos de pantalla dividida para el login, redirección basada en roles, y paneles de control (`dashboards`) responsive enfocados en la usabilidad y experiencia del usuario.
