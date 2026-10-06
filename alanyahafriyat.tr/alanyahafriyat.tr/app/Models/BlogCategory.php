<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class BlogCategory extends Model
{
    protected static string $table = 'blog_categories';

    public static function withCounts(): array
    {
        return Database::select(
            "SELECT c.*, (SELECT COUNT(*) FROM blog_posts p WHERE p.category_id = c.id AND p.status = 'published') AS post_count
             FROM blog_categories c WHERE c.is_active = 1 ORDER BY c.sort_order ASC"
        );
    }
}
