<x-layout.default-layout>
    <x-slot name="pageTitle">Home</x-slot>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" />
    @endpush
    <x-chatbot.chatbox />
    @push('scripts')
        <script type="module" src="{{ asset('js/chatbot.js') }}"></script>
    @endpush
</x-layout.default-layout>
