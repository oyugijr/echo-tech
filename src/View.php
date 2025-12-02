<?php

namespace App;

class View
{
    private static string $templatesPath;
    
    public static function init(): void
    {
        $config = require __DIR__ . '/../config/app.php';
        self::$templatesPath = $config['paths']['templates'];
    }
    
    public static function render(string $template, array $data = []): void
    {
        if (empty(self::$templatesPath)) {
            self::init();
        }
        
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include template file
        $templateFile = self::$templatesPath . '/' . $template . '.php';
        
        if (!file_exists($templateFile)) {
            throw new \Exception("Template not found: $templateFile");
        }
        
        include $templateFile;
        
        // Get content
        $content = ob_get_clean();
        
        echo $content;
    }
    
    public static function renderWithLayout(string $template, array $data = [], string $layout = 'layouts/main'): void
    {
        if (empty(self::$templatesPath)) {
            self::init();
        }
        
        // Extract data to variables
        extract($data);
        
        // Start output buffering for content
        ob_start();
        
        // Include template file
        $templateFile = self::$templatesPath . '/' . $template . '.php';
        
        if (!file_exists($templateFile)) {
            throw new \Exception("Template not found: $templateFile");
        }
        
        include $templateFile;
        
        // Get content
        $content = ob_get_clean();
        
        // Include layout with content
        $layoutFile = self::$templatesPath . '/' . $layout . '.php';
        
        if (!file_exists($layoutFile)) {
            throw new \Exception("Layout not found: $layoutFile");
        }
        
        include $layoutFile;
    }
}
