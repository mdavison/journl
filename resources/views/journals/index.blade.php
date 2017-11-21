@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Journals</h2>

                @foreach($journals as $journal)
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <div class="level">
                                <span class="flex">
                                    <a href="{{ $journal->path() }}">{{ $journal->name }}</a>
                                </span>

                                <form action="{{ $journal->path() }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-link">Delete Journal</button>
                                </form>

                            </div>
                        </div>

                        <div class="panel-body">{{ $journal->description }}</div>
                    </div>

                @endforeach

            </div>
        </div>
    </div>
@endsection
