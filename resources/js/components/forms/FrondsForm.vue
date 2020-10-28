<template>
    <div class="col-12">
        <!-- -->
        <b-form :id="id"
                ref="fronds_form_ref"
                class="fronds-form"
                :inline="horizontal"
                :method="withMethod"
                @submit.stop.prevent
                @keyup.enter="submitForm"
        >
            <slot></slot>
        </b-form>
    </div>
</template>

<script>

    import { BForm } from "bootstrap-vue";
    import { EventBus } from "../../classes/bus";
    import FrondsApi, {METHODS} from "../mixins/fronds-api";
    import FrondsEvents from "../mixins/fronds-events";


    export default {
        components: {
            BForm
        },
        mixins: [FrondsApi, FrondsEvents],
        props: {
            spinnerType: {
                type: String,
                required: false,
                default: "cog"
            },
            submitting: {
                type: Boolean,
                required: false,
                default: false
            },
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
                default: METHODS.POST,
                validator: value => {
                    return [
                        METHODS.POST,
                        METHODS.GET,
                        METHODS.PUT,
                        METHODS.DELETE
                    ].indexOf(value.toUpperCase()) !== -1;
                }
            },
            inMode: {
                type: String,
                required: false,
                default: "web",
                validator: value => {
                    return ["web", "api"].indexOf(value) !== -1;
                }
            }

        },
        data() {
            return {
                formInputs: [],
                returnedInputs: [],
                hasRsvp: null
            };
        },
        created() {
            EventBus.$on("fronds-form-confirm", () => {
                this.submitForm();
            });
            EventBus.$on("fronds-form-register", formElement => {
                this.formInputs.push(formElement);
            });
            EventBus.$on("fronds-event-network", networkResult => {
                if (networkResult.networkSuccess === true) {
                    this.completeApiSubmission(networkResult.networkData.data);
                    // eslint-disable-next-line no-prototype-builtins
                    if (networkResult.networkData.data.hasOwnProperty("rsvp")) {
                        this.completeRsvpApiSubmission(networkResult.networkData.data.rsvp.to,
                                                       networkResult.networkData.data.rsvp.using,
                                                       networkResult.networkData.data.rsvp.with);
                        this.hasRsvp = true;
                    }
                }
            });
        },
        methods: {
            completeApiSubmission(data) {
                if (this.hasRsvp) {
                    this.handleRsvpResult(data);
                }
                this.$emit("fronds-form-submitted");
            },
            completeRsvpApiSubmission(to, using, withData) {
                this.setEndpoint(to);
                this.setApiCall(using);
                Object.keys(withData).forEach(key => {
                    this.addParam(key, withData[key]);
                });
                this.makeRequest();
            },
            submitForm() {
                this.setEndpoint(this.submitsTo);

                if (this.inMode === "api") {
                    this.submitFormToApi();
                }
                else {
                    this.submitFormDefault();
                }

            },
            handleRsvpResult(result) {
                // for forms we just need to know if we're redirecting or staying on the same page
                // eslint-disable-next-line no-prototype-builtins
                if (result.hasOwnProperty("redirectTo")) {
                    location.href = result.redirectTo;
                }
            },
            submitFormToApi() {
                this.setApiCall(this.withMethod.toUpperCase());
                // when this is finished, the event to handle it will be captured.
                // since it's event based we don't really care what tool was used to send the request, only
                // that we have the data.
                for (const ind in this.formInputs) {
                    if (this.formInputs.length > ind) {
                        this.addBodyParam(this.formInputs[ind].$props.inputName, this.formInputs[ind].$data.value);
                    }
                }
                this.makeRequest();
            },
            submitFormDefault() {
                this.$refs.fronds_form_ref.submit();
            }
        }
    };
</script>