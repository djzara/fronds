import axios from "axios";
import frondsEvents from "fronds-events";

const payload = {};
const formPayload = new FormData();

export default {

    methods: {
        apiPost() {

        },
        apiGet() {

        },
        apiPut() {

        },
        apiDelete() {

        },
        addBodyParam(key, value, dataType) {

        },
        addFileParam(key, file) {

        },
        createApiUri() {

        },
        setEndpoint(endpointPath) {
            this.apiEndpoint = endpointPath;
        },
        setQueryParams(paramName, paramValue) {

        },
        getEndpoint() {
            return this.apiEndpoint;
        },
        getErrors() {

        },
        setHeaders(headerName, headerValue) {

        },
        makeRequest() {

        },
        makeAsyncRequestWait() {

        },
        makeAsyncRequestPromise() {

        }
    },
    mixins: [ frondsEvents ],
    computed: {
        currentRequest() {

        }
    },
    data() {
        return {
            frondsApi: {
                lastApiResult: {},
                lastApiError: {},
                lastResponseCode: null,
                apiEndpoint: ""
            }

        }
    }
}