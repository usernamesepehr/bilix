<?php

return [
    'database' => 'elasticsearch',

    'queue' => 'default', // Set to 'default' to enable queuing for index builds (null disables queuing)

    'watchers' => [
        \Modules\Company\Models\Company::class => [
            \Modules\Company\Models\Indexes\IndexedCompany::class,
        ],
    ],

    'index_build_state' => [
        'enabled' => true,
        'log_trim' => 2,
    ],

    'index_migration_logs' => [
        'enabled' => true,
    ],

    'namespaces' => [
        'App\Models' => 'App\Models\Indexes',
        'Modules\Company\Models' => 'Modules\Company\Models\Indexes', // Use backslashes, match exact namespace
    ],

    'index_paths' => [
        'app/Models/Indexes/' => 'App\Models\Indexes',
        'Modules/Company/Models/Indexes/' => 'Modules\Company\Models\Indexes', // Add your module's index path
    ],
];