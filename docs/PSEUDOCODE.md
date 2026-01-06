# 🧭 Souls Space - Documento di Navigazione Pseudocode

> **Scopo:** Guida rapida per orientarsi nel progetto. Pseudocode delle logiche principali.

---

## 📐 Domain Model (Entità)

```pseudocode
ENTITY User {
    id: INT PRIMARY KEY
    name: STRING
    email: STRING UNIQUE
    password: STRING (hashed)
    avatar: STRING NULLABLE (file path)
    timestamps: CREATED_AT, UPDATED_AT
    
    RELATIONS:
        games: HAS_MANY -> Game
        bosses: HAS_MANY -> Console (Boss)
}

ENTITY Game {
    id: INT PRIMARY KEY
    title: STRING UNIQUE
    description: TEXT
    price: DECIMAL
    product: STRING (software house)
    cover: STRING NULLABLE (file path)
    user_id: FOREIGN KEY -> User
    timestamps: CREATED_AT, UPDATED_AT
    
    RELATIONS:
        user: BELONGS_TO -> User
        bosses: BELONGS_TO_MANY -> Console (via console_game)
}

ENTITY Console (ALIAS: Boss) {
    # ⚠️ ATTENZIONE: Nel codice = "Console", nel dominio = "BOSS"
    id: INT PRIMARY KEY
    name: STRING UNIQUE
    brand: STRING (categoria boss)
    description: TEXT (min 20 chars)
    logo: STRING NULLABLE (file path)
    user_id: FOREIGN KEY -> User
    timestamps: CREATED_AT, UPDATED_AT
    
    RELATIONS:
        user: BELONGS_TO -> User
        games: BELONGS_TO_MANY -> Game (via console_game)
}

PIVOT_TABLE console_game {
    id: INT PRIMARY KEY
    console_id: FOREIGN KEY -> Console
    game_id: FOREIGN KEY -> Game
}
```

---

## 🔄 Flow: Autenticazione

```pseudocode
FLOW Registration:
    INPUT: name, email, password, password_confirmation
    
    VALIDATE:
        name: required, string, max:255
        email: required, email, unique:users
        password: required, confirmed, min:8
    
    PROCESS:
        hash_password = Hash(password)
        CREATE User(name, email, hash_password)
        LOGIN(user)
        REDIRECT -> homepage
    
FLOW Login:
    INPUT: email, password
    
    PROCESS:
        user = FIND User WHERE email = input.email
        IF verify(password, user.hash_password):
            SESSION.create(user)
            REDIRECT -> homepage
        ELSE:
            RETURN error "Invalid credentials"

FLOW Logout:
    PROCESS:
        SESSION.destroy()
        REDIRECT -> homepage
```

---

## 🎮 Flow: CRUD Games

```pseudocode
CONTROLLER GameController:

    METHOD index():
        # Lista pubblica di tutti i giochi
        games = Game.with('user', 'consoles').get()
        RETURN view('game.index', games)
    
    METHOD show(game_id):
        # Dettaglio singolo gioco
        game = Game.with('user', 'consoles').find(game_id)
        RETURN view('game.show', game)
    
    METHOD create():
        # Form creazione (RICHIEDE AUTH)
        REQUIRE_AUTH()
        bosses = Console.all()
        RETURN view('game.create', bosses)
    
    METHOD store(request):
        # Salva nuovo gioco (RICHIEDE AUTH)
        REQUIRE_AUTH()
        
        VALIDATE(request) via GameRequest:
            title: required, unique:games, min:3
            description: required, min:10
            price: required, numeric, min:0
            product: required, max:200
            cover: nullable, image, max:2048
            consoles: nullable, array
        
        IF request.hasFile('cover'):
            cover_path = request.file('cover').store('public/covers')
        
        game = Game.create({
            title: request.title,
            description: request.description,
            price: request.price,
            product: request.product,
            cover: cover_path OR null,
            user_id: AUTH.id
        })
        
        IF request.consoles:
            game.consoles().attach(request.consoles)
        
        REDIRECT -> game.index WITH success_message
    
    METHOD edit(game_id):
        # Form modifica (RICHIEDE AUTH + OWNERSHIP)
        REQUIRE_AUTH()
        game = Game.find(game_id)
        
        IF game.user_id != AUTH.id:
            REDIRECT -> homepage WITH error "Not authorized"
        
        bosses = Console.all()
        RETURN view('game.edit', game, bosses)
    
    METHOD update(request, game_id):
        # Aggiorna gioco (RICHIEDE AUTH + OWNERSHIP)
        REQUIRE_AUTH()
        game = Game.find(game_id)
        
        IF game.user_id != AUTH.id:
            REDIRECT -> homepage WITH error "Not authorized"
        
        VALIDATE(request)
        
        update_data = {
            title, description, price, product
        }
        
        IF request.hasFile('cover'):
            DELETE_OLD_FILE(game.cover)
            update_data.cover = store_new_file()
        
        game.update(update_data)
        game.consoles().sync(request.consoles)  # ⚠️ SYNC non ATTACH!
        
        REDIRECT -> game.show WITH success_message
    
    METHOD destroy(game_id):
        # Elimina gioco (RICHIEDE AUTH + OWNERSHIP)
        REQUIRE_AUTH()
        game = Game.find(game_id)
        
        IF game.user_id != AUTH.id:
            REDIRECT -> homepage WITH error "Not authorized"
        
        game.consoles().detach()  # Rimuove relazioni pivot
        DELETE_FILE(game.cover)
        game.delete()
        
        REDIRECT -> game.index WITH success_message
```

