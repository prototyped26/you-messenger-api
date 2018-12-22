<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
Use \Illuminate\Database\QueryException;

class UserController extends Controller
{
    //
    public $publicSuccessStatus = 200;


    public function login(Request $request) {
        // $input['password'] = $input['telephone'];
        if( Auth::attempt(['telephone' => request('telephone'), 'password' => request('telephone')])) {

            // $user = Auth::user();
            //$token= $user->createToken('TutsForWeb')->accessToken;
            $token = auth()->user()->createToken('Get Access to API methods')->accessToken;

            return response()->json(['token' => $token], $this->publicSuccessStatus);
        } else {
            return response()->json(['error'=>'Erro de login et/ou mot de passe !'], 400);
        }
    }

    public function logout(Request $request) {
        try {
            $value = $request->bearerToken();
            $id = (new Parser())->parse($value)->getHeader('jti');
            //return response()->json($request->user()->tokens->find($id), 200);
            $token = $request->user()->tokens->find($id);
            $token->revoke();

            return response()->json(['message' => 'success'], 200);
        }catch (QueryException $e) {
            return response()->json(['' . $e->getMessage()], 400);
        }

    }

    public function register(Request $request) {
        $request->validate([
            'telephone' => 'required',
            'langue_id' => 'required'
        ]);

        try{
            $input = $request->all(['telephone', 'langue_id', 'nom', 'prenom', 'pseudo', 'photo', 'password']);
            $input['password'] = bcrypt($input['telephone']);
            $user = User::create($input);

            return response()->json($user, 200);
            /*$u = Auth::user();
            $token = $u->createToken('TutsForWeb')->accessToken;

            return response()->json(['token' => $token], $this->publicSuccessStatus);*/
        }catch (QueryException $e) {
            $messageError = '';
            if ($e->errorInfo['1'] == 1062) {
                $messageError = "User already exist please change informations and retry !";
            } else {
                $messageError = $e->getMessage();
            }


            return response()->json(['error'=> $messageError], 500);
        }

    }

    public function update(Request $request) {
        $request->validate([
            'telephone' => 'required',
            'langue_id' => 'required'
        ]);
        try {
            $input = $request->all(['telephone', 'nom', 'prenom', 'photo', 'pseudo', 'langue_id']);
           
            $local = User::where('telephone', '=', $input['telephone'])->where('nom', '=', $input['nom'])->get();

            if (sizeof($local) > 0) {
                $id = $local[0]->id;
                User::where('id', '=', $id)->update($input);
                $user = User::find($id);

                return response()->json($user, 200);
            } else {
                return response()->json("Erreur, utilisateur non spécifique !", 400);
            }


        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function otherUsers(Request $request) {
        $current = $request->user();
        $users = [];
        try {

            $users = User::where('id', '<>', $current->id)->get();

            return response()->json($users, 200);
        }catch (QueryException $e) {
            return response()->json(['' . $e->getMessage()], 400);
        }
    }
    public function me(Request $request) {
        $current = $request->user();
        try {

            return response()->json($current, 200);
        }catch (QueryException $e) {
            return response()->json(['' . $e->getMessage()], 400);
        }
    }
}
