<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
  public function searchmembers(Request $request){
    $members = \App\Member::search("%".$request->get('q')."%")->get()->keyBy('id')->toArray();
    	return response()->json($members);
    }

    public function searchshares(Request $request){
    	$shares = \App\Member::search("%".$request->get('q')."%")->with('shares')->get()->toArray();

    	$tshares = [];
    	foreach($shares as $share)
    		$tshares[$share['id']] = $share;

    	return response()->json($tshares);
    }

    public function searchloans(Request $request){
        $loans = \App\Member::search('%'.$request->get('q').'%')->with(['loans', 'guarants'])->get()->keyBy('id');
        $loansarray = $loans->toArray();
        //dd($loansarray);

        foreach($loans as $lkey=>$member){
            foreach($member->guarants as $gkey=>$guarant){
                $loan = $guarant->loan()->first()->toArray();
                $loansarray[$lkey]['guarants'][$gkey]['loan'] = $loan;
            }
        }

        return response()->json($loansarray);
    }
}
