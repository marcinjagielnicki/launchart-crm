<?php

namespace App\Jobs;

use App\Contact;
use App\Klaviyo\Client;
use App\Klaviyo\Model\ProfileDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncContactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Contact
     */
    private Contact $contact;

    /**
     * Create a new job instance.
     *
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

        $dto = new ProfileDTO();
        $dto->setFirstName($this->contact->first_name);
        $dto->setLastName($this->contact->last_name);
        $dto->setEmail($this->contact->email);
        $dto->setInternalId($this->contact->id);
        $dto->setPhoneNumber($this->contact->phone);

        $client->identify($dto);
    }
}
