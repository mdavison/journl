@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8">
                <h2>{{ $journal->name }} <a class="btn btn-default pull-right" href="{{ $journal->path() . '/edit' }}" role="button">Edit</a></h2>

                <hr>

                <form method="POST" action="/entries">
                    {{ csrf_field() }}

                    <input type="hidden" name="journal_id" value="{{ $journal->id }}">

                    <div class="form-group">
                        <textarea name="body" id="body" rows="7" class="form-control" placeholder="New entry" required>
                            {{ old('body') }}
                        </textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>

                    @if (count($errors))
                        <ul class="alert alert-danger list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                </form>

                <hr>

                @foreach($entries as $entry)
                    @include('journals.entry')
                @endforeach

                {{ $entries->links() }}
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>{{ $journal->description }}</p>
                        <hr>
                        <p>This journal has {{ $entries->count() }} {{ str_plural('entry', $entries->count()) }}.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
