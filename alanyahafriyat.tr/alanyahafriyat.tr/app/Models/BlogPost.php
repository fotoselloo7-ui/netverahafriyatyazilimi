<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class BlogPost extends Model
{
    protected static string $table = 'blog_posts';

    public static function published(int $limit = 0, ?int $categoryId = null): array
    {
        $sql = "SELECT p.*, c.title AS category_title, c.slug AS category_slug
                FROM blog_posts p LEFT JOIN blog_categories c ON c.id = p.category_id
                WHERE p.status = 'published'";
        $params = [];
        if ($categoryId) {
            $sql .= ' AND p.category_id = ?';
            $params[] = $categoryId;
        }
        $sql .= ' ORDER BY p.published_at DESC, p.id DESC';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        return Database::select($sql, $params);
    }

    public static function publishedBySlug(string $slug): ?array
    {
        return Database::selectOne(
            "SELECT p.*, c.title AS category_title, c.slug AS category_slug
             FROM blog_posts p LEFT JOIN blog_categories c ON c.id = p.category_id
             WHERE p.slug = ? AND p.status = 'published'",
            [$slug]
        );
    }

    public static function recent(int $limit = 5): array
    {
        return static::published($limit);
    }
}
