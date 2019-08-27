<template>
    <div class="fronds-input-group col-12">
        <label :for="inputId" :class="inputLabelClasses">{{ inputLabel }}:</label>
        <input :type="inputType"
               :id="inputId"
               :class="finalInputClasses"
               @input="didInput"
               v-model="value"
               :name="inputName">
        <p v-if="isValid !== null"
              :class="{'fronds-text-valid' : isValid === true, 'fronds-text-invalid' : isValid === false}">
            <slot v-if="isValid === true" name="valid-text"></slot>
            <slot v-else-if="isValid === false" name="invalid-text"></slot>
        </p>

        <p class="fronds-text-help"><slot name="help-info"></slot></p>
    </div>
</template>

<script>

    import FrondsEvents from "../mixins/fronds-events";
    const inputClassPrefix = "fronds-input-";
    const baseInputClass = "fronds-input-text";
    import { EventBus } from "../../classes/bus";

    export default {
        mounted() {
            EventBus.$emit("fronds-form-register", this);
        },
        data() {
            return {
                value: "",
                isValid: null,
                validationValue: ""
            };
        },
        methods: {
            didInput($event) {
                this.fireFrondsInput(this.value, $event.target.value);
            }
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
                if (this.isValid !== null) {
                    return this.isValid === true ? "fronds-input-valid" : "fronds-input-invalid";
                }

                return "";
            }
        },
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
            }
        }
    }
</script>