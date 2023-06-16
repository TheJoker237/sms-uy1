<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Filiere;
use Brian2694\Toastr\Facades\Toastr;

class FiliereController extends Controller
{
    // index page setting
    public function Filiere()
    {
        $filiereList=Filiere::all();
        $faculteList=Faculte::all();
        return view('filiere.filiere', compact('filiereList','faculteList'));
    }

    /** academic save record */
    public function filiereSave(Request $request)
    {
        $request->validate([
            'title'    => 'required|string',
            'faculty'    => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            if(!empty($request->title) && !empty($request->faculty)) {
                $filiere = new Filiere();
                $filiere->title= $request->title;
                $filiere->faculte_id = Faculte::where('title',$request->faculty)->first()->id;
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

    public function FiliereEdit(Request $request)
    {
        try {
            // dd($request);

            if (!empty($request->title) && !empty($request->faculty)) {
           
                $updateRecord = [
                    'title' => $request->title,
                    'faculte_id' => Faculte::where('title',$request->faculty)->first()->id,
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