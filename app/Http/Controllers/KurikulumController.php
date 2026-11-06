<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use App\Models\ProgramUnggulan;

class KurikulumController extends Controller
{
    public function index()
    {
        $profil = ProfilSekolah::first();
        $programUnggulan = ProgramUnggulan::active()->ordered()->get();

        return view('front.kurikulum', compact('profil', 'programUnggulan'));
    }
}
