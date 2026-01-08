# 📋 TODO - Souls Space Project Improvements
*Generato il: 8 Gennaio 2026*  
*Ultima Revisione: 8 Gennaio 2026 - Analisi Architetturale Completa*

---

## 🔴 CRITICI - Da Fare Subito

### 1. ⚠️ URGENTE: Aggiungere Autorizzazione ai metodi destroy()
**Priorità: CRITICA** | **Impatto: SICUREZZA**

**PROBLEMA SCOPERTO:** I metodi `destroy()` in entrambi i controller NON verificano se l'utente è il proprietario!

- [ ] Aggiungere `$this->authorize('delete', $game)` in `GameController@destroy` (linea 101)
- [ ] Aggiungere `$this->authorize('delete', $console)` in `ConsoleController@destroy` (linea 109)

**Rischio:** Qualsiasi utente autenticato può eliminare giochi/boss di altri utenti!

### 2. Implementare Policies nei Controller
**Priorità: ALTA** | **Impatto: SICUREZZA**

✅ **VERIFICATO:** Le Policies sono già registrate in `AuthServiceProvider` (linee 18-21)

- [ ] Sostituire controlli manuali con `$this->authorize()`:
  - `GameController.php` linea 64-67 (edit) → `$this->authorize('update', $game)`
  - `GameController.php` linea 76-78 (update) → `$this->authorize('update', $game)`
  - `ConsoleController.php` linea 69-71 (edit) → `$this->authorize('update', $console)`
  - `ConsoleController.php` linea 84-86 (update) → `$this->authorize('update', $console)`

**Motivo**: Le Policy esistono già (`GamePolicy.php`, `ConsolePolicy.php`) e sono registrate, ma non vengono usate. Il codice duplica logica di autorizzazione violando DRY.

### 3. Gestione File Orfani
**Priorità: ALTA** | **Impatto: STORAGE**

- [ ] Implementare `Storage::delete()` quando si elimina/aggiorna:
  - Game cover in `GameController@destroy`
  - Game cover in `GameController@update` (quando si carica nuova immagine)
  - Console logo in `ConsoleController@destroy`
  - Console logo in `ConsoleController@update` (quando si carica nuova immagine)
  - User avatar in `UserController@changeAvatar` (rimuovere vecchio avatar)
  - User avatar in `UserController@deleteAvatar`

**Esempio**:
```php
// Prima di eliminare o aggiornare
if($game->cover) {
    Storage::delete($game->cover);
}
```

**Motivo**: Attualmente i file rimangono in `storage/` anche dopo eliminazione record, sprecando spazio disco.

---

## 🟠 IMPORTANTI - Qualità del Codice

### 4. Validazione Inconsistente
**Priorità: MEDIA-ALTA**

- [ ] Creare `UserAvatarRequest` per validare upload avatar
- [ ] Creare `ContactRequest` per validare form contatti
- [ ] Spostare validazione inline da `UserController@changeAvatar` a Request dedicata
- [ ] Spostare validazione inline da `FrontController@contact_us_submit` a Request dedicata
- [ ] Unificare messaggi di errore in italiano in tutti i Request

**Motivo**: Validazione attualmente mischiata tra controller e Request. Serve consistenza.

### 5. Testing Assente
**Priorità: MEDIA-ALTA**

- [ ] Creare Feature Tests per:
  - `GameControllerTest.php`: CRUD completo + autorizzazioni
  - `ConsoleControllerTest.php`: CRUD completo + autorizzazioni
  - `UserControllerTest.php`: Profilo, avatar, eliminazione account
  - `FrontControllerTest.php`: Homepage, contact form
  - `AuthTest.php`: Login, registrazione, logout
- [ ] Creare Unit Tests per:
  - Relazioni Model (Game-User, Console-User, Game-Console)
  - Policy (GamePolicy, ConsolePolicy)
- [ ] Configurare GitHub Actions per CI/CD (vedi sezione dedicata)

**Motivo**: Progetto in produzione senza test automatici = alto rischio di regressioni.

### 6. Eager Loading Incompleto
**Priorità: MEDIA**

- [ ] Verificare query N+1 con Laravel Debugbar
- [ ] Aggiungere `with('consoles')` in `FrontController@homepage` se serve
- [ ] Considerare eager loading in `UserController@profile` per relazioni annidate

**Nota**: Già presente in `GameController@index` e `ConsoleController@index` ✅

### 7. Soft Deletes Mancante
**Priorità: MEDIA**

- [ ] Aggiungere trait `SoftDeletes` a:
  - `Game` model
  - `Console`/`Boss` model
- [ ] Creare migration `add_soft_deletes_to_games_and_consoles`
- [ ] Aggiungere metodi `restore()` e `forceDelete()` nei controller
- [ ] Aggiungere route per ripristino elementi eliminati
- [ ] Creare sezione "Cestino" nel profilo utente

**Motivo**: Permette recupero accidentale eliminazioni senza perdere dati.

---

## 🟡 MIGLIORAMENTI - Funzionalità

### 8. API REST
**Priorità: MEDIA** | **Stato: Pianificato in CHANGELOG**

