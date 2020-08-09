<template>
    <div v-show="show">
        <slot name="fronds-action-widget-head"></slot>
        <slot/>
        <slot name="fronds-action-widget-footer"></slot>
    </div>
</template>

<script>
    export default {
        name: "action-widget",
        data() {
            return {};
        },
        props: {
            widgetName: {
                type: String,
                required: true
            },
            show: {
                type: Boolean,
                required: false,
                default: true
            }
        }
    }
</script>