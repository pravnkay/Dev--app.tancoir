<?php

return [
    'routes' => [
        'root'  => 'backend.dashboard',
        'admin' => 'backend.dashboard',
        'user'  => 'app.index',
    ],
    'fallback' => 'core.index',
];
