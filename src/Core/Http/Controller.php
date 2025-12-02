<?php
/**
 * Base Controller
 * 
 * Abstract base class for all module controllers.
 * Provides common functionality and access to core services.
 */

namespace EcoTech\Core\Http;

use EcoTech\Core\Application;
use EcoTech\Core\Database\Connection;

abstract class Controller
{
    protected Application $app;
    protected Request $request;

    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->request = new Request();
    }

    /**
     * Get the database connection
     */
    protected function db(): ?Connection
    {
        return $this->app->database();
    }

    /**
     * Get the PDO instance
     */
    protected function pdo(): ?\PDO
    {
        return $this->app->pdo();
    }

    /**
     * Get configuration value
     */
    protected function config(string $key, mixed $default = null): mixed
    {
        return $this->app->config()->get($key, $default);
    }

    /**
     * Render a view from a module
     * 
     * @param string $view View path relative to module's Views directory
     * @param array $data Data to pass to the view
     */
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        
        // Get the module name from the controller's namespace
        $reflection = new \ReflectionClass($this);
        $namespace = $reflection->getNamespaceName();
        
        // Parse module name from namespace (e.g., EcoTech\Modules\Auth\Controllers -> Auth)
        if (preg_match('/EcoTech\\\\Modules\\\\(\w+)/', $namespace, $matches)) {
            $moduleName = $matches[1];
            $viewPath = $this->app->srcPath("Modules/{$moduleName}/Views/{$view}.php");
        } else {
            // Fallback to public path for legacy views
            $viewPath = $this->app->publicPath($view);
        }

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new \RuntimeException("View not found: {$view}");
        }
    }

    /**
     * Include a shared partial (header, footer, etc.)
     */
    protected function partial(string $partial, array $data = []): void
    {
        extract($data);
        $partialPath = $this->app->publicPath("includes/{$partial}.php");
        
        if (file_exists($partialPath)) {
            require $partialPath;
        }
    }

    /**
     * JSON response helper
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        Response::json($data, $statusCode);
    }

    /**
     * Success response helper
     */
    protected function success(array $data = [], string $message = ''): void
    {
        Response::success($data, $message);
    }

    /**
     * Error response helper
     */
    protected function error(string $message, int $statusCode = 400): void
    {
        Response::error($message, $statusCode);
    }

    /**
     * Redirect helper
     */
    protected function redirect(string $url): void
    {
        Response::redirect($url);
    }

    /**
     * Redirect with message helper
     */
    protected function redirectWithMessage(string $url, string $message, string $type = 'info'): void
    {
        Response::redirectWithMessage($url, $message, $type);
    }
}
