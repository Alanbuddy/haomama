<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index()
    {
        $items = DB::select('select * from failed_jobs')
            ->get();
        dd($items);
    }
}
