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
                @foreach($journal->entries as $entry)
                    @include('journals.entry')
                @endforeach
            </div>
        </div>

        @if (auth()->check())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ $journal->path() . '/entries' }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="New entry"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        @endif

    </div>
@endsection
