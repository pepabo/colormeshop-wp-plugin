# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a WordPress plugin that integrates with ColorMe Shop (カラーミーショップ) API to display product information and generate product pages within WordPress. The plugin uses OAuth2 authentication and provides shortcodes for embedding product information.

## Development Commands

### Setup
```bash
# Copy environment file and start Docker containers
cp wp.env.sample wp.env
docker-compose up -d
```

### Testing
```bash
# Run unit tests
./tests/run.sh

# Run tests using Docker
docker-compose run --rm wordpress bash -c "cd /var/www/html/wp-content/plugins/colormeshop-wp-plugin && ./vendor/bin/phpunit"
```

### Code Quality
```bash
# Check coding standards (WordPress Coding Standards)
docker-compose run composer vendor/bin/phpcs --standard=ruleset.xml

# Auto-fix code formatting issues
docker-compose run composer vendor/bin/phpcbf --standard=ruleset.xml
```

### Build and Deployment
```bash
# Generate API client from ColorMe Shop API
make generate_api_client

# Build plugin zip file for distribution
make

# Update autoload classmap after adding new classes
docker-compose run --rm composer dump-autoload
```

## Architecture

### Core Components

- **Plugin**: Main plugin class that handles WordPress hooks, shortcode registration, and DI container setup
- **Admin**: WordPress admin interface for plugin configuration (OAuth settings, product page ID)
- **Models**: Data models for Settings and Sitemap generation
- **API Layer**: Wrapper around generated Swagger API client for ColorMe Shop API
- **Shortcodes**: WordPress shortcodes for displaying products, images, options, and cart buttons

### Key Files

- `src/class-plugin.php`: Main plugin orchestrator with DI container
- `src/class-admin.php`: WordPress admin interface
- `src/Swagger/`: Auto-generated API client from ColorMe Shop API
- `src/shortcodes/`: WordPress shortcodes for product display
- `src/models/`: Data models and business logic
- `templates/`: PHP templates for rendering

### DI Container Structure

The plugin uses Pimple for dependency injection. Key services:
- `oauth2_client`: OAuth2 authentication client
- `api.product_api`: Product API wrapper
- `model.setting`: Plugin settings management
- `swagger.configuration`: API configuration with access token

### Database Integration

Settings are stored using WordPress options API under the key `colorme_wp_settings`.

### API Integration

- Uses generated Swagger client for ColorMe Shop API v1
- Implements OAuth2 flow with access token storage
- Provides abstraction layer over raw API responses
- Includes VCR fixtures for testing API interactions

### WordPress Integration

- Registers custom rewrite rules for product pages and sitemaps
- Uses WordPress hooks for title filtering and template redirection
- Follows WordPress coding standards and file naming conventions
- Supports mobile detection and custom templates

## Testing

- PHPUnit with WordPress test framework
- VCR for recording and replaying HTTP requests
- Separate test classes mirror the source structure
- Coverage reporting excludes generated Swagger code
