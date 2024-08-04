<?php

namespace App\Http\Controllers;

use App\Models\Timestamp;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function attendance()
    {
        return view('attendance');
    }

    public function timestamp($mode, $action)
    {
        switch ($mode . $action) {
            case 'workstart':
                Timestamp::createk;
                break;
            case 'workend':
                break;
            case 'breakstart':
                break;
            case 'breakend':
                break;
            default:
                echo 'URLが不正です<br>';
        }


        echo '<script>';
        echo 'console.log(' . json_encode($mode . $action) . ')';
        echo '</script>';

        return redirect('/');
    }
}
