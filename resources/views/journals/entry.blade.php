<entry :attributes="{{ $entry }}" inline-template v-cloak>
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $entry->displayDate() }}
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="5"></textarea>
                </div>

                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <input type="date" placeholder="{{ date('Y-m-d') }}" v-model="entry_date"
                                   value="{{ old('entry_date', date('Y-d-m')) }}">
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
