<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Timestamp extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action_id'];
    protected $appends = ['date', 'user_name', 'work_start', 'work_end', 'break_start', 'break_end'];

    public function judgeStatus()
    {
        $today = Carbon::now()->format('Y-m-d');
        [$records, $fixedDate] = Timestamp::getRecordsWithDate($today);

        // 対象ユーザーのレコードがなければ出勤前
        $name = Auth::user()->name;
        if (!array_key_exists($name, $records)) {
            return 'before working';
        }

        // 対象ユーザーの退勤レコードがあれば退勤後
        $userRecord = $records[$name];
        if ($userRecord['work_end'] !== null) {
            return 'after working';
        }

        // 休憩開始と休憩終了のレコード数が一緒でなければ休憩中
        if (count($userRecord['break_start']) !== count($userRecord['break_end'])) {
            return 'breaking';
        }

        // 上記でなければ(休憩開始と休憩終了のレコードが同数であれば),
        // 休憩がおわり、引き続き勤務中
        return 'working';
    }

    public function getRecordsWithDate($defaultDate)
    {
        $fixedDate = is_null($defaultDate) ? Carbon::now()->format('Y-m-d') : $defaultDate;

        $timestampsDateGrouped = collect(Timestamp::all()->toArray())->groupBy('date');
        $records = [];
        foreach ($timestampsDateGrouped as $date => $timestamps) {
            if ($date !== $fixedDate) {
                continue;
            }

            $timestampsUserGrouped = [];
            $timestampsUserGrouped[$date] = $timestamps->sortBy('user_id')->groupBy('user_name');

            foreach ($timestampsUserGrouped[$date] as $userName => $timestamps) {
                $userRecords = [];

                $arrayOfWorkStart = $timestamps->filter(function ($items) {
                        return $items['work_start'] !== null;
                    })->sortdesc()->first();
                $userRecords['work_start'] = isset($arrayOfWorkStart) ? $arrayOfWorkStart['work_start'] : null;

                $arrayOfWorkEnd = $timestamps->filter(function ($items) {
                        return $items['work_end'] !== null;
                    })->sortDesc()->first();
                $userRecords['work_end'] = isset($arrayOfWorkEnd) ? $arrayOfWorkEnd['work_end'] : null;

                $arrayOfBreakStart = array_values(
                        $timestamps->filter(function ($items) {
                            return $items['break_start'] !== null;
                        })->sortDesc()
                        ->map(function ($item, $key) {
                            return $item['break_start'];
                        })->all()
                    );
                $userRecords['break_start'] = isset($arrayOfBreakStart) ? $arrayOfBreakStart : null;

                $arrayOfBreakEnd = array_values(
                        $timestamps->filter(function ($items) {
                            return $items['break_end'] !== null;
                        })->sortDesc()
                        ->map(function ($item, $key) {
                            return $item['break_end'];
                        })->all()
                    );
                $userRecords['break_end'] = isset($arrayOfBreakEnd) ? $arrayOfBreakEnd : null;

                $breaking = 0;
                foreach ($userRecords['break_end'] as $index => $time) {
                    $breaking += strtotime($userRecords['break_end'][$index]) - strtotime($userRecords['break_start'][$index]);
                }
                $userRecords['breaking'] = gmdate('H:i:s', $breaking);

                if ($userRecords['work_end'] === null) {
                    $userRecords['working'] = null;
                } else {
                    $userRecords['working'] = gmdate(
                        'H:i:s',
                        strtotime($userRecords['work_end']) - strtotime($userRecords['work_start']) - $breaking
                    );
                }

                $records[$userName] = $userRecords;
            }
        }

        return [$records, $fixedDate];
    }

    public function getRecordsWithUser($targetUser)
    {
        $timestampsUserGrouped = collect(Timestamp::all()->toArray())->sortBy('user_id')->groupBy('user_name');
        $records = [];
        foreach ($timestampsUserGrouped as $user => $timestamps) {
            if ($user !== $targetUser) {
                continue;
            }

            $timestampsDateGrouped = [];
            $timestampsDateGrouped[$user] = $timestamps->sortByDesc('date')->groupBy('date');

            foreach ($timestampsDateGrouped[$user] as $date => $timestamps) {
                $dateRecords = [];

                $arrayOfWorkStart = $timestamps->filter(function ($items) {
                        return $items['work_start'] !== null;
                    })->sortdesc()->first();
                $dateRecords['work_start'] = isset($arrayOfWorkStart) ? $arrayOfWorkStart['work_start'] : null;

                $arrayOfWorkEnd = $timestamps->filter(function ($items) {
                        return $items['work_end'] !== null;
                    })->sortDesc()->first();
                $dateRecords['work_end'] = isset($arrayOfWorkEnd) ? $arrayOfWorkEnd['work_end'] : null;

                $arrayOfBreakStart = array_values(
                        $timestamps->filter(function ($items) {
                            return $items['break_start'] !== null;
                        })->sortDesc()
                        ->map(function ($item, $key) {
                            return $item['break_start'];
                        })->all()
                    );
                $dateRecords['break_start'] = isset($arrayOfBreakStart) ? $arrayOfBreakStart : null;

                $arrayOfBreakEnd = array_values(
                        $timestamps->filter(function ($items) {
                            return $items['break_end'] !== null;
                        })->sortDesc()
                        ->map(function ($item, $key) {
                            return $item['break_end'];
                        })->all()
                    );
                $dateRecords['break_end'] = isset($arrayOfBreakEnd) ? $arrayOfBreakEnd : null;

                $breaking = 0;
                foreach ($dateRecords['break_end'] as $index => $time) {
                    $breaking += strtotime($dateRecords['break_end'][$index]) - strtotime($dateRecords['break_start'][$index]);
                }
                $dateRecords['breaking'] = gmdate('H:i:s', $breaking);

                if ($dateRecords['work_end'] === null) {
                    $dateRecords['working'] = null;
                } else {
                    $dateRecords['working'] = gmdate(
                        'H:i:s',
                        strtotime($dateRecords['work_end']) - strtotime($dateRecords['work_start']) - $breaking
                    );
                }

                $records[$date] = $dateRecords;
            }
        }

        return $records;
    }

    public function user() {
        return $this->hasOne(User::class);
    }

    public function getUserNameAttribute()
    {
        return User::find($this->user_id)->name;
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getWorkStartAttribute()
    {
        if ($this->action_id === 1) {
            return $this->created_at->format('H:i:s');
        }
    }

    public function getWorkEndAttribute()
    {
        if ($this->action_id === 2) {
            return $this->created_at->format('H:i:s');
        }
    }

    public function getBreakStartAttribute()
    {
        if ($this->action_id === 3) {
            return $this->created_at->format('H:i:s');
        }
    }

    public function getBreakEndAttribute()
    {
        if ($this->action_id === 4) {
            return $this->created_at->format('H:i:s');
        }
    }
}
