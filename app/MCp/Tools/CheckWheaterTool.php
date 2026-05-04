<?php
namespace App\MCp\Tools;

use Laravel\Mcp\Request;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\JsonSchema\JsonSchema;

#[Description('Get wheater for a specific city through open meteo API using latitude and longitude')]
class CheckWheaterTool extends Tool
{
    public function handle(Request $request)
    {
        $lat  = $request->get('lat');
        $long = $request->get('long');
        $city = $request->get('city') ?? 'Unknown City';

        $weather = Http::timeout(15)->get("https://api.open-meteo.com/v1/forecast",[
            "latitude"=>$lat,
            "longitude"=>$long,
            "current"=>'temperature_2m,wind_speed_10m'
        ])->json();

        return Response::text(json_encode([
            "city"=>$city,
            "temperature"=>$weather['current']['temperature_2m'] ?? null,
            "wind_speed"=>$weather['current']['wind_speed_10m'] ?? null,
            "elevation"=>$weather['elevation'] ?? null
        ]));   
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'lat' => $schema->string('The latitude of the city')->required(),
            'long' => $schema->string('The longitude of the city')->required(),
            'city' => $schema->string('The name of the city'),
        ];
    }
}