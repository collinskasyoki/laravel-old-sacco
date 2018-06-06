<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use \App\Http\Requests;

class MembersController extends Controller
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
        $data = \App\Member::paginate(10);
        //dd($data);
        //$members = $data['data']; unset($data['data']);

        //$tmembers = [];
        //foreach($members as $each)
        //    $tmembers[$each['id']] = $each;
        
        return view('members')->with(['members'=>$data, 'settings'=>$settings,]);
    }

    public function getMember($id){
        $member = \App\Member::find($id)->toArray();

        $total_in_shares=0;
        $member_shares = \App\Share::where('member_id', $id)->get();
        if($member_shares!=null)
            foreach($member_shares as $eachshare)
                $total_in_shares+=$eachshare->amount;

        $total_in_loans=0;
        $member_loans = \App\Loan::where('member_id', $id)->get();
        if($member_loans!=null)
            foreach($member_loans as $eachloan)
                $total_in_loans+=$eachloan->amount;

        $total_in_guarantees=0;
        $guaranteed = \App\Guarant::where('member_id', $id)->get();
        if($guaranteed==null)
            foreach ($guaranteed as $eachguarantee)
                $total_in_guarantees+=$eachguarantee->amount;

        return response()->json(['member'=>$member, 'shares'=>$total_in_shares, 'loans'=>$total_in_loans, 'guaranteed'=>$total_in_guarantees]);
    }

    public function onlyget($id){
        return response()->json(\App\Member::find($id)->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\MemberRequest $request)
    {
        $input = \Input::all();
        $input['is_member'] = 1;
        $input['is_defector'] = 0;
        $input['is_active'] = 1;
        $input['member_level'] = 2;
        $input['speciality'] = '';
        $input['pic'] = '';
        $input['registration_fee'] = \Input::get('registration_fee');
        $input['registered_date'] = \Carbon\Carbon::parse(\Input::get('registered_date'));
        if(strlen($input['phone'])==10)
            $input['phone'] = '+254'.substr($input['phone'], 1);

        if(strlen($input['next_kin_phone'])==10)
            $input['next_kin_phone']='+254'.substr($input['next_kin_phone'], 1);

        $input['shares']=0;
        $input['shares_held']=0;

        $new = \App\Member::create($input);
        $input['status'] = 'success';
        $input['msg'] = 'Success';

        $new->registered_date = $new->registered_date->toDateString();

        if($this->settings->notifications){
            $message = "Dear ".$new->name.", welcome to ".$this->settings->name.".";
            \App\NotifySend::create(['messageto'=>$new->phone, 'messagefrom'=>$this->settings->notification_number, 'message'=>$message, 'member_id'=>$new->id]);
        }

            return response()->json($new->toArray());
            //return response()->json('Fail', 500);
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

    public function toggledefaulter($id){
        $member = \App\Member::find($id);

        $member->is_defector = $member->is_defector === true ? false : true;
        $member->save();

        return response()->json($member->is_defector);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\MemberEditRequest $request, $id)
    {
        $member = \App\Member::find($id);
        $input = \Input::all();
        if(strlen($input['phone'])==10)
            $input['phone'] = '+254'.substr($input['phone'], 1);
        if(strlen($input['next_kin_phone'])==10)
            $input['next_kin_phone']='+254'.substr($input['next_kin_phone'], 1);
        $member->update($input);
        $member->save();
        return response()->json($member, 200);
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
