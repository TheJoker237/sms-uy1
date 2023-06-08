<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Filiere;
use Brian2694\Toastr\Facades\Toastr;

class FiliereController extends Controller
{
    // index page setting
    public function Filiere()
    {
        $FiliereList=Filiere::all();
        return view('filiere.filiere', compact('FiliereList'));
    }

    /** academic save record */
    public function filiereSave(Request $request)
    {
        $request->validate([
            'title'    => 'required|string',
            'faculty'    => 'required|string',
        ]);
        // dd($request);
        
        DB::beginTransaction();
        try {
            if(!empty($request->title) && !empty($request->faculty)) {
                $filiere = new Filiere();
                $filiere->title= $request->title;
                $filiere->faculty= $request->faculty;
                // dd($Course->year);
                $filiere->save();
                Toastr::success('Has been add successfully :)','Success');
                DB::commit();
            }
            return redirect()->back(); 
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new Filiere :)','Error');
            return redirect()->back();
        }
    }

    /** view for academic year edit */
    public function FiliereEdit($id)
    {
        $FiliereList = Filiere::all();
        $Filiere = Filiere::where('id',$id)->first();
        return view('filiere.edit-filiere',compact('FiliereList','Filiere'));
    }

    /** update record */
    public function FiliereUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            // dd($request);

            if (!empty($request->title) && !empty($request->faculty)) {
           
                $updateRecord = [
                    'title' => $request->title,
                    'faculty' => $request->faculty,
                ];
                Filiere::where('id',$request->id)->update($updateRecord);
                
                Toastr::success('Has been update successfully :)','Success');
                DB::commit();
                return redirect()->back();
            }
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update Filiere  :)','Error');
            return redirect()->back();
        }
    }

    /** academic delete */
    public function FiliereDelete(Request $request)
    {
        DB::beginTransaction();
        try {
           
            if (!empty($request->id)) {
                Filiere::destroy($request->id);
                DB::commit();
                Toastr::success('Filiere deleted successfully :)','Success');
                return redirect()->back();
            }
    
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Filiere deleted fail :)','Error');
            return redirect()->back();
        }
    }
}
