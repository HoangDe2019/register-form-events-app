<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Events;
use App\Models\EventTypes;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;
use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = DB::table('users')->join('events', 'events.user_id', '=', 'users.id')->orderBy('users.id', 'DESC')->paginate(
            $perPage = 2, $columns = ['*'], $pageName = 'page'
        );

        $data = [
            'data' => $users
        ];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function registerEvent(Request $request)
    {
        $input = $request;

        $userCheckEmail = User::where(['email' => $input->email])->first();

        if (!isEmpty($userCheckEmail)) {
            throw new \Exception("Email is exits!");
        }

        if (!empty($input->full_name)) {
            $names = explode(" ", trim($input->full_name));
            $last = $names[0];
            unset($names[0]);
            $first = !empty($names) ? implode(" ", $names) : null;
        }

        if (!empty($input->password)) {
            $password = bcrypt($request->password);
        }

        $program = new User([
            'full_name' => $input->full_name,
            'first_name' => $first,
            'last_name' => $last,
            'password' => $password,
            'email' => $input->email,
            'is_supper' => 0,
            'is_actived' => 1,
            'created_at' => date(time()),
            'updated_at' => date(time())
        ]);

        $program->save();

        $user = User::find(DB::table('users')->max('id'));

        if (!empty($user)) {

            $checkEventType = DB::table('events')->join('event_types', 'event_types.id', '=', 'event_types.id')->where('events.event_type_id', 'event_types.id');

            if (empty($checkEventType)) {
                throw new \Exception("Error");
            }
            $event_type = EventTypes::where(['id' => $input->event_type_id])->first();

            if (empty($event_type['id'])) {
                throw new \Exception("id Event is not found!!");
            }

            if ($event_type->id == 0) {
                $content = "{\"work_location\":\"$input->contents\"}";
            } else {
                $content = "{\"hobby\":\"$input->contents\"}";
            }

            $profileParam = new Events([
                'user_id' => $user->id,
                'content' => $content,
                'created_at' => time(),
                'event_type_id' => $event_type->id
            ]);

            $profileParam->save();

        }
        return response()->json(['User register info to join event is successfully.' => $program]);
    }

    public function getIdInfoUser($id)
    {
        $user = User::where(['id' => $id])->first();
        $userEvent = Events::where(['user_id' => $id])->get();
        return [$user, 'info_register_events' => $userEvent];
    }

    public function destroyEvent($id)
    {
        Events::where(['user_id'=>$id])->delete();
        $res = User::find($id)->delete();
        if ($res) {
            $data = [
                'status' => '1',
                'msg' => 'success'
            ];
        } else {
            $data = [
                'status' => '0',
                'msg' => 'fail'
            ];
        }
        return response()->json($data);
    }
}
