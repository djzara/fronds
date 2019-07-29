import axios from "axios";
import frondsEvents from "./fronds-events";

let payload = {};
const formPayload = new FormData();
const frondsApi = {
    lastApiResult: {},
    lastApiError: {},
    lastResponseCode: null,
    apiEndpoint: "",
    requestObj: null
};
const METHODS = {
    POST: "POST",
    GET: "GET",
    PUT: "PUT",
    DELETE: "DELETE"
};

export default {

    methods: {
        setApiCall(apiMethod) {
            switch (apiMethod) {
                case METHODS.POST:
                    this.setApiPost();
                    break;
                case METHODS.GET:
                    this.setApiGet();
                    break;
                default:
                    throw Error("No api method available for this type");
            }
        },
        setApiPost() {
            frondsApi.requestObj = axios.post(frondsApi.apiEndpoint, payload);
        },
        setApiGet() {
            frondsApi.requestObj = axios.get(frondsApi.apiEndpoint, {
                params: payload
            })
        },
        setApiPut() {

        },
        setApiDelete() {

        },
        // calling this with the same key over and over will give unpredictable results.
        addBodyParam(key, value) {
            payload[key] = value;
        },
        addFileParam(key, file) {
            if (file.filename) {
                formPayload.set(key, file);
            }
            else {
                throw "Invalid File";
            }
        },
        createApiUri() {

        },
        setEndpoint(endpointPath) {
            frondsApi.apiEndpoint = endpointPath;
        },
        setQueryParam(paramName, paramValue) {
            if (paramValue.filename) {
                throw "No files allowed";
            }
            payload[paramName] = encodeURIComponent(paramValue);
        },
        getEndpoint() {
            return frondsApi.apiEndpoint;
        },
        getErrors() {

        },
        setHeaders(headerName, headerValue) {

        },
        makeRequest() {
            this.fireFrondsGlobal();
            this.fireFrondsNetwork(frondsApi.requestObj.method, frondsApi.apiEndpoint, payload);
            axios.request(frondsApi.requestObj)
                .then(response => {
                    frondsApi.lastApiResult = response.data.data;
                    frondsApi.lastResponseCode = response.status;
                    this.fireFrondsNetwork(frondsApi.apiEndpoint, frondsApi.requestObj.method, payload, true);
                    payload = {};
                })
                .catch(error => {
                    frondsApi.lastApiError = !error.request ? error : error.request;
                    frondsApi.lastResponseCode = error.status;
                    this.fireFrondsNetwork(frondsApi.apiEndpoint, frondsApi.requestObj.method, payload, false);
                    payload = {};
                });
        },
        async makeAsyncRequestWait() {

        },
        makeAsyncRequestPromise() {

        }
    },
    mixins: [ frondsEvents ],
    computed: {
        currentFormDataPayload() {
            return formPayload;
        },
        currentPayload() {
            return payload;
        },
        currentRequest() {
            return frondsApi;
        }
    }
}