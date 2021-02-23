<?php

namespace App\View\Components\Chatbot;

use Illuminate\View\Component;

class Chatmsg extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.chatbot.chatmsg');
    }
}
