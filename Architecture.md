# 🏛️ Architecture & Development Guidelines - Souls Space

> **Obiettivo del Documento:** Fornire una struttura tecnica rigida, standard di codifica e contesto di dominio per AI Assistants (Copilot) e sviluppatori. Questo documento estende il README originale focalizzandosi sull'implementazione tecnica e sul refactoring.

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

### 1.2 Relazioni Core
* **User** crea molti **Games**.
* **User** crea molti **Consoles** (Bosses).
* **Game** e **Console** (Boss) hanno una relazione **Many-to-Many**.
    * *Logica:* Un Boss può apparire in più giochi; un Gioco ha molti boss.

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