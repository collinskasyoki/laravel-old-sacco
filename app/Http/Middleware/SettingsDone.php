<?php

namespace App\Http\Middleware;

use Closure;

class SettingsDone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $settings = \App\Setting::all()->first();
      if($settings==null){
        return redirect('/dashboard/settings')->with('warning', 'You have to set up the app before using it');
      }
      $settings = $settings->toArray();
      //dd($settings);
      foreach($settings as $key=>$val){
        switch($key){
        case "loan_duration":
        case "loan_interest":
        case "loan_borrowable":
        case "retention_fee":
        case "min_guarantors":
        case "notifications":
        case "notification_number":
          if($val==''||$val==null){
            if($key=='notifications' && $val==false)continue;
            return redirect('/dashboard/settings')->with('warning', 'Some Compulsory settings are blank.');
          }
        }
      }

      return $next($request);
    }
}
