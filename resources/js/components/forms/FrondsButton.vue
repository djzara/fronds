<template>
    <div class="fronds-btn-comp">
        <slot name="fronds-btn-front" />
        <span class="fronds-btn-label">
            <label :for="btnId">{{ btnLabel }}</label>
        </span>
        <div v-if="btnType === 'button'" :style="btnOuterStyles" class="fronds-btn" :class="finalBtnClasses">
            <button :id="btnId"
                    :type="btnRole"
                    :style="btnStyles"
                    :name="btnName"
                    @click.native.prevent="fireEvents"
            >
                {{ btnText }}
            </button>
        </div>
        <div v-else-if="btnType === 'div'" :id="btnId" :style="btnOuterStyles" class="fronds-btn" :class="finalBtnClasses" @click="fireEvents">
            <div :style="btnStyles">
                {{ btnText }}
                <slot />
            </div>
        </div>
        <div v-else-if="btnType === 'a'" :id="btnId" :style="btnOuterStyles" class="fronds-btn" :class="finalBtnClasses" @click="fireEvents">
            <a href="#" :style="btnStyles">{{ btnText }}<span class="fronds-btn-label-ext"><slot /></span></a>
        </div>
    </div>
</template>


<script>

    import FrondsEvents from "../mixins/fronds-events";

    const btnClassPrefix = "fronds-btn-";

    export default {
        mixins: [FrondsEvents],
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
                default: () => {
                    return {};
                }
            },
            btnOuterStyles: {
                type: Object,
                required: false,
                default: () => {
                    return {};
                }
            },
            btnClasses: {
                type: Array,
                required: false,
                default: () => {
                    return [];
                }
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
        },
        data() {
            return {};
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
        methods: {
            fireEvents(elem) {
                this.$emit("click");
                this.fireFrondsClick(this.btnEventName, elem.target);
            }
        }
    };
</script>

<style lang="scss" scoped>
.fronds-btn-comp {
    display: inline-block;
}
</style>