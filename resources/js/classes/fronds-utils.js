export default {
    methods: {
        /**
         *
         * @param {String|Array} classListArray Classes to apply
         * @returns {string|*} A properly formatted class string
         */
        arrayToClassList(classListArray) {
            if (classListArray instanceof Array) {
                return classListArray.join(" ");
            }
            return classListArray;
        }
    }
};