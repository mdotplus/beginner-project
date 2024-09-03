<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Timestamp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserPageController extends Controller
{
    public function userpage(Request $request)
    {
        $users = User::all();
        /* dd($request->userName); */

        if (is_null($request->userName)) {
            return view('user-page', [
                'users' => $users,
                'targetUser' => null,
                'records' => null,
            ]);
        }

        $targetUser = $request->userName;
        $records = Timestamp::getRecordsWithUser($targetUser);

        return view('user-page', [
            'users' => $users,
            'targetUser' => $targetUser,
            'records' => $records,
        ]);
    }
}
