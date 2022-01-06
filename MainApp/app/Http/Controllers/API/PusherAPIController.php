<?php

namespace App\Http\Controllers\API;

set_time_limit(0);
use App\Http\Requests\API\CreatePusherAPIRequest;
use App\Http\Requests\API\UpdatePusherAPIRequest;
use App\Models\Pusher;
use App\Repositories\PusherRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Exception;
use App\Models\Pusher as Push;
use App\Models\Device;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use App\FilterDevices;


/**
 * Class PusherController
 * @package App\Http\Controllers\API
 */

class PusherAPIController extends AppBaseController
{
    /** @var  PusherRepository */
    private $pusherRepository;

    private $messaging;

    private const BARRIER = "nUoyYjz3lvmvtU5JfWSYPh20/9y/G4E2jiL9nCHUJ0Q=";

    public function __construct(PusherRepository $pusherRepo)
    {
        $this->pusherRepository = $pusherRepo;

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/auth.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();
        $this->messaging = $firebase->getMessaging();


    }

    /**
     * Display a listing of the Pusher.
     * GET|HEAD /pushers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pusherRepository->pushCriteria(new RequestCriteria($request));
        $this->pusherRepository->pushCriteria(new LimitOffsetCriteria($request));
        $pushers = $this->pusherRepository->all();

        return $this->sendResponse($pushers->toArray(), 'Pushers retrieved successfully');
    }

    public function refresh(Request $request)
    {
        $filter = new FilterDevices;
        $data = $filter->filter();
        return response()->json($data);
    }

    public function register(Request $request)
    {
        $input =  $request->all();

        $header = $request->header('Authorization');

        if (!empty($header)) 
        {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) 
            {
                if( self::BARRIER == $matches[1] )
                {
                    if( 
                        isset($input['device_id']) &&
                        isset($input['registration_id']) &&
                        isset($input['push_enable']) &&
                        isset($input['platform']) &&
                        isset($input['user_email'])
                      )
                    {



                        $pusher = Push::updateOrCreate(
                        		[ 
                        			'device_id' => $input['device_id'] 
                        		], 
                        		
                        		[ 
                        			'registration_id' => $input['registration_id'],
                        			'push_enable' => $input['push_enable'],
                        			'platform' => $input['platform'],
                        			'user_email' => $input['user_email']                       			
                        		]
                        		);


                        if($pusher)
                        {
                            return response()->json([
                                    "success"   => true,
                                    "message"   => "Device registered successfully"                        
                                ]);                
                        }
                    }
                    else
                    {
                        return response()->json([
                                "success"   => false,
                                "message"   => "Incorrect or missing parameters"                        
                            ]);
                    } 
                }
                else
                {
                    return response()->json([
                            "success"   => false,
                            "message"   => "UnAuthorized request"             
                        ]);
                }
            }
            else
            {
                return response()->json([
                    "success"   => false,
                    "message"   => "BARRIER token format invalid"
                ]);
            }
        }else
        {
            return response()->json([
                    "success"   => false,
                    "message"   => "BARRIER token is missing in headers"
                ]);
        }
    }


    /**
     * Store a newly created Pusher in storage.
     * POST /pushers
     *
     * @param CreatePusherAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $input = $request->all();

        $header = $request->header('Authorization');

        if (!empty($header)) 
        {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) 
            {
                if( self::BARRIER == $matches[1] )
                {
                    if( count($input['device_ids']) <= 10000 )
                    {
                        $error = "";

                        foreach($input['device_ids'] as $deviceId)
                        {
                            $pusher = Push::where('device_id' , $deviceId )
                                                    ->where('push_enable' , 'true')
                                                    ->first();

//							echo ;
                            if($pusher)
                            {
                                if(strtolower($pusher->push_enable)  == "true")
                                {
                                    $deviceToken = $pusher->registration_id;

                                    $message = CloudMessage::withTarget('token', $deviceToken);
                                    
                                    $title = $input['message']['title'];
                                    $body = $input['message']['content'];

                                     $notification = Notification::fromArray([
                                         'title' => $title,
                                         'body' => $body
                                     ]);

                                    $data = [
											    'message' => addslashes($input['message']['content']),
											    'title' => addslashes($input['message']['title']),
											    'url' => $input['message']['message_url']
											];
									
									if($pusher->user_email=="a@a.com")
									{
										 $message = $message->withNotification($notification);
									}
                                    $message = $message->withData($data);

                                    try 
                                    {
                                        $this->messaging->send($message);

                                        
                                        $device = new Device;
                                        $device->deviceId = $deviceId;
                                        $device->title = addslashes($title);
                                        $device->content = addslashes($body);
                                        $device->message_url = $input['message']['message_url'];
                                        $device->priority = $input['message']['priority'];
                                        $device->content_available = $input['message']['content_available'];
                                        $status = $device->save();
                                        if($status)
                                        {
                                            continue;
                                        }                                    
                                    }
                                    catch(Exception $e) 
                                    {
                                      $error .= "Permission denied for Device: ".$deviceId." having token ".$deviceToken." from Firebase. ";
                                      continue;
                                    }
                                }
                                else
                                {
                                    continue;
                                }                                
                            }
                            else
                            {
                                echo "Device having id ".$deviceId." were not found";
                                continue;
                            }
                        }



                        return response()->json([
                                "success"   => true,
                                "message"   => "Notification Send",
                                "error" => $error
                            ]);
                    }
                    else
                    {
                        return response()->json([
                                "success"   => false,
                                "message"   => "Device tokens limits exceeded"
                            ]);
                    }
                }
                else
                {
                    return response()->json([
                            "success"   => false,
                            "message"   => "UnAuthorized request"             
                        ]);
                }

            }
            else
            {
                return response()->json([
                        "success"   => false,
                        "message"   => "BARRIER token format invalid"
                    ]);
            }
        }
        else
        {
            return response()->json([
                    "success"   => false,
                    "message"   => "BARRIER token is missing in headers"
                ]);
        }
    }



    /**
     * Display the specified Pusher.
     * GET|HEAD /pushers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Pusher $pusher */
        $pusher = $this->pusherRepository->findWithoutFail($id);

