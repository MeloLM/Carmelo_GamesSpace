# Changelog

Tutte le modifiche notevoli a questo progetto saranno documentate in questo file.

Il formato è basato su [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
e questo progetto aderisce a [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned
- Implementazione API REST
- Soft Deletes per Games e Consoles
- Sistema di caching
- Ricerca full-text
- Admin Dashboard

---

## [2.0.0] - 2026-01-06

### Added
- Policy per autorizzazione (`GamePolicy`, `ConsolePolicy`)
- Documentazione completa (`docs/`)
- File `PSEUDOCODE.md` per navigazione progetto
- File `API.md` per riferimento endpoints
- File `CONTRIBUTING.md` per contributori
- Validazione avatar upload
- Validazione contact form
- Eager Loading in tutti gli index
- Middleware auth per route protette

### Fixed
- Errore sintassi critico `description->` in GameController
- Variabile `$user` mancante in FrontController
- `attach()` sostituito con `sync()` per evitare duplicati Many-to-Many
- Codice duplicato rimosso da FrontController
- Path upload inconsistente (`foto` → `covers`)
- Messaggio flash errato (`houseUpdated` → `consoleUpdated`)
- Parametro inutile `Game $game` rimosso da `destroy()`
- Typo `UPTADE` → `UPDATE`
- Validazione `numeric|min:0` per price
- Messaggio duplicato in ConsoleRequest
- Nome parametro select (`console` → `consoles[]`)
- `old()` vuoti in console/edit.blade
- ID duplicato in register.blade
- H6 vuoto rimosso in profile.blade
- Naming routes standardizzato
- `hasFile()` check aggiunto

### Changed
- README completamente riscritto per GitHub
- Architettura documentata in `Architecture.md`
- Middleware group per route protette

### Security
- Aggiunto controllo auth in metodi update
- Middleware auth in UserController

---

## [1.0.0] - 2023-03-15

### Added
- Implementazione iniziale del progetto
- CRUD completo per Games
- CRUD completo per Consoles (Boss)
- Sistema autenticazione con Laravel Fortify
- Upload immagini (avatar, covers, logos)
- Form contatto con invio email
- Homepage con carousel
- Profilo utente personalizzabile
- Relazioni Many-to-Many tra Games e Consoles
- Views responsive con Bootstrap 5
- Tema Dark Souls con CSS custom

### Technical
- Laravel 10.x
- PHP 8.1+
- Vite per asset bundling
- Swiper.js per carousel

---

[Unreleased]: https://github.com/username/souls-space/compare/v2.0.0...HEAD
[2.0.0]: https://github.com/username/souls-space/compare/v1.0.0...v2.0.0
[1.0.0]: https://github.com/username/souls-space/releases/tag/v1.0.0
