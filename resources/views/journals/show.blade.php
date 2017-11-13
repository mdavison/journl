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
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $entry->created_at->diffForHumans() }}</div>

                        <div class="panel-body">
                            {{ $entry->body }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
