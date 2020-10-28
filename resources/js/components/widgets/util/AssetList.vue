<template>
    <table :id="id" :key="'fronds-asset-list-' + Math.random()" :name="name" :class="listClasses">
        <th v-for="(listHeader, $index) in list.columns" :key="'header-' + $index">
            <div :class="headerClasses">
                <slot name="list-header" :list-header="listHeader">
                    {{ listHeader }}
                </slot>
            </div>
        </th>
        <tr v-for="(row, $index) in visibleValues" :key="'row-' + $index" :style="pointerStyle"
            :class="[rowClasses, ruledClass, highlight ? '' : 'fronds-tabular-row-no-highlight']"
            @mouseenter="fireListRowMouse($index, row)"
        >
            <td v-for="(datum, $rowIndex) in row" :key="'datum-' + $index + '-' + $rowIndex" @click="fireListRowClick($index, row)">
                <slot name="list-datum" :list-datum="datum">
                    {{ datum }}
                </slot>
            </td>
            <td v-if="deletesRows" @click="fireDeleteRow($index, row)">
                <fronds-button btn-text="Remove"
                               :btn-event-name="'fronds-delete-row-modal-'+$index"
                               btn-type="a"
                               :btn-id="'fronds-row-delete-btn-'+$index"
                               :btn-styles="{color: '#dd1a1a', display:'inline-block', marginRight: '10px;'}"
                               :btn-outer-styles="{backgroundColor: 'transparent', display: 'inline'}"
                >
                    <font-awesome-icon size="1x" :icon="['fas','trash-alt']"></font-awesome-icon>
                </fronds-button>
            </td>
        </tr>
    </table>
</template>


<script>

    import FrondsUtils from "../../../classes/fronds-utils";
    import FrondsEvents from "../../mixins/fronds-events";
    import {EventBus} from "../../../classes/bus";
    export default {
        name: "AssetList",
        mixins: [FrondsUtils, FrondsEvents],
        props: {
            list: {
                type: [Object, Array],
                required: false,
                default: () => {
                    return {values: [], columns: []};
                },
                validator: val => {
                    if (val.length === 0) {
                        return true;
                    }
                    // first, check to be sure the needed keys are inside
                    // eslint-disable-next-line no-prototype-builtins
                    const hasProperColumns = val.hasOwnProperty("columns") && val.columns.length <= 3;
                    // and if it does, just make sure the values are there. we're only going to work with
                    // what's actually inside. since the keys can be set, they can be validated later
                    // eslint-disable-next-line no-prototype-builtins
                    return hasProperColumns && val.hasOwnProperty("values");
                }
            },
            listLabelKey: {
                type: String,
                required: false,
                default: "label"
            },
            listValueKey: {
                type: String,
                required: false,
                default: "value"
            },
            highlight: {
                type: Boolean,
                required: false,
                default: true
            },
            highlightColor: {
                type: String,
                required: false,
                default: "#C5D1BB"
            },
            ruled: {
                type: Boolean,
                required: false,
                default: true
            },
            columnHeaderClasses: {
                type: [String, Array],
                required: false,
                default: "fronds-tabular-header"
            },
            rowValueClasses: {
                type: [String, Array],
                required: false,
                default: "fronds-tabular-row"
            },
            assetListClasses: {
                type: [String, Array],
                required: false,
                default: "fronds-asset-list-table"
            },
            pageSize: {
                type: Number,
                required: false,
                default: 10
            },
            pageNum: {
                type: Number,
                required: false,
                default: 1
            },
            id: {
                type: String,
                required: true
            },
            name: {
                type: String,
                required: false,
                default: "fronds-asset-list"
            },
            clickable: {
                type: Boolean,
                required: false,
                default: true
            },
            loading: {
                type: Boolean,
                required: false,
                default: false
            },
            triggersEventNamed: {
                type: String,
                required: false,
                default: "fronds-list-row-clicked"
            },
            deletesRows: {
                type: Boolean,
                required: false,
                default: false
            },
            triggersDeleteEventNamed: {
                type: String,
                required: false,
                default: "fronds-list-row-delete"
            }
        },
        data() {
            return {
                // just need a little more control over the inline styles
                inlineStyles: [ this.pointerStyle ],
                extraColumnData: [],
                internalList: this.list
            };
        },
        computed: {
            headerClasses() {
                return this.arrayToClassList(this.columnHeaderClasses);
            },
            rowClasses() {
                return this.arrayToClassList(this.rowValueClasses);
            },
            listClasses() {
                return this.arrayToClassList(this.assetListClasses);
            },
            pointerStyle() {
                if (this.clickable) {
                    return "cursor:pointer;";
                }
                return "";
            },
            rowInlineStyles() {
                return this.inlineStyles;
            },
            ruledClass() {
                if (this.ruled) {
                    return "fronds-tabular-row-rule";
                }
                return "";
            },
            visibleValues() {
                const vals = [];
                if (this.list.values.length === 0) {
                    return vals;
                }
                // keep the original so that it's trivial to get the value we need later
                // and just return a virtual mutated copy
                this.list.values.forEach(rowValue => {
                    vals.push(Object.keys(rowValue).reduce((accumulatorObj, colKey) => {
                        if (this.list.hidden.indexOf(colKey) === -1) {
                            // eslint-disable-next-line no-param-reassign
                            accumulatorObj[colKey] = rowValue[colKey];
                        }
                        return accumulatorObj;
                    }, {}));
                });
                return vals;
            }
        },
        mounted() {
            // TODO: in progress
            // eslint-disable-next-line no-unused-vars
            EventBus.$on("fronds-update-activity-list", payload => {
            //this.internalList = payload;

            });
        },
        methods: {
            fireListRowClick(rowNum, clickedRowValues) {
                const fullRowValues = this.internalList.values[rowNum];

                this.fireFrondsClick(this.triggersEventNamed, {
                    rowNum, clickedRowValues, fullRowValues
                });

            },
            fireListRowMouse(rowNum, rowValues) {
                const payload = {};
                this.internalList.columns.forEach((columnName, columnNumber) => {
                    payload[columnName] = rowValues[columnNumber];
                });
                this.fireFrondsMouse("fronds-list-row-hover", {
                    rowNum,
                    payload
                });
            },
            fireDeleteRow(rowNum, row) {
                this.$bvModal.msgBoxConfirm("Are you sure you want to remove this item?", {
                    title: "Delete Row",
                    size: "sm",
                    okVariant: "danger",
                    okTitle: "Yes",
                    cancelTitle: "No",
                    footerClass: "p-2",
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(doDelete => {
                        if (doDelete) {
                            const fullRowValues = this.internalList.values[rowNum];
                            this.fireFrondsClick(this.triggersDeleteEventNamed, {
                                rowNum, row, fullRowValues
                            });
                        }
                    });
            }
        }
    };
</script>

<style lang="scss" scoped>

    .fronds-asset-list-table {
        text-align: center;
        width: 100%;
        padding: 5px;

        .fronds-tabular-header {
            width: 100%;
        }

        .fronds-tabular-row {
            padding: 2px;
            height: 50px;
            min-height: 50px;
            &:hover:not(.fronds-tabular-row-no-highlight) {
                background-color: #9bbad1;
            }
        }

        .fronds-tabular-row-rule {
            border-top: 1px black solid;
        }

    }

</style>
