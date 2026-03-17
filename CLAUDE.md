# Aurelines — WordPress Block Theme

Strona one-page dla szkoły akrobatycznej Aurelines.

## Stack

- **Docker**: WordPress + MySQL (docker-compose)
- **WordPress**: latest, Full Site Editing (FSE)
- **Theme**: custom block theme z `theme.json` v2
- **Język interfejsu**: polski

## Theme Structure

```
aurelines/
├── style.css
├── theme.json
├── functions.php
├── templates/
│   ├── index.html
│   └── front-page.html
├── parts/
│   ├── header.html
│   └── footer.html
├── patterns/
│   ├── hero.php
│   ├── about.php
│   ├── mission.php
│   └── contact.php
├── blocks/           # Custom Gutenberg blocks (block.json + render.php + edit.js)
└── assets/
    ├── css/
    ├── js/
    ├── fonts/
    └── images/
```

## Sekcje (one-page)

1. **Home / Hero** — sekcja powitalna z logo i CTA
2. **O nas** — informacje o szkole
3. **Misja** — cel i wartości
4. **Kontakt** — dane kontaktowe / formularz

## Design

- Primary color: `#1F3FAE`
- Logo: 2 warianty (ciemne/jasne tło) w `docs/`
- Referencyjna strona konkurencji: sktalent.pl
- Responsive, mobile-first

## Konwencje

- Maksymalne wykorzystanie **natywnych bloków Gutenberg** — brak page builderów
- Style definiowane w `theme.json` (settings/styles) — nie w CSS gdzie to możliwe
- Custom **block patterns** dla każdej sekcji one-page
- Brak jQuery — vanilla JS jeśli potrzebny
- Brak zewnętrznych zależności frontendowych (bez npm/build pipeline)

## Docker

- `docker-compose.yml` z kontenerami: `wordpress` + `mysql`
- Katalog theme mountowany do `/var/www/html/wp-content/themes/aurelines`
- Dostęp lokalny: `localhost`

## Pliki projektu

- `docs/brief.md` — brief od klienta
- `docs/` — logo w dwóch wariantach (PNG)
