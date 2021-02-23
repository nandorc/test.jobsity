export const Network = {
    /**
     * @param {object} options
     * options must have following structure:
     * - endpoint(string): Who is goint to receive data
     * - json(boolean): (Optional) Specify if response from endpoint must be json parsed. false by default.
     */
    sendGET: options => {
        return new Promise((resolve, reject) => {
            try {
                if (options == undefined) throw Error('No options received')
                if (options.endpoint == undefined) throw Error('No endpoint defined')
                if (typeof options.endpoint != 'string') throw Error('Endpoint must be a string')
                let obj = new XMLHttpRequest()
                let json = (options.json == undefined) ? false : options.json
                obj.addEventListener('readystatechange',
                    event => Network.validate(event.target, json, resolve, reject))
                obj.open('GET', options.endpoint)
                obj.send()
            } catch (ex) { reject(Error(ex.message)) }
        })
    },

    /**
     * @param {object} options
     * options must have following structure:
     * - endpoint(string): Who is going to receive data
     * - data(object): Data to send on request
     * - form(HTMLFormElement): Form to take and send data.
     * - json(boolean): (Optional) Specify if response from endpoint must be json parsed. false by default.
     */
    sendPOST: options => {
        return new Promise((resolve, reject) => {
            try {
                if (options == undefined) throw Error('No options received')
                if (options.endpoint == undefined) throw Error('No endpoint defined')
                if (typeof options.endpoint != 'string') throw Error('Endpoint must be a string')
                if (options.data == undefined && options.form == undefined) throw Error('You must define data or form on options')
                if (options.data != undefined && typeof options.data != 'object') throw Error('data must be an object')
                if (options.form != undefined && !(options.form instanceof HTMLFormElement)) throw Error('form must be an HTMLFormElement')
                let obj = new XMLHttpRequest()
                let json = (options.json == undefined) ? false : options.json
                let fd = (options.form != undefined) ? new FormData(options.form) : new FormData()
                if (options.data != undefined && options.form == undefined) {
                    let keys = Object.keys(options.data)
                    for (let k of keys) fd.append(k, options.data[k])
                }
                obj.addEventListener('readystatechange',
                    event => Network.validate(event.target, json, resolve, reject))
                obj.open('POST', options.endpoint)
                obj.send(fd)
            } catch (ex) { reject(Error(ex.message)) }
        })
    },
    validate: (target, json, resolve, reject) => {
        if (target.readyState == 4 && target.status != 200)
            reject(Error(`Error ${target.status}: ${target.statusText}`))
        else if (target.readyState == 4 && !json)
            resolve(target.responseText)
        else if (target.readyState == 4)
            try { resolve(JSON.parse(target.responseText)) }
        catch { reject(Error(`El response no se puede parsear. Response:\r\n${target.responseText}`)) }
    }
}