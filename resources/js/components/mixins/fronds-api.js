import axios from "axios";
import frondsEvents from "./fronds-events";

const payload = {};
const formPayload = new FormData();
const frondsApi = {
    lastApiResult: {},
    lastApiError: {},
    lastResponseCode: null,
    apiEndpoint: "",
    requestObj: null
};
export default {

    methods: {
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
        addBodyParam(key, value, dataType) {

            if (dataType.constructor) {
                formPayload.append(key, dataType(value));
            }
            else {
                throw "Invalid type";
            }
        },
        addFileParam(key, file) {
            if (file.filename) {
                formPayload.append(key, file);
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
                    this.fireFrondsNetwork(frondsApi.requestObj.method, frondsApi.apiEndpoint, payload, true);
                })
                .catch(error => {
                    frondsApi.lastApiError = !error.request ? error : error.request;
                    frondsApi.lastResponseCode = error.status;
                    this.fireFrondsNetwork(frondsApi.requestObj.method, frondsApi.apiEndpoint, payload, false);
                });
        },
        makeAsyncRequestWait() {

        },
        makeAsyncRequestPromise() {

        }
    },
    mixins: [ frondsEvents ],
    computed: {
        currentRequest() {
            return frondsApi.requestObj;
        }
    }
}