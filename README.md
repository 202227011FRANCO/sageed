# SAGEED - Sistema de Gestión de Educación Dual (TecNM)

Sistema web para la gestión del programa de Educación Dual del Tecnológico Nacional de México, alineado al Manual ED_20190605.

## Tecnologías

- **Backend:** PHP 8+ con PDO
- **Base de datos:** MySQL 8+
- **Frontend:** HTML5 + Tailwind CSS + JavaScript (Vanilla)
- **Iconos:** FontAwesome 6

## Requisitos previos

- PHP 8.0 o superior
- MySQL 8.0 o superior
- Apache/Nginx (o XAMPP/WAMP/Laragon)
- Git

## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/usuario/sageed.git
   cd sageed
   ```

2. Crear la base de datos:
   ```bash
   mysql -u root -p < sql/sageed.sql
   ```

3. Copiar `.env.example` a `.env` y configurar:
   ```
   DB_HOST=localhost
   DB_NAME=sageed
   DB_USER=root
   DB_PASS=
   ```

4. Levantar el servidor:
   ```bash
   php -S localhost:8000
   ```

5. Abrir en el navegador: `http://localhost:8000`

## Estructura

- `api/` → Endpoints REST
- `config/` → Configuración de BD
- `assets/css/` → Estilos
- `assets/js/` → Lógica del frontend
- `sql/` → Scripts de base de datos

## Colaboradores

- [Franco Contreras Pablo Uriel](https://github.com/202227011FRANCO)
- [Nombre del colaborador](https://github.com/colaborador)

## 📄 Licencia

Uso académico - TecNM EdoMéx