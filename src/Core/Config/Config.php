<?php
/**
 * Configuration Manager
 * 
 * Handles loading and accessing application configuration from environment variables.
 */

namespace EcoTech\Core\Config;

class Config
{
    private string $basePath;
    private array $config = [];
    private bool $loaded = false;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Load configuration from environment
     */
    public function load(): void
    {
        if ($this->loaded) {
            return;
        }

        // Load .env file using vlucas/phpdotenv
        $dotenv = \Dotenv\Dotenv::createImmutable($this->basePath);
        $dotenv->safeLoad();

        // Build configuration array from environment variables
        $this->config = [
            'database' => [
                'host' => $_ENV['DB_HOST'] ?? 'localhost',
                'name' => $_ENV['DB_NAME'] ?? 'ecotech',
                'user' => $_ENV['DB_USER'] ?? 'root',
                'pass' => $_ENV['DB_PASS'] ?? '',
                'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
            ],
            'site' => [
                'name' => $_ENV['SITE_NAME'] ?? 'EcoTech Solutions',
                'email' => $_ENV['SITE_EMAIL'] ?? 'info@ecotechsolutions.com',
            ],
            'email' => [
                'smtp_server' => $_ENV['SMTP_SERVER'] ?? '',
                'smtp_port' => $_ENV['SMTP_PORT'] ?? 587,
                'sender' => $_ENV['EMAIL_SENDER'] ?? '',
                'password' => $_ENV['EMAIL_PASSWORD'] ?? '',
            ],
        ];

        $this->loaded = true;
    }

    /**
     * Get a configuration value using dot notation
     * 
     * @param string $key Configuration key (e.g., 'database.host')
     * @param mixed $default Default value if key not found
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * Check if a configuration key exists
     */
    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    /**
     * Get all configuration as array
     */
    public function all(): array
    {
        return $this->config;
    }
}
