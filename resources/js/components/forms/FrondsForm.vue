<template>
    <div class="col-12">
        <b-form @submit.stop.prevent :inline="horizontal">
            <slot></slot>
        </b-form>
    </div>
</template>

<script>

    import bForm from "bootstrap-vue/es/components/form/form";

    export default {
        data() {
            return {

            };
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
                default: () => { return []; },
                validator: value => {

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