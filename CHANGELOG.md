# Changelog

Tutte le modifiche notevoli a questo progetto saranno documentate in questo file.

Il formato è basato su [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
e questo progetto aderisce a [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

### Planned
- Implementazione API REST con Sanctum
- Soft Deletes per Games e Consoles
- Sistema di caching con Redis
- Ricerca full-text con Laravel Scout
- Admin Dashboard con statistiche
- Sistema di rating/recensioni
- Docker setup completo
- CI/CD pipeline con GitHub Actions

---

## [2.1.0] - 2026-01-08

### Added
- **Database Supabase**: Migrazione completa a PostgreSQL su Supabase
- **Configurazione**: `.env.example` aggiornato con opzioni MySQL/PostgreSQL/Supabase
- **Documentazione**: Aggiornato `Architecture.md` con report analisi completo
- **TODO.md**: Lista completa e prioritizzata di miglioramenti

### Fixed
- **SECURITY CRITICAL**: Aggiunta autorizzazione `$this->authorize('delete')` in `destroy()` di Game e Console
- **Gestione File**: Implementato `Storage::delete()` per eliminare cover e logo quando si aggiorna/elimina record
- **Code Quality**: Sostituiti controlli manuali con Policy `$this->authorize()` in edit/update

### Changed
- **Controllers**: Refactoring completo di `GameController` e `ConsoleController`
- **Policies**: Ora utilizzate correttamente per autorizzazioni (prima erano solo registrate)
- **Project Cleanup**: Rimossi riferimenti obsoleti, pulite cache Laravel

### Infrastructure
- **Database**: PostgreSQL 15 su Supabase (Connection Pooler)
- **Host**: `aws-1-eu-central-1.pooler.supabase.com:5432`
- **PHP**: XAMPP 8.1+ (rimosso Laragon)

---

## [2.0.0] - 2026-01-06

### Added
- Policy per autorizzazione (`GamePolicy`, `ConsolePolicy`)
- Documentazione completa in `docs/` (PSEUDOCODE.md, API.md, CONTRIBUTING.md)
- Eager Loading in tutti gli index
- Middleware auth per route protette

### Fixed
- Errore sintassi critico in GameController
- `attach()` sostituito con `sync()` per evitare duplicati Many-to-Many
- Path upload inconsistente (`foto` → `covers`)
- Validazione `numeric|min:0` per price
- Naming routes standardizzato

### Changed
- README completamente riscritto per GitHub
- Architettura documentata in `Architecture.md`

### Security
- Aggiunto controllo auth in metodi update

---

## [1.0.0] - 2023-03-15

### Added
- Implementazione iniziale del progetto
- CRUD completo per Games e Consoles (Boss)
- Sistema autenticazione con Laravel Fortify
- Upload immagini (avatar, covers, logos)
- Form contatto con invio email
- Homepage con carousel Swiper.js
- Profilo utente personalizzabile
- Relazioni Many-to-Many tra Games e Consoles
- Views responsive con Bootstrap 5
- Tema Dark Souls con CSS custom

### Technical Stack
- Laravel 10.x
- PHP 8.1+
- Vite per asset bundling
- MySQL/PostgreSQL

---

[Unreleased]: https://github.com/MeloLM/Carmelo_GamesSpace/compare/v2.1.0...HEAD
[2.1.0]: https://github.com/MeloLM/Carmelo_GamesSpace/compare/v2.0.0...v2.1.0
[2.0.0]: https://github.com/MeloLM/Carmelo_GamesSpace/compare/v1.0.0...v2.0.0
[1.0.0]: https://github.com/MeloLM/Carmelo_GamesSpace/releases/tag/v1.0.0
