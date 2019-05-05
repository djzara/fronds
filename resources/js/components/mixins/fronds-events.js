export default {
    methods: {
        fireFrondsGlobal(payload) {
            if (payload) {
                this.$emit("fronds-event", payload);
            }
            else {
                this.$emit("fronds-event", this);
            }
        },
        fireFrondsInput(payload, nativeValue) {
            this.fireFrondsGlobal();
            this.$emit("fronds-event-input", payload);
            this.$emit("input", nativeValue);
        },
        fireFrondsChange(from, to, elem) {
            const change = {
                fromValue: from,
                toValue: to,
                elementChanged: elem
            };
            this.fireFrondsGlobal();
            this.$emit("fronds-event-change", change);
        },
        fireFrondsClick(eventName, buttonElem) {
            this.fireFrondsGlobal();
            this.$emit(eventName, buttonElem);
        }
    }
}