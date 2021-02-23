import { Network } from './network.js'
export const Forms = {
    /**
     * Setup single or multiple forms using id, class, HTMLFormElement or an HTMLFormElement collection,
     * it's only neccesary to define one of them.
     * @param {object} options
     * options must have following structure:
     * - id(string): Id for HTMLElement for form
     * - element(HTMLFormElement): HTMLFormElement for form
     * - class(string): class in HTMLElement for forms
     * - collection(HTMLFormElement[]): collection of HTMLFormElement for forms
     * - endpoint(string): Who is going to receive data
     * - json(boolean): (Optional) Specify if response from endpoint must be json parsed. false by default.
     * @param {*} success
     * function to be executed on request success
     * @param {*} error
     * function to be executed on request error
     */
    setup: (options, success = null, error = null) => {
        if (options.id != undefined)
            Forms.setupById(options, success, error)
        else if (options.element != undefined)
            Forms.setupByElement(options, success, error)
        else if (options.class != undefined)
            Forms.setupByClass(options, success, error)
        else if (options.collection != undefined)
            Forms.setupByCollection(options, success, error)
        else
            throw Error('You must define id, element, class or collection to setup forms')
    },

    /**
     * Clean HTMLFormElement input fields
     * @param {HTMLFormElement} form
     * HTMLFormElement to be cleaned
     * @param {string[]} fields
     * Array of fields to be cleaned on form
     */
    clean: (form, fields) => {
        for (let field of fields) form.querySelector('#' + field).value = ''
    },
    setupById: (options, success = null, error = null) => {
        let form = document.getElementById(options.id)
        if (form == null) throw Error('No valid id provided on options')
        Forms.init(form, options, success, error)
    },
    setupByElement: (options, success = null, error = null) => {
        if (!(options.element instanceof HTMLFormElement))
            throw Error('Element is not an HTMLFormElement')
        Forms.init(options.element, options, success, error)
    },
    setupByClass: (options, success = null, error = null) => {
        let list = document.getElementsByClassName(options.class)
        if (list.length <= 0) throw Error('No valid class provided on options')
        for (let form of list) Forms.init(form, options, success, error)
    },
    setupByCollection: (options, success = null, error = null) => {
        if (options.collection.length <= 0)
            throw Error('No elements provided on collection')
        for (let form of options.collection)
            if (!(form instanceof HTMLFormElement))
                throw Error('One or more elements on collection is not an HTMLFormElement')
            else
                Forms.init(form, options, success, error)
    },
    init: (form, options, success = null, error = null) => {
        form.addEventListener('submit', event => {
            event.preventDefault()
            Forms.request(form, options, success, error)
        })
    },
    request: async(form, options, success, error) => {
        let btn = form.querySelector('button[type=submit]')
        try {
            btn.setAttribute('disabled', '')
            if (options.endpoint == undefined)
                throw Error('No endpoint defined for request on options')
            let json = (options.json == undefined) ? false : options.json
            let response = await Network.sendPOST({
                endpoint: options.endpoint,
                form: form,
                json: json
            })
            if (success != null) success(response)
            else console.log(response)
        } catch (ex) {
            if (error != null) error(ex.message)
            else console.error(ex.message)
        } finally {
            btn.removeAttribute('disabled')
        }
    }
}