export default {
    methods: {
        /**
         * @param {Array, String} classListArray
         * @return String
         */
        arrayToClassList(classListArray) {
            if (classListArray instanceof Array) {
                return classListArray.join(" ");
            }
            return classListArray;
        }
    }
}