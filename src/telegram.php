<?php

if (! function_exists('telegramMessage')) {

    function telegramMessage($chat_id, $message, $params = []){

        if($chat_id == ''){

            return false;
        }

        $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage';

        $post = [];

        $post['chat_id'] = $chat_id;
        $post['text'] = urldecode($message);

        if(!array_key_exists('parse_mode', $params)){

            $params['parse_mode'] = 'Markdown';

        }


        if(array_key_exists('buttons', $params)){

            $buttons = $params['buttons'];

            if(is_array($buttons)){

                if(count($buttons) > 0){

                    $keyboard['inline_keyboard'] = $buttons;


                    $params['reply_markup'] = json_encode($keyboard);

                }

            }

            unset($params['buttons']);


        }elseif(array_key_exists('keyboard', $params)){

            $params['reply_markup'] = json_encode(['inline_keyboard' => $params['keyboard']]);

            unset($params['keyboard']);

        }

        $post['parse_mode'] = $params['parse_mode'];

        if(array_key_exists('reply_markup', $params)){

            $post['reply_markup'] = $params['reply_markup'];

        }

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $post);

        //execute post
        $result = curl_exec($ch);

        $result = json_decode($result);

        //close connection
        curl_close($ch);

        if($result->ok){

            $return = [

                'message_id' => $result->result->message_id

            ];

            return $return;

        }else{

            return false;
        }

    }

}

if (! function_exists('telegramUpdate')) {

    function telegramUpdate($chat_id, $message_id, $message, $params = []){

        $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/editMessageText';

        $params['chat_id'] = $chat_id;
        $params['message_id'] = $message_id;

        $params['text'] = urldecode($message);

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $params);

        //execute post
        $result = curl_exec($ch);

        $result = json_decode($result);

        //close connection
        curl_close($ch);

        if($result->ok){

            $return = [

                'message_id' => $result->result->message_id

            ];

            return $return;

        }else{

            return false;
        }

    }

}

if (! function_exists('telegramAnswerCallback')) {

    function telegramAnswerCallback($callback_id, $message, $params = []){

        $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/answerCallbackQuery';

        $params['callback_query_id'] = $callback_id;
        $params['text'] = urldecode($message);

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $params);

        //execute post
        $result = curl_exec($ch);

        $result = json_decode($result);

        //close connection
        curl_close($ch);

        return;

    }
}

if (! function_exists('telegramDelete')) {

    function telegramDelete($chat_id, $message_id, $params = []){

        $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/deleteMessage';

        $params['chat_id'] = $chat_id;
        $params['message_id'] = $message_id;

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $params);

        //execute post
        $result = curl_exec($ch);

        $result = json_decode($result);

        //close connection
        curl_close($ch);

        if($result->ok){

            return true;

        }else{

            return false;
        }

    }

}