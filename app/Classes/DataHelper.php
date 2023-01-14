<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Office;

class DataHelper
{
    public static function campuses($id)
    {
        $data = User::where('campus_id', $id)->get();
        if(count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function colleges($id)
    {
        $data = Office::where('college_id', $id)->get();
        if(count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
