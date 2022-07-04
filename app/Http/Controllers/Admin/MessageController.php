<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $maxMessagesToView = config('partner.messages_to_view', 20);
        $users = User::where('user_type', '=', 1)->pluck('id', 'short_name');
        $users->put('не вказано', 0);
        $messages = null;
        $firstId = 0;
        if (session()->has('atpId')) {
            $counter = Message::where('user_id', '=', session('atpId'))->count();
            if ($counter - $maxMessagesToView > 0) {
                $messages = Message::where('user_id', '=', session('atpId'))
                    ->skip($counter - $maxMessagesToView)
                    ->take($maxMessagesToView)
                    ->get();
                $firstId = $messages->first()->id;
            }else{
                $messages = Message::where('user_id', '=', session('atpId'))
                    ->get();
                $firstId = 0;
            }

        }

        return view('admin.chat', compact(
                'users',
                'messages',
                'firstId'
        ));
    }

    public function createMessage(Request $request)
    {
        $rules = [
            'message' => 'required|string|max:300',
            'user_id' => 'required|integer|exists:users,id',
            'administrator_id' => 'required|integer|exists:administrators,id',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation error', 'message' => $validator->errors()->all()], 400)->withHeaders(['partner' => 'errorPartner']);
        }

        $message = Message::create([
            'text' => $request->get('message'),
            'user_id' => $request->get('user_id'),
            'administrator_id' => auth()->user()->id,
            'from' => $request->get('administrator_id')
        ]);

        if (!$message) {
            return response()->json(['error' => 'error create message', 'message' => ['error create message in table']], 500)->withHeaders(['partner' => 'errorPartner']);
        }
        $user = User::find($request->get('user_id'));
        $event = $user->password_fxp;
        $administrator = Administrator::find($request->get('administrator_id'));

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'), //APP KEY
            env('PUSHER_APP_SECRET'), //APP SECRET
            env('PUSHER_APP_ID'), //APP ID
            [
                'cluster' => env('PUSHER_APP_CLUSTER')
            ]
        );
        $pusher->trigger('partner', $event, array(
            'id' => $message->id,
            'message' => htmlspecialchars($request->get('message')),
            'user_id' => $request->get('user_id'),
            'administrator_id' => $request->get('administrator_id'),
            'from' => $request->get('administrator_id'),
            'user_name' => $user->short_name,
            'administrator_name' => $administrator->shortName(),
            'date' => $message->getDateMessage()

        ));

        return response()->json($request->all(), 200);

    }


    public function getMessages(Request $request)
    {
        $rules = [
            'first_id' => 'required|integer',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation error', 'message' => $validator->errors()->all()], 400)->withHeaders(['partner' => 'errorPartner']);
        }

        $maxMessagesToView = config('partner.messages_to_view', 20);
        $messages = null;
        $counter = Message::where('user_id', '=', session('atpId'))
            ->where('id', '<', $request->get('first_id'))
            ->count();

        if ($counter - $maxMessagesToView > 0) {
            $messages = Message::where('user_id', '=', session('atpId'))
                ->where('id', '<', $request->get('first_id'))
                ->with(['administrator', 'user'])
                ->skip($counter - $maxMessagesToView)
                ->take($maxMessagesToView)
                ->get();
            $firstId = $messages->first()->id;
        } else {
            $messages = Message::where('user_id', '=', session('atpId'))
                ->where('id', '<', $request->get('first_id'))
                ->with(['administrator', 'user'])
                ->get();
            $firstId = 0;
        }

        $reverseMessages = $messages->reverse();
        $result = ['first_id' => $firstId, 'messages' => []];
        foreach ($reverseMessages as $message) {
            $result['messages'][] = [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'user_name' => $message->user->short_name,
                'administrator_name' => $message->administrator_id === 0 ? '' : $message->administrator->shortName(),
                'administrator_id' => $message->administrator_id,
                'message' => htmlspecialchars($message->text),
                'date' => $message->getDateMessage(),
                'from' => $message->from,
            ];
        }

        return response()->json($result, 200);
    }



}
