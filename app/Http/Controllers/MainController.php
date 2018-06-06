<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

    public function __construct(){
        $this->settings = \App\Setting::all()->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = \App\Setting::all()->first();
        $members_reg = \App\Member::sum('registration_fee');
        $total_members = \App\Member::where('is_member', true)->count();
        $defaulter = \App\Member::where('is_defector', true)->count();
        $total_shares = \App\Share::sum('amount');
        $total_unpaid_loans = \App\Loan::where('paid_full', false)->sum('amount');
        $members_unpaid_loans = \App\Loan::distinct()->get(['member_id'])->where('paid_full', false)->count();
        $unpaid_loans = \App\Loan::where('paid_full', false)->count();
        //dd($members_unpaid_loans);

        $stats = [
            'registration_fee' => $members_reg,
            'total_members' => $total_members,
            'defaulters' => $defaulter,
            'total_shares' => $total_shares,
            'total_unpaid_loans_amount' => $total_unpaid_loans,
            'members_unpaid_loans' => $members_unpaid_loans,
            'total_unpaid_loans' => $unpaid_loans,
        ];
        //dd($members_reg);
        if($settings==null) $settings = [];
        return view('dashboard')->with(['settings' => $settings, 'stats'=>$stats,]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
