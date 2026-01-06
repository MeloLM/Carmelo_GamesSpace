# 🔒 Security Policy

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| 2.0.x   | :white_check_mark: |
| 1.0.x   | :x:                |

## Reporting a Vulnerability

Se scopri una vulnerabilità di sicurezza, ti preghiamo di:

1. **NON** aprire una issue pubblica
2. Invia una email privata a [security@example.com]
3. Includi:
   - Descrizione della vulnerabilità
   - Passi per riprodurla
   - Potenziale impatto
   - Eventuali suggerimenti per la fix

### Cosa aspettarsi

- Risposta entro 48 ore
- Aggiornamenti regolari sullo stato
- Credito nel changelog (se desiderato)

## Best Practices Implementate

### Autenticazione
- Password hashate con Bcrypt
- CSRF protection su tutti i form
- Session management sicuro

### Autorizzazione
- Middleware `auth` per route protette
- Ownership check nei controller
- Policy per controllo granulare

### Input Validation
- Form Request per validazione server-side
- Sanitizzazione input
- File upload restrictions (tipo, dimensione)

### Storage
- File upload in `storage/` (non `public/`)
- Symlink per accesso controllato

## Known Limitations

- Two-Factor Auth predisposto ma non attivo
- Rate limiting non implementato
- Password reset via email (richiede config SMTP)

---

*Ultimo aggiornamento: Gennaio 2026*
