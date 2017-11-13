@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Journals</div>

                    <div class="panel-body">
                        @foreach($journals as $journal)
                            <div>
                                <h4>
                                    <a href="/journals/{{ $journal->id }}">
                                        {{ $journal->name }}
                                    </a>
                                </h4>
                            </div>

                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
