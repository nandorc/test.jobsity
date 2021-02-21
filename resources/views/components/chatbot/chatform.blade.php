<form id="chatform">
    @csrf
    <input name="message" type="text" placeholder="How can I help you?" autofocus required />
    <button type="submit">
        <i class="material-icons">send</i>
    </button>
</form>
