@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('status'))
            <div class="row">

                <div class="col-md-8 col-md-offset-2">
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                </div>

            </div>
        @endif

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">New Entry</div>

                    <div class="panel-body">
                        <form method="POST" action="/entries">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="journal_id">Select a Journal</label>
                                <select name="journal_id" id="journal_id" class="form-control" required>
                                    <option value="">Select One...</option>
                                    @foreach ($journals as $journal)
                                        <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>{{ $journal->name }}</option>
                                    @endforeach
                                </select>
                            </div>

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
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($entries as $entry)
                    @include('journals.entry')
                @endforeach
            </div>
        </div>
    </div>
@endsection
