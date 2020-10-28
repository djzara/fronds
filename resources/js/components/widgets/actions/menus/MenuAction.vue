<template>
    <div>
        <b-modal
            id="fronds-menu-action-modal"
            v-model="showMenuModal"
            name="fronds-menu-action-modal"
            :busy="isBusy"
            :ok-disabled="creatingItem"
            @ok.prevent="saveMenu"
        >
            <b-overlay :show="isBusy">
                <template slot="modal-header">
                    <p>{{ modalMenuTitle }}</p>
                </template>
                <transition name="slide-fade" mode="out-in">
                    <fronds-form
                        v-if="!creatingItem"
                        id="fronds-actions-menu-form"
                        key="definition"
                        :horizontal="false"
                        :submits-to="finalEndpointUri"
                        :with-method="actionApiMethod"
                        in-mode="api"
                    >
                        <fronds-input
                            v-model="menu.title.value"
                            :is-required="true"
                            :input-label="menu.title.label"
                            :input-id="menu.title.id"
                            :input-name="menu.title.name"
                            :is-valid="menu.title.valid"
                        >
                            <template slot="invalid-text">
                                <p v-for="(error, $index) in menu.title.errorMsgs" :key="'title-errors-'+$index">
                                    {{ error }}
                                </p>
                            </template>
                        </fronds-input>

                        <b-form-group
                            :label="menu.type.label"
                            :label-for="menu.type.id"
                        >
                            <b-form-select
                                :id="menu.type.id"
                                v-model="menu.type.value"
                                :options="menuTypes"
                                :name="menu.type.name"
                            />
                        </b-form-group>
                        <div id="fronds-menu-item-popover-anchor">
                            &nbsp;
                        </div>
                        <p v-if="markedItemRows.length > 0" class="fronds-error-msg">
                            One or more items had errors
                        </p>
                        <p v-for="(errorMsg, $ind) in itemErrors" :key="$ind" class="fronds-error-msg">
                            {{ errorMsg }}
                        </p>
                        <div v-for="(item, $index) in sortedMenuItems" :key="$index">
                            <fronds-button :btn-id="'fronds-remove-menu-item-icon-'+$index" btn-text="" btn-type="a"
                                           :btn-styles="{color: '#ad2326', display:'inline-block'}"
                                           :btn-outer-styles="{backgroundColor: 'transparent', display: 'inline'}"
                                           @click="showRemoveItemPopover($index)"
                            >
                                <font-awesome-icon :id="'fronds-menu-item-trash-icon-'+$index" size="1x"
                                                   :icon="['fas','trash-alt']"
                                ></font-awesome-icon>
                            </fronds-button>
                            <fronds-button :btn-id="'fronds-edit-menu-item-icon-'+$index" :btn-text="item.label" btn-type="a"
                                           :btn-styles="{color: '#7C807F', display:'inline-block'}"
                                           :btn-outer-styles="{backgroundColor: 'transparent', display: 'inline'}"
                                           @click="editItem($index)"
                            >
                            </fronds-button>
                            <font-awesome-icon v-if="markedItemRows.indexOf($index) !== -1"
                                               :id="'fronds-menu-item-invalid-icon-'+$index"
                                               class="fronds-error-msg" size="1x"
                                               :icon="['fas', 'times']"
                            ></font-awesome-icon>
                        </div>

                        <fronds-button btn-text="Add Item" btn-type="a" :btn-styles="{color: '#3147AA', display:'inline-block'}"
                                       :btn-outer-styles="{backgroundColor: 'transparent', display: 'inline'}"
                                       btn-id="fronds-menu-item-add-btn" @click="addItem"
                        >
                            <font-awesome-icon size="1x" :icon="['fas','plus']"></font-awesome-icon>
                        </fronds-button>
                    </fronds-form>

                    <fronds-form v-else-if="creatingItem" id="fronds-actions-menu-item-form" key="item" :horizontal="false">
                        <div>
                            <fronds-button v-if="creatingItem"
                                           :btn-styles="{color: '#7C807F', display:'inline-block'}"
                                           :btn-outer-styles="{backgroundColor: 'transparent', display: 'inline'}"
                                           btn-id="fronds-menu-item-back"
                                           btn-text="Go back"
                                           btn-type="a"
                                           @click="cancelItem"
                            >
                                <template slot="fronds-btn-front">
                                    <font-awesome-icon size="1x" :icon="['fas','chevron-left']"></font-awesome-icon>
                                </template>
                            </fronds-button>
                        </div>
                        <b-form-group label="Direct to" label-for="fronds-menu-item-direct-to">
                            <b-form-select id="fronds-menu-item-direct-to" v-model="menuItem.directTo" :options="directTo"
                                           name="fronds-menu-item-direct-to"
                            ></b-form-select>
                            <p class="fronds-text-help">
                                A url or reference to an existing page(TBD)
                            </p>
                        </b-form-group>
                        <fronds-input v-model="menuItem.link"
                                      input-label="URL"
                                      input-id="fronds-menu-item-link"
                                      input-name="fronds-menu-item-link"
                                      :is-required="true"
                        />
                        <fronds-input v-model="menuItem.label"
                                      input-label="Label"
                                      input-id="fronds-menu-item-label"
                                      input-name="fronds-menu-item-label"
                                      :is-required="true"
                        />
                        <fronds-input v-model="menuItem.listOrder"
                                      input-label="List Order"
                                      type="number"
                                      input-id="fronds-menu-item-list-order"
                                      input-name="fronds-menu-item-list-order"
                                      :is-required="false"
                        >
                            <template slot="help-info">
                                The order in a list that this will appear in, sorted ascending
                            </template>
                        </fronds-input>
                        <fronds-button v-if="creatingItem"
                                       :btn-styles="{color: '#3147AA', display:'inline-block'}"
                                       :btn-outer-styles="{backgroundColor: 'transparent', display: 'inline'}"
                                       btn-id="fronds-menu-item-back"
                                       btn-text="Save Item"
                                       btn-type="a"
                                       @click="saveItem"
                        >
                            <font-awesome-icon size="1x" :icon="['fas','save']"></font-awesome-icon>
                        </fronds-button>
                    </fronds-form>
                </transition>
                <b-popover
                    placement="auto"
                    container="fronds-actions-menu-form"
                    :show.sync="showDeleteConfirm"
                    triggers="click"
                    :target.sync="deleteConfirmTarget"
                >
                    <fronds-button
                        btn-id="fronds-delete-confirm-no"
                        btn-event-name="fronds-menu-item-delete-confirm-no"
                        btn-text="No"
                        btn-type="div"
                        @click="showDeleteConfirm = false"
                    >
                    </fronds-button>
                    <fronds-button
                        btn-id="fronds-delete-confirm-yes"
                        btn-event-name="fronds-menu-item-delete-confirm-yes"
                        btn-text="Yes"
                        btn-type="div"
                        @click="removeItem(selectedIndexToDelete)"
                    >
                    </fronds-button>
                    <div>
                        Are you sure?
                    </div>
                </b-popover>
            </b-overlay>
        </b-modal>
    </div>
