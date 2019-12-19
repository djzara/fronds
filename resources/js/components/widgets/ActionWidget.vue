<template>
    <div>
        <slot name="fronds-action-widget-head"></slot>
        <slot/>
        <slot name="fronds-action-widget-footer"></slot>
    </div>
</template>

<script>
    export default {
        name: "action-widget",
        data() {
            return {

            };
        }
    }
</script>