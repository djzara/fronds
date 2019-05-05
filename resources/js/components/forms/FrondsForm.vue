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
            }
        },
        components: {
            bForm
        }
    }
</script>