@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Search Results</h2>

                @foreach($results as $result)

                    @if ($result->entry_id != '')
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <a href="/journals/{{ $result->journal_id }}">{{ $result->journal_name }}</a>
                            </div>

                            <div class="panel-body">{{ $result->entry_body }}</div>
                        </div>
                    @else
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <a href="/journals/{{ $result->journal_id }}">{{ $result->journal_name }}</a>
                            </div>

                            <div class="panel-body">{{ $result->journal_description }}</div>
                        </div>
                    @endif

                @endforeach

            </div>
        </div>
    </div>
@endsection
