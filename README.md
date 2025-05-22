
## API Examen Laravel - Luis Lopez Puig

USER ADMIN PARA CORRECCIÓN: 

    {
        "email": "albert@examen.com"
        "password": "123456"
    }


### Descripción

Mi api gestiona una base de datos cuyos datos son de tipo "usuarios" y "mascotas". 
Los usuarios constan de un id, nombre, email y contraseña.
Las mascotas constan de un id, user_id ( que se asocia al usuario que ha creado la mascota), nombre, raza y edad.

Las rutas son las siguientes:

### Public Routes:

// Public routes
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Estas rutas son públicas y no requieren autenticación ni rol. Sirven para registrar el usuario en la base de datos e iniciar sesión.

Teniendo en cuenta los campos de usuario, la peticion en JSOn sería la siguiente:

EJ:
    {
        "name": "Luis",
        "email": "luis@gmail.com",
        "password": "12345678"
        "password_confirmation": "12345678"
        "rol": "admin"
    }

De esta manera, se registrará el usuario en la base de datos y se le asignará el rol de "admin".

Para hacer login, solo se necesita el email y la contraseña. Este, te devolverá un token de inicio de sesión
 
 EJ:
    {
        "email": "luis@gmail.com",
        "password": "12345678"
    }

### Protected Routes:

// Protected routes
Route::middleware([IsAuthenticated::class])->group(function () {
    Route::post('/logout', [AuthController::class,'logout']);
    Route::get('/pets', [PetsController::class, 'getMyPets']);
    Route::post('/pets', [PetsController::class, 'createPet']);
    Route::put('/pets/{id}', [PetsController::class, 'completeUpdatePet']);
    Route::patch('/pets/{id}', [PetsController::class, 'partialUpdatePet']);
    Route::delete('/pets/{id}', [PetsController::class, 'deletePet']);
});

Estas rutas estan protegidas por el middleware IsAuthenticated, que comprueba que el usuario está autenticado. No es necesario ningun rol para acceder a estas rutas.

- Para logout, se necesita el token de autenticación, así que no se podría hacer sin uno.

-   Para ver las mascotas, se necesita el token de autenticación, así que no se podría hacer sin estar logueado. Solo se mostrará las mascotas del usuario, no las del resto de usuarios.

-     Para crear una mascota, se necesita el token de autenticación, así que no se podría hacer sin estar logueado.
   
   EJ: 
    
    {
    "nombre": "Luna",
    "raza": "Perro",
    "edad": 4
    }

    Esto creará automaticamente, para el usuario logueado, una mascota con los datos que se han pasado. Dicha mascota estará asociada al user_id del usuario logueado.

- Para actualizar una mascota, completa o parcialmente, se necesita el token de autenticación, así que no se podría hacer sin estar logueado. put tendrá que actualizar todos los datos, mientras que patch no haría falta, podrá cambiar solo los datos que se le pasen.
    
- Para eliminar una mascota, se necesita el token de autenticación, así que no se podría hacer sin estar logueado.



### Admin Routes:

// Admin routes

Route::middleware([IsUserAdmin::class])->group(function () {

    Route::get('/users', [AuthController::class, 'getAllUsers']);
    Route::get('/users/{id}', [AuthController::class, 'getUserById']);
    Route::put('/users/{id}', [AuthController::class, 'updateUser']);
    Route::delete('/users/{id}', [AuthController::class, 'deleteUser']);
    Route::get('/users/{id}/pets', [AuthController::class, 'getPetsByUserId']);
});


Estas rutas estan protegidas por el middleware IsUserAdmin, que comprueba que el usuario es "admin".

-   Para ver todos los usuarios, se necesita el token de autenticación y ser admin, así que no se podría hacer sin estar logueado.

-   Para ver un usuario en concreto, se necesita el token de autenticación y ser admin, así que no se podría hacer sin estar logueado.

-   Para actualizar un usuario, se necesita el token de autenticación y ser admin, así que no se podría hacer sin estar logueado. 

uerda que los campos son: nombre, email, password y rol, así que un "put" al user en concreto, podría ser de la siguiente manera:

    EJ:

    {
        "name": "Luis Cambio",
        "email": "luiscambiado@gmail.com",
        "rol": "admin"
    }

-     Para eliminar un usuario, se necesita el token de autenticación y ser admin, así que no se podría hacer sin estar logueado.

-     Para ver las mascotas de un usuario, se necesita el token de autenticación y ser admin, así que no se podría hacer sin estar logueado. 


Ten en cuenta que la URL de la api es: examenapiluislp.up.railway.app, así que una petición, por ejemplo para logarse, sería:

examenapiluislp.up.railway.app/api/login -> POST


E introduces los datos del usuario para hacer el log in y que te de el token.
