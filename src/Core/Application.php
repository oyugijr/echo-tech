<?php
/**
 * Core Application class
 * 
 * Central bootstrap for the modular application architecture.
 * Handles autoloading, configuration, and module initialization.
 */

namespace EcoTech\Core;

use EcoTech\Core\Config\Config;
use EcoTech\Core\Database\Connection;

class Application
{
    private static ?Application $instance = null;
    private Config $config;
    private ?Connection $database = null;
    private string $basePath;

    private function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
        $this->config = new Config($this->basePath);
    }

    /**
     * Get the singleton application instance
     */
    public static function getInstance(?string $basePath = null): Application
    {
        if (self::$instance === null) {
            if ($basePath === null) {
                throw new \RuntimeException('Base path required for first initialization');
            }
            self::$instance = new self($basePath);
        }
        return self::$instance;
    }

    /**
     * Initialize the application
     */
    public function boot(): void
    {
        $this->config->load();
        $this->database = new Connection($this->config);
    }

    /**
     * Get the configuration instance
     */
    public function config(): Config
    {
        return $this->config;
    }

    /**
     * Get the database connection
     */
    public function database(): ?Connection
    {
        return $this->database;
    }

    /**
     * Get the PDO instance
     */
    public function pdo(): ?\PDO
    {
        return $this->database?->getPdo();
    }

    /**
     * Get the base path of the application
     */
    public function basePath(string $path = ''): string
    {
        return $this->basePath . ($path ? '/' . ltrim($path, '/') : '');
    }

    /**
     * Get the source path
     */
    public function srcPath(string $path = ''): string
    {
        return $this->basePath('src' . ($path ? '/' . ltrim($path, '/') : ''));
    }

    /**
     * Get the public path (root directory)
     */
    public function publicPath(string $path = ''): string
    {
        return $this->basePath($path);
    }
}
