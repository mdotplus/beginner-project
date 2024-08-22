<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Timestamp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $selectedAction = $request->session()->get('selectedAction');
        switch ($selectedAction) {
            case 'work_start':
                $status = 'working';
                break;
            case 'work_end':
                $status = 'not working';
                break;
            case 'break_start':
                $status = 'breaking';
                break;
            case 'break_end':
                $status = 'working';
                break;
            case null:
                $status = 'not working';
                break;
            default:
                echo '不正な処理です';
                break;
        }

        $user = [
            'name' => Auth::user()->name,
            'id' => Auth::user()->id,
            'status' => $status,
        ];

        return view('index', compact('user'));
    }

    public function attendance()
    {
        return view('attendance');
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
