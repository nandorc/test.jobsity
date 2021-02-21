<x-layout.default-layout>
    <x-slot name="pageTitle">Home</x-slot>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" />
    @endpush
    <x-chatbot.chatbox />
</x-layout.default-layout>
