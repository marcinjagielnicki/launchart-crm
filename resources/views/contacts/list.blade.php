@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Contacts list</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="text-right">
                            <a href="{{ route('contacts.create') }}" class="btn btn-success mb-4">Add new contact</a>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Last name</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>{{ $contact->first_name }}</td>
                                    <td>{{ $contact->last_name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>
                                        <a href="{{ route('contacts.edit', ['contact' => $contact->id]) }}"
                                           class="btn btn-primary">Edit</a>
                                        <a href="{{ route('contacts.destroy.web', ['contact' => $contact->id]) }}"
                                           class="btn btn-danger">Delete</a>
                                        <a href="{{ route('contacts.track.event', ['contact' => $contact->id]) }}"
                                           class="btn btn-info">Track event</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $contacts->links() }}

                        <div class="text-right">
                            <a href="{{ route('contacts.create') }}" class="btn btn-success mb-4 mt-4">Add new
                                contact</a>
                        </div>


                        <form method="POST" action="{{ route('contacts.import') }}" enctype="multipart/form-data">
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @csrf
                            <div class="form-group">
                                <label for="first_name">Import contacts (CSV):</label>
                                <input type="file" class="form-control" name="file" accept=".txt,.csv"/>
                                <small>Available file formats: *.txt, *.csv <br/> CSV format: <b>name,last_name,email,phone</b></small>
                            </div>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
