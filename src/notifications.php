<?php

if (! function_exists('akinotificationqueue')) {

    function akinotificationqueue() {
        
        $rows = AkiCreative\AkiForms\Models\Akinotification::whereNull('sent_at')->where('send_at', '<=', now())->take(25)->get();

        foreach($rows as $row){


            if($row->notificationtype == 'email'){

                if($row->email_toname == ''){

                    $row->email_toname = $row->email_toemail;
                }

                if($row->email_test_flg){

                    $row->email_subject = $row->email_subject . ' - ORIG TO: ' . $row->email_toemail;

                    $row->email_toemail = 'steven.i@me.com';
                }

                \Illuminate\Support\Facades\Mail::send(new \AkiCreative\AkiForms\Models\MailQueue($row)); 

                $row->sent_at = now();
                $row->save();
   

            }elseif($row->notificationtype == 'telegram'){



            }

        }

    }
}