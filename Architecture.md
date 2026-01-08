# 🏛️ Architecture & Development Guidelines - Souls Space

> **Obiettivo del Documento:** Fornire una struttura tecnica rigida, standard di codifica e contesto di dominio per AI Assistants (Copilot) e sviluppatori. Questo documento estende il README originale focalizzandosi sull'implementazione tecnica e sul refactoring.

---

## 📊 REPORT ANALISI ARCHITETTURALE
**Data Analisi:** 8 Gennaio 2026  
**Versione:** 2.0  
**Stato Generale:** 🟡 BUONO con aree di miglioramento

### ✅ Punti di Forza Verificati

| Area | Stato | Descrizione |
|------|-------|-------------|
| **Struttura MVC** | ✅ Corretto | Separazione chiara tra Models, Controllers, Views |
| **Policies** | ✅ Implementate | `GamePolicy` e `ConsolePolicy` esistono e sono registrate in `AuthServiceProvider` |
| **Form Requests** | ✅ Corretti | `GameRequest` e `ConsoleRequest` con validazione differenziata POST/PUT |
| **Eager Loading** | ✅ Presente | `with('user', 'consoles')` in `GameController@index` e `ConsoleController@index` |
| **Middleware Auth** | ✅ Corretto | Applicato nei costruttori dei controller con `except()` appropriati |
| **Relazioni Eloquent** | ✅ Corrette | Many-to-Many via pivot `console_game`, belongsTo per User |
| **Route Naming** | ✅ Coerente | Convenzioni rispettate (es. `game.index`, `console.show`) |

### ⚠️ Problemi Rilevati

| ID | Problema | Severità | File Coinvolti |
|----|----------|----------|----------------|
| P1 | Policies non utilizzate nei controller | 🔴 ALTA | `GameController.php` L64-69, L76-78; `ConsoleController.php` L69-71, L84-86 |
| P2 | File orfani non eliminati | 🔴 ALTA | Tutti i controller con upload file |
| P3 | Terminologia `Console` confusa | 🟠 MEDIA | Tutti i file con prefisso Console* |
| P4 | Validazione inline in `UserController` | 🟡 BASSA | `UserController.php` L45-47 |
| P5 | Validazione inline in `FrontController` | 🟡 BASSA | `FrontController.php` L26-30 |
| P6 | Controllo autorizzazione mancante in `destroy()` | 🔴 ALTA | `GameController.php`, `ConsoleController.php` |

### 📁 Struttura File Attuale Verificata

```
app/
├── Models/
│   ├── User.php        ✅ Relazioni: hasMany(Game), hasMany(Console)
│   ├── Game.php        ✅ Relazioni: belongsTo(User), belongsToMany(Console)
│   └── Console.php     ✅ Relazioni: belongsTo(User), belongsToMany(Game)
├── Http/
│   ├── Controllers/
│   │   ├── Controller.php
│   │   ├── FrontController.php    ✅ homepage, contact_us
│   │   ├── UserController.php     ✅ profile, avatar, destroy
│   │   ├── GameController.php     ⚠️ CRUD (policies non usate)
│   │   └── ConsoleController.php  ⚠️ CRUD (policies non usate)
│   └── Requests/
│       ├── GameRequest.php        ✅ Validazione completa
│       └── ConsoleRequest.php     ✅ Validazione completa
├── Policies/
│   ├── GamePolicy.php             ✅ Registrata, NON usata
│   └── ConsolePolicy.php          ✅ Registrata, NON usata
└── Providers/
    └── AuthServiceProvider.php    ✅ Policies registrate correttamente

database/migrations/
├── create_users_table.php
├── create_games_table.php
├── add_cover_column_to_games_table.php
├── create_consoles_table.php
├── add_column_user_id_to_consoles_table.php
├── add_column_user_id_to_games_table.php
├── add_avatar_column_to_users_table.php
└── create_console_game_table.php  ✅ Pivot table

routes/web.php
├── GET  /                         → homepage
├── GET  /contact_us               → contact form
├── POST /contact_us/submit        → submit contact
├── GET  /profile/{user?}          → profilo (auth)
├── PUT  /profile/avatar/{user}    → change avatar (auth)
├── DELETE /user/destroy           → elimina account (auth)
├── /games/*                       → CRUD Games
└── /bossArea/*                    → CRUD Console/Boss
```

---

## 1. 🧠 Domain Driven Context (Cruciale per AI)

### 1.1 Terminologia del Dominio
L'applicazione gestisce entità basate sull'universo "Dark Souls".
**⚠️ ATTENZIONE:** Esiste una discrepanza terminologica critica nel database attuale.

| Termine nel Codice | Significato Reale (Dominio) | Note per l'AI |
|--------------------|-----------------------------|---------------|
| `Console` (Model) | **BOSS** del gioco | Non confondere con hardware/videogame consoles. Un "Console" è un nemico. |
| `Game` (Model) | Videogioco della saga | Titoli come Dark Souls 1, 2, 3, Bloodborne, etc. |
| `Product` (Field) | Software House/Brand | Es. FromSoftware, Bandai Namco. |
| `Brand` (Field in Console) | **Debolezza** del Boss | Campo che indica la vulnerabilità del boss |

### 1.2 Relazioni Core (Verificate ✅)
* **User** `hasMany` **Games** → Un utente può creare più giochi
* **User** `hasMany` **Consoles** (Bosses) → Un utente può creare più boss
* **Game** `belongsToMany` **Console** (pivot: `console_game`) → Many-to-Many
    * *Logica:* Un Boss può apparire in più giochi; un Gioco ha molti boss.

### 1.3 Schema Database Pivot
```
console_game
├── id
├── console_id (FK → consoles.id)
├── game_id (FK → games.id)
└── timestamps
```