---

## 👹 Flow: CRUD Boss (Console)

```pseudocode
CONTROLLER ConsoleController:
    # Logica identica a GameController
    # Differenze principali:
    
    ENTITY_NAME: Console (rappresenta un BOSS)
    IMAGE_FIELD: logo (invece di cover)
    STORAGE_PATH: 'public/logos'
    RELATION_NAME: games (invece di consoles)
    
    # Validazione specifica (ConsoleRequest):
    VALIDATE:
        name: required, unique:consoles, min:2
        brand: required
        description: required, min:20
        logo: nullable, image, max:2048
        games: nullable, array
```

---

## 👤 Flow: Profilo Utente

```pseudocode
CONTROLLER UserController:

    METHOD profile(user = null):
        # Visualizza profilo (proprio o di altri)
        REQUIRE_AUTH()
        
        IF user IS NULL:
            user = AUTH.user
        
        user_games = Game.where('user_id', user.id).get()
        user_bosses = Console.where('user_id', user.id).get()
        
        RETURN view('profile', user, user_games, user_bosses)
    
    METHOD changeAvatar(request, user_id):
        # Cambia avatar (solo proprio profilo)
        REQUIRE_AUTH()
        
        IF user_id != AUTH.id:
            REDIRECT WITH error
        
        VALIDATE:
            avatar: required, image, max:2048
        
        IF AUTH.user.avatar EXISTS:
            DELETE_OLD_FILE(AUTH.user.avatar)
        
        avatar_path = request.file('avatar').store('public/avatars')
        AUTH.user.update({ avatar: avatar_path })
        
        REDIRECT -> profile WITH success
    
    METHOD deleteAvatar(user_id):
        # Rimuove avatar
        REQUIRE_AUTH()
        DELETE_FILE(AUTH.user.avatar)
        AUTH.user.update({ avatar: null })
        REDIRECT -> profile
    
    METHOD destroy():
        # Elimina account utente
        REQUIRE_AUTH()
        
        # Rimuove tutti i contenuti dell'utente
        FOR game IN AUTH.user.games:
            game.consoles().detach()
            DELETE_FILE(game.cover)
            game.delete()
        
        FOR boss IN AUTH.user.consoles:
            boss.games().detach()
            DELETE_FILE(boss.logo)
            boss.delete()
        
        DELETE_FILE(AUTH.user.avatar)
        AUTH.user.delete()
        LOGOUT()
        
        REDIRECT -> homepage
```

---

## 📧 Flow: Contact Form

```pseudocode
CONTROLLER FrontController:

    METHOD contact_us():
        RETURN view('contact_us')
    
    METHOD contact_us_submit(request):
        VALIDATE:
            name: required, min:2
            email: required, email
            message: required, min:10
        
        SEND_EMAIL ContactMail TO admin_email WITH:
            sender_name: request.name
            sender_email: request.email
            message: request.message
        
        REDIRECT -> contact_us WITH success
```

---

## 🛤️ Routing Map