        if (empty($pusher)) {
            echo "show";exit;
            return $this->sendError('Pusher not found');
        }

        return $this->sendResponse($pusher->toArray(), 'Pusher retrieved successfully');
    }

    /**
     * Update the specified Pusher in storage.
     * PUT/PATCH /pushers/{id}
     *
     * @param  int $id
     * @param UpdatePusherAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePusherAPIRequest $request)
    {
        $input = $request->all();

        /** @var Pusher $pusher */
        $pusher = $this->pusherRepository->findWithoutFail($id);

        if (empty($pusher)) {
            return $this->sendError('Pusher not found');
        }

        $pusher = $this->pusherRepository->update($input, $id);

        return $this->sendResponse($pusher->toArray(), 'Pusher updated successfully');
    }

    /**
     * Remove the specified Pusher from storage.
     * DELETE /pushers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Pusher $pusher */
        $pusher = $this->pusherRepository->findWithoutFail($id);

        if (empty($pusher)) {
            return $this->sendError('Pusher not found');
        }

        $pusher->delete();

        return $this->sendResponse($id, 'Pusher deleted successfully');
    }
}

/*

-- UI Component --
*using Factory;
main()
{
    dynamic m = new MathFactory.CreateMathFactory();
    m.add(10,10);
    m.sub(10,10);
}

*using MathLibaray
namespace Factory{
    public static Class MathFactory{
        public static dynamic CreateMathFactory()
        {
            return new Math();
        }
    }
}

namespace MathLibaray{
    Class Math
    {
        public int add(int x,int y){
            return x+y;
        }

        public int sub(int x,int y){
            return x-y;
        }
    }
}



*/
