<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

        return view('index', ['user' => $user]);
    }

    public function attendance(Request $request)
    {
        $defaultDate = isset($request->targetDate) ? $request->targetDate : null;
        [$records, $fixedDate] = Timestamp::getRecordsWithDate($defaultDate);

        $records = collect($records);
        $recordsPerPage = 5;
        $records = new LengthAwarePaginator(
            $records->forPage($request->page, $recordsPerPage),
            count($records),
            $recordsPerPage,
            $request->page,
            array('path' => $request->url()),
        );

        return view('attendance', [
            'records' => $records,
            'fixedDate' => $fixedDate,
        ]);
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
