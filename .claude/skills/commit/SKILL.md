---
name: commit
description: Create git commits with conventional commit messages in Polish/English. Analyzes staged and unstaged changes, drafts a meaningful commit message, and creates the commit.
argument-hint: "[message]"
disable-model-invocation: true
allowed-tools: Bash(git *), Read, Glob, Grep
---

# Git Commit Creator

Tworzysz commity git dla projektu. Postepuj wedlug ponizszej procedury krok po kroku.

## Procedura

### Krok 1 — Rozpoznanie stanu repozytorium

Wykonaj rownolegle:

1. `git status` — lista zmienionych i nieśledzonych plików (NIGDY nie uzywaj flagi `-uall`)
2. `git diff` — niestageowane zmiany
3. `git diff --cached` — juz stageowane zmiany
4. `git log --oneline -10` — ostatnie commity (aby dopasowac styl wiadomosci)

### Krok 2 — Analiza zmian

1. Przeanalizuj WSZYSTKIE zmiany (staged + unstaged)
2. Okresl typ zmiany:
   - `feat:` — nowa funkcjonalnosc
   - `fix:` — naprawa bledu
   - `refactor:` — refaktoryzacja bez zmiany zachowania
   - `style:` — formatowanie, brak zmian logiki
   - `docs:` — dokumentacja
   - `chore:` — konfiguracja, zaleznosci, buildowanie
   - `test:` — testy
3. Sprawdz czy nie ma plikow z sekretami (`.env`, `credentials.json`, klucze API) — NIGDY ich nie commituj. Ostrzez uzytkownika jesli probuje je dodac.

### Krok 3 — Przygotowanie commit message

Zasady:

- **Conventional Commits** format: `<type>: <description>`
- Pierwsza linia: max 72 znaki, zwiezly opis **dlaczego** (nie co)
- Opcjonalnie: pusta linia + dluzsza tresc wyjasniajaca kontekst
- Jezyk: dopasuj do stylu istniejacych commitow w repozytorium. Jesli brak commitow lub mieszane — uzywaj angielskiego
- Jesli uzytkownik podal argument `$ARGUMENTS`, uzyj go jako baze dla wiadomosci commita (ale dopasuj do formatu conventional commits)

### Krok 4 — Staging i commit

1. Dodaj odpowiednie pliki do stagingu — preferuj dodawanie konkretnych plików po nazwie zamiast `git add -A` lub `git add .`
2. Utworz commit uzywajac HEREDOC dla wiadomosci:

```bash
git commit -m "$(cat <<'EOF'
<type>: <description>

<opcjonalna dluzsza tresc>

Co-Authored-By: Claude Opus 4.6 (1M context) <noreply@anthropic.com>
EOF
)"
```

3. Po udanym commicie wykonaj `git status` aby potwierdzic sukces

### Krok 5 — Obsluga bledow

- Jesli pre-commit hook zawiodl: napraw problem i utworz **NOWY** commit (NIGDY nie uzywaj `--amend` — bo amend zmienilby POPRZEDNI commit)
- Jesli nie ma zmian do commitowania — poinformuj uzytkownika, nie twórz pustego commita
- NIGDY nie uzywaj `--no-verify` ani `--no-gpg-sign`
- NIGDY nie uzywaj flag interaktywnych (`-i`)

## Reguly bezpieczenstwa

- NIGDY nie pushuj do remote — tylko commit lokalny (chyba ze uzytkownik explicite poprosi)
- NIGDY nie modyfikuj konfiguracji git
- NIGDY nie uzywaj `git reset --hard`, `git checkout .`, `git clean -f` ani innych destrukcyjnych komend
- NIGDY nie uzywaj `--force` przy push
- Nie commituj plikow binarnych ani duzych plikow bez potwierdzenia uzytkownika
