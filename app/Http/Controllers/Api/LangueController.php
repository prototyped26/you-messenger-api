<?php

namespace App\Http\Controllers\Api;

use App\Models\Langue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LangueController extends Controller
{
    //
    public function list(Request $request) {
        try {

            $langues = Langue::all();
            $languesReturn = [];


            return response()->json($langues, 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function store(Request $request) {
        $request->validate([
            'label' => 'required'
        ]);
        try {
            $input = $request->all([
                'label', 'code'
            ]);


            $langue = new Langue($input);
            $langue->save();

            return response()->json($langue, 200);

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


            Langue::where('id', '=', $input['id'])->update($input);
            $langue = Langue::find($input['id']);

            return response()->json($langue, 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delete(Request $request, $id) {
        try {

            $langue = Langue::destroy($id);

            return response()->json('Object Complete Deleted', 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function detail(Request $request, $id) {
        try {

            $langue = Langue::find($id);

            return response()->json($langue, 200);

        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
