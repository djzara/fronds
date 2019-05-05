<template>
    <div class="fronds-input-group col-12">
        <label :for="inputId" :class="inputLabelClasses">{{ inputLabel }}:</label>
        <input :type="inputType" :id="inputId" :class="finalInputClasses" @input="fireInputEvent">
    </div>
</template>

<script>

    import FrondsEvents from "../mixins/fronds-events";
    const inputClassPrefix = "fronds-input-";
    const baseInputClass = "fronds-input-text";

    export default {
        data() {
            return {
                textValue: ""
            };
        },
        methods: {
            fireInputEvent($event) {
                this.fireInputEvent(this.textValue, $event.target.value);
            }
        },
        computed: {
            finalInputClasses() {
                const finalClasses = this.inputClasses;
                finalClasses.push(baseInputClass);
                finalClasses.push(this.inputSizeClass);
                return finalClasses;
            },
            inputSizeClass() {
                return inputClassPrefix + this.inputSize;
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
            }

        }
    }
</script>