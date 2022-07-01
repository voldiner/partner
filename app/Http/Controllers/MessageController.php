<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class MessageController extends Controller
{
    public function index()
    {
        $messages = null;

        $counter = Message::where('user_id', '=', auth()->user()->id)->count();
        $messages = Message::where('user_id', '=',  auth()->user()->id)
            ->skip($counter - 30)
            ->take(30)
            ->get();

        return view('chat', compact(
                'messages'
        ));
    }

    public function createMessage(Request $request)
    {
        $rules = [
            'message' => 'required|string|max:300',
            'user_id' => 'required|integer|exists:users,id',
            'administrator_id' => 'required|in:0',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation error', 'message' => $validator->errors()->all()], 400)->withHeaders(['partner' => 'errorPartner']);
        }

        $message = Message::create([
            'text' => $request->get('message'),
            'user_id' => $request->get('user_id'),
            'administrator_id' => $request->get('administrator_id'),
            'from' => $request->get('user_id')
        ]);

        if (!$message) {
            return response()->json(['error' => 'error create message', 'message' => ['error create message in table']], 500)->withHeaders(['partner' => 'errorPartner']);
        }
        $user = User::find($request->get('user_id'));
        $event = $user->password_fxp;

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'), //APP KEY
            env('PUSHER_APP_SECRET'), //APP SECRET
            env('PUSHER_APP_ID'), //APP ID
            [
                'cluster' => env('PUSHER_APP_CLUSTER')
            ]
        );
        $pusher->trigger('partner', $event, array(
            'message' => htmlspecialchars($request->get('message')),
            'user_id' => $request->get('user_id'),
            'administrator_id' => $request->get('administrator_id'),
            'from' => $request->get('user_id'),
            'user_name' => $user->short_name,
            'date' => $message->getDateMessage()

        ));

        return response()->json($request->all(), 200);

    }

}
