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
            EventBus.$emit("fronds-event-input", payload);
            EventBus.$emit("input", nativeValue);
        },
        fireFrondsChange(from, to, elem) {
            const change = {
                fromValue: from,
                toValue: to,
                elementChanged: elem
            };
            EventBus.$emit("fronds-event-change", change);
        },
        fireFrondsClick(eventName, buttonElem) {
            EventBus.$emit(eventName, buttonElem);
        },
        fireFrondsMouse(mouseEventName, payload) {
            EventBus.$emit(mouseEventName, payload);
        },
        fireFrondsNetwork(uri, method, data, isSuccess) {
            EventBus.$emit("fronds-event-network", {
                networkUri: uri,
                networkMethod: method,
                networkData: data,
                networkSuccess: isSuccess
            });
        },
        fireGatherInputs() {
            EventBus.$emit("fronds-gather-inputs");
        },
        fireFrondsClearForm() {
            EventBus.$emit("fronds-clear-form");
        }
    }
};