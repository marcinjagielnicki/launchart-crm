<?php

namespace App\Jobs;

use App\Contact;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportContactFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $fileName;
    /**
     * @var User
     */
    private User $user;

    /**
     * Create a new job instance.
     *
     * @param string $fileName
     * @param User $user
     */
    public function __construct(string $fileName, User $user)
    {
        //
        $this->fileName = $fileName;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = array_map('str_getcsv', file($this->fileName));
        foreach ($data as $row) {
            $contact = Contact::updateOrCreate([
                'first_name' => $row[0],
                'last_name' => $row[1],
                'email' => $row[2],
                'phone' => $row[3],
                'owner_id' => $this->user->id
            ], ['email' => $row[2], 'owner_id' => $this->user->id]);
            dispatch(new SyncContactJob($contact));
        }
        unlink($this->fileName);
    }
}
