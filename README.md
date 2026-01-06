<div align="center">

# 🎮 Souls Space

### A Dark Souls Fan Platform built with Laravel

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.2-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

[Features](#-features) •
[Installation](#-installation) •
[Documentation](#-documentation) •
[Contributing](#-contributing)

<img src="public/media/preview.png" alt="Souls Space Preview" width="600">

</div>

---

## 📖 About

**Souls Space** is a web platform dedicated to the Dark Souls/Demon Souls saga. Users can browse and create game profiles, manage a "Boss Area" with detailed boss information, and interact with the community.

> ⚠️ **Domain Note**: In this codebase, `Console` refers to **game bosses**, not gaming consoles.

---

## ✨ Features

- 🎮 **Game Management** - Browse and create game profiles for the Souls saga
- 👹 **Boss Area** - Comprehensive boss database with images and descriptions
- 👤 **User Profiles** - Registration, login, and customizable avatars
- 📧 **Contact System** - Email-based contact form
- 🖼️ **Image Uploads** - Support for covers, logos, and avatars
- 🔐 **Authentication** - Powered by Laravel Fortify

---

## 🛠️ Tech Stack

| Technology | Purpose |
|------------|---------|
| **Laravel 10** | Backend Framework |
| **PHP 8.1+** | Server Language |
| **Laravel Fortify** | Authentication |
| **Bootstrap 5** | UI Framework |
| **Vite** | Asset Bundling |
| **MySQL/SQLite** | Database |
| **Swiper.js** | Carousel Component |

---

## 🚀 Installation

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL or SQLite

### Quick Start

```bash
# Clone the repository
git clone https://github.com/yourusername/souls-space.git
cd souls-space

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure database in .env, then:
php artisan migrate

# Create storage symlink
php artisan storage:link

# Start development servers
npm run dev
php artisan serve
```

Visit `http://localhost:8000` 🎉

---

## 📁 Project Structure

```
souls-space/
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Models/              # Eloquent models (User, Game, Console)
│   ├── Policies/            # Authorization policies
│   └── Mail/                # Mailable classes
├── database/
│   └── migrations/          # Database schema
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Custom styles
│   └── js/                  # JavaScript files
├── routes/
│   └── web.php              # Web routes
├── docs/                    # Documentation
│   ├── PSEUDOCODE.md        # Logic reference
│   ├── API.md               # Endpoints reference
│   └── CONTRIBUTING.md      # Contribution guide
└── storage/app/public/      # User uploads
```

---

## 🗄️ Database Schema

```
┌──────────┐       ┌──────────┐       ┌───────────┐
│  Users   │       │  Games   │       │  Consoles │
├──────────┤       ├──────────┤       │  (Bosses) │
│ id       │──┐    │ id       │       ├───────────┤
│ name     │  │    │ title    │       │ id        │
│ email    │  │    │ price    │       │ name      │
│ avatar   │  ├───►│ user_id  │       │ brand     │
└──────────┘  │    └────┬─────┘       │ user_id   │
              │         │             └─────┬─────┘
              │         │                   │
              │         └───────┬───────────┘
              │           ┌─────┴─────┐
              │           │ Pivot     │
              │           │ M:M       │
              └──────────►└───────────┘
```

**Relationships:**
- User → hasMany → Games
- User → hasMany → Consoles (Bosses)
- Game ↔ belongsToMany ↔ Console

---

## 🛤️ API Routes

### Public Routes
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/` | Homepage |
| GET | `/games/index` | List all games |
| GET | `/games/show/{id}` | Game details |
| GET | `/bossArea/index` | List all bosses |
| GET | `/bossArea/show/{id}` | Boss details |

### Protected Routes (Auth Required)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/profile/{user?}` | User profile |
| POST | `/games/store` | Create game |
| PUT | `/games/update/{id}` | Update game |
| DELETE | `/games/destroy/{id}` | Delete game |

> 📚 See [docs/API.md](docs/API.md) for complete reference

---

## 📚 Documentation

| Document | Description |
|----------|-------------|
| [Architecture.md](Architecture.md) | Technical architecture & guidelines |
| [docs/PSEUDOCODE.md](docs/PSEUDOCODE.md) | Logic flow & pseudocode reference |
| [docs/API.md](docs/API.md) | API endpoints documentation |
| [docs/CONTRIBUTING.md](docs/CONTRIBUTING.md) | Contribution guidelines |
| [CHANGELOG.md](CHANGELOG.md) | Version history |
| [SECURITY.md](SECURITY.md) | Security policy |

---

## 🤝 Contributing

Contributions are welcome! Please read our [Contributing Guide](docs/CONTRIBUTING.md) first.

```bash
# Fork & clone
git clone https://github.com/YOUR_USERNAME/souls-space.git

# Create feature branch
git checkout -b feature/amazing-feature

# Commit changes
git commit -m "feat: add amazing feature"

# Push & create PR
git push origin feature/amazing-feature
```

---

## 📝 Changelog

### v2.0.0 (January 2026)
- ✅ 25 bug fixes
- ✅ Added Policies for authorization
- ✅ Complete documentation
- ✅ Improved validation

See [CHANGELOG.md](CHANGELOG.md) for full history.

---

## 🔮 Roadmap

- [ ] REST API implementation
- [ ] Soft Deletes
- [ ] Caching system
- [ ] Full-text search
- [ ] Admin dashboard
- [ ] Rename "Console" to "Boss" for clarity

---

## ⚡ Commands Reference

```bash
# Development
npm run dev              # Start Vite dev server
php artisan serve        # Start PHP server

# Database
php artisan migrate:fresh --seed   # Reset & seed DB

# Cache
php artisan optimize:clear         # Clear all caches

# Generate
php artisan make:model Entity -mcr # Model + Migration + Controller
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT License](LICENSE).

---

<div align="center">

**Built with ❤️ for the Souls Community**

[⬆ Back to Top](#-souls-space)

</div>
