<?php

namespace App\Http\Controllers;

use App\Models\Requete;
use Illuminate\Http\Request;

class RequeteController extends Controller
{
    public function requete()
    {
        $examenList = Requete::all();
        return view('requete.requete',compact('examenList'));
    }

    public function requeteAdd()
    {
        $faculteList = [];
        $filiereList = [];
        $courseList = [];
        return view('requete.add-requete', compact('faculteList','filiereList','courseList'));
    }
}
