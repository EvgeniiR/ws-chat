export default {
    data() {
        items: []
    },

    methods: {
        add(item) {
            this.items.push(item);

            this.$emit('added');
        },

        remove(index) {
            this.items.splice(index, 1);

            this.$emit('removed');

            flash('Reply was deleted!');
        }
    }
}