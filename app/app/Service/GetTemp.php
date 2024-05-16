<?php

namespace App\Service;

use DateTime;
use DateTimeZone;
use App\Service\Contracts\GetTempInterface;

class GetTemp implements GetTempInterface
{
    public function getTempKatowice(): ?float
    {
        $response = $this->callApi('https://api.open-meteo.com/v1/forecast?latitude=50.25841&longitude=19.02754&hourly=temperature_2m&timezone=Europe%2FWarsaw&forecast_days=1');

        if ($response === false) {
            return null;
        }

        $response = json_decode($response);

        $dateTime = new DateTime('now');
        $dateTime->setTimezone(new DateTimeZone('Europe/Warsaw'));
        $currentTime = $dateTime->format('Y-m-d\TH:00');

        $currentTimeIdx = array_search($currentTime, $response->hourly->time);
        return $response->hourly->temperature_2m[$currentTimeIdx] ?? null;
    }

    private function callApi(string $url): bool|string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 10,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