- [ ] Creare API Controller in `app/Http/Controllers/Api/`
  - `Api/GameController` con metodi index, show, store, update, destroy
  - `Api/ConsoleController` con stessi metodi
- [ ] Implementare autenticazione con Sanctum (già installato)
- [ ] Documentare endpoints in `docs/API.md` (già esiste ma vuoto)
- [ ] Aggiungere rate limiting
- [ ] Testare con Postman/Insomnia

**Riferimento**: `docs/API.md` dice "TODO: Implementare API REST"

### 9. Sistema di Ricerca
**Priorità: MEDIA**

- [ ] Aggiungere barra di ricerca in `/games/index` per:
  - Titolo gioco
  - Developer (campo `product`)
  - Boss associati
- [ ] Aggiungere barra di ricerca in `/bossArea/index` per:
  - Nome boss
  - Debolezza (campo `brand`)
  - Giochi associati
- [ ] Considerare Laravel Scout per full-text search

### 10. Sistema di Rating/Recensioni
**Priorità: BASSA-MEDIA**

- [ ] Creare model `Review` con campi:
  - `user_id`, `game_id`, `rating` (1-5 stelle), `comment`, `timestamps`
- [ ] Aggiungere metodo `reviews()` in `Game` model
- [ ] Creare sezione recensioni in `game.show` view
- [ ] Policy per impedire multiple recensioni stesso utente/gioco

### 11. Admin Dashboard
**Priorità: BASSA-MEDIA** | **Stato: Pianificato in CHANGELOG**

- [ ] Aggiungere campo `is_admin` a tabella `users`
- [ ] Creare middleware `IsAdmin`
- [ ] Creare `AdminController` con:
  - Dashboard statistiche (totale giochi, boss, utenti)
  - Lista utenti con possibilità ban
  - Moderazione contenuti (approvare/rifiutare giochi/boss)
- [ ] Creare route `/admin/*` protette da middleware
- [ ] Views admin con grafici (Chart.js)

### 12. Sistema di Caching
**Priorità: BASSA** | **Stato: Pianificato in CHANGELOG**

- [ ] Implementare cache per:
  - Lista giochi in homepage (cache 60 minuti)
  - Lista boss in Boss Area (cache 60 minuti)
  - Profilo utente pubblico (cache 30 minuti)
- [ ] Invalidare cache su create/update/delete
- [ ] Configurare Redis per ambiente produzione

**Esempio**:
```php
$games = Cache::remember('games.index', 3600, function () {
    return Game::with('user', 'consoles')->get();
});
```

---

## 🟢 OTTIMIZZAZIONI - Infrastruttura

### 13. Configurazione Ambiente Produzione
**Priorità: ALTA per Deploy**

- [ ] Creare `.env.production` con:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `LOG_LEVEL=error`
  - Database produzione corretto
  - Mail driver corretto (non mailpit)
  - Queue driver `redis` invece di `sync`
- [ ] Configurare HTTPS/SSL
- [ ] Configurare CORS se serve API
- [ ] Settare `SESSION_SECURE_COOKIE=true`

### 14. Docker Setup
**Priorità: MEDIA**

- [ ] Creare `Dockerfile` per PHP 8.1+
- [ ] Creare `docker-compose.yml` con servizi:
  - PHP-FPM
  - Nginx
  - MySQL 8.0
  - Redis (per cache/queue)
  - Mailpit (per sviluppo)
- [ ] Aggiungere script `docker/setup.sh` per inizializzazione
- [ ] Documentare in README.md sezione "Docker Deployment"

### 15. CI/CD Pipeline
**Priorità: MEDIA**

- [ ] Creare `.github/workflows/tests.yml`:
  ```yaml
  name: Tests
  on: [push, pull_request]
  jobs:
    test:
      runs-on: ubuntu-latest
      steps:
        - Checkout code
        - Setup PHP 8.1
        - Install dependencies
        - Run PHPUnit
        - Run Laravel Pint (linter)
  ```
- [ ] Configurare deploy automatico su main branch

### 16. Database Optimization
**Priorità: BASSA-MEDIA**

- [ ] Aggiungere indici su colonne frequentemente interrogate:
  - `games.user_id`
  - `consoles.user_id`
  - `games.title` (per ricerche)
  - `consoles.name` (per ricerche)
- [ ] Creare migration `add_indexes_for_performance`
- [ ] Analizzare slow queries con Laravel Telescope

---

## 🎨 UI/UX - Frontend

### 17. Miglioramenti Interfaccia
**Priorità: BASSA-MEDIA**

