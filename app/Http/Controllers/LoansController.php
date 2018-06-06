<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests;
use Request;

class LoansController extends Controller
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

        $loans = \App\Loan::orderBy('date_given', 'DESC')->paginate(10);

        $members = [];
        foreach($loans as $loan){
            //dd($loan);
            $members[$loan->member_id] = $loan->member()->first();
        }

        return view('loans')->with(['settings'=> $settings, 'loans' => $loans, 'members'=>$members]);

    }

    public function add_loan_verify_members(){

        $members = \App\Member::where('is_member', true)->get()->keyBy('id');

        $maxes = [];
        foreach($members as $memberindex=>$member){
            if(!$this->verify($member['id'])){
               $members->forget($memberindex);
                continue;
            }

            $loanable = $member->shares - $member->shares_held;

            $loanable = $loanable - (($this->settings->retention_fee/100)*$loanable);

            if($loanable<=0){
                $members->forget($memberindex);
                continue;
            }

            $maxes[$memberindex]['guarant_max'] = $loanable;
            $maxes[$memberindex]['loan_max'] = $loanable*3;
        }

        //return response()->json(['settings'=> $this->settings->toArray(), 'members'=>$members, 'maxes'=>$maxes,]);
        return response()->json(['settings'=> $this->settings->toArray(), 'members'=>$members, 'maxes'=>$maxes,]);
    }

    protected function verify($id){
        $member = \App\Member::find($id);
        if($member==null)return false;
        $loans = $member->loans()->get()->toArray();
        $shares = $member->shares()->get()->toArray();
        
        if(!($member->is_active) || !($member->is_member) || $member->is_defector || empty($shares)){
            return false;
        }
        
        return true;
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
    public function store(Requests\LoanRequest $request)
    {
        $settings = \App\Setting::all()->first();
        $member = \App\Member::find(\Input::get('member_id'));

        $input = \Input::all();
        $dategiven = \Carbon\Carbon::parse(\Input::get('date_given'));
        $input['date_given'] = $dategiven;

        $date = new \Carbon\Carbon();
        $date = $date->parse(\Input::get('date_given'));
        $input['date_given'] = $date->toDateString();

        $guarantors = $input['guarantors'];

        $input['date_due'] = $date->addMonths(1)->toDateString();
        $interest = (($settings->loan_interest)/100) * $input['amount'];
        $input['amount_payable'] = $interest + $input['amount'];
        $input['approved'] = true;
        $input['paid_full'] = false;
        $extremedate = $dategiven->addMonths($this->settings->loan_duration);
        $input['extreme_due'] = $extremedate->toDateString();
        $input['installment'] = $input['amount_payable']/($this->settings->loan_duration);

        $loan = \App\Loan::create($input);
        //add retention fee in held up
        $retention_fee = ($this->settings->retention_fee/100) * ($member->shares-$member->shares_held);
        $member->shares_held += $retention_fee;
        $member->save();
        $loan->retention_fee = $retention_fee;
        $loan->save();
        $loan->id_no = $member->id_no;

        //notify
        if($this->settings->notifications){
            $message_loanee = "Loan processed. Your loan balance of Ksh ".$loan->amount_payable." is due on ".$loan->date_due." and a fee of KSh  ".$interest." applied.";
            \App\NotifySend::create(['messageto'=>$member->phone, 'messagefrom'=>$this->settings->notification_number, 'message'=>$message_loanee, 'member_id'=>$member->id]);
        }

        $all_guarantors = [];
        //add guarantors
        foreach($input['guarantors_amounts'] as $key=>$guarantor){
            $theguarantor = \App\Member::find($key);

            $input_guarant = [
                'member_id' => $key,
                'loan_id' => $loan->id,
                'loan_owner_id' => $input['member_id'],
                'amount' => $guarantor,
                'to_release' => $guarantor,
                'retention_fee' => 0,
            ];

            $each_guarant = \App\Guarant::create($input_guarant);
            $all_guarantors[] = $each_guarant;

            if($key==$input['member_id']){ $theguarantor->shares_held += $each_guarant->amount; }
            else{
                $guarantors_retention = ($theguarantor->shares-$theguarantor->shares_held)*($this->settings->retention_fee/100);
                $each_guarant->retention_fee = $guarantors_retention;
                $each_guarant->save();
                $theguarantor->shares_held += $each_guarant->amount + $guarantors_retention;
            }
            
            $theguarantor->save();

            if($this->settings->notifications){
                $message_guarantor = "Dear member, you have guaranteed ".$member->name." KSh ".$each_guarant->amount." on their loan.";
                \App\NotifySend::create(['messageto'=>$theguarantor->phone, 'messagefrom'=>$this->settings->notification_number, 'message'=>$message_guarantor, 'member_id'=>$theguarantor->id]);
            }
        }


        return response()->json(['loan'=>$loan, 'guarantees'=>$all_guarantors, 'member'=>$member->toArray()], 200);
    }

    public function pay(Requests\PayLoanRequest $request, $id){
        $loan = \App\Loan::find($id);
        if($loan->paid_full==true){
            return response()->json('Loan Fully Paid', 200);
        }

        $loanee = \App\Member::find($loan->member_id);

        $input = \Input::all();
        $input['paid_by'] = $loanee->name;
        $date = \Carbon\Carbon::parse(\Input::get('date_given'));
        $input['received_date'] = $date->toDateString();
        unset($input['date_given']);
        $amount_rem = $loan->amount_payable-=\Input::get('amount');
        $message = "Dear Member, KSh ".\Input::get('amount')." has been paid to your loan of Ksh ".$loan->amount.". A balance of Ksh ".$amount_rem." is due by ".$loan->date_due;

        $payment = \App\Payment::create($input);
        $loan->update(['amount_payable'=>$amount_rem]);
        if($amount_rem<=0){
            $tempamount = $loan->amount_payable;
            $loan->update(['paid_full'=>true, 'amount_payable'=>0]);
            $loan->save();
            $loan->amount_payable = $tempamount;
            $message = "Dear Member. Your loan of Ksh ".$loan->amount." has been fully repaid.";
        }

        $releases = [];

        $theguarants = $loan->guarants()->get(); $totalalienguarants = 0;
        foreach($theguarants as $guarantindex=>$eachguarant){
            $releases[$eachguarant->member_id]['amount'] = 0;

            if($eachguarant->member_id!=$loan->member_id)
                $totalalienguarants += $eachguarant->amount;
        }

        if($totalalienguarants>0){
            foreach($theguarants as $guarantindex=>$eachguarant){
                if($eachguarant->member_id==$loan->member_id){
                    $releases[$loan->member_id]['guarant_id'] = $eachguarant->id;
                    continue;
                 }

                $theguarantor = $eachguarant->member()->first();
                //his/her percentage
                $guarant_percentage = $eachguarant->amount/$totalalienguarants;
                $release_amount = $guarant_percentage * $payment->amount;

                if($release_amount > $eachguarant->to_release){
                    $releases[$theguarantor->id]['amount'] += $eachguarant->to_release;
                    $releases[$theguarantor->id]['guarant_id'] = $eachguarant->id;
                    $releases[$loan->member_id]['amount'] += ($release_amount-$eachguarant->to_release);
                    $releases[$theguarantor->id]['release_retention'] = 1;
                }else{
                    $releases[$theguarantor->id]['amount'] += $guarant_percentage*$payment->amount;
                    $releases[$theguarantor->id]['guarant_id'] = $eachguarant->id;
                }
            }

        }else{
            $releases[$loan->member_id]['guarant_id'] = $theguarants->first()->id;
            $releases[$loan->member_id]['amount'] = $payment->amount;
        }

            if($loan->paid_full){
                $thepayments = $loan->payments()->get();
                $allpayments = 0;
                foreach($thepayments as $eachpayment){
                    $allpayments += $eachpayment->amount;
                }


                $loanee->shares_held -= ($loan->retention_fee - (($allpayments-$loan->amount)-$loan->amount_payable));
                $loanee->save();
            }

            foreach($releases as $m_id=>$eachrelease){
                $owner = new \App\Member;
                $owner = \App\Member::find($m_id);

                $owner->shares_held -= $eachrelease['amount'];
                //if($owner->shares_held<0)$owner->shares_held=0;
                $owner->save();

                $theguarant = New \App\Guarant;
                $theguarant = \App\Guarant::find($eachrelease['guarant_id']);
                $theguarant->to_release -= $eachrelease['amount'];
            

                if($theguarant->to_release < 0)$theguarant->to_release=0;
                $theguarant->save();
                if($theguarant->to_release==0){
                    $owner->shares_held -= $theguarant->retention_fee;
                    $theguarant->retention_fee=0;
                    $theguarant->save();
                    $owner->save();
                }
            }

            /*
            //after payments and releases
            //check if amount paid is lower limit
            $payments = $loan->payments()->get();

            $today = \Carbon\Carbon::now();
            $today_string = $today->toDateString();
            $loan_taken_date = \Carbon\Carbon::parse($loan->date_given);
            $loan_due_date = \Carbon\Carbon::parse($loan->date_due);
            $extremedue = \Carbon\Carbon::parse($loan->extreme_due);

            //check this month's payments
            $this_month_payments = [];
            foreach($payments as $each_payment){
                $today_exploded = explode('-', $today_string);
                $payment_date_exploded = explode('-', $payment->received_date);

                if($today_exploded[1]==$payment_date_exploded[1])
                    $this_month_payments[] = $each_payment;
            }
            */

            //add this month's payments
            //$this_month_sum = 0;
            //foreach($this_month_payments as $each_payment)
            //    $this_month_sum += $each_payment->amount;
            
            //amount supposed to pay this month
            //$installment = $loan->amount_payable / ($today->diffInMonths($extremedue));

            //if paid as supposed to
            //recalculate amount to pay next
            //add months
            //if($this_month_sum>=$installment){
                
            //}

        if($this->settings->notifications){
            \App\NotifySend::create(['messageto'=>$loanee->phone, 'messagefrom'=>$this->settings->notification_number, 'message'=>$message, 'member_id'=>$loanee->id]);
        }
            return response()->json(['loan'=>$loan, 'payment'=>$payment]);
    }

    public function payments($id){
        $loan = \App\Loan::find($id);
        $member = $loan->member()->first();
        //if(!$loan || $loan==[]) return [];
        $payments = $loan->payments()->orderBy('received_date', 'desc')->get()->toArray();

        return response()->json(['loan'=>$loan, 'payments'=>$payments, 'member'=>$member]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }


    public function showGuarantors($id)
    {
        $guarants = \App\Guarant::where('loan_id', $id)->get();
        $info = [];
        foreach($guarants as $guarant){
            $info[$guarant->member_id] = ['member_info' => $guarant->member()->first()->toArray(), 'guarant' => $guarant->toArray(),];
        }

        $info['loan'] =  \App\Loan::find($id)->toArray();

        return response()->json($info, 200);
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
        $loan = \App\Loan::find($id);
        $guarants = $loan->guarants()->get();
        $payments = $loan->payments()->get();

        //delete payments
        if(!empty($payments)){ foreach($payments as $payment) $payment->delete(); }
        //delete guarants
        if(!empty($guarants)){ foreach ($guarants as $guarant) $guarant->delete(); }
        //delete loan
        if(!empty($loan)){ $loan->delete(); }

        return response()->json('Success', 200);
    }
}