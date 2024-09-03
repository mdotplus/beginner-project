<?php

namespace App\Http\Controllers;

use App\Models\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AttendanceController extends Controller
{
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
}
