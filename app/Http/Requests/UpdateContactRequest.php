<?php

namespace App\Http\Requests;

use App\Contact;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends CreateContactRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $contact = Contact::find($this->route('contact'))->first();
        return $contact && $this->user()->can('update', $contact);
    }
}
