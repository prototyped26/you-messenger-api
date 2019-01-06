<?php

namespace App\Http\Controllers\Api;

use App\Models\Administrateur;
use App\Models\Groupe;
use App\Models\Membre;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupeController extends Controller
{
    //
    public function create(Request $request) {
        $request->validate([
            'label' => 'required',
            'user_id' => 'required'
        ]);

        $groupe = new Groupe();
        try{
            $input = $request->all(['label', 'photo', 'description', 'note', 'user_id']);

            $groupe = Groupe::create($input);

            $input = ['user_id' => $groupe->user_id, 'groupe_id' => $groupe->id];

            $admin = Administrateur::create($input);

            return response()->json($groupe, 200);
        }catch (QueryException $e) {
            $messageError = '';
            $messageError = $e->getMessage();
            return response()->json($messageError, 400);

            return response()->json($messageError, 500);
        }
    }

    public function getGroupe(Request $request, $id) {
        $groupe = new Groupe();
        try{

            $groupe = Groupe::find($id);
            // $groupe["administrateurs"] = $groupe->administrateurs;
            $arr = [];
            foreach ($groupe->administrateurs as $key => $admin) {
                $arr[] = $admin->user;
                //$groupe["administrateurs"][$key]["user"] = $admin->user;
                //$groupe["administrateurs"][$key]["groupe"] = $admin->groupe;

            }
            $groupe["administrators"] = $arr;
            // $groupe["membres"] = $groupe->membres;
            $arr = [];
            foreach ($groupe->membres as $key => $membre) {
                $arr = $membre->user;
                //$groupe["membres"][$key]["user"] = $membre->user;

            }
            $groupe["members"] = $arr;
            //$groupe["administrateurs"]["user"] = $groupe->administrateurs->

            return response()->json($groupe, 200);
        }catch (QueryException $e) {
            $messageError = '';
            $messageError = $e->getMessage();
            return response()->json($messageError, 400);
        }
        return response()->json($messageError, 500);
    }

    public function addAdminGroup(Request $request) {
        $request->validate([
            'groupe_id' => 'required',
            'user_id' => 'required'
        ]);
        try{
            $input = $request->all(['groupe_id', 'user_id']);

            $admin = Administrateur::create($input);

            return response()->json($admin, 200);
        }catch (QueryException $e) {
            $messageError = '';
            $messageError = $e->getMessage();
            return response()->json($messageError, 400);

            return response()->json($messageError, 500);
        }
    }

    public function removeAdminGroup(Request $request) {
        $request->validate([
            'groupe_id' => 'required',
            'user_id' => 'required'
        ]);
        try{
            $input = $request->all(['groupe_id', 'user_id']);

            $admin = Administrateur::where('groupe_id', '=', $input['groupe_id'])->where('user_id', '=', $input['user_id'])->get();

            if (sizeof($admin) > 0) {

                Administrateur::destroy($admin[0]->id);
                return response()->json("Opération ok", 200);

            } else {
                return response()->json("L'administrateur n'existe pas !", 400);
            }

            $admin = Administrateur::create($input);

            return response()->json($admin, 200);
        }catch (QueryException $e) {
            $messageError = '';
            $messageError = $e->getMessage();
            return response()->json($messageError, 400);
        }
        return response()->json($messageError, 500);
    }

    public function addMemberGroup(Request $request) {
        $request->validate([
            'groupe_id' => 'required',
            'user_id' => 'required'
        ]);
        try{
            $input = $request->all(['groupe_id', 'user_id']);

            $member = Membre::create($input);

            return response()->json($member, 200);
        }catch (QueryException $e) {
            $messageError = '';
            $messageError = $e->getMessage();
            return response()->json($messageError, 400);

        }
        return response()->json($messageError, 500);
    }

    public function removeMemberGroup(Request $request) {
        $request->validate([
            'groupe_id' => 'required',
            'user_id' => 'required'
        ]);
        try{
            $input = $request->all(['groupe_id', 'user_id']);

            $member = Membre::where('groupe_id', '=', $input['groupe_id'])->where('user_id', '=', $input['user_id'])->get();

            if (sizeof($member) > 0) {

                Membre::destroy($member[0]->id);
                return response()->json("Opération ok", 200);

            } else {
                return response()->json("Le membre ou le groupe n'existe pas !", 400);
            }

            $admin = Administrateur::create($input);

            return response()->json($admin, 200);
        }catch (QueryException $e) {
            $messageError = '';
            $messageError = $e->getMessage();
            return response()->json($messageError, 400);
        }
        return response()->json($messageError, 500);
    }
}
