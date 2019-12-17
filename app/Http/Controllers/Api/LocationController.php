<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Location\LocationsSearchRequest;
use Illuminate\Support\Facades\Log;

class LocationController extends BaseController
{
    const URL_GEO_LOCATIONS_AUTOCOMPLETE = 'https://maps.googleapis.com/maps/api/place/autocomplete/json';
    const URL_GEO_LOCATIONS_DETAIL = 'https://maps.googleapis.com/maps/api/place/details/json';

    public function getFromGEO(LocationsSearchRequest $request)
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
            $locationsGEO = json_decode(($client->get($this::URL_GEO_LOCATIONS_AUTOCOMPLETE, ['query' => $params]))->getBody());

            $response = [];
            if ($locationsGEO->predictions) {
                $locations = $locationsGEO->predictions;
                foreach ($locations as $location) {
                    $client = new \GuzzleHttp\Client;
                    $params = [
                        'placeid' => $location->place_id,
                        'key' => env('GOOGLE_MAPS_API_KEY'),
                    ];

                    $detail = json_decode(($client->get($this::URL_GEO_LOCATIONS_DETAIL, ['query' => $params]))->getBody())->result;

                    array_push($response, [
                        'name' => $detail->name,
                        'long_name' => $detail->formatted_address,
                        'google_place_id' => $location->place_id,
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

}
