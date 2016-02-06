<?php

return [
    'zf_annotation' => [
        'annotations' => [
            'Toggle'
        ],
        'event_listeners' => [
            'ToggleListener'
        ]
    ],
    'qandidate_toggle' => [
        'persistence' => 'InMemory', // 'redis'
        'context_factory' => 'UserContextFactory', // |your.context_factory.service.id
        'redis_namespace' => null, // toggle_%kernel.environment% # default, only required when persistence = redis
        'redis_client' => null // |your.redis_client.service.id # only required when persistence = redis
    ]
];
