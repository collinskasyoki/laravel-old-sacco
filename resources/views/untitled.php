
								<div class="card">
                                        <div class="card-header" data-background-color="purple">
                                            <h4 class="title" style="color:white">Add Loan</h4>
                                        </div>
                                        <div class="card-content">
                                            <form id="AddLoanForm" class="form-horizontal" action="#" method="">
                                            <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <select class="selectpicker" data-style="btn btn-primary btn-round" title="Select Member" data-size="7" id="loanee" name="loanee">
                                                    	<option disabled value="0">Choose Member</option>
                                                        @foreach($members as $member)
                                                        <option value="{{$member['id']}}" member-name="{{$member['name']}}">{{$member['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="col-xs-12">
                                                	<div class="form-group label-floating">
                                                		<label class="control-label">Amount</label>
                                                		<input id="loan-amount" name="loan-amount" required class="form-control" type="text" number="true" max="" />
                                                	</div>
                                                </div>
                                            <div class="col-xs-12">
                                                <div class="form-group label-floating">
                                                    <select class="selectpicker" data-style="select-with-transition" multiple title="Choose Guarantors" data-size="7" id="guarantors" name="guarantors">
                                                        <option disabled value="0">Choose Guarantors</option>
                                                        @foreach($members as $member)
                                                        <option id="guarantor{{$member['id']}}" value="{{$member['id']}}" member-name="{{$member['name']}}">{{$member['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div  class="form-group label-floating">
                                                    <label class="label-control">Date Given</label>
                                                    <input class="form-control datepicker" placeholder="MM/DD/YYYY" id="loan-date-given" name="loan-date-given" required="true" date="true" style="" type="text">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-xs">Apply</button>
                                                </div>
                                            </div>
                                            </div>
                                            </form>
                                        </div>
                                </div>