<template>
    <div>
        <b-modal id="fronds-actions-pages-modal"
                 @ok.prevent="submitPageAction"
                 name="fronds-actions-pages-modal"
                 v-model="showPagesForm">
            <template slot="modal-header">
                <p>{{ pageModalTitle }}{{ pageTitle }}</p>
            </template>

            <span v-if="displayAddon">
                <slot name="pages-action-addons"></slot>
            </span>

            <fronds-form :horizontal="false"
                   id="fronds-actions-pages-form"
                   :submits-to="finalEndpointUri"
                   :with-method="actionApiMethod"
                   in-mode="api"
                        v-if="!isEdit">

               <fronds-input v-model="pageInfo.title"
                             @input="pageInfo.slug = slugifyStr(pageInfo.title)"
                             :input-label="formElementsInfo.title.label"
                             :is-required="true"
                             :is-valid="formElementsInfo.title.valid"
                             :input-name="formElementsInfo.title.name"
                             :input-id="formElementsInfo.title.id">

                   <template slot="invalid-text">

                       <p v-for="(error, $index) in errors.title" :key="$index">
                           {{ error }}
                       </p>
                   </template>
               </fronds-input>


               <fronds-input
                             :input-label="formElementsInfo.slug.label"
                             :value="pageInfo.slug"
                             :readonly="true"
                             :is-required="true"
                             :is-valid="formElementsInfo.slug.valid"
                             :input-name="formElementsInfo.slug.name"
                             :input-id="formElementsInfo.slug.id">
                   <template slot="help-info">
                       <p>This is the path that this page will be available at when rendered</p>
                   </template>
                   <template slot="invalid-text">

                       <p v-for="(error, $index) in errors.slug" :key="$index">
                           {{ error }}
                       </p>
                   </template>
               </fronds-input>
               <b-form-group :label="formElementsInfo.layout.label" :label-for="formElementsInfo.layout.id">
                   <b-form-select
                           :options="pageInfo.layoutOptions"
                           v-model="pageInfo.selectedLayout"
                           :name="formElementsInfo.layout.name"
                           :id="formElementsInfo.layout.id"></b-form-select>
               </b-form-group>
           </fronds-form>
        </b-modal>
        <fronds-button btn-text=""
                       btn-event-name="fronds-add-page-modal"
                       btn-type="a"
                       btn-id="fronds-page-add-btn"
                       :btn-styles="addPageButtonStyles"
                       :btn-outer-styles="pageButtonOuterStyles">
            <font-awesome-icon :size="addButtonSize" :icon="addButton"></font-awesome-icon>
        </fronds-button>
        <fronds-button btn-text=""
                       btn-event-name="fronds-edit-page-modal"
                       btn-type="a"
                       btn-id="fronds-page-edit-btn"
                       :btn-styles="editPageButtonStyles"
                       :btn-outer-styles="pageButtonOuterStyles">
            <font-awesome-icon :size="editButtonSize" :icon="editButton"></font-awesome-icon>
        </fronds-button>
    </div>
</template>

