@extends('main')
@section('content')
                    <div class="row">
                        <!--div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="rose">
                                    <i class="material-icons">equalizer</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Stats</p>
                                    <h3 class="card-title">All</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">local_offer</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">store</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Revenue</p>
                                    <h3 class="card-title">Kshs 0</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> Total
                                    </div>
                                </div>
                            </div>
                        </div-->
                        <div class="col-md-12">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="card">
                                <div class="card-header card-header-text" data-background-color="rose">
                                    <h4 class="card-title">Send a Message To all members</h4>
                                    <span>Please make sure notifications are turned on in Settings</span>
                                </div>
                                <div class="card-content">
                                <form class="form-horizontal" id="sendMessageForm" name="sendMessageForm">
                                    <div class="col-xs-12">
                                    <input type="text" id="message" name="message" class="form-control" placeholder="Type Your Message Here." />
                                    </div>
                                    <div class="col-xs-12">
                                        <button type="submit" disabled class="btn btn-sm btn-info" style="float:right">Send</button>
                                    </div>
                                </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header card-header-text" data-background-color="blue">
                                    <h4 class="card-title">Members at a glance</h4>
                                </div>
                                <div class="card-content">
                                    Total Members : <strong>{{$stats['total_members']}}</strong>
                                    <hr />
                                    Members With Active Loans : <strong>{{$stats['members_unpaid_loans']}}</strong>
                                    <hr />
                                    Defaulters : <strong>{{$stats['defaulters']}}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header card-header-text" data-background-color="green">
                                    <h4 class="card-title">Funds at a glance</h4>
                                </div>
                                <div class="card-content">
                                    Total Membership Fee : <strong>KShs {{$stats['registration_fee']}}</strong>
                                    <hr />
                                    Total Shares Contributed : <strong>KShs {{$stats['total_shares']}}</strong>
                                    <hr />
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header card-header-text" data-background-color="red">
                                    <h4 class="card-title">Loans at a glance</h4>
                                </div>
                                <div class="card-content">
                                    Total Unpaid Loans Amount : <strong>Kshs {{$stats['total_unpaid_loans_amount']}}</strong>
                                    <hr />
                                    Unpaid Loans : <strong>{{$stats['total_unpaid_loans']}}</strong>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
@stop
