<script>
    export default {
        props: ['attributes'],

        data() {
            return {
                editing: false,
                body: this.attributes.body
            }
        },

        methods: {
            update() {
                axios.patch('/entries/' + this.attributes.id, {
                    body: this.body
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