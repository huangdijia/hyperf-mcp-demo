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

namespace App\Prompt;

use Mcp\Capability\Attribute\McpPrompt;

#[McpPrompt(
    name: 'code-review',
    description: 'Generate code review suggestions'
)]
class CodeReviewPrompt
{
    public function handle(array $params): array
    {
        $prompt = "Please review the following code and provide suggestions for improvement:\n\n";
        $prompt .= $params['code'] ?? '';

        return [
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        'type' => 'text',
                        'text' => $prompt,
                    ],
                ],
            ],
        ];
    }
}
