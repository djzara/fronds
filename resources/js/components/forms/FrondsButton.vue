<template>
    <div class="fronds-btn-comp">
        <span class="fronds-btn-label">
            <label :for="btnId">{{ btnLabel }}</label>
        </span>
        <div :style="btnOuterStyles" class="fronds-btn" v-if="btnType === 'button'" :class="finalBtnClasses">
            <button :type="btnRole"
                    :style="btnStyles"
                    :name="btnName"
                    :id="btnId"
                    @click.native.prevent="fireEvents">
                {{ btnText }}
            </button>
        </div>
        <div :id="btnId" :style="btnOuterStyles" class="fronds-btn" :class="finalBtnClasses" @click="fireEvents" v-else-if="btnType === 'div'">
            <div :style="btnStyles">{{ btnText }}<slot/></div>
        </div>
        <div :id="btnId" :style="btnOuterStyles" class="fronds-btn" :class="finalBtnClasses" @click="fireEvents" v-else-if="btnType === 'a'">
            <a href="#" :style="btnStyles">{{ btnText }}<span class="fronds-btn-label-ext"><slot/></span></a>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .fronds-btn-comp {
        display: inline-block;
    }
</style>
<script>

    import FrondsEvents from "../mixins/fronds-events";
    const btnClassPrefix = "fronds-btn-";

    export default {
        data() {
            return {

            };
        },
        mixins: [ FrondsEvents ],
        methods: {
            fireEvents(elem) {
                this.fireFrondsClick(this.btnEventName, elem.target);
            }
        },
        computed: {
            finalBtnClasses() {
                const btnSizeClassClone = this.btnClasses;
                btnSizeClassClone.push(this.btnSizeClass);
                btnSizeClassClone.push(this.btnRoleClass);
                btnSizeClassClone.push(this.btnTypeClass);
                return btnSizeClassClone;
            },
            btnSizeClass() {
                return btnClassPrefix + this.btnSize;
            },
            btnRoleClass() {
                return btnClassPrefix + this.btnRole;
            },
            btnTypeClass() {
                return btnClassPrefix + this.btnType;
            }
        },
        props: {
            btnRole: {
                type: String,
                required: false,
                default: "btn",
                validator: value => {
                    return ["btn", "submit", "cancel"].indexOf(value) !== -1;
                }

            },
            btnLabel: {
                type: String,
                required: false,
                default: ""
            },
            btnType: {
                type: String,
                required: false,
                default: "div",
                validator: value => {
                    return ["button", "a", "div"].indexOf(value) !== -1;
                }
            },
            btnStyles: {
                type: Object,
                required: false,
                default: () => { return {}; }
            },
            btnOuterStyles: {
                type: Object,
                required: false,
                default: () => { return {}; }
            },
            btnClasses: {
                type: Array,
                required: false,
                default: () => { return[]; }
            },
            btnText: {
                type: String,
                required: true
            },
            btnSize: {
                type: String,
                required: false,
                default: "md",
                validator: value => {
                    return ["sm", "md", "lg", "none"].indexOf(value) !== -1;
                }
            },
            btnName: {
                type: String,
                required: false,
                default: "fronds-btn"
            },
            btnId: {
                type: String,
                required: false,
                default: "fronds-btn"
            },
            btnEventName: {
                type: String,
                required: false,
                default: "fronds-btn-click"
            }
        }
    }
</script>