export default {
    filters: {
        slugify(value) {
            return this.slugifyStr(value);
        }
    },
    methods: {
        slugifyStr(value) {
            return value.toLowerCase().replace(/\s/g, "-");
        }
    }
};