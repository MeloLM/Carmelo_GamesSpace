# 🤝 Contributing to Souls Space

Grazie per l'interesse nel contribuire a Souls Space! Questo documento fornisce le linee guida per contribuire al progetto.

---

## 📋 Indice

1. [Code of Conduct](#code-of-conduct)
2. [Getting Started](#getting-started)
3. [Development Setup](#development-setup)
4. [Coding Standards](#coding-standards)
5. [Pull Request Process](#pull-request-process)
6. [Issue Guidelines](#issue-guidelines)

---

## 📜 Code of Conduct

- Sii rispettoso e inclusivo
- Accetta critiche costruttive
- Focalizzati su ciò che è meglio per il progetto
- Mostra empatia verso gli altri contributori

---

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL o SQLite

### Fork & Clone

1. Fork il repository
2. Clone il tuo fork:
   ```bash
   git clone https://github.com/YOUR_USERNAME/Carmelo_GamesSpace.git
   cd Carmelo_GamesSpace
   ```

3. Aggiungi l'upstream:
   ```bash
   git remote add upstream https://github.com/ORIGINAL_OWNER/Carmelo_GamesSpace.git
   ```

---

## 🛠️ Development Setup

```bash
# Installa dipendenze PHP
composer install

# Installa dipendenze Node
npm install

# Copia environment file
cp .env.example .env

# Genera application key
php artisan key:generate

# Configura database in .env, poi:
php artisan migrate

# Crea symlink per storage
php artisan storage:link

# Avvia dev server
npm run dev
php artisan serve
```

---

## 📐 Coding Standards

### PHP/Laravel

- Segui [PSR-12](https://www.php-fig.org/psr/psr-12/)
- Usa type hints dove possibile
- Documenta metodi pubblici con PHPDoc
- Usa Form Request per validazione
- Usa Policy per autorizzazione

```php
// ✅ Corretto
public function store(GameRequest $request): RedirectResponse
{
    $game = Game::create([
        'title' => $request->title,
        'user_id' => Auth::id(),
    ]);
    
    return redirect()->route('game.index')
        ->with('gameCreated', 'Gioco creato con successo!');
}

// ❌ Evita
public function store(Request $request)
{
    // Validazione inline...
    // Logica mista...
}
```

### JavaScript

- Usa ES6+
- Evita `var`, preferisci `const`/`let`
- Usa arrow functions dove appropriato

### Blade

- Usa components per elementi riutilizzabili
- Mantieni la logica nelle views al minimo
- Usa `@csrf` per tutti i form

### Naming Conventions

| Tipo | Convenzione | Esempio |
|------|-------------|---------|
| Route names | entity.action | `game.index`, `console.create` |
| Views | folder/action | `game/show.blade.php` |
| Controllers | PascalCase | `GameController.php` |
| Models | Singular PascalCase | `Game.php` |
| Migrations | snake_case | `create_games_table.php` |

---

## 🔄 Pull Request Process

### Branch Naming

```
feature/nome-feature    # Nuove funzionalità
fix/descrizione-bug     # Bug fixes
docs/cosa-documenti     # Documentazione
refactor/cosa-refactori # Refactoring
```

### Workflow

1. Crea branch dal main aggiornato:
   ```bash
   git checkout main
   git pull upstream main
   git checkout -b feature/mia-feature
   ```

2. Sviluppa e committa:
   ```bash
   git add .
   git commit -m "feat: aggiungi nuova funzionalità X"
   ```

3. Pusha e crea PR:
   ```bash
   git push origin feature/mia-feature
   ```

### Commit Messages

Segui [Conventional Commits](https://www.conventionalcommits.org/):

```
feat: aggiungi nuova funzionalità
fix: correggi bug in X
docs: aggiorna documentazione
style: formattazione, semicolons mancanti
refactor: refactoring codice
test: aggiungi test
chore: aggiorna dipendenze
```

### PR Checklist

- [ ] Il codice segue le coding standards
- [ ] Ho testato le modifiche localmente
- [ ] Ho aggiornato la documentazione (se necessario)
- [ ] Il PR ha una descrizione chiara
- [ ] Non ci sono conflitti con main

---

## 🐛 Issue Guidelines

### Bug Report

```markdown
**Descrizione Bug**
Descrizione chiara e concisa del bug.

**Passi per Riprodurre**
1. Vai a '...'
2. Clicca su '...'
3. Vedi errore

**Comportamento Atteso**
Cosa dovrebbe succedere.

**Screenshots**
Se applicabile.

**Environment**
- OS: [es. Windows 11]
- Browser: [es. Chrome 120]
- PHP Version: [es. 8.2]
- Laravel Version: [es. 10.x]
```

### Feature Request

```markdown
**Descrizione Feature**
Descrizione chiara della funzionalità.

**Motivazione**
Perché questa feature sarebbe utile?

**Possibile Implementazione**
Come potrebbe essere implementata?
```

---

## 🎮 Domain Knowledge

⚠️ **IMPORTANTE**: Nel contesto di questo progetto:
- `Console` (Model) = **BOSS** del gioco Dark Souls
- `Game` = Videogioco della saga
- `Product` = Software House (es. FromSoftware)

Non confondere "Console" con le console di gioco!

---

## 📞 Contatti

Per domande o supporto:
- Apri una Issue su GitHub
- Usa il form di contatto sul sito

---

*Grazie per contribuire! 🎮*
