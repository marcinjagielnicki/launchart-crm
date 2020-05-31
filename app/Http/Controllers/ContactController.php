<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\ImportDataRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Jobs\AddEventJob;
use App\Jobs\ImportContactFileJob;
use App\Jobs\SyncContactJob;
use App\Klaviyo\Model\EventDTO;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $contacts = Contact::whereOwner(auth()->user())->paginate(20);

        return view('contacts.list', ['contacts' => $contacts]);
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * @param CreateContactRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateContactRequest $request)
    {
        $contact = new Contact($request->except('owner_id'));
        $contact->owner_id = auth()->user()->id;
        $contact->save();

        $this->dispatch(new SyncContactJob($contact));

        return redirect('/contacts')->with('status', 'Contact saved!');
    }

    /**
     * @param Contact $contact
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Contact $contact)
    {
        Gate::authorize('update', $contact);
        return view('contacts.edit', ['contact' => $contact]);

    }

    /**
     * @param UpdateContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->fill($request->except('owner_id'));
        $contact->save();

        // @TODO: sync contact via observer
        $this->dispatch(new SyncContactJob($contact));

        return redirect('/contacts')->with('status', 'Contact updated!');
    }


    /**
     * @param Contact $contact
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Contact $contact)
    {
        Gate::authorize('delete', $contact);
        $contact->delete();
        return redirect('/contacts')->with('status', 'Contact removed!');
    }

    /**
     * @param Contact $contact
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function trackEvent(Contact $contact)
    {
        Gate::authorize('update', $contact);
        $eventDto = new EventDTO();
        $eventDto->setEvent('Clicked button');
        $eventDto->setCustomerProperties(['$id' => $contact->id]);

        $this->dispatch(new AddEventJob($eventDto));

        return redirect('/contacts')->with('status', 'Event has been tracked!');
    }

    /**
     * @param ImportDataRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function importData(ImportDataRequest $request)
    {
        $file = $request->file('file');

        if (!$file->isValid()) {
            return redirect('/contacts')->with('error', 'Error during uploading of file');
        }

        // Split file into chunks in order to optimize import.
        $file = file($file->getRealPath());
        // Remove header line from file and chunk array
        // @TODO: add possibility to select columns from file by user
        $parts = array_chunk(array_slice($file, 1), 1000);
        $i = 1;
        foreach ($parts as $line) {
            $filename = base_path('storage/import_contacts/' . date('y-m-d-H-i-s') . $i . auth()->user()->id . '.csv');
            file_put_contents($filename, $line);
            $i++;
            // Dispatch job for each file
            $this->dispatch(new ImportContactFileJob($filename, auth()->user()));
        }

        return redirect('/contacts')->with('status', 'Import of contacts enqueued!');
    }
}
