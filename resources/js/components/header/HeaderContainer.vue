<template>
    <div id="fronds-header-cont" dusk="fronds-header-cont" :class="headerClasses">
        <img alt="Fronds Header Image" :src="headerImgSrc" />
        <slot></slot>
    </div>
</template>

<script>

    export default {
        name: "HeaderContainer",
        props: {
            headerImgSrc: {
                type: String,
                required: false,
                default: null // just move the menu bar to the top
            }
        },
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
        }
    };
</script>

<style lang="scss" scoped>
    .fronds-no-cont-image {
        padding-top: 15px !important;
        min-height: 0 !important;
    }
</style>
