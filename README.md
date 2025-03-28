# MCP Demo

基于 Hyperf 框架的 MCP (Micro-service Control Protocol) 演示项目。

## 简介

本项目展示了如何使用 Hyperf 框架的 MCP 组件来构建和管理微服务工具。通过注解的方式，可以轻松地将类方法暴露为微服务工具。

## 特性

- 基于 Hyperf 框架
- 使用注解方式定义工具
- 支持工具描述和参数说明
- 支持多服务部署
- Docker 容器化支持

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

### 定义工具

使用 `#[Tool]` 和 `#[Description]` 注解来定义工具和参数说明：

```php
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
    ):mixed
    {
        return match ($name) {
            'John' => '1990-01-01',
            'Jane' => '1991-02-02',
            'Jack' => '1992-03-03',
            'Jill' => '1993-04-04',
            default => null,
        };
    }
}
```

### Docker 部署

项目提供了 Docker 支持，可以使用以下命令进行部署：

```bash
# 使用 docker-compose 启动
docker-compose up -d
```

## 测试

```bash
composer test
```

## 许可证

本项目使用 [LICENSE](LICENSE) 许可证。