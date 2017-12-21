<entry :attributes="{{ $entry }}" inline-template v-cloak>
    <div class="panel panel-default">
        <div class="panel-heading">
            Posted {{ $entry->created_at->diffForHumans() }}
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="5"></textarea>
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
