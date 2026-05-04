<?php

use Laravel\Mcp\Facades\Mcp;
use App\Mcp\Servers\WheaterServer;

Mcp::local('weather', WheaterServer::class);
