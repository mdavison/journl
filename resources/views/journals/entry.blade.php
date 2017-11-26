<entry :attributes="{{ $entry }}" inline-template v-cloak>
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $entry->created_at->diffForHumans() }}
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        <div class="panel-footer level">
            <button class="btn btn-xs mr-1" @click="editing = true">Edit</button>

            <form action="/entries/{{ $entry->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button class="btn btn-xs btn-danger mr-1">Delete</button>
            </form>
        </div>
    </div>
</entry>