```pseudocode
# ==================== PUBLIC ROUTES ====================
GET  /                          -> FrontController@homepage        [homepage]
GET  /contact_us                -> FrontController@contact_us      [contact_us]
POST /contact_us/submit         -> FrontController@contact_us_submit [contact_us_submit]

GET  /games/index               -> GameController@index            [game.index]
GET  /games/show/{game}         -> GameController@show             [game.show]

GET  /bossArea/index            -> ConsoleController@index         [console.index]
GET  /bossArea/show/{console}   -> ConsoleController@show          [console.show]

# ==================== AUTH ROUTES (Fortify) ====================
GET  /login                     -> LoginView                       [login]
POST /login                     -> LoginAction
GET  /register                  -> RegisterView                    [register]
POST /register                  -> RegisterAction
POST /logout                    -> LogoutAction                    [logout]

# ==================== PROTECTED ROUTES ====================
MIDDLEWARE('auth'):

    # Profile
    GET    /profile/{user?}            -> UserController@profile       [profile]
    PUT    /profile/avatar/{user}      -> UserController@changeAvatar  [changeAvatar]
    PUT    /profile/avatar/{user}/delete -> UserController@deleteAvatar [deleteAvatar]
    DELETE /user/destroy               -> UserController@destroy       [user.destroy]

    # Games CRUD
    GET    /games/create               -> GameController@create        [game.create]
    POST   /games/store                -> GameController@store         [game.store]
    GET    /games/edit/{game}          -> GameController@edit          [game.edit]
    PUT    /games/update/{game}        -> GameController@update        [game.update]
    DELETE /games/destroy/{game}       -> GameController@destroy       [game.destroy]

    # Boss CRUD
    GET    /bossArea/create            -> ConsoleController@create     [console.create]
    POST   /bossArea/store             -> ConsoleController@store      [console.store]
    GET    /bossArea/edit/{console}    -> ConsoleController@edit       [console.edit]
    PUT    /bossArea/update/{console}  -> ConsoleController@update     [console.update]
    DELETE /bossArea/destroy/{console} -> ConsoleController@destroy    [console.destroy]
```

---

## 📁 File Structure Reference

```pseudocode
PROJECT_ROOT/
│
├── app/
│   ├── Models/
│   │   ├── User.php          # Utente con relazioni games, consoles
│   │   ├── Game.php          # Gioco con relazioni user, consoles
│   │   └── Console.php       # Boss con relazioni user, games
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── FrontController.php   # Homepage, Contact
│   │   │   ├── UserController.php    # Profile, Avatar
│   │   │   ├── GameController.php    # CRUD Giochi
│   │   │   └── ConsoleController.php # CRUD Boss
│   │   │
│   │   └── Requests/
│   │       ├── GameRequest.php       # Validazione giochi
│   │       └── ConsoleRequest.php    # Validazione boss
│   │
│   ├── Mail/
│   │   └── ContactMail.php           # Email contatto
│   │
│   └── Policies/                     # [TODO] Autorizzazioni
│       ├── GamePolicy.php
│       └── ConsolePolicy.php
│
├── resources/views/
│   ├── welcome.blade.php             # Homepage
│   ├── profile.blade.php             # Profilo utente
│   ├── contact_us.blade.php          # Form contatto
│   │
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   │
│   ├── components/
│   │   ├── layout.blade.php          # Layout principale
│   │   ├── navbar.blade.php
│   │   ├── footer.blade.php
│   │   └── carousel.blade.php
│   │
│   ├── game/
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   │
│   └── console/                      # Boss views
│       ├── index.blade.php
│       ├── show.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
│
├── routes/
│   └── web.php                       # Tutte le route web
│
├── database/migrations/              # Schema DB
│
├── storage/app/public/               # Upload files
│   ├── avatars/
│   ├── covers/
│   └── logos/
│
└── docs/                             # Documentazione
    ├── PSEUDOCODE.md                 # Questo file
    ├── API.md                        # [TODO] API Reference
    └── CONTRIBUTING.md               # [TODO] Guida contributi
```

---

## ⚠️ Critical Notes per AI/Developers

```pseudocode
REMEMBER:
    1. "Console" nel codice = "BOSS" nel dominio (Dark Souls enemy)
    2. SEMPRE usare sync() per relazioni M:M negli update
    3. SEMPRE verificare ownership prima di edit/delete
    4. SEMPRE usare hasFile() prima di processare upload
    5. Eager Loading obbligatorio: with('user', 'consoles')
    6. Storage link richiesto: `php artisan storage:link`
    
NAMING CONVENTIONS:
    Route: entity.action (game.index, console.create)
    Views: folder/action.blade.php
    Flash: actionEntity ('gameCreated', 'consoleUpdated')
    
VALIDATION RULES:
    Images: 'image|max:2048' (max 2MB)
    Price: 'numeric|min:0'
    Description Boss: 'min:20'
```

---

*Generato automaticamente per navigazione progetto*
