<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models\Pusher;
use App\Models\Record;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;


class FilterDevices extends Model
{
	private $messaging;

	public function __construct()
	{
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/Http/Controllers/API/auth.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();
        $this->messaging = $firebase->getMessaging();
	}

	public function filter()
	{
		Pusher::where('device_id','')->forceDelete();
		$duplicate_device = [];

		$pushers = Pusher::all();
		foreach ($pushers as $pusher) 
		{
			if($this->verfiyFromFirebase($pusher))
			{
				if(empty($duplicate_device))
				{
					array_push($duplicate_device, $pusher->registration_id );
				}
				else
				{
					if(in_array($pusher->registration_id, $duplicate_device))
					{
						Pusher::find($pusher->id)->forceDelete();
					}
					else
					{
						array_push($duplicate_device, $pusher->registration_id );
						continue;
					}
				}
			}
			else
			{
				$record = new Record;
				$record->device_id = $pusher->device_id;
				$record->registration_id = $pusher->registration_id;
				$record->push_enable = $pusher->push_enable;
				$record->platform = $pusher->platform;
				$record->user_email = $pusher->user_email;
				$record->deleted_at = date('Y-m-d h:i:s');
				$record->save();

				Pusher::find($pusher->id)->forceDelete();
			}
		}
		
		return ['status' => 'success','message' => 'remove unusual records'];
	}

	private function verfiyFromFirebase(Pusher $pusher)
	{
		$boolean = true;

        $message = CloudMessage::withTarget('token', $pusher->registration_id);
        $notification = Notification::fromArray([
            'title' => '',
            'body' => ''
        ]);
        $message = $message->withNotification($notification);
        try 
        {
           $this->messaging->send($message);
           $boolean = true;                                
        }
        catch(\Exception $e) 
        {
        	$boolean = false;
        }

        return $boolean;
	}



}
