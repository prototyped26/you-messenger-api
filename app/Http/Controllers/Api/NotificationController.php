<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    //
    public function store(Request $request, $telephone) {

        $findUser = User::where("telephone", "=", $telephone)->get();

        if (sizeof($findUser) > 0 ) {

            try {

                $input = $request->all(['label', 'read']);
                $input['user_id'] = $findUser[0]->id;

                $notif = new Notification($input);
                $notif->save();

                return response()->json($notif, 200);

            } catch (QueryException $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }


        } else {
            return response()->json(['error' => "L'utilisateur n'existe pas"], 400);
        }

    }

    public function getNotif(Request $request, $telephone) {

        $findUser = User::where("telephone", "=", $telephone)->get();

        if (sizeof($findUser) > 0 ) {

            try {

                $user = $findUser[0]->id;

                $notifications = Notification::where("read", "=", false)
                                    ->where("user_id", "=", $user)
                                    ->get();

                if (sizeof($notifications) > 0) {
                    $liste = [];

                    foreach ($notifications as $notification) {
                        $liste[] = $notification->label;

                        $notification->read = true;
                        $notification->save();

                    }


                    return response()->json($liste, 200);
                } else {
                    return response()->json([], 200);
                }

            } catch (QueryException $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }


        } else {
            return response()->json(['error' => "L'utilisateur n'existe pas"], 400);
        }

    }
}
