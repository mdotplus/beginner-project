<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $status = Timestamp::judgeStatus();
        $user = [
            'name' => Auth::user()->name,
            'id' => Auth::user()->id,
            'status' => $status,
        ];

        return view('index', ['user' => $user]);
    }

    public function timestamp(Request $request)
    {
        Timestamp::create([
            'user_id' => intval($request->user_id),
            'action_id' => Action::where('action', $request->action)->get()[0]['id'],
        ]);

        return redirect('/')->with('selectedAction', $request->action);
    }
}
