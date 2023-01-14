<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

use App\Models\Campus;
use App\Models\User;
use App\Classes\AppHelper;
use App\Http\Requests\UsersRequest;

class UsersController extends Controller
{
    public function index()
    {
        $data = [];
        
        $data['campuses'] = Campus::where('id','<>','1')->orderBy('id', 'DESC')->get();

        return view('users.index', compact('data'));
    }

    public function load()
    {
        $data = User::where('id', '<>', Auth::user()->id)
                        ->whereNull('deleted_at')
                        ->get();

        $html = view('users.data')->with('data', $data)->render();

        return response()->json(['html' => $html]);
    }

    public function save(UsersRequest $request)
    {
        $validated = $request->validated();

        $user = $request->safe()->only(['employee_id']);

        $dataToMerge = [
            'password' => bcrypt($user['employee_id']),
            'user_id' => Auth::user()->id
        ];

        //return response()->json(['error' => json_encode($dataToMerge)]);

        $data = array_merge($validated, $dataToMerge);

        try {
            User::create($data);
            $message = AppHelper::saved();
            
            return response()->json([
                'success' => $message,
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }

    public function deactivate(Request $request)
    {
        $id = $request->input('id');
        $data = User::find($id);
        try {
            $is_deactivated = $data->is_deactivated;

            if($is_deactivated) {
                $data->update(['is_deactivated' => false]);    
            } else {
                $data->update(['is_deactivated' => true]);
            }
            
            return response()->json([
                'success' => 'Status has been updated.',
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $data = User::find($id);
        try {

            //$data->delete();
            $data->update(['deleted_at' => now()]);
            
            return response()->json([
                'success' => AppHelper::deleted(),
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }
}
