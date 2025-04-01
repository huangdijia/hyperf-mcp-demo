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

use Hyperf\Mcp\Annotation\Description;
use Hyperf\Mcp\Annotation\Tool;

class Foo
{
    #[Tool(
        name: 'getBirthday',
        description: 'Get the birthday of the person',
        serverName: 'mcp-sse'
    )]
    public function getBirthday(
        #[Description('姓名')]
        string $name
    ): mixed {
        return match ($name) {
            'John' => '1990-01-01',
            'Jane' => '1991-02-02',
            'Jack' => '1992-03-03',
            'Jill' => '1993-04-04',
            default => null,
        };
    }
}
