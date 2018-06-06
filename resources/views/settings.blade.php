@extends('main')
@section('content')
<!--Warnings-->
@if(Session::has('warning'))
<p class="alert alert-danger">
  {{Session::get('warning')}}
</p>
@endif
<div class="row">
<div class="col-md-12">
                            <div class="card">
                                <form method="get" action="#" id="settingsForm" name="settingsForm" class="form-horizontal">
                                    <div class="card-header card-header-text" data-background-color="purple">
                                        <h4 class="card-title">Settings</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Organization's Name</label>
                                            <div class="col-sm-10">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" id="settings_organization_name" name="organization_name" value>
                                                    <span class="help-block">Please Enter the Name of the Organization</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-sm-8 col-sm-offset-2">
                                        		<h3>Loan Settings</h3>
                                        	</div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Loan Borrowable*</label>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" id="settings_loan_borrowable" name="settings_loan_borrowable" required number="true" value>
                                                    <span class="help-block">Maximum amount a member can borrow as a loan. (x times shares)</span>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 label-on-left">Retention Fee(%)*</label>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" id="settings_retention_fee" name="settings_retention_fee" required number="true" value>
                                                    <span class="help-block">Fee Retained when borrowing the loan. (in percentage)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Loan Duration(Months)*</label>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" id="settings_loan_duration" name="settings_loan_duration" required number="true" value>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 label-on-left">Loan Interest(%)*</label>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" id="settings_loan_interest" name="settings_loan_interest" required number="true" value>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Minimum Guarantors*</label>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" id="settings_minimum_guarantors" name="settings_minimum_guarantors" required number="true" value>
                                                    <span class="help-block">Minimum number of guarantors needed per loan.</span>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 label-on-left">SMS notifications</label>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating">
                                                <div class="radio-inline">
                                                    <input id="notifications_on" required="true" value="1" name="notifications" type="radio" class="load-results" />
                                                    On
                                                </div>
                                                <div class="radio-inline">
                                                    <input id="notifications_off" required="true" value="0" name="notifications" type="radio" class="load-results" />
                                                    Off
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                            </div>
                                            <label class="col-sm-2 label-on-left">Notification Number</label>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating">
                                                    <input type="text" id="notification_number" class="form-control" name="notification_number" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-xs-2 col-xs-offset-5">
                                        		<button type="submit" class="btn btn-info">Save</button>
                                        	</div>
                                    </div>
                                </form>
                            </div>
                        </div>
</div>
@stop
@section('js')
	<script src="{{asset('/sacco/js/settings.js')}}" type="text/javascript"></script>
@stop
