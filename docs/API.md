# 📚 API Reference - Souls Space

> Documentazione delle API interne del progetto

---

## 🔷 Endpoints Overview

### Risorse Pubbliche

| Endpoint | Metodo | Descrizione |
|----------|--------|-------------|
| `/` | GET | Homepage |
| `/games/index` | GET | Lista tutti i giochi |
| `/games/show/{id}` | GET | Dettaglio gioco |
| `/bossArea/index` | GET | Lista tutti i boss |
| `/bossArea/show/{id}` | GET | Dettaglio boss |
| `/contact_us` | GET | Form contatto |
| `/contact_us/submit` | POST | Invia messaggio |

### Risorse Protette (Auth Required)

| Endpoint | Metodo | Descrizione |
|----------|--------|-------------|
| `/profile/{user?}` | GET | Profilo utente |
| `/profile/avatar/{user}` | PUT | Cambia avatar |
| `/games/create` | GET | Form nuovo gioco |
| `/games/store` | POST | Crea gioco |
| `/games/edit/{id}` | GET | Form modifica |
| `/games/update/{id}` | PUT | Aggiorna gioco |
| `/games/destroy/{id}` | DELETE | Elimina gioco |
| `/bossArea/*` | * | CRUD Boss (stessa struttura) |

---

## 📝 Request/Response Examples

### GET /games/index

**Response:** HTML View con lista giochi

**Data disponibile nella view:**
```php
$games = [
    {
        'id' => 1,
        'title' => 'Dark Souls',
        'description' => '...',
        'price' => 59.99,
        'product' => 'FromSoftware',
        'cover' => 'public/covers/darksouls.jpg',
        'user' => { 'id' => 1, 'name' => 'Admin' },
        'consoles' => [ /* array di boss */ ]
    },
    // ...
]
```

### POST /games/store

**Request Body:**
```
title: string (required, unique, min:3)
description: string (required, min:10)
price: numeric (required, min:0)
product: string (required, max:200)
cover: file (optional, image, max:2048KB)
consoles[]: array (optional, array of boss IDs)
```

**Response:** Redirect to `game.index` with flash message

### POST /contact_us/submit

**Request Body:**
```
name: string (required, min:2)
email: string (required, email)
message: string (required, min:10)
```

**Response:** Redirect with success message

---

## 🔐 Autenticazione

Il progetto usa **Laravel Fortify** per l'autenticazione.

### POST /login

**Request:**
```
email: string (required)
password: string (required)
remember: boolean (optional)
```

### POST /register

**Request:**
```
name: string (required, max:255)
email: string (required, email, unique)
password: string (required, min:8, confirmed)
password_confirmation: string (required)
```

---

## ⚠️ Error Responses

### Validazione Fallita (422)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": ["Il titolo è obbligatorio."],
        "price": ["Il prezzo deve essere un numero."]
    }
}
```

### Non Autorizzato (403)
Redirect a homepage con flash message:
```php
->with('accessDenied', 'You are not authorized!')
```

### Non Autenticato (401)
Redirect a `/login`

---

## 🔮 Future API REST

> TODO: Implementare API REST per integrazioni esterne

```
GET    /api/v1/games
GET    /api/v1/games/{id}
POST   /api/v1/games
PUT    /api/v1/games/{id}
DELETE /api/v1/games/{id}

GET    /api/v1/bosses
GET    /api/v1/bosses/{id}
POST   /api/v1/bosses
PUT    /api/v1/bosses/{id}
DELETE /api/v1/bosses/{id}
```

---

*Ultimo aggiornamento: Gennaio 2026*
