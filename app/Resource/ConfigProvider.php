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

class ConfigProvider
{
    /**
     * Provides the current application configuration.
     */
    #[McpResource(uri: 'config://app/settings', name: 'app_settings')]
    public function getSettings(): array
    {
        return [
            'version' => '1.0.0',
            'debug' => false,
            'features' => ['auth', 'logging'],
        ];
    }
}
