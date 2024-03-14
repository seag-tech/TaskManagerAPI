# Creacion de la tabla 

Para la creación de la tabla , recurri al comando php artisan make:migration , creando una columna como clave foránea para hacer la relacion 1-n entre usuario y tasks(middleware).
* He anexado seeders para tener datos de prueba.
# Task Controlles 

En TaskController están especificados todos los métodos requeridos en la practica.
# Modelo Taks
En el modelo task y user esta especificadas su relación 1-n .

```
    public function user()
    {
        return $this->belongsTo(User::class);
    }
```

# Rutas
En el archivo api.php están especificadas las rutas de acceso publico como son ,login y register y las rutas protegidas por sanctum , donde se requiere el personal access token.

```
Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/get-tasks', [TaskController::class, 'getTasks']);

    Route::get('/show-task/{id}', [TaskController::class, 'showTask']);

    Route::post('/task-with-date', [TaskController::class, 'taskWithDate']);

    Route::put('/complete-task/{id}', [TaskController::class, 'completeTask']);

    Route::get('/external-info-task/{id}', [TaskController::class, 'externalInfo']);
});
``` 
# Api publica 
Para la implementación de la información de la api externa he creado el método externalInfo donde se recoge la información de la tarea , más un apartado de external info , donde están los datos de la api externa.
```
 $response = Http::get("https://jsonplaceholder.typicode.com/posts/$idTask");

        if ($response->successful()) {

            $externalInfo = $response->json();

            $data = [
                'task' => $task,
                'external_api_info' => $externalInfo
            ];

            return response()->json($data);
```
# Notificacion por correo electrónico + test

Para la creación de la notificación , he echo uso del comando php artisan make:notification , configurado para enviar un mail , para este caso he creado un **test** para probar su funcionalidad , al estar en modo local y no tener cliente smpt , he especificado a laravel que registre el envió de mails en el archivo storage/laravel.log para poder porbar el caso. 
Además he creado una tarea schedule para la comprobación de la condición de tarea vencida de forma recurrente :

```
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('tasks:check-expired')->hourly();
    }
``` 
# Middleware

Para el middlewear , he protegido las rutas sensibles con un access token, que el usuario recibe al hacer login o register , teniendo así acceso a las rutas protegidas por sanctum .


# Validación

Para la validación, he hecho uso de la clase Validator , especificando que el campo title es requerido.

```
  $validator = Validator::make($request->all(), [
            'title' => 'required|string',
        ]);
```
