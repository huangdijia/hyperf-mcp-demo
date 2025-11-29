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

use InvalidArgumentException;
use Mcp\Capability\Attribute\McpTool;

class Calculator
{
    /**
     * Performs arithmetic operations with validation.
     */
    #[McpTool(name: 'calculate')]
    public function performCalculation(float $a, float $b, string $operation): float
    {
        return match ($operation) {
            'add' => $a + $b,
            'subtract' => $a - $b,
            'multiply' => $a * $b,
            'divide' => $b != 0 ? $a / $b : throw new InvalidArgumentException('Division by zero'),
            default => throw new InvalidArgumentException('Invalid operation')
        };
    }
}
