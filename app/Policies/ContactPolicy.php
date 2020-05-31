<?php

namespace App\Policies;

use App\Contact;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Contact $contact)
    {
        return $user->id === $contact->owner_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Contact $contact)
    {
        return $user->id == $contact->owner_id;
    }

    public function delete(User $user, Contact $contact)
    {
        return $user->id === $contact->owner_id;
    }

}
