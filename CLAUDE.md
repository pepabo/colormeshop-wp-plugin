# CLAUDE.md

This document provides guidance for Claude Code (claude.ai/code) **and developers** working with code in this repository.

---

## Project Overview

This is a WordPress plugin that integrates with the ColorMe Shop (カラーミーショップ) API to display product information and generate product pages within WordPress.  
It uses OAuth2 authentication and provides WordPress shortcodes for embedding product details.

---

## Development Commands

### Setup

```bash
# Copy environment file and start Docker containers
cp wp.env.sample wp.env
docker-compose up -d

# Install PHP dependencies via Composer
docker-compose run --rm composer install
```

> After setup, activate the plugin from the WordPress admin dashboard.

---

### Testing

```bash
# Run unit tests
./tests/run.sh

# Run tests using Docker (WordPress environment)
docker-compose run --rm wordpress bash -c   "cd /var/www/html/wp-content/plugins/colormeshop-wp-plugin && ./vendor/bin/phpunit"
```

- Tests use the WordPress test framework and VCR for recording/replaying HTTP requests
- VCR fixtures are stored in `tests/fixtures/`
- New API interactions can be recorded by switching VCR to record mode
- Coverage reports exclude generated Swagger code

---

### Code Quality

```bash
# Check coding standards (WordPress Coding Standards)
docker-compose run composer vendor/bin/phpcs --standard=ruleset.xml

# Auto-fix formatting issues
docker-compose run composer vendor/bin/phpcbf --standard=ruleset.xml
```

> Note: This plugin follows WordPress coding standards and naming conventions.  
> Claude should preserve these when suggesting code changes.

---

### Build and Deployment

```bash
# Generate API client from ColorMe Shop API (Swagger/OpenAPI)
make generate_api_client

# Build plugin zip for distribution (output: ./dist/colormeshop-wp-plugin.zip)
make

# Update autoload classmap after adding new classes
docker-compose run --rm composer dump-autoload
```

---

## Architecture

### Core Components

- **Plugin**: Main orchestrator that registers hooks, shortcodes, and DI container
- **Admin**: WordPress admin UI for plugin settings (OAuth credentials, page IDs)
- **Models**: Internal models for plugin settings and sitemap generation
- **API Layer**: Wrapper around Swagger-generated client for ColorMe Shop API
- **Shortcodes**: Functions to embed product data, images, cart buttons via shortcodes

---

### Key File Structure

| Path                         | Purpose                                    |
|-----------------------------|--------------------------------------------|
| `src/class-plugin.php`      | Plugin bootstrap and DI setup              |
| `src/class-admin.php`       | Admin UI and setting page                  |
| `src/Swagger/`              | Auto-generated ColorMe API client          |
| `src/shortcodes/`           | Shortcode definitions                      |
| `src/models/`               | Data models and logic                      |
| `templates/`                | PHP templates used in rendering            |

> Note: Filenames like `class-plugin.php` follow WordPress conventions — do not rename them.

---

### Dependency Injection (DI)

- The plugin uses [Pimple](https://pimple.symfony.com/) as a DI container.
- Key service bindings:
  - `oauth2_client`: OAuth2 client instance
  - `api.product_api`: Product API abstraction
  - `model.setting`: WordPress options access wrapper
  - `swagger.configuration`: Swagger client configuration (access token injected)

---

### Database Integration

- Plugin settings are stored using the WordPress Options API under the key:

```
colorme_wp_settings
```

---

### API Integration

- Uses Swagger client generated from ColorMe Shop API v1
- Authenticated via OAuth2 access token (user-provided)
- Abstraction layer wraps raw API client for safer access
- VCR (PHP-VCR) used to record HTTP interactions during tests

---

### WordPress Integration

- Custom rewrite rules for product pages and sitemap XML
- Uses hooks for title filtering and template redirection
- Supports device detection for rendering mobile-specific views
- Template override support via standard WordPress theme hierarchy

---

## Claude Usage Tips

- When modifying shortcodes, ensure arguments are processed using `shortcode_atts()`
- Always retrieve settings via the `model.setting` service rather than accessing options directly
- When adding templates, place them in the `templates/` directory and reference with `include()`
- When working on OAuth2 logic, ensure secure token storage using WP options and proper sanitization
- Avoid modifying files in `src/Swagger/` directly — these are auto-generated

---

## Appendix

### External Dependencies

- WordPress ≥ 5.0
- Composer (for dependency management)
- Docker (for development environment)

---

## License

See `LICENSE` file in the root of this repository.
