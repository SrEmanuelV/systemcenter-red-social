SystemCenter - Red Social (Nombre Temporal)

Descripción del Proyecto
SystemCenter es un proyecto en desarrollo por un equipo de tres estudiantes de ingeniería en sistemas que buscan aplicar y expandir sus conocimientos técnicos mediante la creación de una red social destinada a una comunidad universitaria. Inspirada en la filosofía de libre expresión, la plataforma permitirá a los usuarios mayores de 15 años publicar contenido de manera responsable, excluyendo material traumático o pornográfico, con el fin de proteger a la comunidad infantil y fomentar un entorno seguro.

El objetivo de SystemCenter no es sólo ofrecer una red social, sino también servir como un espacio para que los estudiantes del técnico de ingeniería en sistemas desarrollen sus habilidades en programación y diseño. Inicialmente, el líder del proyecto se encargará tanto del backend como del frontend, mientras que los otros dos miembros, actualmente en proceso de aprendizaje, se enfocarán en el diseño UX/UI y el desarrollo frontend en fases posteriores.

El proyecto evolucionará en diferentes versiones a medida que se desarrolle, documentando su progreso desde los cimientos hasta las fases más avanzadas.

Características Clave
Red social para una corporación universitaria, creada por y para estudiantes.
Enfoque en la libre expresión, con límites para proteger a la comunidad.
Usuarios deben tener más de 15 años para registrarse.
Contenido prohibido: material traumático o pornográfico.
Diseño modular: backend y frontend estarán claramente separados en futuras versiones.
Instalación
Requisitos Previos
Antes de instalar el proyecto, asegúrate de tener instalado lo siguiente:

Servidor web local (como XAMPP o MAMP).
PHP 7.0 o superior.
MySQL.
Git (opcional, para clonar el repositorio).
Pasos de Instalación
Descarga el repositorio desde GitHub. Puedes clonar el proyecto o descargar el archivo .zip y descomprimirlo:

git clone https://github.com/SrEmanuelV/systemcenter-red-social.git
O bien, descargar el archivo en formato .zip y extraerlo.

Configura la base de datos.

Crea una base de datos MySQL en tu servidor local.
Importa el archivo SQL que contendrá la estructura de las tablas (si está disponible en futuras versiones).
Asegúrate de configurar las credenciales de tu base de datos en el archivo conexion.php que se encuentra en la carpeta php.
Configura el entorno.

Ubica la carpeta del proyecto en tu directorio raíz del servidor web local (por ejemplo, htdocs en XAMPP).
Ajusta las configuraciones necesarias en conexion.php para establecer la conexión con la base de datos.
Inicia el servidor local y abre el navegador para acceder al archivo index.php, el cual servirá como la página principal de la red social.

Estructura del Proyecto
La estructura de carpetas del proyecto está diseñada para mantener una clara organización entre los diferentes componentes del sistema:

/css/: Carpeta que contiene los archivos CSS. Cada archivo CSS está vinculado con su respectiva página PHP para facilitar el mantenimiento.

main.css: Archivo principal que contiene estilos generales del sitio.
/php/: Carpeta que contiene los archivos esenciales de PHP, incluyendo:

conexion.php: Archivo para gestionar la conexión a la base de datos.
funciones.php: Aquí se registran todas las funciones necesarias para el funcionamiento del sitio.
register.php: Formulario de registro de nuevos usuarios.
login.php: Formulario de inicio de sesión.
index.php: Página principal de la red social que servirá como el home o inicio. Este archivo está ubicado en la carpeta principal y no pertenece a ninguna subcarpeta específica.

Actualizaciones y Versiones
El proyecto SystemCenter está en constante evolución. Cada nueva versión será lanzada en una carpeta separada dentro del repositorio, etiquetada con el formato V1, V2, etc., según el progreso del desarrollo. Las versiones documentarán cambios significativos en la estructura y funcionalidad del proyecto.
