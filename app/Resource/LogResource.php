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

namespace App\Resource;

use Mcp\Capability\Attribute\McpResource;

#[McpResource(
    uri: 'file:///var/log/app.log',
    name: 'Application Log',
    description: 'Current application log file',
    mimeType: 'text/plain'
)]
class LogResource
{
    public function handle(array $params): array
    {
        $content = file_get_contents('/var/log/app.log');
        return [
            'contents' => [
                [
                    'uri' => $params['uri'],
                    'mimeType' => 'text/plain',
                    'text' => $content,
                ],
            ],
        ];
    }
}
