<?php
namespace App\MCp\Tools;

use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Gets geocoding information for a given city.')]
class GetWheaterTool extends Tool
{
    public function handle(Request $request)
    {
        $city = $request->get('city');
        
        // 1. Geocoding: City se Lat/Long nikalna
        $geo = Http::timeout(15)->get("https://geocoding-api.open-meteo.com/v1/search",
        [
            "name"=>$city,
            "count"=>1,
            "language"=>"en",
            "format"=>"json"
        ])->json('results.0');
        
        if(!$geo) {
            return Response::text("City Not Found");
        }

        $lat = $geo['latitude'];
        $long = $geo['longitude'];

        return Response::text(json_encode([
            "city"=>$city,
            "lat"=>$lat,
            "long"=>$long
        ]));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'city' => $schema->string('The name of the city to get weather for')->required(),
        ];
    }
}