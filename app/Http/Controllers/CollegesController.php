<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

use App\Models\Campus;
use App\Models\College;
use App\Models\User;
use App\Classes\AppHelper;
use App\Http\Requests\CollegesRequest;

class CollegesController extends Controller
{
    public function index()
    {
        return view('colleges.index');
    }

    public function load()
    {
        $data = College::with('campuses')
                        ->whereNull('deleted_at')
                        ->orderBy('id','DESC')
                        ->get();

        $html = view('colleges.data')->with('data', $data)->render();

        return response()->json(['html' => $html]);
    }

    public function save(CollegesRequest $request)
    {
        $campus_id = Auth::user()->campus_id;
        $input = $request->safe()->only(['college_code','college_name']);

        $key = $request->safe()->only(['id']);
        $validated = $request->safe()->except(['id']);

        $dataToMerge = [
            'user_id' => Auth::user()->id,
            'campus_id' => $campus_id
        ];

        $data = array_merge($validated, $dataToMerge);

        try {

            if(isset($key['id'])) {

                College::where('id', $key['id'])->update($data);
                $message = AppHelper::updated();
                
            } else {

                College::create($data);
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
        $data = College::find($id);
        try {

            $data->update(['deleted_at' => now()]);
            
            return response()->json([
                'success' => AppHelper::deleted(),
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }
}
