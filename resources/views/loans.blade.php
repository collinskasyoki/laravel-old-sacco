@extends('main')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="card">
			<div class="card-content">
				<button type="button" class="btn btn-info" id="add-loan-btn">Add Loan</button>
                <button type="button" class="btn btn-info" style="display:none" id="clear-search">Clear Search</button>



				<!--Add Loan modal-->
				<div class="modal fade" id="modal-add-loan" tabindex="-1" role="dialog" aria-labelledby="modal-add-loan-label" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-body">
                                <form id="AddLoanForm" name="AddLoanForm" class="form-horizontal" action="#" method="">
                                <div id="rootwizard">
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <div class="container">
                                                <ul id="wizardTabs">
                                                    <li><a href="#tab1" data-toggle="tab">Loan</a></li>
                                                    <li><a href="#tab2" data-toggle="tab">Guarantors</a></li>
                                                    <li><a href="#tab3" data-toggle="tab">Approve</a></li>
                                                </ul>
                                            </div>
                                        </div> 
                                    </div>
                                    <div id="bar" class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="tab1">
                                            <div class="row">
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div class="form-group label-floating">
                                                    <select class="selectpicker" title="Choose Member" data-style="btn btn-primary btn-round" data-size="7" id="loanee" name="loanee" required>
                                                        <option disabled selected="selected">Choose Member</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div class="col-sm-8">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Loan Amount</label>
                                                        <input id="loan-amount" name="loan-amount" required class="form-control" type="text" number="true" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <span id="loan-max" name="loan-max"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div class="form-group label-floating">
                                                    <select class="selectpicker" title="Choose Guarantors" data-style="select-with-transition" multiple data-size="7" id="guarantors" name="guarantors" required minlength="{{$settings['min_guarantors']}}">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div  class="form-group label-floating">
                                                    <label class="label-control">Date Given</label>
                                                    <input class="form-control datepicker" placeholder="MM/DD/YYYY" id="loan-date-given" name="loan-date-given" required="true" date="true" style="" type="text">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <div class="card card-stats">
                                                    <div class="card-content">
                                                        <p class="category">Amount Left to Guarantee</p>
                                                        <h3 class="card-title" id="remaining_guarantee"></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="tab2-guarantors">
                                            </div>
                                        </div>
                                            <div class="tab-pane" id="tab3">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <h3 style="text-align:center">Add Loan?</h3>
                                                    </div>
                                                    <div class="col-sm-4 col-sm-offset-4">
                                                    <button type="submit" class="btn btn-success" style="align:center">
                                                        <span class="btn-label">
                                                            <i class="material-icons">check</i>
                                                        </span>
                                                        Add
                                                    </button>
                                                    </div>
                                                </div>
                                            </div>
                                                <ul class="pager wizard">
                                                    <li class="previous"><a href="#">Previous</a></li>
                                                    <li class="next"><a href="#">Next</a></li>
                                                    <li class="finish" style="display:none"><a href="#">Finish</a></li>
                                                </ul>
                                    </div>
                                </div>
                            </form>
							</div>
						</div>							
					</div>
				</div>
				<!--End add Loan modal-->
			</div>
			</div>

			<div id="loan-list" class="card">
				<div class="card-header" data-background-color="purple">
                	<h4 class="title" style="color:white">Loans</h4>
                    <p>Loans History</p>
                </div>
                <div class="card-content">
                	<div class="table-responsive" id="members-loans">
                    <table class="table table-striped table-hover" id="view-loans" cellspacing="0" width="100%" style="width:100%">
                    	<thead class="text-primary">
                    	  <tr>
                    		<th>Name</th>
                            <th>ID</th>
                    		<th>Amount</th>
                    		<th>Borrowed</th>
                    		<th>To Pay</th>
                    		<th>Due By</th>
                            <!--th>Installment</th-->
                            <th>Flags</th>
                    		<th class="disabled-sorting">Guarantors</th>
                            <th class="disabled-sorting">Actions</th>
                    	  </tr>
                    	</thead>
                    	<tbody id="loans-body">
                                @foreach($loans as $loan)
                                    <tr id="loan{{$loan->id}}">
                                        <td>{{$members[$loan->member_id]->name}}</td>
                                        <td>{{$members[$loan->member_id]->id_no}}</td>
                                        <td>{{$loan->amount}}</td>
                                        <td>{{$loan->date_given}}</td>
                                        <td>{{$loan->amount_payable}}</td>
                                        <td>{{$loan->date_due}}</td>
                                        <!--td></td-->
                                        <td>
                                            @php
                                            switch($loan->flag){
                                                case 0:
                                                    echo "<i style='color:green' class='material-icons'>flag</i>";
                                                    break;
                                                case 1:
                                                    echo "<i style='color:red' class='material-icons'>flag</i>";
                                                    break;
                                                case 2:
                                                    echo "<i style='color:red' class='material-icons'>flag</i>";echo "<i style='color:red' class='material-icons'>flag</i>";
                                                    break;
                                                case 3:
                                                    echo "<i style='color:red' class='material-icons'>flag</i>";echo "<i style='color:red' class='material-icons'>flag</i>";echo "<i style='color:red' class='material-icons'>flag</i>";
                                                    break;
                                            }
                                            @endphp
                                        </td>
                                        <td><button id="loan-view-guarantors" name="loan-view-guarantors" theid="{{$loan->id}}" class="btn btn-round btn-info btn-xs">View</button></td>
                                        <td>
                                            <button id="loan-pay" name="loan-pay" theid="{{$loan->id}}" themember="{{$loan->member_id}}" class="btn btn-xs btn-round btn-default">Payments</button>
                                                <button id="loan-delete" name="loan-delete" theid="{{$loan->id}}" type="button" rel="tooltip" class="btn btn-xs btn-danger btn-simple" style="margin-top:0; margin-bottom: 0"><i class="material-icons">close</i></button>
                                        </td>
                                    </tr>
                                @endforeach
                    	</tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{$loans->links()}}</td>
                                            </tr>
                                        </tfoot>
                    </table>
                    <table class="table table-striped table-hover" id="search-loans" cellspacing="0" width="100%" style="width:100%; display:none;">
                        <thead class="text-primary">
                        <tr>
                            <th colspan="9" style="text-align:center" class="text-info"><strong>Loans Given</strong></th>
                        </tr>
                          <tr>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Borrowed</th>
                            <th>To Pay</th>
                            <th>Due By</th>
                            <th>Flags</th>
                            <th class="disabled-sorting">Guarantors</th>
                            <th class="disabled-sorting">Actions</th>
                          </tr>
                        </thead>
                        <tbody id="search-loans-body">
                        </tbody>
                    </table>
                    <table class="table table-striped table-hover" id="search-guarants" cellspacing="0" width="100%" style="width:100%; display:none;">
                        <thead class="text-primary">
                        <tr>
                            <th colspan="9" style="text-align:center" class="text-info"><strong>Loans Guaranteed</strong></th>
                        </tr>
                          <tr>
                            <th>Loan Owner</th>
                            <th>Amount Guaranteed</th>
                            <th>Date Due</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody id="search-guarants-body">
                        </tbody>
                    </table>
                    </div>

                    <!--Loan pay modal-->
                    <div class="modal fade" id="modal-pay-loan" tabindex="-1" role="dialog" aria-labelledby="modal-pay-loan-label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form id="pay-loan-form" name="pay-loan-form">
                                    <div class="row">
                                        <div>
                                        <div class="col-sm-6">
                                            <p id="pay-loanee-id" name="pay-loanee-id">ID</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p id="pay-loanee-name" name="pay-loanee-name">Name</p>
                                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <p id="pay-loan-amount" name="pay-loan-amount">Amount Taken</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p id="pay-loan-topay" name="pay-loan-topay">To Pay</p>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover" id="payments-table" cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="payments-table-body">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="pay-form">
                                        <div class="col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Amount</label>
                                                <input type="text" number="true" id="pay-loan" name="pay-loan" required="true" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Payment Date</label>
                                                <input type="text" required="true" name="pay-date" id="pay-date" class="form-control datepicker" date="true">
                                                <input type="hidden" id="loanee_member_id" name="loanee_member_id" value="">
                                                <input type="hidden" name="loan_id" id="loan_id" value="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <button type="submit" class="btn btn-xs btn-info">Pay</button>
                                        </div>
                                        </div>
                                        <div id="paid-form" class="col-xs-12" style="display:none">Paid</div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End loan pay modal-->
                </div>
			</div>
		</div>
	</div>
@stop
@section('js')
    <script type="text/javascript" src="{{asset('sacco/js/loans.js')}}"></script>
    <script type="text/javascript" src="{{asset('sacco/js/demo.js')}}"></script>
    <script type="text/javascript">
    $().ready(function() {
        demo.initMaterialWizard();
    });
</script>
@stop
