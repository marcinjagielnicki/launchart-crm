<?php

namespace Tests\Unit\Klaviyo;

use App\Klaviyo\Client;
use App\Klaviyo\Model\EventDTO;
use App\Klaviyo\Model\ProfileDTO;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /** @var Client  */
    protected Client $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Client();
    }

    public function testTrackEvent()
    {
        $eventDto = new EventDTO();
        $eventDto->setEvent('Test');
        $eventDto->setProperties([
            'test' => 'test'
        ]);

        Http::fake();

        $this->client->trackEvent($eventDto);

        Http::assertSent(function (Request $request) {
            $data = json_decode(base64_decode($request->data()['data']), true);
            return $data['token'] ?? false && $data['$email'] ?? false;
        });
    }

    public function testIdentify()
    {
        $profileDto = new ProfileDTO();
        $profileDto->setEmail('test@test.pl');
        $profileDto->setFirstName('Name');
        $profileDto->setLastName('LastName');
        $profileDto->setPhoneNumber('000000');
        $profileDto->setTitle('Mr');

        Http::fake();
        $this->client->identify($profileDto);

        Http::assertSent(function (Request $request) {
            $data = json_decode(base64_decode($request->data()['data']), true);
            return $data['token'] ?? false && $data['properties'] ?? false && $data['properties']['email'] ?? false;
        });
    }
}
