<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Events;
use App\Models\EventTypes;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        $data = User::latest()->get();
        return response()->json([UserResource::collection($data), 'User fetched.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerEvent(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'registerEvent' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        if (!empty($request->full_name)) {
            $names = explode(" ", trim($request->full_name));
            $last = $names[0];
            unset($names[0]);
            $first = !empty($names) ? implode(" ", $names) : null;
        }

        if (!empty($request->password)) {
            $password = password_hash($request->password, PASSWORD_BCRYPT);
        }

        $program = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'first_name' => $first,
            'last_name' => $last,
            'password' => $password,
        ]);

        $UserRegisterJoinEvent = new Events();
        $user = User::latest()->id->get();
        $event_type = EventTypes::latest()->id->get();

        if (empty($user)) {
            $profileModel = new Events();

            $checkEventType = EventTypes::model()->where('id', $event_type->id)->first();
            if(empty($checkEventType)){
                throw new \Exception(Message::get("Error", "is not found event Type!"));
            }
            $profileParam = [
                'user_id' => $user->id,
                'content' => $request->contents,
                'event_type_id' => $checkEventType
            ];
            //print_r($profileParam); die;

            $profileModel->create($profileParam);

        }

        return response()->json(['User register info to join event is successfully.', new ProgramResource($program)]);
    }
}
