<template>
    <div class="fronds-input-group">
        <label :for="inputId" :class="inputLabelClasses">{{ inputLabel }}:</label>
        <input :id="inputId"
               :type="inputType"
               :class="finalInputClasses"
               :value="value"
               :readonly="readonly"
               :name="inputName"
               @input="didInput"
        >
        <span v-if="isValid === false"
              class="fronds-text-invalid"
        >
            <slot name="invalid-text"></slot>
        </span>
        <span v-else-if="isValid === true" class="fronds-text-valid">
            <slot name="valid-text"></slot>
        </span>

        <span class="fronds-text-help"><slot name="help-info"></slot></span>
    </div>
</template>

<script>

    import FrondsEvents from "../mixins/fronds-events";
    const inputClassPrefix = "fronds-input-",
          baseInputClass = "fronds-input-text";
    import { EventBus } from "../../classes/bus";

    export default {
        mixins: [ FrondsEvents ],
        props: {
            inputType: {
                type: String,
                required: false,
                validator: value => {
                    return ["text", "email", "date", "numeric", "phone", "password"].indexOf(value) !== -1;
                },
                default: "text"
            },
            inputLabel: {
                type: String,
                required: false,
                default: ""
            },
            inputId: {
                type: String,
                required: false,
                default: "fronds-input"
            },
            inputClasses: {
                type: Array,
                required: false,
                default: () => { return []; }
            },
            inputSize: {
                type: String,
                required: false,
                default: "md",
                validator: value => {
                    return ["sm", "md", "lg"].indexOf(value) !== -1;
                }
            },
            inputLabelClasses: {
                type: Array,
                required: false,
                default: () => { return []; }
            },
            isRequired: {
                type: Boolean,
                required: false,
                default: false
            },
            inputName: {
                type: String,
                required: true
            },
            value: {
                type: [String, Number],
                required: false,
                default: ""
            },
            readonly: {
                type: Boolean,
                required: false,
                default: false
            },
            isValid: {
                type: Boolean,
                required: false,
                default: null
            }
        },
        data() {
            return {
                validationValue: ""
            };
        },
        computed: {
            finalInputClasses() {
                const finalClasses = this.inputClasses;
                finalClasses.push(baseInputClass);
                finalClasses.push(this.inputSizeClass);
                finalClasses.push(this.currentValidationClass);
                return finalClasses;
            },
            inputSizeClass() {
                return inputClassPrefix + this.inputSize;
            },
            currentValidationClass() {
                if (typeof this.isValid === "boolean") {
                    return this.isValid === true ? "fronds-input-valid" : "fronds-input-invalid";
                }

                return "";
            }
        },
        mounted() {
            EventBus.$emit("fronds-form-register", this);
        },
        methods: {
            didInput($event) {
                this.fireFrondsInput(this.value, $event.target.value);
                this.$emit("input", $event.target.value);
            }
        }
    };
</script>