---

## 2. 🏗️ Struttura Architetturale (MVC)

Il progetto segue lo standard **Laravel MVC**.

### 2.1 Struttura delle Directory e Responsabilità

```text
app/
├── Models/          # Entità Eloquent (User, Game, Console)
├── Http/
│   ├── Controllers/ # Logica di orchestrazione
│   │   ├── FrontController.php   # Logica pubblica (Home, Contatti)
│   │   ├── UserController.php    # Logica Utente (Profilo, Avatar)
│   │   ├── GameController.php    # CRUD Giochi (Richiede Auth per modifiche)
│   │   └── ConsoleController.php # CRUD Boss (Richiede Auth per modifiche)
│   └── Requests/    # Validazione Input (GameRequest, ConsoleRequest)
├── Actions/         # Logica Business isolata (Fortify)
└── Policies/        # ✅ Logica di Autorizzazione (GamePolicy, ConsolePolicy)

### 2.2 Flow Autorizzazione (DA IMPLEMENTARE)

```text
Request → Middleware(auth) → Controller → $this->authorize() → Policy → Action
                                              ↑
                                    ATTUALMENTE MANCANTE
```

**Stato Attuale (Errato):**
```php
// GameController@edit - Linea 64-67
if ($game->user_id != Auth::id()){
    return redirect(route('homepage'))->with('accessDenied','...');
}
```

**Implementazione Corretta:**
```php
// Usare Policy invece di controlli manuali
$this->authorize('update', $game);
```

### 2.3 Gestione File Storage (DA IMPLEMENTARE)

| Tipo File | Path Storage | Controller | Metodo Eliminazione |
|-----------|--------------|------------|---------------------|
| Game Cover | `public/covers` | GameController | ❌ Mancante |
| Console Logo | `public/logos` | ConsoleController | ❌ Mancante |
| User Avatar | `public/avatars` | UserController | ❌ Mancante |

**Pattern da Implementare:**
```php
use Illuminate\Support\Facades\Storage;

// Prima di update/delete
if ($model->image_field) {
    Storage::delete($model->image_field);
}
```

---

## 3. 📋 TODO LIST CORRETTA E AGGIORNATA

### 🔴 CRITICI - Priorità Massima

#### TODO #1: Implementare Policies nei Controller
**Linee Specifiche da Modificare:**

| File | Metodo | Linee | Azione |
|------|--------|-------|--------|
| `GameController.php` | `edit()` | 64-67 | Sostituire if con `$this->authorize('update', $game)` |
| `GameController.php` | `update()` | 76-78 | Sostituire if con `$this->authorize('update', $game)` |
| `GameController.php` | `destroy()` | 101+ | Aggiungere `$this->authorize('delete', $game)` |
| `ConsoleController.php` | `edit()` | 69-71 | Sostituire if con `$this->authorize('update', $console)` |
| `ConsoleController.php` | `update()` | 84-86 | Sostituire if con `$this->authorize('update', $console)` |
| `ConsoleController.php` | `destroy()` | 109+ | Aggiungere `$this->authorize('delete', $console)` |

#### TODO #2: Gestione File Orfani
**File da Modificare:**
- `GameController.php` → `update()`, `destroy()`
- `ConsoleController.php` → `update()`, `destroy()`
- `UserController.php` → `changeAvatar()`, `deleteAvatar()`

#### TODO #3: Aggiungere Autorizzazione a destroy()
**PROBLEMA CRITICO:** I metodi `destroy()` non verificano se l'utente è il proprietario!

### 🟠 IMPORTANTI

#### TODO #4: Creare Form Requests Mancanti
- [ ] `UserAvatarRequest.php` - Validazione avatar upload
- [ ] `ContactRequest.php` - Validazione form contatti

#### TODO #5: Testing
- [ ] Feature tests per CRUD completo
- [ ] Unit tests per relazioni e policies

### 🟡 MIGLIORAMENTI

#### TODO #6: Refactoring Console → Boss
- Rinominare model, controller, policy, request, views, tabelle
- Route `/bossArea/*` già corrette ✅

---

## 4. 📊 Metriche Codebase

| Metrica | Valore |
|---------|--------|
| Models | 3 (User, Game, Console) |
| Controllers | 5 (incluso Controller base) |
| Policies | 2 (GamePolicy, ConsolePolicy) |
| Form Requests | 2 (GameRequest, ConsoleRequest) |
| Migrations | 12 |
| Views | 8+ cartelle/file |
| Routes Web | ~20 |

---

## 5. 🔐 Sicurezza - Stato Attuale

| Check | Stato | Note |
|-------|-------|------|
| CSRF Protection | ✅ | Default Laravel |
| XSS Protection | ✅ | Blade escaping |
| SQL Injection | ✅ | Eloquent ORM |
| Auth Middleware | ✅ | Implementato |
| Authorization Policies | ⚠️ | Esistono ma non usate |
| File Upload Validation | ✅ | Presente in Requests |
| Rate Limiting | ❌ | Da implementare |

---

## 6. 🎯 Prossimi Step Raccomandati (in ordine)

1. **[URGENTE]** Implementare `$this->authorize()` in tutti i metodi CRUD
2. **[URGENTE]** Aggiungere controllo autorizzazione in `destroy()`
3. **[IMPORTANTE]** Implementare eliminazione file con `Storage::delete()`
4. **[IMPORTANTE]** Creare test automatici
5. **[MIGLIORAMENTO]** Refactoring Console → Boss
6. **[MIGLIORAMENTO]** Creare Request per validazione inline rimanente

---

**Ultima Analisi:** 8 Gennaio 2026  
**Analizzato da:** GitHub Copilot  
**Prossima Revisione Consigliata:** Dopo implementazione TODO #1-#3