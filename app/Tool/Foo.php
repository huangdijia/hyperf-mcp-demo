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

use FriendsOfHyperf\MCP\Annotation\Description;
use FriendsOfHyperf\MCP\Annotation\Tool;

class Foo
{
    #[Tool(
        name: 'getBirthday',
        description: '获取个人的生日',
        server: 'demo'
    )]
    public function getBirthday(
        #[Description('姓名')]
        string $name
    ): array {
        return [
            'toolResult' => match ($name) {
                'John' => '1990-01-01',
                'Jane' => '1991-02-02',
                'Jack' => '1992-03-03',
                'Jill' => '1993-04-04',
                default => null,
            },
        ];
    }

    #[Tool(
        name: 'add',
        description: '将两个数字相加',
        server: 'demo'
    )]
    public function add(
        #[Description('第一个数字')]
        int $a,
        #[Description('第二个数字')]
        int $b
    ): array {
        return ['toolResult' => $a + $b];
    }

    #[Tool(
        name: 'multiply',
        description: '将两个数字相乘',
        server: 'demo'
    )]
    public function multiply(
        #[Description('第一个数字')]
        int $a,
        #[Description('第二个数字')]
        int $b
    ): array {
        return ['toolResult' => $a * $b];
    }

    #[Tool(
        name: 'textProcess',
        description: '处理文本字符串',
        server: 'demo'
    )]
    public function textProcess(
        #[Description('要处理的文本')]
        string $text,
        #[Description('操作,如：uppercase、lowercase、capitalize、reverse')]
        string $operation
    ): array {
        switch ($operation) {
            case 'uppercase':
                $result = strtoupper($text);
                break;
            case 'lowercase':
                $result = strtolower($text);
                break;
            case 'capitalize':
                $result = ucwords($text);
                break;
            case 'reverse':
                $result = strrev($text);
                break;
            default:
                $result = $text;
        }

        return ['toolResult' => $result];
    }
}
