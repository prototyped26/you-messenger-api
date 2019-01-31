<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    //
    public function list(Request $request) {
        try {

            $contacts = Contact::all();

            return response()->json($contacts, 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function storeOne(Request $request) {
        $request->validate([
            'telephone' => 'required',
            'user_id' => 'required'
        ]);

        try {

            $input = $request->all([
                'label', 'user_id', 'telephone', 'pays'
            ]);

            $contact = new Contact($input);
            $contact->save();

            return response()->json($contact, 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function storeMany(Request $request) {

        $contacts = $request->input('contacts');

        try {

            foreach ($contacts as $key => $input) {

                try {

                    $contact = new Contact($input);
                    $contact->save();

                    $contacts[$key] =  ["operation" => true ];
                } catch (QueryException $e) {
                    $contacts[$key] =  [
                        "operation" => false,
                        "raison" => $e->getMessage()
                    ];
                }

            }

            return response()->json($contacts, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
