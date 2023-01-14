<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Setting;
use App\Classes\AppHelper;

class SettingsController extends Controller
{

    public function index()
    {
        $data = [];
        $campus_id = Auth::user()->campus_id;
        $data = Setting::where('campus_id', $campus_id)->first();

        return view('settings.index')->with('data', $data);
    }

    public function require_email_verification(Request $request)
    {
        $require_email_verification = $request->input('require_email_verification');

        $campus_id = Auth::user()->campus_id;
        try {

            $query = Setting::where('campus_id', $campus_id)->first();

            if(empty($query)) {
                Setting::create([
                    'require_email_verification' => $require_email_verification,
                    'campus_id' => $campus_id
                ]);
            } else {
                Setting::where('campus_id', $campus_id)->update([
                    'require_email_verification' => $require_email_verification
                ]);
            }
            
            return response()->json([
                'success' => "Setting saved!",
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }
}
