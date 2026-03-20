---
name: create-skill
description: Generate new Claude Code custom skills from a description. Creates SKILL.md with proper frontmatter, structured prompt, and conventions. Use when you need to create a new slash command / skill.
argument-hint: "<skill-name> <description>"
disable-model-invocation: true
allowed-tools: Read, Write, Edit, Bash, Glob, Grep
---

# Skill Generator

Tworzysz nowe skille (slash commands) dla Claude Code. Postepuj wedlug ponizszej procedury krok po kroku.

## Procedura

### Krok 1 — Parsowanie argumentow

Wyodrebnij z `$ARGUMENTS`:
- **Nazwa skilla** — pierwszy argument (np. `deploy`, `test-runner`)
- **Opis** — pozostale argumenty opisujace co skill ma robic

Jesli brak argumentow — zapytaj uzytkownika o nazwe i opis skilla.

### Krok 2 — Sprawdzenie konfliktow

Przeszukaj istniejace skille:

1. `.claude/skills/` — skille projektowe
2. `~/.claude/skills/` — skille uzytkownika (globalne)

Jesli skill o tej nazwie juz istnieje — poinformuj uzytkownika i zapytaj czy chce go nadpisac czy wybrac inna nazwe.

### Krok 3 — Rozpoznanie konwencji projektu

Przeczytaj 1-2 istniejace skille z `.claude/skills/` aby dopasowac:
- Jezyk (polski/angielski)
- Strukture i formatowanie
- Styl frontmatter

### Krok 4 — Ustalenie zakresu

Domyslnie tworzysz skill na poziomie projektu (`.claude/skills/`).

Zapytaj uzytkownika tylko jesli kontekst sugeruje ze skill moze byc globalny:
- **Projekt** (`.claude/skills/<nazwa>/SKILL.md`) — domyslne
- **Uzytkownik** (`~/.claude/skills/<nazwa>/SKILL.md`) — dla skillow niezwiazanych z projektem

### Krok 5 — Generowanie SKILL.md

Wygeneruj plik skilla z nastepujaca struktura:

```markdown
---
name: <skill-name>
description: <opis z informacja kiedy uzywac>
argument-hint: "<argumenty>"
disable-model-invocation: true
allowed-tools: <odpowiednie narzedzia>
---

# <Tytul Skilla>

<Opis roli i przeznaczenia>

## Kontekst
<Kiedy uzywac, kontekst projektu>

## Procedura
<Instrukcje krok po kroku — kazdy krok jako ### Krok N>

## Szablony (opcjonalnie)
<Szablony kodu jesli potrzebne>

## Reguly bezpieczenstwa
<Zabezpieczenia i ograniczenia>
```

Zasady generowania:

- **Frontmatter:**
  - `name` — nazwa skilla (kebab-case)
  - `description` — zwiezly opis z informacja kiedy/jak uzywac (1-2 zdania)
  - `argument-hint` — podpowiedz argumentow w nawiasach `<>` dla wymaganych, `[]` dla opcjonalnych
  - `disable-model-invocation` — domyslnie `true` (bezpieczniejsze — uzytkownik wywoluje jawnie)
  - `allowed-tools` — dobierz minimalny zestaw potrzebnych narzedzi (Read, Write, Edit, Bash, Glob, Grep, WebFetch, WebSearch, Agent)

- **Tresc:**
  - Jezyk glowny: dopasuj do konwencji istniejacych skillow (domyslnie polski z angielskimi terminami technicznymi)
  - Procedura podzielona na numerowane kroki
  - Kazdy krok jasno opisuje CO zrobic i JAK
  - Uzyj zmiennej `$ARGUMENTS` do odwolywania sie do argumentow uzytkownika
  - Dodaj sekcje szablonow jesli skill generuje pliki o powtarzalnej strukturze
  - Reguly bezpieczenstwa — co skill NIGDY nie powinien robic

### Krok 6 — Zapis pliku

1. Utworz katalog: `<target>/skills/<skill-name>/`
2. Zapisz plik: `<target>/skills/<skill-name>/SKILL.md`

### Krok 7 — Weryfikacja

1. Potwierdz ze plik zostal utworzony (`Glob` lub `Read`)
2. Pokaz uzytkownikowi jak wywolac nowy skill: `/<skill-name> <args>`
3. Wyswietl krotkie podsumowanie co skill robi

## Reguly bezpieczenstwa

- NIGDY nie nadpisuj istniejacego skilla bez potwierdzenia uzytkownika
- NIGDY nie twórz skillow z `disable-model-invocation: false` bez wyjasnienia uzytkownikowi konsekwencji (skill bedzie wywolywany automatycznie przez model)
- NIGDY nie dodawaj narzedzi do `allowed-tools` ktore nie sa potrzebne — zasada minimalnych uprawnien
- NIGDY nie generuj skillow ktore pushuja kod, usuwaja pliki, lub wykonuja inne destrukcyjne operacje bez jawnego potwierdzenia w procedurze
- Zawsze czytaj istniejace skille przed generowaniem — aby zachowac spojnosc konwencji
