<?php

namespace App\Domain\Weather\Services;

use App\Domain\Event\Dto\CreateEventDto;
use App\Domain\Weather\API\WeatherApiService;
use App\Domain\Weather\Dto\ForecastDayDto;
use App\Domain\Weather\Dto\ForecastDaySpecificTimeForecastDto;
use App\Domain\Weather\Dto\ForecastDayTemperatureDto;
use Carbon\Carbon;
use Exception;
use ReflectionException;

readonly class WeatherService
{
    public function __construct(
        private WeatherApiService $apiService
    )
    {
    }

    /**
     * Get weather data
     * @param CreateEventDto $dto
     * @return array
     * @throws ReflectionException
     * @throws Exception
     */
    public function prediction(CreateEventDto $dto): array
    {
        $data = $this->getWeatherData($dto);

        return ForecastDayDto::fromArray([
            'date' => $data['date'],
            'weather_description' => $data['day']['condition']['text'],
            'temperature' => $this->getForecastDayTemperatureDto($data)->toArray(),
            'specific_time_forecast' => $this->getForecastDaySpecificTimeForecastDto($data)->toArray()
        ])->toArray();
    }

    /**
     * Get forecast day specific time forecast dto
     * @param array $data
     * @return ForecastDaySpecificTimeForecastDto
     * @throws ReflectionException
     */
    private function getForecastDaySpecificTimeForecastDto(array $data): ForecastDaySpecificTimeForecastDto
    {
        return ForecastDaySpecificTimeForecastDto::fromArray([
            'time' => $data['hour'][0]['time'],
            'temperature' => $data['hour'][0]['temp_c'],
            'feels_like' => $data['hour'][0]['feelslike_c'],
            'condition' => $data['hour'][0]['condition']['text'],
            'chance_of_rain' => $data['hour'][0]['chance_of_rain'],
            'visibility' => $data['hour'][0]['vis_km']
        ]);
    }

    /**
     *  Get forecast day temperature dto
     * @param array $data
     * @return ForecastDayTemperatureDto
     * @throws ReflectionException
     */
    private function getForecastDayTemperatureDto(array $data): ForecastDayTemperatureDto
    {
        return ForecastDayTemperatureDto::fromArray([
            'average' => $data['day']['avgtemp_c'],
            'maximum' => $data['day']['maxtemp_c'],
            'minimum' => $data['day']['mintemp_c']
        ]);
    }

    /**
     * Set forecast data
     * @param CreateEventDto $dto
     * @return array
     * @throws Exception
     */
    private function getWeatherData(CreateEventDto $dto): array
    {
        $data = $dto->toArray();
        $eventDate = Carbon::parse($data['event_date']);
        $predictionWeather = $this->apiService->history()->get(
            city: $data['location'],
            date: $eventDate
        )->json();

        if(
            !$predictionWeather ||
            !array_key_exists('forecast', $predictionWeather)
        ){
            throw new Exception("Something wrong with weather service");
        }

        return $predictionWeather['forecast']['forecastday'][0];
    }
}
