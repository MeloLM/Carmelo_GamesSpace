# 🎮 Souls Space - Guida Completa per Sviluppatori e Agenti AI

> **"La Bibbia del Progetto"** - Questo documento è la guida definitiva per chiunque debba lavorare su questo progetto.

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.2-7952B3?style=flat-square&logo=bootstrap)](https://getbootstrap.com)

---

## 📋 Indice
1. [Panoramica Progetto](#panoramica-progetto)
2. [Stack Tecnologico](#stack-tecnologico)
3. [Architettura e Struttura](#architettura-e-struttura)
4. [Database e Relazioni](#database-e-relazioni)
5. [Routing e Controllers](#routing-e-controllers)
6. [Autenticazione](#autenticazione)
7. [Views e Frontend](#views-e-frontend)
8. [Bug Corretti (v2.0)](#bug-corretti-v20)
9. [Miglioramenti Futuri](#miglioramenti-futuri)
10. [Istruzioni per Sviluppatori/AI](#istruzioni-per-sviluppatori-ai)
11. [Comandi Utili](#comandi-utili)
12. [Changelog](#changelog)

---

## 🎯 Panoramica Progetto

**Souls Space** è una piattaforma web dedicata alla saga Dark Souls/Demon Souls. Permette agli utenti di:

- 📖 Visualizzare e creare schede di videogiochi della saga
- 👹 Gestire una "Boss Area" con informazioni sui boss del gioco
- 👤 Registrarsi, effettuare login e gestire il proprio profilo
- 📧 Contattare gli amministratori via email
- 🖼️ Caricare avatar personalizzati e immagini per i contenuti

### Contesto Tematico
La terminologia "Console" nel codice NON si riferisce alle console di gioco, ma ai **BOSS** del videogioco Dark Souls. Questo è fondamentale per capire il dominio dell'applicazione.

---

## 🛠️ Stack Tecnologico

| Tecnologia | Versione | Uso |
|------------|----------|-----|
| **PHP** | ^8.1 | Backend |
| **Laravel** | ^10.0 | Framework |
| **Laravel Fortify** | ^1.16 | Autenticazione |
| **Laravel Sanctum** | ^3.2 | API Tokens |
| **Bootstrap** | ^5.2.3 | UI Framework |
| **Vite** | ^4.0.0 | Build Tool |
| **MySQL/SQLite** | - | Database |
| **Swiper.js** | ^9 (CDN) | Carousel |

---

## 🏗️ Architettura e Struttura

### Directory Principali

```
📁 app/
├── 📁 Actions/Fortify/     # Azioni autenticazione (registrazione, password)
├── 📁 Http/
│   ├── 📁 Controllers/     # 4 Controller principali
│   │   ├── FrontController.php    # Homepage, Contact, Profile pubblico
│   │   ├── GameController.php     # CRUD Giochi
│   │   ├── ConsoleController.php  # CRUD Boss (chiamati "Console")
│   │   └── UserController.php     # Profilo, Avatar, Account
│   ├── 📁 Middleware/      # Middleware standard Laravel
│   └── 📁 Requests/        # Form Request Validation
│       ├── GameRequest.php
│       └── ConsoleRequest.php
├── 📁 Mail/               # Mailable per Contact Form
│   └── ContactMail.php
├── 📁 Models/             # 3 Modelli Eloquent
│   ├── User.php
│   ├── Game.php
│   └── Console.php
└── 📁 Providers/          # Service Providers

📁 resources/
├── 📁 css/                # Stili custom (style.css, btn.css, card.css, etc.)
├── 📁 js/                 # JavaScript (app.js, carousel.js)
└── 📁 views/
    ├── 📁 auth/           # Login, Register
    ├── 📁 components/     # Layout, Navbar, Footer, Carousel
    ├── 📁 console/        # CRUD Views Boss
    ├── 📁 game/           # CRUD Views Giochi
    ├── 📁 mail/           # Email templates
    ├── welcome.blade.php  # Homepage
    ├── profile.blade.php  # Profilo utente
    └── contact_us.blade.php

📁 database/migrations/    # 12 migrazioni
📁 public/media/           # Asset statici (immagini, icone)
📁 storage/app/public/     # Upload utenti (avatar, covers, logos)
```

---

## 🗄️ Database e Relazioni

### Schema ER

```
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│    USERS    │       │    GAMES    │       │  CONSOLES   │
├─────────────┤       ├─────────────┤       │   (BOSS)    │
│ id          │       │ id          │       ├─────────────┤
│ name        │       │ title       │       │ id          │
│ email       │       │ description │       │ name        │
│ password    │       │ price       │       │ brand       │
│ avatar      │       │ product     │       │ description │
│ created_at  │       │ cover       │       │ logo        │
│ updated_at  │       │ user_id (FK)│       │ user_id (FK)│
└──────┬──────┘       └──────┬──────┘       └──────┬──────┘
       │                     │                     │
       │    hasMany          │                     │
       ├────────────────────►│                     │
       │    hasMany                                │
       ├──────────────────────────────────────────►│
       │
       │         ┌──────────────────┐
       │         │   CONSOLE_GAME   │ (Pivot Table)
       │         │  Many-to-Many    │
       │         ├──────────────────┤
       │         │ id               │
       │         │ console_id (FK)  │
       │         │ game_id (FK)     │
       │         └──────────────────┘
```

### Relazioni Eloquent

| Model | Relazione | Con | Tipo |
|-------|-----------|-----|------|
| User | hasMany | Game | 1:N |
| User | hasMany | Console | 1:N |
| Game | belongsTo | User | N:1 |
| Game | belongsToMany | Console | N:M |
| Console | belongsTo | User | N:1 |
| Console | belongsToMany | Game | N:M |

### Campi Importanti

**Games:**
- `title` - Nome del gioco (unique)
- `description` - Descrizione completa
- `price` - Prezzo (float)
- `product` - Brand/produttore (max 200 char)
- `cover` - Path immagine copertina

**Consoles (Boss):**
- `name` - Nome del boss (unique)
- `brand` - Categoria/tipo
- `description` - Descrizione (min 20 char)
- `logo` - Path immagine

---

## 🛤️ Routing e Controllers

### Mappa Route Completa

#### Route Pubbliche
| Metodo | URI | Controller@Method | Nome |
|--------|-----|-------------------|------|
| GET | `/` | FrontController@homepage | homepage |
| GET | `/contact_us` | FrontController@contact_us | contact_us |
| POST | `/contact_us/submit` | FrontController@contact_us_submit | contact_us_submit |
| GET | `/games/index` | GameController@index | game.index |
| GET | `/games/show/{game}` | GameController@show | game.show |
| GET | `/bossArea/index` | ConsoleController@index | console.index |
| GET | `/bossArea/show/{console}` | ConsoleController@show | console.show |

#### Route Protette (Auth Required)
| Metodo | URI | Controller@Method | Nome |
|--------|-----|-------------------|------|
| GET | `/profile/{user?}` | UserController@profile | profile |
| PUT | `/profile/avatar/{user}` | UserController@changeAvatar | changeAvatar |
| PUT | `/profile/avatar/{user}/delete` | UserController@deleteAvatar | deleteAvatar |
| DELETE | `/user/destroy` | UserController@destroy | user.destroy |
| GET | `/games/create` | GameController@create_game | game.create |
| POST | `/games/store` | GameController@store | game.store |
| GET | `/games/edit/{game}` | GameController@edit | game.edit |
| PUT | `/games/update/{game}` | GameController@update | game.update |
| DELETE | `/games/destroy/{game}` | GameController@destroy | game.destroy |
| GET | `/bossArea/create` | ConsoleController@create | console.create |
| POST | `/bossArea/store` | ConsoleController@store | console.store |
| GET | `/bossArea/edit/{console}` | ConsoleController@edit | console.edit |
| PUT | `/bossArea/update/{console}` | ConsoleController@update | console.update |
| DELETE | `/bossArea/destroy/{console}` | ConsoleController@destroy | console.destroy |

### Middleware Applicati
- `auth` - Protegge tutte le route di creazione/modifica/eliminazione
- Le route `index` e `show` sono pubbliche per visualizzazione

---

## 🔐 Autenticazione

### Sistema: Laravel Fortify

**File di configurazione:** `config/fortify.php`

**Views personalizzate:**
- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`

**Features abilitate:**
- Registrazione
- Login/Logout
- Reset Password
- Two-Factor Authentication (predisposto)

**Flusso registrazione:** `App\Actions\Fortify\CreateNewUser.php`

### Controllo Autorizzazioni nei Controller

```php
// GameController e ConsoleController usano:
if ($game->user_id != Auth::id()){
    return redirect(route('homepage'))->with('accessDenied','You are not authorized!');
}
```

---

## 🎨 Views e Frontend

### Sistema Component-Based

**Layout principale:** `resources/views/components/layout.blade.php`

Usa Blade Components:
```blade
<x-layout>
    <x-navbar />
    {{$slot}}
    <x-footer />
</x-layout>
```

### CSS Custom Variables

```css
:root{
    --first-color: rgb(0,0,0);
    --second-color: rgb(14,14,14);
    --main-color: rgb(224,136,33);    /* Arancione Dark Souls */
    --hover-color: rgba(224, 135, 33, 0.804);
}
```

### Classi CSS Principali

| Classe | Uso |
|--------|-----|
| `.mainBg` | Background principale con immagine |
| `.sectionBg` | Sezioni con GIF animata |
| `.formBg` | Background form |
| `.profileBg`, `.profileBg2` | Pagina profilo |
| `.custom-card` | Card prodotti (300x450px) |
| `.btn-ds` | Bottoni custom arancioni |

### File Upload
I file vengono salvati in:
- `storage/app/public/avatars/` - Avatar utenti
- `storage/app/public/covers/` - Copertine giochi
- `storage/app/public/logos/` - Loghi boss

**IMPORTANTE:** Eseguire `php artisan storage:link` per creare il symlink.

---

## 🐛 Bug Corretti (v2.0)

### ✅ CORRETTO #1 - Errore Sintassi in GameController

**File:** `app/Http/Controllers/GameController.php`

```php
// ❌ ERA (ERRORE):
'description'->$request->description,

// ✅ CORRETTO:
'description' => $request->description,
```

### ✅ CORRETTO #2 - Variabile senza $ in FrontController

**File:** `app/Http/Controllers/FrontController.php`

```php
// ❌ ERA:
if(!user){

// ✅ CORRETTO (metodo rimosso - codice duplicato)
```

### ✅ CORRETTO #3 - attach() invece di sync() negli Update

**Problema:** `attach()` aggiungeva relazioni duplicate invece di sostituirle.

```php
// ❌ ERA:
$game->consoles()->attach($request->console);

// ✅ CORRETTO:
$game->consoles()->sync($request->consoles);
```

### ✅ CORRETTO #4 - Codice Duplicato Rimosso

Metodi `profile()` e `changeAvatar()` rimossi da `FrontController.php` - esistevano già in `UserController.php`.

### ✅ CORRETTO #5 - Path Upload Inconsistente

```php
// ❌ ERA:
'cover'=>$request->file('cover')->store('public/foto'),

// ✅ CORRETTO:
'cover'=>$request->file('cover')->store('public/covers'),
```

### ✅ CORRETTO #6 - Messaggio Flash Errato

```php
// ❌ ERA:
->with('houseUpdated', 'Hai modificato annuncio');

// ✅ CORRETTO:
->with('consoleUpdated', 'Hai modificato il boss!');
```

### ✅ CORRETTO #7 - Parametro Inutile in destroy()

```php
// ❌ ERA:
public function destroy(Console $console, Game $game)

// ✅ CORRETTO:
public function destroy(Console $console)
```

### ✅ CORRETTO #8 - Typo nel Commento

```php
// ❌ ERA:
//CRUD - CREATE READ UPTADE DELETE

// ✅ CORRETTO:
//CRUD - CREATE READ UPDATE DELETE
```

### ✅ CORRETTO #9 - Validazione Price non Numerica

```php
// ❌ ERA:
'price'=> 'required',

// ✅ CORRETTO:
'price'=> 'required|numeric|min:0',
```

### ✅ CORRETTO #10 - Messaggio Duplicato in ConsoleRequest

```php
// ❌ ERA (chiave duplicata):
'name.required' => 'Devi mettere il nome della console!',
...
'name.required'=>'Questa console esiste già'

// ✅ CORRETTO:
'name.required' => 'Devi mettere il nome del boss!',
'name.unique' => 'Questo boss esiste già!',
```

### ✅ CORRETTO #11 - N+1 Query Problem

```php
// ❌ ERA:
$games = Game::all();

// ✅ CORRETTO (Eager Loading):
$games = Game::with('user', 'consoles')->get();
```

### ✅ CORRETTO #12 - Route Profile senza Auth Middleware

```php
// ❌ ERA:
Route::get('/profile/{user?}', [UserController::class,'profile'])->name('profile');

// ✅ CORRETTO:
Route::middleware('auth')->group(function () {
    Route::get('/profile/{user?}', [UserController::class,'profile'])->name('profile');
    // ...altre route protette
});
```

### ✅ CORRETTO #13 - Nome Parametro Select Inconsistente

```php
// ❌ ERA:
<select name="console" id="console">

// ✅ CORRETTO:
<select name="consoles[]" id="consoles">
```

### ✅ CORRETTO #14 - old() Vuoti in console/edit.blade

```blade
{{-- ❌ ERA: --}}
value="{{old('name')}}"

{{-- ✅ CORRETTO: --}}
value="{{old('name', $console->name)}}"
```

### ✅ CORRETTO #15 - ID Duplicato in register.blade

```blade
{{-- ❌ ERA: --}}
<input type="password" id="password" name="password_confirmation">

{{-- ✅ CORRETTO: --}}
<input type="password" id="password_confirmation" name="password_confirmation">
```

### ✅ CORRETTO #16 - H6 Vuoto Inutile in profile.blade

Rimosso `<h6 class="text-muted"></h6>` vuoto.

### ✅ CORRETTO #17 - Mancanza hasFile() Check

```php
// ❌ ERA:
if($request->cover){

// ✅ CORRETTO:
if($request->hasFile('cover')){
```

### ✅ CORRETTO #18 - Naming Route Inconsistente

```php
// ❌ ERA:
->name('createGame')
->name('games.store')

// ✅ CORRETTO:
->name('game.create')
->name('game.store')
```

### ✅ CORRETTO #19 - Mancanza Auth Check in Update

Aggiunto controllo autorizzazione in `GameController@update` e `ConsoleController@update`.

### ✅ CORRETTO #20 - Validazione Avatar Mancante

Aggiunta validazione per upload avatar:
```php
$request->validate([
    'avatar' => 'required|image|max:2048',
]);
```

### ✅ CORRETTO #21 - Validazione Contact Form

Aggiunta validazione per il form di contatto:
```php
$request->validate([
    'name' => 'required|min:2',
    'email' => 'required|email',
    'message' => 'required|min:10',
]);
```

### ✅ CORRETTO #22 - Metodo Detach Inefficiente

```php
// ❌ ERA:
foreach($game->consoles as $console){
    $game->consoles()->detach($console->id);
}

// ✅ CORRETTO:
$game->consoles()->detach();
```

### ✅ CORRETTO #23 - Aggiunto Middleware in UserController

```php
public function __construct(){
    $this->middleware('auth')->except('login', 'register');
}
```

### ✅ CORRETTO #24 - UserController profile() con parametro

```php
// ❌ ERA:
public function profile(){

// ✅ CORRETTO:
public function profile(User $user = null){
```

### ✅ CORRETTO #25 - Messaggi Validazione Aggiornati

Messaggi in italiano corretti e coerenti con il tema "Boss" invece di "Console".

---

## 💡 Miglioramenti Futuri

### 🔴 Priorità Alta

1. **Policy/Gate per Autorizzazioni**
   ```php
   // Creare GamePolicy e ConsolePolicy
   php artisan make:policy GamePolicy --model=Game
   php artisan make:policy ConsolePolicy --model=Console
   ```

2. **Soft Deletes**
   ```php
   use SoftDeletes;
   ```

3. **Paginazione per Liste Lunghe**
   ```php
   $games = Game::with('user')->paginate(12);
   ```

### 🟡 Priorità Media

4. **Resource Controllers**
   - Convertire le route in Resource Controllers per maggiore pulizia

5. **Form Request per Update**
   - Creare `GameUpdateRequest` senza regola `unique` per permettere aggiornamenti

6. **API Endpoints**
   - Creare API REST per future integrazioni mobile

7. **Caching**
   ```php
   $games = Cache::remember('games', 3600, function () {
       return Game::with('user')->get();
   });
   ```

### 🟢 Priorità Bassa

8. **Image Optimization**
   - Usare Intervention Image per resize/compress

9. **Search Functionality**
   - Aggiungere ricerca giochi/boss con Scout

10. **Admin Dashboard**
    - Pannello admin separato per gestione contenuti

11. **Rinominare "Console" in "Boss"**
    - Per maggiore chiarezza semantica

12. **Testing**
    - Aggiungere test unitari e feature test

---

## 🤖 Istruzioni per Sviluppatori/AI

### Prima di Modificare

1. **Capire il dominio:** "Console" = Boss, non console di gioco
2. **Verificare relazioni:** Many-to-Many tra Games e Consoles
3. **Controllare middleware:** Auth richiesto per CRUD operations
4. **Storage link:** Assicurarsi che esista `php artisan storage:link`

### Dove Mettere le Mani

| Tipo Modifica | File Principali |
|---------------|-----------------|
| Nuova entità | `Models/`, `migrations/`, `Controllers/` |
| Nuova pagina | `views/`, `routes/web.php` |
| Stili | `resources/css/style.css` |
| Validazione | `Http/Requests/` |
| Email | `Mail/`, `views/mail/` |
| Auth | `Actions/Fortify/`, `config/fortify.php` |

### Pattern da Seguire

```php
// Controller standard per nuova entità
public function __construct(){
    $this->middleware('auth')->except('index', 'show');
}

// Store con relazione
public function store(EntityRequest $request){
    $entity = Entity::create([
        'field' => $request->field,
        'user_id' => Auth::id(),
    ]);
    
    $entity->relations()->attach($request->relations);
    
    return redirect(route('entity.index'))
        ->with('success', 'Messaggio');
}

// Update con controllo ownership
public function update(Request $request, Entity $entity){
    if ($entity->user_id != Auth::id()){
        return redirect(route('homepage'))
            ->with('accessDenied', 'Not authorized');
    }
    
    $entity->update([...]);
    $entity->relations()->sync($request->relations);
    
    return redirect()->back()->with('success', 'Updated');
}
```

### Convenzioni Naming

- **Route names:** `entity.action` (es: `game.index`, `console.create`)
- **Views:** `folder/action.blade.php` (es: `game/show.blade.php`)
- **Form Requests:** `EntityRequest.php`
- **Flash messages:** `with('actionEntity', 'messaggio')`

---

## ⚡ Comandi Utili

```bash
# Setup iniziale
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link

# Development
npm run dev                    # Avvia Vite dev server
php artisan serve              # Avvia server PHP

# Produzione
npm run build                  # Build assets

# Database
php artisan migrate:fresh      # Reset DB
php artisan migrate:fresh --seed  # Reset + Seed

# Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Generazione
php artisan make:model EntityName -mcr  # Model + Migration + Controller Resource
php artisan make:request EntityRequest
php artisan make:policy EntityPolicy --model=Entity
php artisan make:mail EmailName

# Debug
php artisan route:list         # Lista tutte le route
php artisan tinker              # REPL PHP
```

---

## 📝 Changelog

### v2.0.0 (Gennaio 2026) - Major Bug Fix Release

#### 🔧 Bug Fixes (25 correzioni totali)

**Controller:**
- ✅ Fix errore sintassi critico `description->` in GameController
- ✅ Fix variabile `$user` mancante in FrontController
- ✅ Sostituito `attach()` con `sync()` per evitare duplicati
- ✅ Rimosso codice duplicato da FrontController
- ✅ Fix path upload inconsistente (`foto` → `covers`)
- ✅ Fix messaggio flash errato (`houseUpdated` → `consoleUpdated`)
- ✅ Rimosso parametro inutile `Game $game` da `destroy()`
- ✅ Fix typo `UPTADE` → `UPDATE`
- ✅ Aggiunto controllo auth in metodi update
- ✅ Ottimizzato detach() delle relazioni
- ✅ Aggiunto middleware auth a UserController
- ✅ Aggiunto supporto parametro opzionale in `profile()`

**Validazione:**
- ✅ Aggiunta validazione `numeric|min:0` per price
- ✅ Fix messaggio duplicato in ConsoleRequest
- ✅ Aggiunta validazione avatar upload
- ✅ Aggiunta validazione contact form

**Performance:**
- ✅ Implementato Eager Loading in tutti gli index

**Route:**
- ✅ Aggiunto middleware group per route protette
- ✅ Standardizzato naming routes (`game.create`, `game.store`)

**Views:**
- ✅ Fix nome parametro select (`console` → `consoles[]`)
- ✅ Fix `old()` vuoti in console/edit.blade
- ✅ Fix ID duplicato in register.blade
- ✅ Rimosso h6 vuoto in profile.blade
- ✅ Aggiornato route name in navbar
- ✅ Aggiornato route name in createGame form

### v1.0.0 (Marzo 2023) - Initial Release
- Implementazione iniziale del progetto
- CRUD Games e Consoles (Boss)
- Sistema autenticazione con Fortify
- Upload immagini
- Form contatto con email

---

## 👥 Crediti

Progetto sviluppato come esercizio didattico per imparare Laravel.

Tema: **Dark Souls / Demon Souls** - La famosa serie di Action RPG.

---

*Ultimo aggiornamento: Gennaio 2026*
