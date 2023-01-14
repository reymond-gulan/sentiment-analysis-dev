<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

use App\Models\Course;
use App\Models\College;
use App\Classes\AppHelper;
use App\Http\Requests\CoursesRequest;

class CoursesController extends Controller
{
    public function index()
    {
        $data = [];
        $campus_id = Auth::user()->campus_id;
        $data['colleges'] = College::where('campus_id', $campus_id)
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();
        return view('courses.index', compact('data'));
    }

    public function load()
    {
        $data = Course::with('colleges')
                        ->whereNull('deleted_at')
                        ->orderBy('id','DESC')
                        ->get();

        $html = view('courses.data')->with('data', $data)->render();

        return response()->json(['html' => $html]);
    }

    public function save(CoursesRequest $request)
    {
        $campus_id = Auth::user()->campus_id;

        $key = $request->safe()->only(['id']);
        $validated = $request->safe()->except(['id']);

        $dataToMerge = [
            'campus_id' => $campus_id,
            'user_id' => Auth::user()->id
        ];

        $data = array_merge($validated, $dataToMerge);

        try {

            if(isset($key['id'])) {

                Course::where('id', $key['id'])->update($data);
                $message = AppHelper::updated();
                
            } else {

                Course::create($data);
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
        $data = Course::find($id);
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
