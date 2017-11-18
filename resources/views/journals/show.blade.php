@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>{{ $journal->name }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form method="POST" action="/entries">
                    {{ csrf_field() }}

                    <input type="hidden" name="journal_id" value="{{ $journal->id }}">

                    <div class="form-group">
                        <textarea name="body" id="body" class="form-control" placeholder="New entry" required>
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
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($journal->entries as $entry)
                    @include('journals.entry')
                @endforeach
            </div>
        </div>

    </div>
@endsection
