<?php


namespace App\Klaviyo;

use App\Klaviyo\Model\EventDTO;
use App\Klaviyo\Model\ProfileDTO;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Klaviyo HTTP API client.
 * @package App\Klaviyo
 */
class Client
{

    /**
     * Get API endpoint for Klaviyo integration.
     *
     * @return string
     */
    protected function getApiEndpoint(): string
    {
        return env('KLAVIYO_API_URL', 'https://a.klaviyo.com/api/');
    }

    /**
     * @return string
     */
    protected function getApiToken(): string
    {
        $token = env('KLAVIYO_API_TOKEN', null);

        if (!$token) {
            throw new \RuntimeException('Missing KLAVIYO_API_TOKEN');
        }

        return $token;
    }

    /**
     * Register single event for Profile in Klaviyo.
     *
     * @param EventDTO $event
     * @param bool $trackOnce
     * @return bool
     */
    public function trackEvent(EventDTO $event, bool $trackOnce = false): bool
    {
        $trackData = $this->prepareTrackData($event);

        $endpoint = 'track';
        if ($trackOnce) {
            $endpoint = 'track-once';
        }

        $response = Http::get($this->getApiEndpoint() . $endpoint, ['data' => base64_encode(json_encode($trackData))]);
        return $response->body() == 0;
    }

    /**
     * Identify single profile.
     *
     * @param ProfileDTO $profile
     * @return bool
     */
    public function identify(ProfileDTO $profile): bool
    {
        $profileData = $this->prepareProfileData($profile);
        $response = Http::get($this->getApiEndpoint() . 'identify', ['data' => base64_encode(json_encode($profileData))]);
        return $response->body() == 0;
    }


    /**
     * @param EventDTO $eventDTO
     * @return array|string[]
     */
    protected function prepareTrackData(EventDTO $eventDTO): array
    {
        $data = $this->transformDto($eventDTO);
        return $data->toArray() + ['token' => $this->getApiToken()];
    }

    /**
     * @param ProfileDTO $profileDTO
     * @return array
     */
    protected function prepareProfileData(ProfileDTO $profileDTO): array
    {
        $data = $this->transformDto($profileDTO);
        return ['token' => $this->getApiToken(), 'properties' => $data->toArray()];
    }

    protected function transformDto(Arrayable $dto): Collection
    {
        $data = collect($dto);
        $data->reject(function ($value, $key) {
            return $value === null;
        });

        return $data;
    }
}
