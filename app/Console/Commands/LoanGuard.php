<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoanGuard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'LoanGuard:guard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LoanGuard is a check that runs every day to check if any loans taken are being well serviced.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

      //calculate month's installment

      print "Handling..";
      $settings = \App\Setting::all()->first();
      $loans = \App\Loan::where(['approved'=>true, 'paid_full'=>false])->get();
      $today = \Carbon\Carbon::now();

/*
      foreach($loans as $loan){
        $member = $loan->member()->first();
        $member_id = $member->id;

        $temp_due = explode("-", $loan->date_due);
        $due_orig = $temp_due[2]."/".$temp_due[1]."/".$temp_due[0];
        $temp_date_orig = explode("-", $loan->date_given);
        $date_orig_string = $temp_date_orig[2]."/".$temp_date_orig[1]."/".$temp_date_orig[0];

        $loan_orig = $loan->amount_payable;
        $diff = \Carbon\Carbon::parse($loan->date_due)->diffInDays(\Carbon\Carbon::now());

        if($diff==1 && $loan->warned===false){
          //loan almost due, send warning
          $message = "Dear Member, Your loan of Kshs ".$loan_orig." is due on ".$due_orig.". Please pay this month's installment in time to avoid penalties.";
          if($settings->notifications)
            \App\NotifySend::create(['messageto'=>$member->phone, 'messagefrom'=>$settings->notification_number, 'message'=>$message, 'member_id'=>$member->id]);

          $loan->warned = true;
          $loan->save();
        }

        if($diff==0){
          if($loan->flag==0){
            $loan->flag += 1;
            $loan->save();
            $message = "Dear member, you have not paid this month's installment on your loan. Avoid penalties and pay in time.";
          }else if($loan->flag==1){
            $loan->flag += 1;
            $loan->save();
           $message = "Dear member, you have not paid installments for two months. Avoid penalties and pay in time."; 
          }else if($loan->flag==2){
            //$loan->update(['flag'=>3]);
            //$loan->save();
            //extreme defaulter
            //PANIC ATTACK

            if($loan->amount_payable > $loan->amount){
              $interested = $loan->amount_payable-$loan->amount;

            \App\Share::create(['member_id'=>$member->id, 'amount'=>(0-$interested), 'date_received'=>$today->toDateString(), 'paid_by_id'=>$member->id, 'paid_by'=>'Loan Recovery System']);
            $member->update([
              'shares' => $member->shares-$interested,
            ]);
            $member->save();

            $paymentInterest = [
              'member_id' => $member->id,
              'loan_id' => $loan->id,
              'paid_by_id' => $member->id,
              'paid_by' => 'Loan Recovery System',
              'amount' => $interested,
              'received_date' => $today->toDateString(),
            ];
            \App\Payment::create($paymentInterest);

            $loan->amount_payable-=$interested;
            $loan->save();
            }

            //Guarantors
            $guarants = $loan->guarants()->get();
            $guarantors = [];
            $counter = 0;
            $total_guarantors = $guarants->count();
            $amount_paid_each = ($loan->amount-$loan->amount_payable)/$total_guarantors;

            foreach($guarants as &$guarant){
              $theguy = new \App\Member;
              $guarantors[$counter] = \App\Member::find($guarant->member_id);

              $hisshares = $guarantors[$counter]->shares; 
              $rem_guarant_amount = $guarant->amount-$amount_paid_each;
              $remshares = $hisshares-$rem_guarant_amount;

              $guarantors[$counter]->update(['shares'=>$remshares]);

              \App\Share::create(['member_id'=>$guarantors[$counter]->id, 'amount'=>(0-$rem_guarant_amount), 'date_received'=>$today->toDateString(), 'paid_by_id'=>$guarantors[$counter]->id, 'paid_by'=>'Loan Recovery System']);

              $loan->update(['amount_payable'=>$loan->amount_payable-=$rem_guarant_amount]); $loan->save();

              $payment = [
              'member_id' => $guarantors[$counter]->id,
              'loan_id' => $loan->id,
              'paid_by_id' => $guarantors[$counter]->id,
              'paid_by' => 'Loan Recovery System',
              'amount' => $rem_guarant_amount,
              'received_date' => $today->toDateString(),
              ];
              \App\Payment::create($payment);


              $guarantormessage = "Dear Member. A loan taken by ".$loan->owner." on ".$date_orig_string.", in which you guaranteed has been auto-recovered.";

              if($settings->notifications)
                \App\NotifySend::create(['messageto'=>$guarantors[$counter]->phone, 'messagefrom'=>$settings->notification_number, 'message'=>$guarantormessage, 'member_id'=>$guarantors[$counter]->id]);
              $counter++;
            }

            foreach($guarantors as $eachguarantor) $eachguarantor->save();

            $member = new \App\Member;
            $member = $member->find($member_id);
            $member->update(['is_defector'=>1]);
            $member->save();


            $loan->update(['paid_full'=>1]); $loan->save();

            $message = "Dear Member, Your loan of Kshs ".$loan_orig.", which was due on ".$due_orig." has not been paid. The loan has been auto-recovered and you have been listed as a defaulter.";
            if($settings->notifications)
              \App\NotifySend::create(['messageto'=>$member->phone, 'messagefrom'=>$settings->notification_number, 'message'=>$message, 'member_id'=>$member->id]);

          }
        }
        //end if diff 0
      }
      //end foreach
*/

    }
}
