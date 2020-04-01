<?php

namespace AkiCreative\AkiForms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use AkiCreative\AkiForms\Models\MailQueue;

class Akinotification extends Model
{
    
	static public function process()
	{

		$rows = Akinotification::whereNull('sent_at')->where('send_at', '<=', now())->take(25)->get();

        foreach($rows as $row){


            if($row->notificationtype == 'email'){

                if($row->email_toname == ''){

                    $row->email_toname = $row->email_toemail;
                }

                if($row->email_test_flg){

                    $row->email_subject = $row->email_subject . ' - ORIG TO: ' . $row->email_toemail;

                    $row->email_toemail = 'steven.i@me.com';
                }

                Mail::send(new MailQueue($row)); 

                $row->sent_at = now();
                $row->save();
   

            }elseif($row->notificationtype == 'telegram'){



            }

        }

	}

}
