<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function note()
    {
        $examenList = Note::all();
        return view('note.note',compact('examenList'));
    }

    public function noteAdd()
    {
        $faculteList = [];
        $filiereList = [];
        $courseList = [];
        return view('note.add-note', compact('faculteList','filiereList','courseList'));
    }
}
