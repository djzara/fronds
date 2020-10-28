<template>
    <div v-show="show">
        <slot name="fronds-action-widget-head"></slot>
        <slot />
        <slot name="fronds-action-widget-footer"></slot>
    </div>
</template>

<script>
    export default {
        name: "ActionWidget",
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
        },
        data() {
            return {};
        }
    };
</script>