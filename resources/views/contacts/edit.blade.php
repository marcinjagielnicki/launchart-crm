@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Update contact (#{{$contact->id}})</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('contacts.update', ['contact' => $contact->id]) }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" class="form-control" name="first_name" value="{{ $contact->first_name }}"/>
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" class="form-control" name="last_name" value="{{ $contact->last_name }}"/>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email" value="{{ $contact->email }}"/>
                            </div>

                            <div class="form-group">
                                <label for="city">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ $contact->phone }}"/>
                            </div>

                            <button type="submit" class="btn btn-primary">Update contact</button>
                            <a href="{{ route('contacts.track.event', ['contact' => $contact->id]) }}" class="btn btn-info">Track event</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
