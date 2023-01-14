<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Answer;
use App\Classes\AppHelper;
use App\Http\Requests\AnswersRequest;

class AnswersController extends Controller
{
    public function index()
    {
        return view('answers.index');
    }

    public function load()
    {
        $campus_id = Auth::user()->campus_id;
        $data = Answer::with('campuses')
                        ->where('campus_id', $campus_id)
                        ->whereNull('deleted_at')
                        ->orderBy('points','DESC')
                        ->get();

        $html = view('answers.data')->with('data', $data)->render();

        return response()->json(['html' => $html]);
    }

    public function save(AnswersRequest $request)
    {
        $key = $request->safe()->only(['id']);
        $validated = $request->safe()->except(['id']);

        $dataToMerge = [
            'campus_id' => Auth::user()->campus_id,
            'user_id' => Auth::user()->id
        ];

        $data = array_merge($validated, $dataToMerge);

        try {

            if(isset($key['id'])) {

                Answer::where('id', $key['id'])->update($data);
                $message = AppHelper::updated();
                
            } else {

                Answer::create($data);
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
        $data = Answer::find($id);
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
