# Otas Dynamic Pages

A comprehensive Laravel dynamic pages package that provides a robust content management system with pages, sections, items, custom attributes, and keywords support. Built with multilingual capabilities and media management integration.

## Features

- **Content Management**: Create and manage pages, sections, and section items
- **Multilingual Support**: Full Arabic and English translation support
- **Custom Attributes**: Flexible custom attribute system for enhanced content metadata
- **Keyword Management**: Organize content with a powerful keyword system
- **Media Integration**: Built-in media management capabilities
- **Admin Interface**: Complete admin controllers for content management
- **API Resources**: RESTful API endpoints for all entities
- **Filtering**: Advanced filtering capabilities for all content types
- **Validation**: Comprehensive form request validation
- **Database Migrations**: Automated database setup

## Requirements

- PHP 8.1+
- Laravel 11.0+
- MySQL/PostgreSQL database

## Installation

Install the package via Composer:

```bash
composer require otas/dynamic-pages
```

### Quick Setup

Run the setup command to install and configure the package:

```bash
php artisan dynamic-pages:setup
```

This command will:
- Publish the configuration file
- Cache the configurations
- Optionally run migrations

### Manual Installation

If you prefer manual setup:

1. **Publish the configuration file:**
```bash
php artisan vendor:publish --provider="Otas\DynamicPages\DynamicPagesServiceProvider"
```

2. **Run the migrations:**
```bash
php artisan migrate
```

3. **Cache the configuration:**
```bash
php artisan config:cache
```

## Configuration

After installation, you can find the configuration file at `config/dynamic_pages.php`. Customize the package settings according to your needs.

## Usage

### Models

The package provides several core models:

- **Page**: Main content pages
- **Section**: Content sections within pages
- **SectionItem**: Individual items within sections
- **CustomAttribute**: Flexible attribute system
- **Keyword**: Content organization and tagging

### Admin Controllers

Access the admin functionality through the provided controllers:

- `PageController` - Manage pages
- `SectionController` - Manage sections
- `SectionItemController` - Manage section items
- `KeywordController` - Manage keywords
- `CustomAttributeController` - Manage custom attributes

### API Resources

The package includes API resources for all entities, suitable for frontend frameworks or mobile applications.

### Multilingual Support

All content models support Arabic and English translations out of the box. The package uses the `mabrouk/translatable` package for translation management.

### Filtering

Advanced filtering is available for all models using the `mabrouk/filterable` package. Filter classes are organized in:
- `Admin/` - Admin interface filters
- `Website/` - Frontend filters
- `Support/` - Support system filters

## Dependencies

This package depends on:

