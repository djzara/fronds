
const config = Symbol("configParams");
export const frondsApiConfig = {
    frondsEndpoint: "",
    frondsMethod: "GET",
    frondsApiBody: {},
    frondsApiHeaders: [ {} ],
    frondsQueryParams: {},
    frondsApiHandler: "axios"
};

export class FrondsAxiosDriver {

}
export class FrondsApiPayload {
    constructor(configParams) {
        if (configParams) {
            this[config] = configParams;
        }
    }
}