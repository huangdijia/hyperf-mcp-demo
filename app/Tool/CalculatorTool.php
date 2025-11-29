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

namespace App\Tool;

use Mcp\Capability\Attribute\McpTool;

#[McpTool(
    name: 'calculator.add',
    description: 'Add two numbers together'
)]
class CalculatorTool
{
    public function handle(array $params): array
    {
        $result = $params['a'] + $params['b'];
        return [
            'content' => [
                [
                    'type' => 'text',
                    'text' => "The sum of {$params['a']} and {$params['b']} is {$result}",
                ],
            ],
        ];
    }
}
