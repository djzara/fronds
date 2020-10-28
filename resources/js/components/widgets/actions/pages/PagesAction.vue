<template>
    <b-modal id="fronds-actions-pages-modal"
             v-model="showPagesForm"
             name="fronds-actions-pages-modal"
             @ok.prevent="submitPageAction"
    >
        <template slot="modal-header">
            <p>{{ pageModalTitle }}{{ pageTitle }}</p>
        </template>

        <span v-if="displayAddon">
            <slot name="pages-action-addons"></slot>
        </span>

        <fronds-form id="fronds-actions-pages-form"
                     :horizontal="false"
                     :submits-to="finalEndpointUri"
                     :with-method="actionApiMethod"
                     in-mode="api"
        >
            <fronds-input v-model="pageInfo.title"
                          :input-label="formElementsInfo.title.label"
                          :is-required="true"
                          :is-valid="formElementsInfo.title.valid"
                          :input-name="formElementsInfo.title.name"
                          :input-id="formElementsInfo.title.id"
                          @input="pageInfo.slug = slugifyStr(pageInfo.title)"
            >
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
                :input-id="formElementsInfo.slug.id"
            >
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
                    :id="formElementsInfo.layout.id"
                    v-model="pageInfo.selectedLayout"
                    :options="pageInfo.layoutOptions"
                    :name="formElementsInfo.layout.name"
                ></b-form-select>
            </b-form-group>
        </fronds-form>
    </b-modal>
</template>

<script>

// fronds lib
    import {EventBus} from "../../../../classes/bus";
    // fronds components
    import FrondsForm from "../../../forms/FrondsForm";
    import FrondsInput from "../../../forms/FrondsInput";
    // fronds mixins
    import FrondsUtil from "../../../mixins/fronds-util";
    import FrondsApi, {METHODS, RESPONSE_CODE} from "../../../mixins/fronds-api";
    import FrondsEvents from "../../../mixins/fronds-events";
    // automatically resets forms in certain scenarios
    import FrondsFormMixin from "../../../mixins/fronds-form";
    // third party components
    import {BModal, BFormSelect, BFormGroup} from "bootstrap-vue";

    export default {
        name: "PagesAction",
        components: {
            BModal, BFormSelect, BFormGroup, FrondsForm, FrondsInput
        },
        mixins: [FrondsUtil, FrondsFormMixin, FrondsApi, FrondsEvents],
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
                default: () => {
                    return {};
                }
            }
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
                editPageButtonStyles: {
                    color: "#2631D1"
                },
                actionApiMethod: METHODS.POST,
                isEdit: null,
                selectedId: null,
                frondsEventPrefix: ""

            };
        },
        computed: {
            pageTitle() {
                if (this.pageInfo.title !== "") {
                    return " : " + this.pageInfo.title;
                }
                return "";
            },
            finalEndpointUri() {
                if (this.actionApiMethod === METHODS.PUT || this.actionApiMethod === METHODS.DELETE) {
                    return this.endpointUri + "/" + this.selectedId;
                }
                return this.endpointUri;
            }
        },
        mounted() {
            EventBus.$on("fronds-delete-page", pageToDelete => {
                this.actionApiMethod = METHODS.DELETE;
                this.selectedId = pageToDelete.fullRowValues.id;
                this.setApiCall(this.actionApiMethod);
                this.setEndpoint(this.finalEndpointUri);
                this.deletePageAction();
            });
            EventBus.$on("fronds-add-page-modal", () => {
                this.isEdit = false;
                this.displayAddon = false;
                this.pageModalTitle = "Add Page";
                this.showPagesForm = true;
                this.actionApiMethod = METHODS.POST;
                this.setApiCall(this.actionApiMethod);
            });
            EventBus.$on("fronds-edit-page-modal", rowClicked => {
                this.isEdit = true;
                this.displayAddon = true;
                this.pageModalTitle = "Edit Page";
                this.showPagesForm = true;
                this.pageInfo.title = rowClicked.fullRowValues.name;
                this.pageInfo.slug = rowClicked.fullRowValues.slug;
                this.pageInfo.selectedLayout = rowClicked.fullRowValues.layout;
                this.selectedId = rowClicked.fullRowValues.id;
                this.actionApiMethod = METHODS.PUT;
                this.setEndpoint(this.finalEndpointUri);
                this.setApiCall(this.actionApiMethod);
            });
            // eslint-disable-next-line complexity
            EventBus.$on(this.frondsEventPrefix + "fronds-event-network", networkResult => {
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
                    this.$emit("fronds-update-activity-list", {});
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
        methods: {
            deletePageAction() {
                this.makeRequest();
            },
            submitPageAction() {
                this.addBodyParam(this.formElementsInfo.title.paramName, this.pageInfo.title);
                this.addBodyParam(this.formElementsInfo.slug.paramName, this.pageInfo.slug);
                this.addBodyParam(this.formElementsInfo.layout.paramName, this.pageInfo.selectedLayout);
                this.makeRequest();
            }
        }
    };
</script>