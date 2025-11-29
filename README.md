# MCP Demo

基于 Hyperf 框架的 MCP (Model Context Protocol) 演示项目。

## 简介

本项目展示了如何使用 [friendsofhyperf/mcp-server](https://github.com/friendsofhyperf/mcp-server) 组件来构建 MCP 服务器。通过注解的方式，可以轻松地定义工具（Tools）、提示（Prompts）和资源（Resources）。

## 特性

- 基于 Hyperf 框架
- 使用注解方式定义工具（`#[McpTool]`）
- 使用注解方式定义提示（`#[McpPrompt]`）
- 使用注解方式定义资源（`#[McpResource]`）
- 支持 SSE 和 STDIO 两种传输模式

## 安装

```bash
# 克隆项目
git clone https://github.com/huangdijia/hyperf-mcp-demo.git

# 安装依赖
composer install

# 复制环境配置文件
cp .env.example .env

# 启动服务
php bin/hyperf.php start
```

## 配置

### MCP 服务配置

在 `config/autoload/mcp.php` 中配置 MCP 服务：

```php
<?php

return [
    'servers' => [
        [
            'enabled' => true,

            // Server basic information
            'name' => 'Hyperf MCP Server',
            'version' => '1.0.0',
            'description' => 'A powerful MCP server built on Hyperf framework.',

            // Protocol version
            'protocol_version' => '2024-11-05',

            // Class discovery configuration
            'discovery' => [
                'base_path' => BASE_PATH,
                'scan_dirs' => ['.', 'src', 'app'],
                'exclude_dirs' => ['vendor', 'tests', 'config'],
            ],

            // HTTP mode configuration
            'http' => [
                'path' => '/mcp',
            ],

            // STDIO mode configuration
            'stdio' => [
                'name' => 'mcp:server',
                'description' => 'Run the MCP server via STDIO transport.',
            ],
        ],
    ],
];
```

## 使用方法

### 定义工具 (Tool)

使用 `#[McpTool]` 注解来定义工具：

```php
<?php

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
```

### 定义提示 (Prompt)

使用 `#[McpPrompt]` 注解来定义提示：

```php
<?php

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
```

### 定义资源 (Resource)

使用 `#[McpResource]` 注解来定义资源：

```php
<?php

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
```

### Claude Desktop 配置

要在 Claude Desktop 中使用 MCP 工具，需要进行以下配置：

1. 编辑配置文件 `~/Library/Application Support/Claude/claude_desktop_config.json`（macOS）
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
        "http://127.0.0.1:9501/mcp"
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
                "mcp:server"
            ],
            "env": {}
        },
        "mcp-server-sse": {
            "type": "sse",
            "url": "http://localhost:9501/mcp"
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
