<template>

    <table :id="id" :name="name" :class="listClasses" :key="'fronds-asset-list-' + Math.random()">
        <th v-for="(listHeader, $index) in list.columns" :key="'header-' + $index">
            <div :class="headerClasses">
                <slot name="list-header" :list-header="listHeader">
                    {{ listHeader }}
                </slot>
            </div>
        </th>
        <tr v-for="(row, $index) in visibleValues" :key="'row-' + $index" :style="pointerStyle"
            @mouseenter="fireListRowMouse($index, row)"
            @click="fireListRowClick($index, row)"
            :class="[rowClasses, ruledClass, highlight ? '' : 'fronds-tabular-row-no-highlight']">
            <td v-for="(datum, $rowIndex) in row" :key="'datum-' + $index + '-' + $rowIndex">
                <slot name="list-datum" :list-datum="datum">
                    {{ datum }}
                </slot>
            </td>
        </tr>
    </table>

</template>

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

<script>

    import FrondsUtils from "../../../classes/fronds-utils";
    import FrondsEvents from "../../mixins/fronds-events";
    import {EventBus} from "../../../classes/bus";
    export default {
        name: "asset-list",
        mixins: [FrondsUtils, FrondsEvents],
        data() {
            return {
                // just need a little more control over the inline styles
                inlineStyles: [ this.pointerStyle ],
                extraColumnData: [],
                internalList: this.list
            };
        },
        methods: {
            fireListRowClick(rowNum, clickedRowValues) {
                const fullRowValues = this.internalList.values[rowNum];

                this.fireFrondsClick("fronds-list-row-click", {
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
            }
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
        props: {
            list: {
                type: Object,
                required: true,
                validator: val => {
                    // first, check to be sure the needed keys are inside
                    const hasProperColumns = val.hasOwnProperty("columns") && val.columns.length <= 3;
                    // and if it does, just make sure the values are there. we're only going to work with
                    // what's actually inside. since the keys can be set, they can be validated later
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
                required: false,
                default: "fronds-asset-list"
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
            }
        },
        mounted() {
            // TODO: in progress
            // eslint-disable-next-line no-unused-vars
            EventBus.$on("fronds-update-activity-list", payload => {
                //this.internalList = payload;

            });
        }
    }
</script>