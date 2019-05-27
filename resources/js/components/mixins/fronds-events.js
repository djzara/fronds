import { EventBus } from "../../classes/bus";

export default {
    methods: {
        fireFrondsGlobal(payload) {
            if (payload) {
                EventBus.$emit("fronds-event", payload);
            }
            else {
                EventBus.$emit("fronds-event", this.data);
            }
        },
        fireFrondsInput(payload, nativeValue) {
            this.fireFrondsGlobal();
            EventBus.$emit("fronds-event-input", payload);
            EventBus.$emit("input", nativeValue);
        },
        fireFrondsChange(from, to, elem) {
            const change = {
                fromValue: from,
                toValue: to,
                elementChanged: elem
            };
            this.fireFrondsGlobal();
            EventBus.$emit("fronds-event-change", change);
        },
        fireFrondsClick(eventName, buttonElem) {
            this.fireFrondsGlobal();
            EventBus.$emit(eventName, buttonElem);
        },
        fireFrondsNetwork(uri, method, data, isSuccess) {
            this.fireFrondsGlobal();
            EventBus.$emit("fronds-event-network", {
                networkUri: uri,
                networkMethod: method,
                networkData: data,
                networkSuccess: isSuccess
            });
        }
    }
}