<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Question;
use App\Classes\AppHelper;
use App\Http\Requests\QuestionsRequest;

class QuestionsController extends Controller
{
    public function index()
    {
        return view('questions.index');
    }

    public function load()
    {
        $campus_id = Auth::user()->campus_id;
        $data = Question::with('campuses')
                        ->where('campus_id', $campus_id)
                        ->whereNull('deleted_at')
                        ->orderBy('question_number','ASC')
                        ->get();

        $html = view('questions.data')->with('data', $data)->render();

        return response()->json(['html' => $html]);
    }

    public function save(QuestionsRequest $request)
    {
        $key = $request->safe()->only(['id']);
        $validated = $request->safe()->except(['id']);

        try {

            if(isset($key['id'])) {

                $data = $request->safe()->only(['question_description']);
                Question::where('id', $key['id'])->update($data);
                $message = AppHelper::updated();
                
            } else {

                $campus_id = Auth::user()->campus_id;
                $question_number = self::questionNumber($campus_id);
                $dataToMerge = [
                    'question_number' => $question_number,
                    'campus_id' => $campus_id,
                    'user_id' => Auth::user()->id
                ];
                $data = array_merge($validated, $dataToMerge);

                Question::create($data);
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
        $data = Question::find($id);
        try {

            $data->update(['deleted_at' => now()]);
            
            return response()->json([
                'success' => AppHelper::deleted(),
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $question_number = $request->input('question_number');
        $data = Question::find($id);
        try {

            $data->update(['question_number' => $question_number]);
            
            return response()->json([
                'success' => AppHelper::updated(),
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }

    private static function questionNumber($campusId) {
        
        $query = Question::where('campus_id', $campusId);

        if(count($query->get()) > 0) {
            $data = $query->max('question_number') + 1;
        } else {
            $data = 1;
        }

        return $data;
    }
}
