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
- **Base de Datos:** SQLite (Configuración inicial)

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

5. Configura tu base de datos en el `.env` (si usas SQLite, asegúrate de crear el archivo `database/database.sqlite`) y luego ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```

6. Compila los assets del frontend (Tailwind CSS, JS):
   ```bash
   npm run dev
   ```

7. Inicia el servidor de desarrollo local:
   ```bash
   php artisan serve
   ```
   La aplicación estará disponible en `http://localhost:8000`.

## 🎨 Diseño y UI/UX

La interfaz ha sido diseñada para reflejar la identidad visual de la Universidad de Colima, empleando su paleta de colores distintiva. Incluye layouts modernos de pantalla dividida para el login, redirección basada en roles, y paneles de control (`dashboards`) responsive enfocados en la usabilidad y experiencia del usuario.
