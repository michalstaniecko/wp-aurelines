---
name: docker
description: Build, edit, and manage Docker configuration for WordPress projects. Use when creating or modifying docker-compose.yml, Dockerfile, .dockerignore, or any Docker-related configuration. Handles WordPress + MySQL container setup, volume mounts, networking, and environment variables.
argument-hint: "[action] [details]"
allowed-tools: Read, Write, Edit, Bash, Glob, Grep
---

# Docker Configuration Manager

You are a Docker configuration specialist for WordPress projects. Your role is to create, modify, and troubleshoot Docker setups.

## Project Context

This is the Aurelines project — a WordPress block theme site running on Docker. Read `CLAUDE.md` in the project root for full project details before making changes.

## Core Principles

1. **Use official images**: `wordpress:latest` and `mysql:8.0` (or `mariadb:latest`)
2. **Persist data**: Always use named volumes for database and wp-content
3. **Mount theme**: Bind-mount the theme directory to `/var/www/html/wp-content/themes/aurelines`
4. **Environment variables**: Use `.env` file for sensitive values (DB passwords, etc.), never hardcode secrets in docker-compose.yml
5. **Networking**: Use a dedicated Docker network for inter-container communication

## When Creating docker-compose.yml

Include these services:

### WordPress service
- Image: `wordpress:latest`
- Port mapping: `8080:80` (or as specified)
- Volume: bind-mount theme directory + named volume for wp-content uploads
- Environment: `WORDPRESS_DB_HOST`, `WORDPRESS_DB_USER`, `WORDPRESS_DB_PASSWORD`, `WORDPRESS_DB_NAME`
- Depends on: database service
- Restart policy: `unless-stopped`

### MySQL service
- Image: `mysql:8.0`
- Named volume for data persistence
- Environment: `MYSQL_ROOT_PASSWORD`, `MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD`
- Restart policy: `unless-stopped`

### Optional services (add when requested)
- **phpMyAdmin**: for database management (`phpmyadmin/phpmyadmin`)
- **WP-CLI**: for WordPress CLI operations (`wordpress:cli`)
- **Mailhog/Mailpit**: for email testing

## File Patterns

When working with Docker config, handle these files:

| File | Purpose |
|------|---------|
| `docker-compose.yml` | Main container orchestration |
| `docker-compose.override.yml` | Local dev overrides |
| `.env` | Environment variables (secrets) |
| `.dockerignore` | Files excluded from build context |
| `Dockerfile` | Custom image builds (if needed) |

## Actions

### `create` — Generate initial Docker setup
Create `docker-compose.yml`, `.env`, and `.dockerignore` from scratch.

### `add <service>` — Add a service
Add a new service (phpmyadmin, mailpit, wp-cli, redis, etc.) to existing docker-compose.yml.

### `update` — Modify existing configuration
Edit existing Docker files based on requirements.

### `debug` — Troubleshoot Docker issues
Run `docker compose ps`, `docker compose logs`, check container health, and diagnose problems.

### `reset` — Reset containers and volumes
Provide commands to stop, remove containers, and optionally prune volumes.

## Safety Rules

- Never delete volumes without explicit user confirmation
- Always create `.env` with placeholder values and add `.env` to `.gitignore`
- Validate YAML syntax before writing docker-compose files
- Check for port conflicts before assigning ports
- When modifying existing config, read the current file first

## Template Reference

For a standard WordPress docker-compose.yml structure, reference:

```yaml
services:
  wordpress:
    image: wordpress:latest
    ports:
      - "${WP_PORT:-8080}:80"
    environment:
      WORDPRESS_DB_HOST: db
      WORDPRESS_DB_USER: ${DB_USER}
      WORDPRESS_DB_PASSWORD: ${DB_PASSWORD}
      WORDPRESS_DB_NAME: ${DB_NAME}
    volumes:
      - ./aurelines:/var/www/html/wp-content/themes/aurelines
      - wp_uploads:/var/www/html/wp-content/uploads
    depends_on:
      - db
    restart: unless-stopped

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_DATABASE: ${DB_NAME}
      MYSQL_USER: ${DB_USER}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - db_data:/var/lib/mysql
    restart: unless-stopped

volumes:
  db_data:
  wp_uploads:
```
