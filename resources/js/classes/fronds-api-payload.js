
export const frondsApiConfig = {
        frondsEndpoint: "",
        frondsMethod: "GET",
        frondsApiBody: {},
        frondsApiHeaders: [ {} ],
        frondsQueryParams: {},
        frondsApiHandler: "axios"
    }, config = Symbol("configParams");

export class FrondsAxiosDriver {

}
export class FrondsApiPayload {
    constructor(configParams) {
        if (configParams) {
            this[config] = configParams;
        }
    }
}