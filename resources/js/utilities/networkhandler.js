import { Forms } from "./forms.js";
import { Network } from "./network.js";
export const NetworkHandler = {
    getrequest: async endpoint => {
        let response = await Network.sendGET({
            endpoint: endpoint,
            json: true
        });
        return NetworkHandler.validaterequest(response)
    },
    postrequest: async(endpoint, data) => {
        let response = await Network.sendPOST({
            endpoint: endpoint,
            data: data,
            json: true
        });
        return NetworkHandler.validaterequest(response)
    },
    validaterequest: response => {
        if ("success" != response.status) {
            if (response.message == undefined)
                throw Error('endpoint didn\'t send status:success on response.')
            else throw Error(response.message)
        }
        return response
    },
    setupform: (form, endpoint, success, error) => {
        Forms.setup({
            element: form,
            endpoint: endpoint,
            json: true
        }, response => NetworkHandler.handleformresponse(response, success, error), error)
    },
    handleformresponse: (response, success, error) => {
        try {
            NetworkHandler.validaterequest(response)
            success(response)
        } catch (ex) { error(ex.message) }
    }
};