<script>
    export default {
        props: ['attributes'],

        data() {
            return {
                editing: false,
                body: this.attributes.body,
                entry_date: this.attributes.entry_date
            }
        },

        methods: {
            update() {
                axios.patch('/entries/' + this.attributes.id, {
                    body: this.body,
                    entry_date: this.entry_date
                })
                .catch(error => {
                    flash(error.response.data.errors.body[0], 'danger');
                });

                this.editing = false;

                flash('Entry has been updated.');
            },

            destroy() {
                axios.delete('/entries/' + this.attributes.id);

                $(this.$el).fadeOut(300, () => {
                    flash('Entry has been deleted.');
                });
            }
        }
    }
</script>