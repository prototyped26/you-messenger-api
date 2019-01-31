<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    //
    public function list(Request $request) {
        try {

            $messages = Message::all();
            $messagesReturn = [];


            return response()->json($messages, 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function storeOne(Request $request, $telephone) {

        $findUser = User::where("telephone", "=", $telephone)->get();

        if (sizeof($findUser) > 0 ) {

            try {

                $input = $request->all(['label', 'user_id', 'is_valid', 'date', 'is_send', 'id_message', 'groupe_id']);

                $input['user_id'] = $findUser[0]->id;

                $message = new Message($input);
                $message->save();

                return response()->json($message, 200);

            } catch (QueryException $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }


        } else {
            return response()->json(['error' => "L'utilisateur n'existe pas"], 400);
        }
    }

    public function store(Request $request) {
        $current = $request->user();
        $request->validate([
            'label' => 'required'
        ]);
        try {
            $input = $request->all([
                'label', 'user_id', 'user_id1', 'membre_id', 'is_valid', 'administrateur_id'
            ]);
            $input['user_id'] = $current->id;

            $message = new Message($input);
            $message->save();

            return response()->json($message, 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required',
            'label' => 'required',
        ]);
        try {
            $input = $request->all([
                'label', 'code', 'id'
            ]);


            Message::where('id', '=', $input['id'])->update($input);
            $message = Message::find($input['id']);

            return response()->json($message, 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delete(Request $request, $id) {
        try {

            $message = Message::destroy($id);

            return response()->json('Object Complete Deleted', 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function detail(Request $request, $id) {
        try {

            $message = Message::find($id);

            return response()->json($message, 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
