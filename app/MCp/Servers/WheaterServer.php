<?php

namespace App\Mcp\Servers;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('Wheater Server')]
#[Version('0.0.1')]
#[Instructions('Instructions describing how to use the server and its features.')]
class WheaterServer extends Server
{
    protected array $tools = [
        \App\MCp\Tools\GetWheaterTool::class,
        \App\MCp\Tools\CheckWheaterTool::class,
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}
