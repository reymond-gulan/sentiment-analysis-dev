<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use App\Http\Requests\CampusesRequest;
use App\Models\Campus;
use App\Classes\AppHelper;


class CampusesController extends Controller
{
    public function index()
    {
        return view('campuses.index');
    }

    public function load()
    {
        $data = Campus::where('id','<>','1')->orderBy('id', 'DESC')->get();

        $html = view('campuses.data')->with('data', $data)->render();

        return response()->json(['html' => $html]);
    }

    public function save(CampusesRequest $request)
    {
        $key = $request->safe()->only(['id']);
        $data = $request->safe()->except(['id']);

        try {

            if(isset($key['id'])) {
                Campus::where('id', $key['id'])->update($data);
                $message = AppHelper::updated();
            } else {
                Campus::create($data);
                $message = AppHelper::saved();
            }
            
            return response()->json([
                'success' => $message,
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $data = Campus::find($id);
        try {

            $data->delete();
            
            return response()->json([
                'success' => AppHelper::deleted(),
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }
}
