<?php

namespace Otas\DynamicPages;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Otas\DynamicPages\Console\Commands\DynamicPagesPublishRoutesCommand;
use Otas\DynamicPages\Console\Commands\DynamicPagesSetupCommand;

class DynamicPagesServiceProvider extends ServiceProvider
{
    private array $packageMigrations = [
        'create_custom_attribute_translations_table',
        'create_custom_attributes_table',
        'create_keyword_related_objects_table',
        'create_keyword_translations_table',
        'create_keywords_table',
        'create_page_translations_table',
        'create_pages_table',
        'create_section_item_translations_table',
        'create_section_items_table',
        'create_section_translations_table',
        'create_sections_table',
    ];

    private array $packageSeeders = [
        'DynamicPagesContentSeeder',
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require_once __DIR__ . '/Helpers/DynamicPagesHelperFunctions.php';

        $this->registerRoutes();

        if ($this->app->runningInConsole()) {

            $this->commands([
                DynamicPagesSetupCommand::class,
                DynamicPagesPublishRoutesCommand::class,
            ]);

            $this->publishMigrations();
            $this->publishSeeders();
            $this->publishLanguageFiles();
            $this->publishConfig();
        }
    }

    /**
     * load routes from the route files.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        if (config('dynamic_pages.load_routes')) {
            Route::group($this->routeConfiguration(), function () {
                $this->loadRoutesFrom(__DIR__ . '/routes/dynamic_pages_admin_routes.php');
                $this->loadRoutesFrom(__DIR__ . '/routes/dynamic_pages_support_routes.php');
                $this->loadRoutesFrom(__DIR__ . '/routes/dynamic_pages_website_routes.php');
            });
        }
    }

    /**
     * Get the route configuration for the package.
     *
     * @return array
     */
    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('dynamic_pages.package_routes_prefix'),
        ];
    }

    /**
     * Publish migration files.
     */
    protected function publishMigrations(): void
    {
        $migrationFiles = $this->migrationFiles();

        if (\count($migrationFiles) > 0) {
            $this->publishes($migrationFiles, 'dynamic-pages-migrations');
        }
    }

    protected function migrationFiles(): array
    {
        $migrationFiles = [];

        foreach ($this->packageMigrations as $migrationName) {
            if (! $this->migrationExists($migrationName)) {
                $migrationFiles[__DIR__ . "/database/migrations/{$migrationName}.php.stub"] = database_path('migrations/' . date('Y_m_d_His', time()) . "_{$migrationName}.php");
            }
        }
        return $migrationFiles;
    }

    /**
     * Publish seeder files.
     */
    protected function publishSeeders(): void
    {
        $seedersFiles = $this->seedersFiles();

        if (\count($seedersFiles) > 0) {
            $this->publishes($seedersFiles, 'dynamic-pages-seeders');
        }
    }

    /**
     * Get the seeder files that need to be published.
     *
     * @return array
     */
    protected function seedersFiles(): array
    {
        $seedersFiles = [];

        foreach ($this->packageSeeders as $seederName) {
            if (! $this->seederExists($seederName)) {
                $seedersFiles[__DIR__ . "/database/seeders/{$seederName}.php.stub"] = database_path("seeders/{$seederName}.php");
            }
        }
        return $seedersFiles;
    }

    /**
     * Check if a seeder exists.
     *
     * @param string $seederName The seeder name to check
     * @return bool
     */
    protected function seederExists(string $seederName): bool
    {
        return $this->fileExistsInDirectory(database_path('seeders/'), $seederName);
    }

    /**
     * Publish language files.
     */
    protected function publishLanguageFiles(): void
    {
        $this->publishes([
            __DIR__ . '/resources/lang' => App::langPath(),
        ], 'dynamic-pages-lang');
    }

    /**
     * Publish config files.
     */
    protected function publishConfig(): void
    {
        $this->publishes([
            __DIR__ . '/config/dynamic_pages.php' => config_path('dynamic_pages.php'),
        ], 'dynamic-pages-config');
    }

    /**
     * Check if a file exists in a directory by partial name match.
     *
     * @param string $path The directory path to search in
     * @param string $fileName The partial file name to search for
     * @return bool
     */
    protected function fileExistsInDirectory(string $path, string $fileName): bool
    {
        $files = \scandir($path);

        foreach ($files as $value) {
            if (str_contains($value, $fileName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a migration exists.
     *
     * @param string $migrationName The migration name to check
     * @return bool
     */
    protected function migrationExists(string $migrationName): bool
    {
        return $this->fileExistsInDirectory(database_path('migrations/'), $migrationName);
    }
}
