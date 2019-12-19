export default {
    methods: {
        resetForm() {
            // eslint-disable-next-line prefer-reflect
            Object.assign(this.$data, this.$options.data.apply(this));
        }
    },
    mounted() {
        // if the form is present on a modal, and includes this mixin, this will reset it
        this.$root.$on("bv::modal::hidden", () => {
            this.resetForm();
        });
    }
}