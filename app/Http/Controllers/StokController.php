<?php

namespace App\Http\Controllers;

use App\Models\InternalModel;
use App\Models\LainnyaModel;
use Illuminate\Http\Request;
use App\Models\Oli;
use App\Models\RemModel;

class StokController extends Controller
{
    public function index (){
        $totalRem = RemModel::sum('stok');
        $totalOli = Oli::sum('stok');
        $totalInternal = InternalModel::sum('stok');
        $totalLainnya = LainnyaModel::sum('stok');
        return view('stok/stok' , compact('totalOli', 'totalRem', 'totalInternal', 'totalLainnya'));
    }
}
