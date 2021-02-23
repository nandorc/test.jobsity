import { NetworkHandler } from '../utilities/networkhandler.js'
import { ChatBox } from './chatbox.js'
export const ChatBot = {
    init: async() => {
        await ChatBot.greet()
    },
    greet: async() => {
        let chatform = ChatBox.getChatForm()
        NetworkHandler.setupform(chatform, 'chatbot/message', ChatBot.handleBotResponse, console.error)
        chatform.addEventListener('submit', ChatBot.handleUserMessages)
        ChatBot.handleBotResponse(await NetworkHandler.getrequest('account'))
    },
    handleUserMessages: () => {
        let inputmessage = ChatBox.getInputMessage()
        inputmessage.setAttribute('disabled', '')
        let type = inputmessage.getAttribute('type')
        let msg = inputmessage.value
        if (type == 'password') msg = '(¬.¬)->(<i>YourSecretPassword</i>)<-(¬.¬)'
        ChatBox.send('user', msg)
    },
    handleBotResponse: response => {
        let data = response.data
        if (data.message != undefined) ChatBot.handleBotMessage(data.message)
        else if (data.redirect != undefined) ChatBot.handleRedirection(data.redirect)
    },
    handleBotMessage: message => {
        ChatBox.send('bot', message.content)
        ChatBox.getChatForm().reset()
        ChatBox.getInputMessage().setAttribute('type', message.type)
        ChatBox.activateForm()
    },
    handleRedirection: redirect => {
        window.open(redirect.href, redirect.target)
    }
}
document.addEventListener('DOMContentLoaded', ChatBot.init)