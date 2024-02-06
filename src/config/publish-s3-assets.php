<?php

return [
    'disk' => [
        'driver' => 's3',
        'key' => env('ASSET_AWS_ACCESS_KEY_ID', env('AWS_ACCESS_KEY_ID')),
        'secret' => env('ASSET_AWS_SECRET_ACCESS_KEY', env('AWS_SECRET_ACCESS_KEY')),
        'region' => env('ASSET_AWS_DEFAULT_REGION', env('AWS_DEFAULT_REGION')),
        'bucket' => env('ASSET_AWS_BUCKET'),
        'url' => env('ASSET_AWS_URL', env('AWS_URL')),
        'endpoint' => env('ASSET_AWS_ENDPOINT', env('AWS_ENDPOINT')),
        'use_path_style_endpoint' => env('ASSET_AWS_USE_PATH_STYLE_ENDPOINT', env('AWS_USE_PATH_STYLE_ENDPOINT', false)),
        'throw' => false,
        'visibility' => 'public',
    ]
];
