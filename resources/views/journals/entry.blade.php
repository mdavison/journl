<div class="panel panel-default">
    <div class="panel-heading">{{ $entry->created_at->diffForHumans() }}</div>

    <div class="panel-body">
        {{ $entry->body }}
    </div>
</div>