</template>

<script>

    import axios from "axios";

    import {EventBus} from "../../../../classes/bus";
    import {BModal, BFormSelect, BFormGroup, BPopover, BOverlay} from "bootstrap-vue";
    import FrondsForm from "../../../forms/FrondsForm";
    import FrondsInput from "../../../forms/FrondsInput";
    import FrondsButton from "../../../forms/FrondsButton";

    import {METHODS, RESPONSE_CODE} from "../../../mixins/fronds-api";
    import FrondsFormMixin from "../../../mixins/fronds-form";
    import FrondsEventMixin from "../../../mixins/fronds-events";

    export default {

        name: "MenuAction",
        components: {
            BModal, BFormSelect, FrondsForm, FrondsInput, BFormGroup, FrondsButton, BPopover, BOverlay
        },
        mixins: [FrondsFormMixin, FrondsEventMixin],
        props: {
            endpointUri: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                isBusy: false,
                creatingItem: false,
                showMenuModal: false,
                modalMenuTitle: "Create a menu",
                actionApiMethod: METHODS.POST,
                menu: {
                    title: {
                        label: "Menu Title",
                        id: "fronds-action-menu-title",
                        name: "fronds-action-menu-title",
                        value: "",
                        valid: null,
                        errorMsgs: []
                    },
                    type: {
                        label: "Menu Type",
                        id: "fronds-action-menu-type",
                        name: "fronds-action-menu-type",
                        value: "list",
                        valid: null,
                        errorMsgs: []
                    },
                    items: []
                },
                menuTypes: [
                    {
                        value: "list", text: "List"
                    },
                    {
                        value: "dropdown", text: "Dropdown"
                    }
                ],
                directTo: [
                    {
                        value: "page", text: "Page", disabled: true
                    },
                    {
                        value: "external", text: "URL"
                    }
                ],
                menuItem: {
                    directTo: "external",
                    link: "",
                    label: "",
                    listOrder: 0,
                    errorMsgs: [],
                    valid: null,
                    uuid: ""
                },
                markedItemRows: [],
                editingMenuIndex: null,
                showDeleteConfirm: false,
                selectedIndexToDelete: "",
                itemErrors: [],
                isEditMode: false,
                menuId: ""
            };
        },
        computed: {
            finalEndpointUri() {
                return this.endpointUri;
            },
            deleteConfirmTarget() {
                return "fronds-menu-item-trash-icon-" + this.selectedIndexToDelete;
            },
            sortedMenuItems() {
                // eslint is gonna be like "don't think so you might create side effects"
                const sortedMenuItems = this.menu.items;
                return sortedMenuItems.sort((left, right) => {
                    return left.listOrder > right.listOrder;
                });
            },
            finalizedMenuItems() {
                return this.menu.items.map(menuItem => {
                    const baseItem = {
                        "direct_to": menuItem.directTo,
                        "external_link": menuItem.link,
                        "label": menuItem.label,
                        "list_order": menuItem.listOrder
                    };
                    if (menuItem.uuid !== "" && menuItem.uuid !== null) {
                        baseItem.uuid = menuItem.uuid;
                    }
                    return baseItem;
                });
            }
        },
        mounted() {
            EventBus.$on("fronds-edit-menu-modal", rowClicked => {
                this.isEditMode = true;
                this.showMenuModal = true;
                this.isBusy = true;
                this.modalMenuTitle = "Edit Menu";
                this.menuId = rowClicked.fullRowValues.id;
                this.loadExisting(rowClicked.fullRowValues.id);
            });

            EventBus.$on("fronds-add-menu-modal", () => {
                this.isEditMode = false;
                this.showMenuModal = true;
                this.modalMenuTitle = "Create Menu";
            });

        },
        methods: {
            addItem() {
                this.creatingItem = true;
                this.resetItem(null);
            },
            loadExisting(menuId) {
                axios.get(this.endpointUri + "/" + menuId).then(response => {
                    this.menu.title.value = response.data.data.menu_title;
                    this.menu.type.value = response.data.data.menu_type;
                    if (response.data.data.items.length > 0) {
                        response.data.data.items.forEach(item => {
                            this.menu.items.push(
                                {
                                    directTo: item.direct_to,
                                    link: item.external_link,
                                    label: item.label,
                                    listOrder: item.list_order,
                                    errorMsgs: [],
                                    valid: null,
                                    uuid: item.uuid
                                }
                            );
                        });
                    }
                    this.isBusy = false;
                }).catch(errorResponse => {
                    this.$bvModal.msgBoxOk(JSON.stringify(errorResponse.response.data.error), {
                        size: "sm",
                        okVariant: "danger",
                        centered: true,
                        id: "fronds-edit-menu-message-failure"
                    });
                    this.isBusy = false;
                });
            },
            cancelItem() {
                this.creatingItem = false;
                this.editingMenuIndex = null;
                if (this.menuItem.uuid !== "") {
                    this.resetItem(this.menuItem.uuid);
                }
                else {
                    this.resetItem(null);
                }
            },
            saveItem() {
                this.creatingItem = false;
                if (this.editingMenuIndex !== null && this.editingMenuIndex > -1) {
                    this.menu.items.splice(this.editingMenuIndex, 1, this.menuItem);
                    this.editingMenuIndex = null;
                }
                else {
                    this.menu.items.push(this.menuItem);
                }
                this.resetItem(null);
            },
            resetItem(id) {
                this.menuItem = {
                    directTo: "external",
                    link: "",
                    label: "",
                    listOrder: 0,
                    uuid: id
                };
            },
            showRemoveItemPopover(itemIndex) {
                this.selectedIndexToDelete = itemIndex;
                // turns out it takes one extra cycle to render right
                this.$nextTick(() => {
                    this.showDeleteConfirm = true;
                });
            },
            removeItem(itemIndex) {
                this.showDeleteConfirm = false;
                this.$nextTick(() => {
                    this.menu.items.splice(itemIndex, 1);
                });
            },
            editItem(itemIndex) {
                this.menuItem.listOrder = this.menu.items[itemIndex].listOrder;
                this.menuItem.label = this.menu.items[itemIndex].label;
                this.menuItem.directTo = this.menu.items[itemIndex].directTo;
                this.menuItem.link = this.menu.items[itemIndex].link;
                if (this.menu.items[itemIndex].uuid !== "") {
                    this.menuItem.uuid = this.menu.items[itemIndex].uuid;
                }
                this.creatingItem = true;
                this.editingMenuIndex = itemIndex;
            },
            resetValidationState() {
                this.menu.title.errorMsgs = [];
                this.menu.title.valid = null;
                this.menu.type.errorMsgs = [];
                this.menu.title.valid = null;
                this.menu.items.forEach(menuItem => {
                    // we're only resetting values, not setting the object to something new
                    // so it's pretty safe to ignore here
                    // eslint-disable-next-line no-param-reassign
                    menuItem.valid = null;
                    // eslint-disable-next-line no-param-reassign
                    menuItem.errorMsgs = [];
                    // eslint-disable-next-line no-param-reassign
                    menuItem.uuid = "";
                });
            },
            renderErrors(errorResponse) {
                Object.keys(errorResponse.response.data.errors).forEach(errorKey => {
                    if (errorKey.indexOf("items") === 0) {
                        errorResponse.response.data.errors[errorKey].forEach(err => this.itemErrors.push(err));
                        this.menu.items.forEach((menuItem, index) => {
                            if (errorKey.indexOf("items." + index) === 0 && this.markedItemRows.indexOf(index) === -1) {
                                this.markedItemRows.push(index);
                            }
                        });

                    }
                    else {
                        this.menu[errorKey].valid = false;
                        this.menu[errorKey].errorMsgs = errorResponse.response.data.errors[errorKey];
                    }
                });

            },
            saveMenu: function () {
                this.isBusy = true;
                this.markedItemRows = [];
                this.itemErrors = [];
                if (this.isEditMode) {
                    this.updateMenu();
                }
                else {
                    this.createMenu();
                }
            },
            createMenu: function () {

                axios.post(this.finalEndpointUri, {
                    "title": this.menu.title.value,
                    "type": this.menu.type.value,
                    "items": this.finalizedMenuItems
                }).then(response => {
                    this.isBusy = false;
                    this.menu.title.valid = true;
                    this.menu.title.errorMsgs = [];
                    if (response.status === RESPONSE_CODE.CREATED) {
                        this.$bvModal.msgBoxOk(response.data.message, {
                            size: "sm",
                            okVariant: "success",
                            centered: true,
                            id: "fronds-add-menu-message-success"
                        });
                    }
                }).catch(errorResponse => {
                    this.renderErrors(errorResponse);
                    this.isBusy = false;
                });
            },
            updateMenu: function () {
                axios.put(this.finalEndpointUri + "/" + this.menuId, {
                    "title": this.menu.title.value,
                    "type": this.menu.type.value,
                    "items": this.finalizedMenuItems
                }).then(response => {
                    this.isBusy = false;
                    this.menu.title.valid = true;
                    this.menu.title.errorMsgs = [];
                    if (response.status === RESPONSE_CODE.OK) {
                        this.$bvModal.msgBoxOk(response.data.message, {
                            size: "sm",
                            okVariant: "success",
                            centered: true,
                            id: "fronds-edit-menu-message-success"
                        });
                    }
                }).catch(errorResponse => {
                    this.renderErrors(errorResponse);
                    this.isBusy = false;
                });
            }
        }
    };
</script>

<style lang="scss" scoped>

.slide-fade-enter-active {
    transition: all .3s;
}

.slide-fade-leave-active {
    transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}
</style>
