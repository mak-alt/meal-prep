<?php

if (!function_exists('getDistance')) {
    /**
     * @param string $addressFrom
     * @param string $addressTo
     * @param string $unit
     * @return float
     * @throws \Exception
     */
    function getDistance(string $addressFrom, string $addressTo, string $unit = '')
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $formattedAddrFrom = str_replace(' ', '+', $addressFrom);
        $formattedAddrTo   = str_replace(' ', '+', $addressTo);

        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrFrom . '&sensor=false&key=' . $apiKey);
        $outputFrom  = json_decode($geocodeFrom);
        if (!empty($outputFrom->error_message)) {
            return $outputFrom->error_message;
        }
        // Geocoding API request with end address
        $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrTo . '&sensor=false&key=' . $apiKey);
        $outputTo  = json_decode($geocodeTo);
        if (!empty($outputTo->error_message)) {
            return $outputTo->error_message;
        }

        if (!empty($outputFrom->results)) {
            $latitudeFrom  = $outputFrom->results[0]->geometry->location->lat;
            $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
            $latitudeTo    = $outputTo->results[0]->geometry->location->lat;
            $longitudeTo   = $outputTo->results[0]->geometry->location->lng;

            $theta = $longitudeFrom - $longitudeTo;
            $dist  = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
            $dist  = acos($dist);
            $dist  = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;

            $unit = strtoupper($unit);
            if ($unit == "K") {
                return round($miles * 1.609344, 2);
            } elseif ($unit == "M") {
                return round($miles * 1609.344, 2);
            } else {
                return round($miles, 2);
            }
        } else {
            throw new \Exception("There is either a mistake or we don't deliver to this area");
        }
    }
}

if (!function_exists('calculateDeliveryFees')) {
    /**
     * @param float $distance
     * @param float $coefficient
     * @return int
     */
    function calculateDeliveryFees(float $distance, float $coefficient): int
    {
        return round($distance * $coefficient);
    }
}

if (!function_exists('setSessionResponseMessage')) {
    /**
     * @param string $responseMessage
     * @param string $style
     */
    function setSessionResponseMessage(string $responseMessage, string $style = 'success')
    {
        session()->put('response-message', $responseMessage);
        session()->put('response-message-style', $style);
    }
}

if (!function_exists('calculatePercentageValueFromNumber')) {
    /**
     * @param int $percentage
     * @param int $total
     */
    function calculatePercentageValueFromNumber(int $percentage, int $total)
    {
        return round($total * $percentage) / 100;
    }
}

if (!function_exists('getInscriptions')) {
    /**
     * @param string $key
     * @param string $page
     * @param string $data
     * @return string
     */
    function getInscriptions(string $key, string $page, string $data):string
    {
        $inscription = \App\Models\Inscription::where([
            ['key', $key],
            ['page', $page],
        ])->first();
        if ($inscription === null){
            \App\Models\Inscription::create([
                'key' => $key,
                'page' => $page,
                'data' => $data,
            ]);
            return $data;
        }
        else return $inscription->data;
    }
}
