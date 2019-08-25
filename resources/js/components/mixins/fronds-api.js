import axios from "axios";
import frondsEvents from "./fronds-events";

let payload = {};
const formPayload = new FormData();
const frondsApi = {
    lastApiResult: {},
    lastApiError: {},
    lastResponseCode: null,
    apiEndpoint: "",
    requestObj: null,
    apiMethod: "",
    rsvp: {}
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
            frondsApi.requestObj = {
                url: frondsApi.apiEndpoint,
                data: payload,
                method: METHODS.POST
            };
            frondsApi.apiMethod = METHODS.POST;
        },
        setApiGet() {
            frondsApi.requestObj = {
                url: frondsApi.apiEndpoint,
                params: payload,
                method: METHODS.GET
            };
            frondsApi.apiMethod = METHODS.GET;
        },
        addParam(paramKey, paramValue) {
            if (frondsApi.apiMethod === METHODS.POST) {
                this.addBodyParam(paramKey, paramValue);
            }
            else if (frondsApi.apiMethod === METHODS.GET) {
                this.setQueryParam(paramKey, paramValue);
            }
        },
        setApiPut() {
            this.setApiPost();
            // except override the method
            frondsApi.apiMethod = METHODS.PUT;
            frondsApi.requestObj.method = METHODS.PUT;
        },
        setApiDelete() {
            this.setApiGet();
            // except override the method
            frondsApi.apiMethod = METHODS.DELETE;
            frondsApi.requestObj.method = METHODS.DELETE
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
                throw Error("Invalid File");
            }
        },
        setEndpoint(endpointPath) {
            frondsApi.apiEndpoint = endpointPath;
        },
        setQueryParam(paramName, paramValue) {
            if (paramValue.filename) {
                throw Error("No files allowed");
            }
            payload[paramName] = encodeURIComponent(paramValue);
        },
        getEndpoint() {
            return frondsApi.apiEndpoint;
        },
        getErrors() {
            return frondsApi.lastApiError;
        },
        setHeaders(headerName, headerValue) { /* eslint no-unused-vars:off */

        },
        makeRequest() {
            this.fireFrondsGlobal();
            this.fireFrondsNetwork(frondsApi.apiEndpoint, frondsApi.apiMethod, payload, null);
            axios.request(frondsApi.requestObj)
                .then(response => {
                    frondsApi.lastApiResult = response.data.data;
                    frondsApi.lastResponseCode = response.status;
                    payload = {};
                    this.fireFrondsNetwork(frondsApi.apiEndpoint, frondsApi.apiMethod, response.data, true);
                })
                .catch(error => {
                    frondsApi.lastApiError = !error.response ? error : error.response;
                    frondsApi.lastResponseCode = error.status;
                    payload = {};
                    this.fireFrondsNetwork(frondsApi.apiEndpoint, frondsApi.apiMethod, error, false);
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
        },
        lastResult() {
            return frondsApi.lastApiResult;
        }
    }
}