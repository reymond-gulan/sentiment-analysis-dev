<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Office;
use App\Models\College;
use App\Models\User;
use App\Classes\AppHelper;
use App\Http\Requests\OfficesRequest;

class OfficesController extends Controller
{
    public function index()
    {
        $data = [];
        $campus_id = Auth::user()->campus_id;
        $data['colleges'] = College::where('campus_id', $campus_id)
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();
        

        $data['groups'] = Office::whereIn('college_id', $data['colleges']->pluck('id'))
                            ->whereNull('deleted_at')
                            ->groupBy('college_id')
                            ->orderBy('id', 'DESC')->get();

        return view('offices.index', compact('data'));
    }

    public function load()
    {
        $data = Office::with('colleges')
                        ->whereNull('deleted_at')
                        ->orderBy('id','DESC')
                        ->get();

        $html = view('offices.data')->with('data', $data)->render();

        return response()->json(['html' => $html]);
    }

    public function save(OfficesRequest $request)
    {
        $key = $request->safe()->only(['id']);
        $validated = $request->safe()->except(['id']);

        $dataToMerge = [
            'user_id' => Auth::user()->id
        ];

        $data = array_merge($validated, $dataToMerge);

        try {

            if(isset($key['id'])) {

                Office::where('id', $key['id'])->update($data);
                $message = AppHelper::updated();
                
            } else {

                Office::create($data);
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
        $data = Office::find($id);
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
