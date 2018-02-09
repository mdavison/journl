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
                                    @foreach ($journalsForNav as $journal)
                                        <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>{{ $journal->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <textarea name="body" id="body" class="form-control" placeholder="New entry" required>
                                    {{ old('body') }}
                                </textarea>
                            </div>

                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="entry_date" name="entry_date" placeholder="{{ date('Y-m-d') }}"
                                               value="{{ old('entry_date', date('Y-m-d')) }}">
                                    </div>
                                </div>
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

                @foreach($entries as $entry)
                    <entry :attributes="{{ $entry }}" inline-template v-cloak>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{ $entry->displayDate() }} in
                                <a href="/journals/{{ $entry->journal_id }}">{{ $entry->journalName() }}</a>
                            </div>

                            <div class="panel-body">
                                <div v-if="editing">
                                    <div class="form-group">
                                        <textarea class="form-control" v-model="body" rows="5"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <input type="date" class="form-control" v-model="entry_date"
                                                       value="{{ old('entry_date', date('Y-m-d')) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-xs btn-primary" @click="update">Update</button>
                                    <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
                                </div>

                                <div v-else v-text="body"></div>
                            </div>

                            <div class="panel-footer level">
                                <button class="btn btn-xs mr-1" @click="editing = true">Edit</button>
                                <button class="btn btn-xs btn-danger" @click="destroy">Delete</button>
                            </div>
                        </div>
                    </entry>
                @endforeach

                {{ $entries->links() }}

            </div>
        </div>

    </div>
@endsection
