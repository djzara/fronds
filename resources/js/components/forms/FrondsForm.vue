<template>
    <div class="col-12">
        <b-form @submit.stop.prevent :inline="horizontal">
            <slot></slot>
        </b-form>
    </div>
</template>

<script>

    import bForm from "bootstrap-vue/es/components/form/form";
    import { EventBus } from "../../classes/bus";
    import FrondsApi from "../mixins/fronds-api";
    import FrondsEvents from "../mixins/fronds-events";

    export default {
        mounted() {
            EventBus.$on("fronds-form-confirm", () => {
                this.submitForm();
            });
        },
        data() {
            return {

            };
        },
        mixins: [FrondsApi, FrondsEvents],
        methods: {
            submitForm() {

            },
            submitFormToApi() {

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
            submitOptions: {
                type: Array,
                required: false,
                default: () => { return [ { submitsTo: "#", withMethod: "GET" } ]; },
                validator: value => {
                    // TODO: try to get a schema validator in place in a future item. need to have, but not atm
                    const intermediate = value.map(item => {
                        if (item.hasOwnProperty("submitsTo") && item.hasOwnProperty("withMethod")) {
                            return item;
                        }
                    });
                    return intermediate.length !== 0;
                }
            },
            submitsTo: {
                type: String,
                required: false,
                default: ""
            },
            withMethod: {
                type: String,
                required: false,
                default: ""
            }

        },
        components: {
            bForm
        }
    }
</script>