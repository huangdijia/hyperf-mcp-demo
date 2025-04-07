<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'servers' => [
        [
            'name' => 'demo',
            'version' => '1.0.0',
            'description' => 'This is a demo mcp server.',
            // The options of the sse server
            'sse' => [
                'server' => 'mcp-sse',
                'endpoint' => '/sse',
            ],
        ],
    ],
];