<script>

    // fronds lib
    import { EventBus } from "../../../../classes/bus";
    // fronds components
    import FrondsForm from "../../../forms/FrondsForm";
    import FrondsButton from "../../../forms/FrondsButton";
    import FrondsInput from "../../../forms/FrondsInput";
    // fronds mixins
    import FrondsUtil from "../../../mixins/fronds-util";
    import FrondsApi, {METHODS, RESPONSE_CODE} from "../../../mixins/fronds-api";
    import FrondsEvents from "../../../mixins/fronds-events";
    // automatically resets forms in certain scenarios
    import FrondsFormMixin from "../../../mixins/fronds-form";
    // third party components
    import { BModal, BFormSelect, BFormGroup } from "bootstrap-vue";
    import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
    import { faPlusCircle, faEdit } from "@fortawesome/free-solid-svg-icons";

    export default {
        name: "pages-action",
        mounted() {
            EventBus.$on("fronds-list-row-click", rowClicked => {
                this.displayAddon = false;
                this.pageInfo.title = rowClicked.fullRowValues.name;
                this.pageInfo.slug = rowClicked.fullRowValues.slug;
                this.pageInfo.selectedLayout = rowClicked.fullRowValues.layout;
                this.existingId = rowClicked.fullRowValues.id;
                this.isEdit = false;
                this.actionApiMethod = METHODS.PUT;
                this.setEndpoint(this.finalEndpointUri);
                this.setApiCall(this.actionApiMethod);
            });
            EventBus.$on("fronds-add-page-modal", () => {
                this.isEdit = false;
                this.displayAddon = false;
                this.pageModalTitle = "Add Page";
                this.showPagesForm = true;
                this.actionApiMethod = METHODS.POST;
                this.setApiCall(this.actionApiMethod);
            });
            EventBus.$on("fronds-edit-page-modal", () => {
                this.isEdit = true;
                this.displayAddon = true;
                this.pageModalTitle = "Edit Page";
                this.showPagesForm = true;
            });
            // eslint-disable-next-line complexity
            EventBus.$on("fronds-event-network", networkResult => {
                if (networkResult.networkData.status === RESPONSE_CODE.INVALID) {
                    this.errors = networkResult.networkData.data.errors;
                    Object.keys(networkResult.networkData.data.errors).forEach(fieldKey => {
                        this.formElementsInfo[fieldKey].valid = false;
                    });
                }
                else if (networkResult.networkData.status === RESPONSE_CODE.CREATED) {
                    this.$bvModal.msgBoxOk("Page Created Successfully", {
                        title: "Page Added",
                        size: "sm",
                        okVariant: "success",
                        centered: true,
                        id: "fronds-add-page-message-success"
                    })
                    .then(() => {
                        this.showPagesForm = false;
                    });
                }
                else if (networkResult.networkData.status === RESPONSE_CODE.OK && this.actionApiMethod === METHODS.PUT) {
                    // object needs to contain all updated values in the intermediary format
                    // expected by an asset list
                    this.$emit("fronds-update-activity-list", {

                    });
                    this.$bvModal.msgBoxOk(networkResult.networkData.data.message, {
                        title: "Page Updated",
                        size: "sm",
                        okVariant: "success",
                        centered: true,
                        id: "fronds-edit-page-message-success"
                    });
                }
                this.setApiCall(this.actionApiMethod);
            });

            this.setEndpoint(this.finalEndpointUri);
        },
        data() {
            return {
                errors: [],
                displayAddon: false,
                modalKey: 0,
                selectedPage: null,
                formElementsInfo: {
                    title: {
                        name: "fronds-actions-pages-title",
                        id: "fronds-actions-pages-title",
                        paramName: "title",
                        label: "Page Title",
                        valid: null
                    },
                    slug: {
                        name: "fronds-actions-pages-slug",
                        id: "fronds-actions-pages-slug",
                        paramName: "slug",
                        label: "Slug",
                        valid: null
                    },
                    layout: {
                        name: "fronds-actions-pages-layout",
                        id: "fronds-actions-pages-layout",
                        paramName: "layout",
                        label: "Page layout",
                        valid: null
                    }
                },
                pageInfo: {
                    title: "",
                    slug: "",
                    selectedLayout: "full-page",
                    layoutOptions: [
                        {text: "Full Page", value: "full-page"},
                        {text: "Two Column", value: "two-column"},
                        {text: "Single With Gutter", value: "single-with-gutter"},
                        {text: "Two Column With Gutter", value: "two-column-with-gutter"}
                    ] // this will come from a list of available layouts, hardcoded for now
                },
                pageModalTitle: "",
                addButtonSize: "3x",
                showPagesForm: false,
                showErrorMsgModal: false,
                pageButtonOuterStyles: {
                    backgroundColor: "transparent",
                    width: 0,
                    height: 0
                },
                addPageButtonStyles: {
                    color: "#1BC215"
                },
                editPageButtonStyles: {
                    color: "#2631D1"
                },
                actionApiMethod: METHODS.POST,
                editButtonSize: "3x",
                isEdit: null,
                existingId: null

            };
        },
        mixins: [FrondsUtil, FrondsFormMixin, FrondsApi, FrondsEvents],
        components: {
            BModal, BFormSelect, BFormGroup, FrondsForm, FrondsButton, FrondsInput, FontAwesomeIcon
        },
        computed: {
            pageTitle() {
                if (this.pageInfo.title !== "") {
                    return " : " + this.pageInfo.title;
                }
                return "";
            },
            addButton() {
                return faPlusCircle;
            },
            editButton() {
                return faEdit;
            },
            finalEndpointUri() {
                if (this.actionApiMethod === METHODS.PUT) {
                    return this.endpointUri + "/" + this.existingId;
                }
                return this.endpointUri;
            },
            pageList() {
                return this.pages.map(page => {
                    return page;
                });
            }
        },
        methods: {
            submitPageAction() {
                this.addBodyParam(this.formElementsInfo.title.paramName, this.pageInfo.title);
                this.addBodyParam(this.formElementsInfo.slug.paramName, this.pageInfo.slug);
                this.addBodyParam(this.formElementsInfo.layout.paramName, this.pageInfo.selectedLayout);
                this.makeRequest();
            }
        },
        props: {
            endpointUri: {
                type: String,
                required: true
            },
            pageId: {
                type: String,
                required: false,
                default: ""
            },
            pages: {
                type: Object,
                required: false,
                default: () => { return {}; }
            }
        }
    }
</script>