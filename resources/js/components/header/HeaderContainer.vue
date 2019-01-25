<template>
    <div dusk="fronds-header-cont" id="fronds-header-cont" :class="headerClasses">
        <img alt="Fronds Header Image" :src="headerImgSrc"/>
        <slot></slot>
    </div>
</template>

<script>

    export default {
        name: "header-container",
        data() {
            return {

            };
        },
        computed: {
            headerClasses() {
                return {
                    "fronds-no-cont-image": this.headerImgSrc === null
                };
            }
        },
        props: {
            headerImgSrc: {
                type: String,
                required: false,
                default: null // just move the menu bar to the top
            }
        }
    }
</script>

<style lang="scss" scoped>
    .fronds-no-cont-image {
        padding-top: 15px !important;
        min-height: 0 !important;
    }
</style>
