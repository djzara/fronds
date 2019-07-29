<template>
    <div class="col-12">
        <b-form @submit.stop.prevent :inline="horizontal">
            <slot :field="formField"></slot>
        </b-form>
    </div>
</template>

<script>

    import bForm from "bootstrap-vue/es/components/form/form";
    import { EventBus } from "../../classes/bus";
    import FrondsApi from "../mixins/fronds-api";
    import FrondsEvents from "../mixins/fronds-events";


    export default {
        created() {

            EventBus.$on("fronds-form-confirm", () => {
                EventBus.$emit("fronds-gather-inputs");
            });

            // TODO: go ahead and fix submission, that might actually
            // make this work correctly
            EventBus.$on("fronds-input-return", returnValue => {
                if (this.returnedInputs.length === this.formInputs.length) {
                    // all fields have returned a value
                    this.submitForm(returnValue);
                }
                else {
                    // TODO: would a "set" make more sense here?
                    this.returnedInputs.push(returnValue.key);
                    this.addBodyParam(returnValue.key, returnValue.value);
                }

            });

            EventBus.$on("fronds-form-register", formElement => {
                this.formInputs.push(formElement);
            });
        },
        mounted() {
            EventBus.$on("fronds-event-network", networkResult => {
                console.log(networkResult.networkData);
            });
        },
        data() {
            return {
                formInputs: [],
                returnedInputs: []
            };
        },
        mixins: [FrondsApi, FrondsEvents],
        methods: {
            submitForm() {
                this.setEndpoint(this.submitsTo);

                if (this.inMode === "api") {
                    this.submitFormToApi();
                }
                else {
                    this.submitFormDefault();
                }

            },
            submitFormToApi() {
                this.setApiCall(this.withMethod.toUpperCase());
                // when this is finished, the event to handle it will be captured.
                // since it's event based we don't really care what tool was used to send the request, only
                // that we have the data.
                this.makeRequest();
            },
            submitFormDefault() {

            }
        },
        props: {
            id: {
                type: String,
                required: true
            },
            horizontal: {
                type: Boolean,
                required: false,
                default: false
            },
            submitsTo: {
                type: String,
                required: false,
                default: "#"
            },
            withMethod: {
                type: String,
                required: false,
                default: "POST",
                validator: value => { return ["POST", "GET", "PUT"].indexOf(value.toUpperCase()) !== -1; }
            },
            inMode: {
                type: String,
                required: false,
                default: "default",
                validator: value => {
                    return ["default", 'api'].indexOf(value) !== -1;
                }
            }

        },
        components: {
            bForm
        }
    }
</script>