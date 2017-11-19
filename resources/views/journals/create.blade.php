@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a New Journal</div>

                    <div class="panel-body">
                        <form method="POST" action="/journals">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                                       value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <textarea name="description" id="description" class="form-control" placeholder="Description">
                                    {{ old('description') }}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    </div>
@endsection