<?php
/**
 * Pages Service
 * 
 * Handles data retrieval for static pages like services, projects, etc.
 */

namespace EcoTech\Modules\Pages;

use EcoTech\Core\Database\Connection;

class PagesService
{
    private ?Connection $db;

    /**
     * Sample services data
     */
    private array $sampleServices = [
        ['title' => 'Smart Energy Management', 'description' => 'Intelligent energy monitoring and optimization systems for maximum efficiency', 'image' => 'energy-management.jpg', 'features' => '["Real-time energy monitoring","Automated optimization","Cost reduction analytics"]'],
        ['title' => 'Water Conservation Solutions', 'description' => 'Advanced water recycling and conservation technologies', 'image' => 'water-conservation.jpg', 'features' => '["Smart irrigation systems","Water recycling","Leak detection"]'],
        ['title' => 'Sustainable Infrastructure', 'description' => 'Green building and infrastructure consulting services', 'image' => 'sustainable-infra.jpg', 'features' => '["LEED certification support","Green materials consulting","Energy-efficient design"]'],
        ['title' => 'Environmental Consulting', 'description' => 'Expert guidance on environmental compliance and sustainability', 'image' => 'consulting.jpg', 'features' => '["Regulatory compliance","Sustainability audits","Carbon footprint analysis"]']
    ];

    /**
     * Sample projects data
     */
    private array $sampleProjects = [
        ['id' => 1, 'title' => 'Smart Energy Grid Implementation', 'description' => 'Comprehensive smart grid solution reducing energy waste and improving efficiency', 'image' => 'smart-grid.jpg', 'client' => 'Global Energy Corp', 'year' => '2024', 'location' => 'North America'],
        ['id' => 2, 'title' => 'Industrial Water Conservation', 'description' => 'Advanced water recycling system for manufacturing facilities', 'image' => 'water-system.jpg', 'client' => 'Manufacturing Inc', 'year' => '2023', 'location' => 'Europe'],
        ['id' => 3, 'title' => 'Solar Panel Campus', 'description' => 'Large-scale solar energy installation for educational campus', 'image' => 'solar-panels.jpg', 'client' => 'State University', 'year' => '2023', 'location' => 'California, USA'],
        ['id' => 4, 'title' => 'Green Building Retrofit', 'description' => 'Sustainable renovation of historic office building', 'image' => 'green-building.jpg', 'client' => 'Downtown Properties', 'year' => '2022', 'location' => 'New York, USA']
    ];

    /**
     * Sample featured projects for home page
     */
    private array $sampleFeaturedProjects = [
        ['id' => 1, 'title' => 'Smart Energy Grid', 'description' => 'Innovative smart grid solution reducing energy waste by 40%', 'image' => 'smart-grid.jpg'],
        ['id' => 2, 'title' => 'Water Conservation System', 'description' => 'Advanced water recycling system for industrial facilities', 'image' => 'water-system.jpg'],
        ['id' => 3, 'title' => 'Solar Panel Integration', 'description' => 'Complete solar energy solution for commercial buildings', 'image' => 'solar-panels.jpg']
    ];

    public function __construct(?Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Get all services
     */
    public function getServices(): array
    {
        $pdo = $this->db?->getPdo();

        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM services");
                $services = $stmt->fetchAll();
                if (!empty($services)) {
                    return $services;
                }
            } catch (\PDOException $e) {
                // Table might not exist
            }
        }

        return $this->sampleServices;
    }

    /**
     * Get all projects
     */
    public function getProjects(): array
    {
        $pdo = $this->db?->getPdo();

        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM projects ORDER BY year DESC");
                $projects = $stmt->fetchAll();
                if (!empty($projects)) {
                    return $projects;
                }
            } catch (\PDOException $e) {
                // Table might not exist
            }
        }

        return $this->sampleProjects;
    }

    /**
     * Get featured projects for home page
     */
    public function getFeaturedProjects(int $limit = 3): array
    {
        $pdo = $this->db?->getPdo();

        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM projects WHERE featured = TRUE ORDER BY year DESC LIMIT " . (int) $limit);
                $projects = $stmt->fetchAll();
                if (!empty($projects)) {
                    return $projects;
                }
            } catch (\PDOException $e) {
                // Table might not exist
            }
        }

        return array_slice($this->sampleFeaturedProjects, 0, $limit);
    }
}
