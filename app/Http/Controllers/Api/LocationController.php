<?php

namespace App\Http\Controllers\Api;

use App\ConfigProject\Constants;
use App\Http\Requests\Location\LocationsSearchRequest;
use Illuminate\Support\Facades\Log;

class LocationController extends BaseController
{
    const URL_GOOGLE_LOCATIONS_AUTOCOMPLETE = 'https://maps.googleapis.com/maps/api/place/autocomplete/json';
    const URL_GOOGLE_LOCATIONS_DETAIL = 'https://maps.googleapis.com/maps/api/place/details/json';
    //const URL_MAPBOX_LOCATIONS_AUTOCOMPLETE = 'https://api.mapbox.com/v4/geocode/mapbox.places/';
    const URL_MAPBOX_LOCATIONS_AUTOCOMPLETE = 'https://api.mapbox.com/geocoding/v5/mapbox.places/';
    const COUNTRY = 'DE';

    public function getFromGEO(LocationsSearchRequest $request)
    {
        dd($this->getCityFromMapBox($request));
        return $this->getCityFromMapBox($request);
    }

    protected function getCityFromGoogle(LocationsSearchRequest $request)
    {
        try {
            $query = $request->get('query');
            $client = new \GuzzleHttp\Client;
            $params = [
                'input'     => $query,
                'language'  => 'en',
                'types'     => '(cities)',
                'sensor'    => false,
                'key'       => env('GOOGLE_MAPS_API_KEY'),
            ];
            $locationsGEO = json_decode(($client->get($this::URL_GOOGLE_LOCATIONS_AUTOCOMPLETE, ['query' => $params]))->getBody());

            $response = [];
            if ($locationsGEO->predictions) {
                $locations = $locationsGEO->predictions;
                foreach ($locations as $location) {
                    $client = new \GuzzleHttp\Client;
                    $params = [
                        'placeid' => $location->place_id,
                        'key' => env('GOOGLE_MAPS_API_KEY'),
                    ];

                    $detail = json_decode(($client->get($this::URL_GOOGLE_LOCATIONS_DETAIL, ['query' => $params]))->getBody())->result;

                    array_push($response, [
                        'name' => $detail->name,
                        'long_name' => $detail->formatted_address,
                        'place_id' => $location->place_id,
                        'lat' => $detail->geometry->location->lat,
                        'lng' => $detail->geometry->location->lng,
                    ]);
                }
            }
            return $this->sendResponse('Successfully get Google locations.', $response);

        } catch (\Exception $e){
            Log::error('Exception in get Google locations: ', ['exception' => $e]);
            return $this->sendError('Cannot get Google locations.', [], 409);
        }
    }

    protected function getCityFromMapBox(LocationsSearchRequest $request)
    {
        try {
            $query = $request->get('query');
            $locale = $request->get('locale', Constants::LANGUAGE_EN);
            $client = new \GuzzleHttp\Client;
            $params = [
                'access_token' => env('MAPBOX_ACCESS_TOKEN'),
                'country' => $this::COUNTRY,
                'types' => 'place',
                'limit' => 5,
                'language' => $locale,
            ];
            $url = $this::URL_MAPBOX_LOCATIONS_AUTOCOMPLETE . $query . '.json';
            $locationsGEO = json_decode(($client->get($url, ['query' => $params]))->getBody());
            $response = [];
            if ($locationsGEO->features) {
                $locations = $locationsGEO->features;
                foreach ($locations as $location) {
                    array_push($response, [
                        'name' => $location->text,
                        'long_name' => $location->place_name,
                        'place_id' => $location->id,
                        'lat' => $location->center[0],
                        'lng' => $location->center[1],
                    ]);
                }
            }
            return $this->sendResponse('Successfully get Google locations.', $response);

        } catch (\Exception $e){
            Log::error('Exception in get Google locations: ', ['exception' => $e]);
            return $this->sendError('Cannot get Google locations.', [], 409);
        }
    }
}
