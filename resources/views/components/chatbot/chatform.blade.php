<form id="chatform">
    @csrf
    <input name="message" type="text" placeholder="How can I help you?" disabled required />
    <button type="submit" disabled>
        <i class="material-icons">send</i>
    </button>
</form>
