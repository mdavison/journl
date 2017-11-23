<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <span class="flex">
                {{ $entry->created_at->diffForHumans() }}
            </span>

            <form action="/entries/{{ $entry->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" class="btn btn-link">Delete Entry</button>
            </form>

        </div>

    </div>

    <div class="panel-body">
        {{ $entry->body }}
    </div>
</div>