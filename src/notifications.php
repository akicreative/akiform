<?php

if (! function_exists('akinotificationqueue')) {

    function akinotificationqueue() {

        echo time();

        /*
        
        $emails = AkiCreative\AkiForms\Akinotification::whereNull('sent_at')->where('toemail', '!=', '')->where('send_at', '<=', now())->take(25)->get();

        */

        /*

        foreach($emails as $email){

            if($email->toname == ''){

                $email->toname = $email->toemail;
            }

            if($email->test_flg){

                $email->subject = $email->subject . ' - ORIG TO: ' . $email->toemail;

                $email->toemail = 'info@akicreative.net';
            }

            Illuminate\Support\Facades\Mail::send(new App\Mail\MailQueue($email));  

            $email->sent = 1;
            $email->sent_dt = now();
            $email->save();

        }

        */

    }
}