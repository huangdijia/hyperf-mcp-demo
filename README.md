# MCP Demo

基于 Hyperf 框架的 MCP (Model Context Protocol) 演示项目。

## 简介

本项目展示了如何使用 Hyperf 框架的 MCP 组件来构建和管理微服务工具。通过注解的方式，可以轻松地将类方法暴露为微服务工具、资源和提示。

## 特性

- 基于 Hyperf 3.1 框架
- 使用注解方式定义工具、资源和提示
- 支持工具描述和参数说明
- 支持 HTTP 和 STDIO 两种传输模式
- 支持多种客户端集成（Cursor、VSCode 等）

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

### MCP 配置

MCP 服务的核心配置位于 `config/autoload/mcp.php` 中，包含服务器信息、发现配置、HTTP 和 STDIO 模式配置等。

## 使用方法

使用 `#[McpTool]` 注解来定义工具：

```php
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

### 定义资源

使用 `#[McpResource]` 注解来定义资源：

```php
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

### 定义提示

使用 `#[McpPrompt]` 注解来定义提示：

```php
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

### 启动服务

#### HTTP 模式

服务启动后，MCP 服务默认通过 `/mcp` 路径暴露，可通过以下 URL 访问：

```bash
http://localhost:9501/mcp
```

#### STDIO 模式

使用以下命令启动 STDIO 模式的 MCP 服务：

```bash
php bin/hyperf.php mcp:server
```

### Cursor MCP 配置

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
        "mcp-server-http": {
            "type": "http",
            "url": "http://localhost:9501/mcp"
        }
    }
}
```

## 项目结构

```bash
app/
├── Controller/          # HTTP 控制器
├── Exception/           # 异常处理器
├── Listener/            # 事件监听器
├── Model/               # 数据模型
├── Prompt/              # MCP 提示定义
├── Resource/            # MCP 资源定义
└── Tool/                # MCP 工具定义
config/
└── autoload/
    └── mcp.php          # MCP 核心配置
```

## 依赖

- PHP >= 8.1
- Hyperf 3.1
- friendsofhyperf/mcp-server

## 许可证

本项目使用 [MIT](LICENSE) 许可证。
