# 📘 Documentación de la API REST

Esta API permite gestionar usuarios, tarjetas (cards), juegos (games) y categorías. Utiliza autenticación JWT y control de acceso basado en roles (`admin`, `user`).

---

## 🔐 Autenticación y Roles

- **Usuario autenticado:** Debe incluir el token JWT en el header:
    ```
    Authorization: Bearer {token}
    ```
- **Admin:** Usuario con rol `"admin"` que tiene acceso completo, incluyendo rutas exclusivas.

---

## 🌐 Endpoints Públicos

### 📝 Registro de Usuario

`POST /api/register`

```json
{
    "name": "Juan",
    "role": "user",
    "email": "juan@email.com",
    "password": "12345",
    "password_confirmation": "12345"
}
```
**Respuesta:** `201 Created`

---

### 🔑 Login

`POST /api/login`

```json
{
    "email": "juan@email.com",
    "password": "12345"
}
```
**Respuesta:** `200 OK`

```json
{
    "message": "Login successful",
    "token": "JWT_TOKEN"
}
```

---

## 🔒 Endpoints Protegidos (requieren JWT)

### 👤 Usuario

- `POST /api/logout` – Cierra sesión.
- `GET /api/me` – Retorna los datos del usuario autenticado.

### 💳 Tarjetas (Cards)

- `GET /api/my-cards` – Lista las tarjetas del usuario autenticado.
- `GET /api/public-cards` – Lista tarjetas públicas (sin usuario).
- `POST /api/cards` – Crea una nueva tarjeta.

```json
{
    "nom": "Tarjeta 1",
    "imatge": "https://url-imagen.com/img.png",
    "category_id": 1
}
```

- `DELETE /api/cards/{id}` – Elimina una tarjeta (propia o si el usuario es admin).

### 🎮 Juegos (Games)

- `GET /api/games` – Lista partidas del usuario.
- `POST /api/games` – Crea una nueva partida.
- `GET /api/games/{id}` – Muestra una partida propia.
- `PUT /api/games/{id}` – Actualiza una partida.

```json
{
    "duració": 120,
    "puntuació": 100,
    "clics": 30
}
```

- `DELETE /api/games/{id}` – Elimina una partida.
- `GET /api/ranking` – Devuelve el top 5 del ranking.
- `GET /api/games/user/{id}` – (Admin) Lista partidas de un usuario específico.

### 🗂️ Categorías

- `GET /api/categories` – Lista todas las categorías.
- `POST /api/categories` – Crea una nueva categoría.
- `PUT /api/categories/{category}` – Actualiza una categoría.
- `DELETE /api/categories/{category}` – Elimina una categoría.

---

## 🛠️ Endpoints de Administración (solo Admin)

> Requieren token JWT con rol admin

### 👥 Usuarios

- `GET /api/users` – Lista todos los usuarios.
- `GET /api/users/{id}` – Muestra un usuario.
- `PUT /api/users/{id}` – Actualiza un usuario.
- `PATCH /api/users/{id}` – Actualización parcial.
- `DELETE /api/users/{id}` – Elimina un usuario.

### 💳 Tarjetas

- `GET /api/cards` – Lista todas las tarjetas.
- `GET /api/cards/{id}` – Muestra una tarjeta.
- `PUT /api/cards/{id}` – Actualiza una tarjeta.
- `PATCH /api/cards/{id}` – Actualización parcial.

---

## 🧪 Ejemplos con `curl`

### Registro

```bash
curl -X POST http://localhost:8000/api/register \
-H "Content-Type: application/json" \
-d '{"name":"Juan","role":"user","email":"juan@email.com","password":"12345","password_confirmation":"12345"}'
```

### Login

```bash
curl -X POST http://localhost:8000/api/login \
-H "Content-Type: application/json" \
-d '{"email":"juan@email.com","password":"12345"}'
```

### Obtener mis tarjetas (requiere token JWT)

```bash
curl -H "Authorization: Bearer JWT_TOKEN" \
http://localhost:8000/api/my-cards
```

---

## 📎 Notas

- Todas las respuestas están en formato JSON.
- Los endpoints protegidos requieren autenticación con JWT.
- Los endpoints de administración requieren que el usuario tenga rol admin.
- Los errores de validación retornan código `422` con detalles en el cuerpo de la respuesta.

---

## 🛡️ Roles y Permisos

| Endpoint                      | Invitado | Usuario | Admin |
|-------------------------------|:--------:|:-------:|:-----:|
| `/register`, `/login`         |   ✅     |   ✅    |  ✅   |
| `/logout`, `/me`              |   ❌     |   ✅    |  ✅   |
| `/my-cards`, `/public-cards`  |   ❌     |   ✅    |  ✅   |
| `/cards` (POST, DELETE)       |   ❌     |   ✅    |  ✅   |
| `/games` (GET, POST, etc)     |   ❌     |   ✅    |  ✅   |
| `/categories`                 |   ❌     |   ✅    |  ✅   |
| `/users*`                     |   ❌     |   ❌    |  ✅   |
| `/cards*` (GET, PUT, PATCH)   |   ❌     |   ❌    |  ✅   |