- [ ] Aggiungere paginazione in:
  - `/games/index` (Laravel: `paginate(12)` invece di `get()`)
  - `/bossArea/index`
  - Profilo utente (giochi e boss dell'utente)
- [ ] Implementare caricamento lazy immagini (loading="lazy")
- [ ] Aggiungere breadcrumbs per navigazione
- [ ] Migliorare messaggi flash (icone, animazioni)
- [ ] Dark mode toggle

### 18. Accessibilità (A11y)
**Priorità: BASSA**

- [ ] Verificare contrasto colori (WCAG AA)
- [ ] Aggiungere attributi `aria-label` su icone
- [ ] Testare navigazione con solo tastiera (tab order)
- [ ] Aggiungere testi alternativi (alt) a tutte le immagini
- [ ] Supporto screen reader

### 19. Progressive Web App (PWA)
**Priorità: BASSA**

- [ ] Creare `manifest.json`
- [ ] Configurare Service Worker per offline mode
- [ ] Aggiungere icone app (192x192, 512x512)
- [ ] Implementare "Add to Home Screen" prompt

---

## 📚 DOCUMENTAZIONE

### 20. Miglioramenti README
**Priorità: BASSA**

- [ ] Aggiungere sezione "Troubleshooting"
- [ ] Documentare comandi Artisan custom se esistono
- [ ] Aggiungere badge per:
  - Build status (CI/CD)
  - Code coverage
  - Latest release
- [ ] Video demo o GIF animate

### 21. Code Documentation
**Priorità: BASSA**

- [ ] Aggiungere PHPDoc completi su:
  - Tutti i metodi controller (attualmente mancanti o incompleti)
  - Metodi model (relazioni, accessor, mutator)
- [ ] Generare documentazione API con phpDocumentor
- [ ] Commentare logica business complessa

---

## 🔒 SICUREZZA

### 22. Security Hardening
**Priorità: MEDIA-ALTA**

- [ ] Implementare rate limiting su:
  - Login (max 5 tentativi/minuto)
  - Registrazione (max 3/ora per IP)
  - Contact form (max 5/ora per utente)
  - API endpoints
- [ ] Aggiungere honeypot in form pubblici (anti-bot)
- [ ] Validare MIME type reali file upload (non solo estensione)
- [ ] Implementare Content Security Policy (CSP) headers
- [ ] Aggiungere logs per azioni sensibili:
  - Login falliti
  - Tentativi accesso non autorizzato
  - Eliminazione account
  - Upload file

### 23. Aggiornamenti Dipendenze
**Priorità: CONTINUA**

- [ ] Aggiornare Laravel 10 → 11 (quando stabile)
- [ ] Verificare vulnerabilità con `composer audit`
- [ ] Verificare vulnerabilità NPM con `npm audit`
- [ ] Settare Dependabot su GitHub per PR automatiche

---

## 🧪 QUALITY ASSURANCE

### 24. Code Quality Tools
**Priorità: MEDIA**

- [ ] Installare e configurare:
  - Laravel Pint (già presente ✅) → eseguire `./vendor/bin/pint`
  - PHPStan (analisi statica)
  - Laravel Telescope (debug produzione)
  - Laravel Debugbar (solo sviluppo)
- [ ] Configurare pre-commit hooks con Husky
- [ ] Definire coding standard in `.php-cs-fixer.php`

### 25. Performance Monitoring
**Priorità: BASSA (post-deploy)**

- [ ] Integrare servizio monitoring:
  - Laravel Pulse
  - Sentry (error tracking)
  - New Relic / Datadog
- [ ] Configurare alerting email su errori critici
- [ ] Dashboard analytics utenti

---

## 📝 NOTE AGGIUNTIVE

### Punti di Forza Attuali ✅
- ✅ Struttura MVC ben organizzata
- ✅ Policies implementate (anche se non usate)
- ✅ Form Request per validazione
- ✅ Eager Loading presente
- ✅ Middleware autenticazione corretto
- ✅ Documentazione Architecture.md eccellente
- ✅ CHANGELOG ben mantenuto

### File da Non Modificare
- `docs/PSEUDOCODE.md` (documentazione struttura)
- `docs/CONTRIBUTING.md` (linee guida contributori)
- `.env.example` (template corretto)

### Prossimi Step Consigliati
1. ✅ Completare TODO #1 (Refactoring Console → Boss)
2. ✅ Completare TODO #2 (Usare Policies)
3. ✅ Completare TODO #3 (Gestione file orfani)
4. ✅ Completare TODO #5 (Testing base)
5. ✅ Deploy staging per validazione

---

## 🎯 Riepilogo Priorità

| Livello | Tasks | Focus |
|---------|-------|-------|
| 🔴 **CRITICI** | #1, #2, #3 | Refactoring, Sicurezza, Storage |
| 🟠 **IMPORTANTI** | #4, #5, #6, #7 | Qualità Codice, Testing |
| 🟡 **MIGLIORAMENTI** | #8-#12 | Nuove Funzionalità |
| 🟢 **OTTIMIZZAZIONI** | #13-#16 | Infrastruttura, Performance |
| 🎨 **UI/UX** | #17-#19 | Frontend, Accessibilità |
| 📚 **DOCUMENTAZIONE** | #20-#21 | README, PHPDoc |
| 🔒 **SICUREZZA** | #22-#23 | Hardening, Updates |
| 🧪 **QA** | #24-#25 | Code Quality, Monitoring |

---

**Ultima Revisione**: 8 Gennaio 2026  
**Progetto**: Souls Space v2.0  
**Maintainer**: Team Development