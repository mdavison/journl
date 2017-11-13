@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $journal->name }}</div>

                    <div class="panel-body">
                        <p>Journal entries would go here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