- [mabrouk/translatable](https://github.com/ah-mabrouk/translatable) (>=2.0) - Multilingual support
- [mabrouk/filterable](https://github.com/ah-mabrouk/filterable) (>=1.0) - Advanced filtering
- [mabrouk/mediable](https://github.com/ah-mabrouk/mediable) (>=3) - Media management

## API Endpoints

The package provides three types of API endpoints with different access levels:

### Admin Routes (Admin Interface)
Base prefix: Configurable via `dynamic_pages.package_admin_routes_prefix`

- **Pages Management:**
  - `GET /pages` - List all pages
  - `GET /pages/{path}` - Get specific page (by path)
  - `PUT /pages/{path}` - Update page
  - `PATCH /pages/{path}` - Partially update page

- **Keywords Management:**
  - `GET /keywords` - List all keywords
  - `POST /keywords` - Create keyword
  - `GET /keywords/{id}` - Get specific keyword
  - `PUT /keywords/{id}` - Update keyword
  - `PATCH /keywords/{id}` - Partially update keyword
  - `DELETE /keywords/{id}` - Delete keyword

- **Page Keywords:**
  - `GET /pages/{path}/keywords` - Get page keywords
  - `POST /pages/{path}/keywords` - Assign keyword to page

- **Sections Management:**
  - `GET /pages/{path}/sections` - List page sections
  - `GET /pages/{path}/sections/{identifier}` - Get specific section (by identifier)
  - `PUT /pages/{path}/sections/{identifier}` - Update section
  - `PATCH /pages/{path}/sections/{identifier}` - Partially update section

- **Section Media:**
  - `POST /sections/{identifier}/medias` - Upload section media
  - `DELETE /sections/{identifier}/medias/{id}` - Delete section media

- **Section Custom Attributes:**
  - `GET /pages/{path}/sections/{identifier}/custom-attributes` - List section attributes
  - `GET /pages/{path}/sections/{identifier}/custom-attributes/{key}` - Get specific attribute (by key)
  - `PUT /pages/{path}/sections/{identifier}/custom-attributes/{key}` - Update attribute
  - `PATCH /pages/{path}/sections/{identifier}/custom-attributes/{key}` - Partially update attribute

- **Section Items Management:**
  - `GET /pages/{path}/sections/{identifier}/section-items` - List section items
  - `GET /pages/{path}/sections/{identifier}/section-items/{item_identifier}` - Get specific item (by identifier)
  - `PUT /pages/{path}/sections/{identifier}/section-items/{item_identifier}` - Update item
  - `PATCH /pages/{path}/sections/{identifier}/section-items/{item_identifier}` - Partially update item

- **Section Item Media:**
  - `POST /section-items/{item_identifier}/medias` - Upload item media
  - `DELETE /section-items/{item_identifier}/medias/{id}` - Delete item media

- **Section Item Custom Attributes:**
  - `GET /pages/{path}/sections/{identifier}/section-items/{item_identifier}/custom-attributes` - List item attributes
  - `GET /pages/{path}/sections/{identifier}/section-items/{item_identifier}/custom-attributes/{key}` - Get specific attribute (by key)
  - `PUT /pages/{path}/sections/{identifier}/section-items/{item_identifier}/custom-attributes/{key}` - Update attribute
  - `PATCH /pages/{path}/sections/{identifier}/section-items/{item_identifier}/custom-attributes/{key}` - Partially update attribute

### Support Routes (Support Interface)
Base prefix: Configurable via `dynamic_pages.package_support_routes_prefix`

Full CRUD operations available for all resources:
- `POST /pages` - Create page
- `DELETE /pages/{path}` - Delete page (by path)
- `POST /pages/{path}/sections` - Create section
- `DELETE /pages/{path}/sections/{identifier}` - Delete section (by identifier)
- `POST /pages/{path}/sections/{identifier}/section-items` - Create section item
- `DELETE /pages/{path}/sections/{identifier}/section-items/{item_identifier}` - Delete section item (by identifier)
- `POST /pages/{path}/sections/{identifier}/custom-attributes` - Create section custom attribute
- `DELETE /pages/{path}/sections/{identifier}/custom-attributes/{key}` - Delete section custom attribute (by key)
- `POST /pages/{path}/sections/{identifier}/section-items/{item_identifier}/custom-attributes` - Create section item custom attribute
- `DELETE /pages/{path}/sections/{identifier}/section-items/{item_identifier}/custom-attributes/{key}` - Delete section item custom attribute (by key)
- All other endpoints same as Admin routes but with full CRUD capabilities

### Website Routes (Public Interface)
Base prefix: Configurable via `dynamic_pages.package_website_routes_prefix`

- `GET /pages` - List public pages
- `GET /pages/{path}` - Get specific public page (by path)

## Configuration

The package can be configured via the `config/dynamic_pages.php` file:

### Route Configuration

```php
// Global API prefix for all routes
'package_routes_prefix' => 'api',

// Specific prefixes for different route types
'package_admin_routes_prefix' => '',
'package_support_routes_prefix' => '',
'package_website_routes_prefix' => '',

// Enable/disable route loading
'load_routes' => true,
```

### Middleware Configuration

```php
'middlewares' => [
    'admin' => [
        // Add your admin middleware here
        // Example: 'auth:admin', 'permission:manage-dynamic-pages'
    ],
    'support' => [
        // Add your support middleware here
        // Example: 'auth:support', 'permission:support-access'
    ],
    'website' => [
        // Add your public middleware here
        // Example: 'throttle:60,1', 'cors'
    ],
],
```

### Configuration Keys Usage

- **`package_routes_prefix`**: Sets the global prefix for all dynamic pages routes (e.g., 'api' results in `/api/pages`)
- **`package_admin_routes_prefix`**: Additional prefix for admin routes (e.g., 'admin' with global prefix results in `/api/admin/pages`)
- **`package_support_routes_prefix`**: Additional prefix for support routes
- **`package_website_routes_prefix`**: Additional prefix for public website routes
- **`middlewares`**: Define different middleware stacks for each route type to control access and behavior
- **`load_routes`**: Control whether package routes should be loaded (useful for custom route implementations)

## Content Seeding

The package provides a comprehensive content seeding system to help you populate your dynamic pages with initial content.

### Using the Content Seeder

1. **Publish the Content Seeder:**
```bash
php artisan vendor:publish --provider="Otas\DynamicPages\DynamicPagesServiceProvider"
```

2. **Locate the Seeder:** Find the published seeder at `database/seeders/DynamicPagesContentSeeder.php`

3. **Configure Content:** Edit the seeder file to define your content structure:

```php
DynamicPagesSeeder::seedContent([
    [
        'page_path' => 'home',
        'translation_data' => [
            'en' => [
                'name' => 'Home',
                'title' => 'Page Title',
                'description' => 'Page Description',
            ],
            'ar' => [
                'name' => 'الرئيسية',
                'title' => 'عنوان الصفحة',
                'description' => 'تفاصيل الصفحة',
            ],
        ],
        'sections' => [
            [
                'identifier' => 'hero-section',
                'has_title' => true,
                'has_description' => true,
                'images_count' => 1,
                'has_items' => true,
                'item_images_count' => 1,
                'has_items_title' => true,
                'has_items_description' => true,
                'title_validation_text' => 'sometimes|string|min:3|max:190',
                'description_validation_text' => 'sometimes|string|min:3|max:1000',
                'translation_data' => [
                    'en' => ['name' => 'Hero Section'],
                    'ar' => ['name' => 'قسم البطل'],
                ],
                'items' => [
                    // Section items configuration
                ],
                'custom_attributes' => [
                    // Custom attributes configuration
                ],
            ],
        ],
    ],
]);
```

4. **Run the Seeder:**
```bash
php artisan db:seed --class=DynamicPagesContentSeeder
```

### Content Structure

The seeder supports the following structure:

- **Pages**: Define page paths and multilingual content
- **Sections**: Configure section properties including validation rules
- **Section Items**: Add items within sections with their own attributes
- **Custom Attributes**: Flexible attribute system for both sections and section items
- **Multilingual Support**: Full Arabic and English translation support for all content

### Seeder Features

- **Transaction Safety**: All seeding operations are wrapped in database transactions
- **Duplicate Prevention**: The seeder checks for existing content to prevent duplicates
- **Flexible Configuration**: Support for various content types and validation rules
- **Multilingual Content**: Automatic translation handling for all supported languages

## Database Structure

The package creates the following tables:

- `pages` - Main content pages
- `page_translations` - Page translations
- `sections` - Content sections
- `section_translations` - Section translations
- `section_items` - Section items
- `section_item_translations` - Section item translations
- `custom_attributes` - Custom attributes
- `custom_attribute_translations` - Custom attribute translations
- `keywords` - Keywords
- `keyword_translations` - Keyword translations
- `keyword_related_objects` - Keyword relationships

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).