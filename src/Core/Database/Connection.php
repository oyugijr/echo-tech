<?php
/**
 * Database Connection Manager
 * 
 * Handles PDO database connections with proper error handling.
 */

namespace EcoTech\Core\Database;

use EcoTech\Core\Config\Config;
use PDO;
use PDOException;

class Connection
{
    private ?PDO $pdo = null;
    private ?string $error = null;
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->connect();
    }

    /**
     * Establish database connection
     */
    private function connect(): void
    {
        $host = $this->config->get('database.host');
        $dbname = $this->config->get('database.name');
        $user = $this->config->get('database.user');
        $pass = $this->config->get('database.pass');
        $charset = $this->config->get('database.charset');

        $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            // Log error but don't throw - allow pages to load without database
            error_log("Database connection failed: " . $this->error);
        }
    }

    /**
     * Get PDO instance
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * Check if connection is successful
     */
    public function isConnected(): bool
    {
        return $this->pdo !== null;
    }

    /**
     * Get connection error message
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * Execute a query and return all results
     */
    public function query(string $sql, array $params = []): array
    {
        if (!$this->pdo) {
            return [];
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Execute a query and return single result
     */
    public function queryOne(string $sql, array $params = []): ?array
    {
        if (!$this->pdo) {
            return null;
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Execute an insert/update/delete and return affected rows or last insert ID
     */
    public function execute(string $sql, array $params = []): int|false
    {
        if (!$this->pdo) {
            return false;
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            // Return last insert ID for INSERT statements
            if (stripos(trim($sql), 'INSERT') === 0) {
                return (int) $this->pdo->lastInsertId();
            }
            
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Execute failed: " . $e->getMessage());
            return false;
        }
    }
}
