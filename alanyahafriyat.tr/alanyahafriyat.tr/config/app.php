<?php

use App\Core\Env;

return [
    'app' => [
        'name'    => Env::get('APP_NAME', 'Ersan Hafriyat'),
        'env'     => Env::get('APP_ENV', 'local'),
        'debug'   => Env::get('APP_DEBUG', false),
        'url'     => Env::get('APP_URL', 'http://127.0.0.1:8020'),
        'key'     => Env::get('APP_KEY', ''),
        'version' => Env::get('APP_VERSION', '1.0.0'),
    ],
    'digikey' => [
        'base_url'              => Env::get('DIGIKEY_BASE_URL', ''),
        'api_secret'            => Env::get('DIGIKEY_API_SECRET', ''),
        'product_slug'          => Env::get('DIGIKEY_PRODUCT_SLUG', 'ersan-hafriyat-cms'),
        'timeout'               => Env::get('DIGIKEY_API_TIMEOUT', 10),
        'verify_interval_hours' => Env::get('DIGIKEY_VERIFY_INTERVAL_HOURS', 24),
        'grace_days'            => Env::get('DIGIKEY_GRACE_DAYS', 7),
        'cache_secret'          => Env::get('DIGIKEY_CACHE_SECRET', ''),
        // Varsayılan production: .env'de DIGIKEY_ENV yoksa lisans kilidi AKTİFTİR.
        // local mod yalnızca geliştiricinin açıkça DIGIKEY_ENV=local yazmasıyla çalışır.
        'env'                   => Env::get('DIGIKEY_ENV', 'production'),
        // API uç yolları tek noktadan yönetilir; gerekirse .env ile override edilir.
        'endpoints' => [
            'activate'  => Env::get('DIGIKEY_ENDPOINT_ACTIVATE', '/api/v1/activate'),
            'verify'    => Env::get('DIGIKEY_ENDPOINT_VERIFY', '/api/v1/verify'),
            'heartbeat' => Env::get('DIGIKEY_ENDPOINT_HEARTBEAT', '/api/v1/heartbeat'),
            'health'    => Env::get('DIGIKEY_ENDPOINT_HEALTH', '/api/v1/public-settings'),
        ],
    ],
    'db' => [
        'connection'    => Env::get('DB_CONNECTION', 'sqlite'),
        'sqlite_path'   => Env::get('DB_DATABASE_SQLITE', 'storage/database.sqlite'),
        'host'          => Env::get('DB_HOST', '127.0.0.1'),
        'port'          => Env::get('DB_PORT', '3306'),
        'database'      => Env::get('DB_DATABASE', 'ersan_hafriyat'),
        'username'      => Env::get('DB_USERNAME', 'root'),
        'password'      => Env::get('DB_PASSWORD', ''),
    ],
    'upload' => [
        'max_size'      => 5 * 1024 * 1024, // 5 MB
        'allowed_mime'  => ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
        'allowed_ext'   => ['jpg', 'jpeg', 'png', 'webp', 'gif'],
    ],
];
