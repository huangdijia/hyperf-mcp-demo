# MCP Demo

基于 Hyperf 框架的 MCP (Micro-service Control Protocol) 演示项目。

## 简介

本项目展示了如何使用 Hyperf 框架的 MCP 组件来构建和管理微服务工具。通过注解的方式，可以轻松地将类方法暴露为微服务工具。

## 特性

- 基于 Hyperf 框架
- 使用注解方式定义工具
- 支持工具描述和参数说明

## 安装

```bash
# 克隆项目
git clone https://github.com/huangdijia/mcp-demo.git

# 安装依赖
composer install

# 复制环境配置文件
cp .env.example .env

# 启动服务
php bin/hyperf.php start
```

## 使用方法

### 配置

MCP 服务会自动通过 `config/autoload/mcp.php` 配置文件注册 SSE 路由。配置示例：

```php
<?php

declare(strict_types=1);

return [
    'servers' => [
        [
            'name' => 'demo',
            'version' => '1.0.0',
            'description' => 'This is a demo mcp server.',
            // The options of the sse server
            'sse' => [
                'server' => 'http',  // 指定使用的 HTTP 服务器名称
                'endpoint' => '/sse', // SSE 端点路径
            ],
        ],
    ],
];
```

**注意**：`friendsofhyperf/mcp` 包会自动注册 SSE 路由，无需手动在 `config/autoload/server.php` 中配置 MCP 服务器。只需确保 `config/autoload/server.php` 中配置了基本的 HTTP 服务器即可

### 定义工具

使用 `#[Tool]` 和 `#[Description]` 注解来定义工具和参数说明：

```php
use FriendsOfHyperf\MCP\Annotation\Description;
use FriendsOfHyperf\MCP\Annotation\Tool;

class Foo
{
    #[Tool(
        name: 'getBirthday',
        description: 'Get the birthday of the person',
        server: 'demo'  // 对应 config/autoload/mcp.php 中配置的服务器名称
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
}
```

### Cursor MCP 配置

要在 Cursor 中使用 MCP 工具，需要进行以下配置：

1. 在项目根目录下创建 `/Users/[your-name]/Library/Application Support/Claude/claude_desktop_config.json` 文件
2. 添加以下配置内容：

```json
{
  "mcpServers": {
    "mcp-php": {
      "command": "npx",
      "args": [
        "-y",
        "supergateway",
        "--sse",
        "http://127.0.0.1:9501/sse"
      ]
    }
  }
}
```

### VSCode MCP 配置

在 VSCode 中使用 MCP 工具，需要进行以下配置：

1. 在项目根目录下创建 `.vscode/mcp.json` 文件

```json
{
    "servers": {
        "mcp-server-stdio": {
            "type": "stdio",
            "command": "php",
            "args": [
                "${workspaceFolder}/bin/hyperf.php",
                "mcp:run",
                "--name",
                "demo"
            ],
            "env": {}
        },
        "mcp-server-sse": {
            "type": "sse",
            "url": "http://localhost:9501/sse"
        }
    }
}
```

![cursor-setting](./assets/cursor-setting.png)

### 执行结果

在 Cursor 中调用 MCP 工具：

![call-mcp-php](./assets/call-mcp-php.png)

## 许可证

本项目使用 [LICENSE](LICENSE) 许可证。
