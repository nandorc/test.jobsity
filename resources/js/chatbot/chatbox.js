export const ChatBox = {
    /**
     * @param {string} sender The one who is sending the message (bot or user)
     * @param {string} message The message to be sent
     */
    send: (sender, message) => {
        if (sender != 'bot' && sender != 'user') throw Error('sender must be bot or user')
        else if (typeof message != 'string') throw Error('message must be a string')
        else if (message == '') throw Error('message can\'t be an empty string')
        let chatmessages = ChatBox.getChatMessages()
        let chatmsg = document.createElement('div')
        chatmsg.setAttribute('class', `chatmsg ${sender}msg`)
        chatmsg.innerHTML = message
        chatmessages.appendChild(chatmsg)
        chatmessages.scrollTop = chatmessages.scrollHeight
    },
    /**
     * Remove disabled attribute on input[name="message"] and button[type="submit"] in form#chatform
     */
    activateForm: () => {
        let inputmessage = ChatBox.getInputMessage()
        inputmessage.removeAttribute('disabled')
        inputmessage.focus()
        ChatBox.getSubmitButton().removeAttribute('disabled')
    },
    /**
     * @returns {HTMLDivElement} The div#chatmessages container
     */
    getChatMessages: () => {
        let chatmessages = document.querySelector('div#chatmessages')
        if (!(chatmessages instanceof HTMLDivElement))
            throw Error('div#chatmessages not found')
        else return chatmessages
    },
    /**
     * @returns {HTMLFormElement} The form#chatform
     */
    getChatForm: () => {
        let chatform = document.querySelector('form#chatform')
        if (!(chatform instanceof HTMLFormElement))
            throw Error('form#chatform not found')
        else return chatform
    },
    /**
     * @returns {HTMLInputElement} The input[name="message"]
     */
    getInputMessage: () => {
        let inputmessage = ChatBox.getChatForm().querySelector('input[name="message"]')
        if (!(inputmessage instanceof HTMLInputElement))
            throw Error('input[name="message"] not found')
        else return inputmessage
    },
    /**
     * @returns {HTMLButtonElement} The button[type="submit"]
     */
    getSubmitButton: () => {
        let submitbutton = ChatBox.getChatForm().querySelector('button[type="submit"]')
        if (!(submitbutton instanceof HTMLButtonElement))
            throw Error('button[type="submit"] not found')
        else return submitbutton
    }
}