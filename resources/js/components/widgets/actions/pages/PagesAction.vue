<template>
    <div>
        <b-modal id="fronds-actions-pages-modal"
                 @ok.prevent="submitPageAction"
                 name="fronds-actions-pages-modal"
                 v-model="showPagesForm">
            <template slot="modal-header">
                <p>{{ pageModalTitle }}{{ pageTitle }}</p>
            </template>

            <asset-list v-if="isEdit" :list="pageList"></asset-list>

           <fronds-form :horizontal="false"
                   id="fronds-actions-pages-form"
                   :submits-to="finalEndpointUri"
                   :with-method="actionApiMethod"
                   in-mode="api"
                        v-else>

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
    import AssetList from "../../util/AssetList";
    // fronds mixins
    import FrondsUtil from "../../../mixins/fronds-util";
    import FrondsApi, {RESPONSE_CODE} from "../../../mixins/fronds-api";
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
            EventBus.$on("fronds-add-page-modal", () => {
                this.isEdit = false;
                this.pageModalTitle = "Add Page";
                this.showPagesForm = true;
                this.actionApiMethod = "POST";
                this.setApiCall(this.actionApiMethod);
            });
            EventBus.$on("fronds-edit-page-modal", () => {
                this.isEdit = true;
                this.pageModalTitle = "Edit Page";
                this.showPagesForm = true;
                this.actionApiMethod = "PUT";
                this.setApiCall(this.actionApiMethod);
            });
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
                this.setApiCall(this.actionApiMethod);
            });

            this.setEndpoint(this.finalEndpointUri);
        },
        data() {
            return {
                errors: [],
                modalKey: 0,
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
                actionApiMethod: "",
                editButtonSize: "3x",
                isEdit: null

            };
        },
        mixins: [FrondsUtil, FrondsFormMixin, FrondsApi, FrondsEvents],
        components: {
            BModal, BFormSelect, BFormGroup, FrondsForm, FrondsButton, FrondsInput, FontAwesomeIcon, AssetList
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
                if (this.actionApiMethod === "PUT") {
                    return this.endpointUri + "/1";
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
                type: Array,
                required: false,
                default: () => { return []; }
            }
        }
    }
</script>