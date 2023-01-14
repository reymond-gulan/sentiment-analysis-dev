<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Antoineaugusti\LaravelSentimentAnalysis\SentimentAnalysis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Comment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->is_deactivated) {
            Auth::logout();
            Session::flush();
            return redirect('/login')->with('deactivated', true);
        }

        $data = [];
        return view('home', compact('data'));
    }

    public function load(Request $request) 
    {
        $campus_id = Auth::user()->campus_id;
        $from = $request->input('from');
        $to = $request->input('to');
        $data = [];

        if(!empty($from) && !empty($to)) {
            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));


            $data['neutral'] = Comment::where('campus_id', $campus_id)
                                    ->whereBetween(DB::raw('DATE(created_at)'), [$date_from, $date_to])
                                    ->avg('neutral');

            $data['positive'] = Comment::where('campus_id', $campus_id)
                                    ->whereBetween(DB::raw('DATE(created_at)'), [$date_from, $date_to])
                                    ->avg('positive');

            $data['negative'] = Comment::where('campus_id', $campus_id)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$date_from, $date_to])
                                        ->avg('negative');

            $data['value'] = Comment::select(DB::raw('count(id) as count, created_at'))
                                    ->where('campus_id', $campus_id)
                                    ->whereBetween(DB::raw('DATE(created_at)'), [$date_from, $date_to])
                                    ->groupBy(DB::raw('DATE(created_at)'))
                                    ->get();
            $data['comments'] = Comment::where('campus_id', $campus_id)
                                    ->whereBetween(DB::raw('DATE(created_at)'), [$date_from, $date_to])
                                    ->get();
        } else {

            $data['neutral'] = Comment::where('campus_id', $campus_id)
                                    ->avg('neutral');

            $data['positive'] = Comment::where('campus_id', $campus_id)
                                    ->avg('positive');

            $data['negative'] = Comment::where('campus_id', $campus_id)
                                        ->avg('negative');

            $data['value'] = Comment::select(DB::raw('count(id) as count, created_at'))
                                    ->where('campus_id', $campus_id)
                                    ->groupBy(DB::raw('DATE(created_at)'))
                                    ->get();
            $data['comments'] = Comment::where('campus_id', $campus_id)
                                    ->get();
        }

        $html = view('admin.data', compact('data'))->render();
        return response()->json(['html' => $html]);
    }
}
