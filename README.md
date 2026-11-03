# 🖥️ HardStore MS - Plataforma de Gestión y Ventas

![Laravel](https://img.shields.io/badge/Laravel-13.x-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4-blue?style=for-the-badge&logo=php)
![MariaDB](https://img.shields.io/badge/MariaDB-10.x-003545?style=for-the-badge&logo=mariadb)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

> **HardStore MS** es una solución integral diseñada para centralizar, controlar y potenciar la gestión de una tienda de hardware con múltiples sucursales. Desde el control de inventario en tiempo real hasta el análisis de ventas y la atención al cliente con Inteligencia Artificial.

---

## 🎯 ¿Qué problema resuelve?

Las tiendas de hardware con múltiples sucursales suelen enfrentar problemas de **descentralización de la información**, **falta de control de stock** y **procesos de venta lentos**. HardStore MS resuelve esto mediante:

1.  **Control Multi-Sucursal:** Visualización unificada del inventario distribuido en diferentes puntos de venta (Sede Central, Norte, Sur, etc.).
2.  **Trazabilidad Total:** Cada movimiento de stock, venta y confirmación de pago queda registrado con el usuario responsable y la sucursal de origen.
3.  **Compatibilidad de Componentes:** Un sistema de validación técnica que ayuda a los clientes a no comprar piezas incompatibles (ej. placas base con sockets de CPU diferentes).
4.  **Fidelización del Cliente:** Sistema de puntos, gacha de descuentos y lista de deseos para incentivar la recompra.

---

## 🚀 Características Principales

### 🛒 Para el Cliente
*   **Catálogo Interactivo:** Búsqueda semántica y filtros por categoría (CPUs, GPUs, RAM, etc.) con diseño responsivo (Mobile-First).
*   **Sistema de Puntos y Gacha:** Gana puntos por cada compra y canjéalos por descuentos aleatorios (5%, 10%, 15% o envío gratis).
*   **Asistente Virtual con IA (HardBot):** Chatbot impulsado por **Ollama (Llama 3.2)** que ayuda a armar PCs según el presupuesto, verifica stock y consulta precios en tiempo real.
*   **Compra con Pago por QR:** Generación de códigos QR con los datos de transferencia bancaria y el detalle exacto de la compra.
*   **Panel de Cliente:** Historial de compras, seguimiento de pedidos y gestión de favoritos.

### 📊 Para el Administrador
*   **Dashboard Analítico:** Gráficos de rendimiento, Top Vendedores, Mejores Clientes y filtros de ventas por fechas (día, semana, mes).
*   **Reportes PDF:** Exportación de reportes detallados de ventas e inventario con la herramienta DomPDF.
*   **Gestión de Inventario:** Control de stock en tiempo real por sucursal, con alertas visuales para productos por agotarse.

### 💼 Para el Vendedor
*   **Gestión de Sucursal:** Vista limitada a su sucursal asignada.
*   **Confirmación de Ventas:** Bandeja de entrada para verificar pagos por transferencia y confirmar pedidos (lo que descuenta el stock y genera la factura).
*   **Reportes Locales:** Descarga de inventario y ventas exclusivos de su sucursal.

---

## 🧠 Módulo de Inteligencia Artificial

HardStore MS integra un asistente virtual local para evitar depender de APIs de pago y proteger la privacidad de los datos.
*   **Motor:** [Ollama](https://ollama.com/)
*   **Modelo:** `llama3.2:1b`
*   **Funcionalidad:** El asistente está contextualizado con la base de datos de la tienda. Puede leer precios, verificar stock y armar combinaciones de componentes dentro de un presupuesto.

---

## 🛠️ Arquitectura y Tecnologías

*   **Backend:** Laravel 13 (MVC).
*   **Base de Datos:** MariaDB / MySQL.
*   **Frontend:** Bootstrap 5, CSS personalizado, JavaScript nativo y Chart.js.
*   **Autenticación:** Laravel Breeze (con roles: Admin, Vendedor, Cliente).
*   **Herramientas extra:** Dompdf, Simple-QRCode, Laravel Socialite.

---

## 📸 Capturas de Pantalla

*(Reemplaza estos enlaces con las imágenes reales de tu proyecto subidas a GitHub)*

### Página Principal y Catálogo
*(Aquí va la imagen de tu catálogo)*

### Asistente Virtual (HardBot)
*(Aquí va la imagen del chat del asistente)*

### Dashboard del Administrador
*(Aquí va la imagen del dashboard con gráficos)*

---

## ⚙️ Instalación y Despliegue Local

Si deseas correr este proyecto en tu máquina:

```bash
# 1. Clonar el repositorio
git clone https://github.com/EliuMarioVillanueva/hardstore-ms.git

# 2. Entrar al directorio
cd hardstore-ms

# 3. Instalar dependencias
composer install
npm install

# 4. Configurar variables de entorno
cp .env.example .env
php artisan key:generate

# 5. Configurar la base de datos en el archivo .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 6. Ejecutar migraciones y seeders (poblar con datos de prueba)
php artisan migrate:fresh --seed

# 7. Crear enlace simbólico para imágenes
php artisan storage:link

# 8. Iniciar el servidor
php artisan serve