## Prueba Técnica de Laravel para API y Consumo de APIs Públicas

**Objetivo:** Crear una API RESTful de gestión de tareas y agregar la capacidad de consultar una API pública para obtener información adicional sobre las tareas.

### Pasos:

1. **Configuración del Proyecto:**
   - Crea un nuevo proyecto Laravel llamado "TaskManagerAPI".
   - Configura la conexión a la base de datos SQLite.

2. **Base de Datos:**
   - Crea una migración para la tabla "tasks" con los siguientes campos:
     - `id` (autoincremental)
     - `title` (cadena de texto)
     - `description` (texto)
     - `completed` (booleano)
     - `due_date` (fecha de vencimiento)
     - `created_at` y `updated_at` (marcas de tiempo)

3. **Modelo:**
   - Crea un modelo llamado "Task" para la tabla "tasks".

4. **Controladores:**
   - Crea un controlador llamado "TaskController" con métodos para:
     - Obtener todas las tareas.
     - Obtener una tarea específica.
     - Crear una nueva tarea que no tenga fecha de vencimiento.
     - Crear una nueva tarea con fecha de vencimiento.
     - Marcar una tarea como completada.
     - Agregar un método para obtener información adicional sobre una tarea consultando una API pública de tu elección (por ejemplo, la API de JSONPlaceholder).

5. **Rutas:**
   - Define las rutas necesarias en el archivo "api.php" para llamar a los métodos del controlador.

6. **Validaciones:**
   - Agrega validaciones a las solicitudes de la API para garantizar que el título sea obligatorio.

7. **Consumo de API Pública:**
   - Utiliza Laravel HTTP Client o cualquier otra biblioteca para realizar la consulta a la API pública. Añade la información obtenida de la API pública a la respuesta de la API de gestión de tareas.

8. **Notificaciones:**
   - Implementa notificaciones para alertar al usuario cuando una tarea está vencida. Puedes usar Laravel Notifications y configurar un canal de notificación de tu elección (correo electrónico, SMS, Slack, etc.).

9. **Middleware (Opcional):**
   - Implementa un middleware para autenticar las solicitudes de la API (puedes usar Laravel Passport u otra solución de tu elección).

10. **Documentación (Opcional):**
   - Puedes agregar documentación básica para la API utilizando herramientas como Swagger o Laravel API Documentation.

**Notas:**
- Utiliza Eloquent para las consultas a la base de datos.
- Asegúrate de manejar correctamente las solicitudes HTTP para la creación de tareas.
- Documenta cómo realizar la configuración para consumir la API pública elegida.
