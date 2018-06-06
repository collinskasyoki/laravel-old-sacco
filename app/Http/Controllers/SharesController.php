<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use App\Http\Requests;

class SharesController extends Controller
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
        if($settings==null) $settings = [];
        $shares = \App\Share::orderBy('amount', 'desc')->paginate(10);

        $members = [];
        foreach($shares as $share)
            $members[$share->member_id] = $share->member()->first();

        $allmembers = \App\Member::where('is_member', true)->get()->keyBy('id');
        
        return view('shares')->with(['shares' => $shares, 'settings'=>$settings, 'allmembers'=>$allmembers, 'members'=>$members]);
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
    public function store(Requests\SharesRequest $request)
    {
        $input = \Input::all();
        $input['date_received'] = \Carbon\Carbon::parse(\Input::get('date_received'));

        $share = \App\Share::create($input);
        $share->date_received = $share->date_received->toDateString();

        $member = \App\Member::find($input['member_id']);
        $member->update(['shares' => $member->shares+=$input['amount']]);
        $member->save();

        $share->id_no = $member->id_no;
        $message = "Dear Member, KSh ".\Input::get('amount')." worth of shares has been added to your account, dated ".$share->date_received.". Your total shares are now KSh ".$member->shares;

        if($this->settings->notifications){
            \App\NotifySend::create(['messageto'=>$member->phone, 'messagefrom'=>$this->settings->notification_number, 'message'=>$message, 'member_id'=>$member->id]);
        }
        return response()->json($share);
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
    public function update($id)
    {
        $share = \App\Share::find($id);
        $orig_amount = $share->amount;
        $member = $share->member()->first();
        $share->update(\Input::all());
        $share->save();
        $share->id_no=$member->id_no;

        if($orig_amount!=\Input::get('amount')){
            //$message = "Dear Member, KSh ".\Input::get('amount')." worth of shares added on ".$share->date_received." has been changed to KSh ".$share->amount.". Your total shares are now KSh ".$member->shares;
            //\App\NotifySend::create(['messageto'=>$member->phone, 'messagefrom'=>$this->settings->notification_number, 'message'=>$message, 'member_id'=>$member->id]);
        }
        
        return response()->json($share);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $share = \App\Share::find($id);
        $tloans = \App\Loan::where('member_id', $share->member_id)->get();
        $tshares = \App\Member::find($share->member_id)->shares;
        $total = 0;
            foreach($tloans as $tloan){
                if($tloan['paid_full']==true)continue;
                $total += ($this->settings['retention_fee']/100)*$tshares;
                $total += $tloan['amount'];
            }

        $tguarants = \App\Guarant::where('member_id', $share->member_id)->get()->toArray();
            //minus amounts guaranteed
            //unless its self guaranteeing
            foreach ($tguarants as $eachguarant){
                if($share->member_id!=$eachguarant['loan_owner_id'])
                    $total += $eachguarant['amount'];
            }

        $amount = $share->amount;

        if(($tshares-$total)<$amount)
            return response()->json(['fail', 'Not able to delete shares, loans exceed shares.'], 422);

        $member = $share->member()->first();
        $member->update(['shares'=>$member->shares-$amount]);
        if($member->shares < 0)$member->shares=0;
        $member->save();
        $share->delete();
        return response()->json('Success', 200);
    }
}
