<?php

namespace App\Jobs;

use App\Klaviyo\Client;
use App\Klaviyo\Model\EventDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var EventDTO
     */
    private EventDTO $eventDTO;

    /**
     * Create a new job instance.
     *
     * @param EventDTO $eventDTO
     */
    public function __construct(EventDTO $eventDTO)
    {
        //
        $this->eventDTO = $eventDTO;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        $client->trackEvent($this->eventDTO);
    }
}
