<?php

namespace App\Http\Utilities;

class ChatBotHandler
{
    /**
     * Retreive a clean string
     * @param string The string to be cleaned
     */
    public static function clean(string $message)
    {
        $message = str_replace(' ', '', $message); // Supress blank spaces
        $message = strtolower($message); // Convert to lowercase
        $message = trim($message); // Remove scaped characters at begining or end
        $message = htmlspecialchars($message, ENT_QUOTES); // Convert HTML special chars
        return $message;
    }
    /**
     * Returns a random message from $messages
     * @param string[] &$messages String array with messages
     * @return string The random message.
     */
    public static function randomMessage(array &$messages)
    {
        shuffle($messages);
        return $messages[0];
    }
    /**
     * Returns an associative array with basic structure message to be sent as response from chatbot.
     * @param string $msg The message to be sent.
     * @param string $type (Optional) Expected type for next input on chatbot. Must be a valid input[type] value.
     */
    public static function botResponse(string $msg, string $type = 'text')
    {
        return self::successResponse(['message' => ['content' => $msg, 'type' => $type]]);
    }
    /**
     * Returns an associative array with a status:success response requesting to redir on data
     */
    public static function redirResponse(string $href = '/', string $target = '_self')
    {
        return self::successResponse(['redirect' => ['href' => $href, 'target' => $target]]);
    }
    /**
     * Return an associative array with key 'status' set as 'success'
     * @param array $data (Optional) Associative array with data to be sent.
     */
    public static function successResponse(array $data = [])
    {
        return ['status' => 'success', 'data' => $data];
    }
}
