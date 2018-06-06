@extends('main')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card col-xs-4">
			<div class="card-content">
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add-shares">Add Shares</button>
                <button type="button" class="btn btn-info" style="display:none" id="clear-search">Clear Search</button>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
			<div class="card">
				<div class="card-header" data-background-color="purple">
                	<h4 class="title" style="color:white">Shares</h4>
                    <p>Shares History</p>
                </div>
                <div class="card-content">
                	<div class="table-responsive">
                    <table class="table table-striped table-hover" id="members-shares" cellspacing="0" width="100%" style="width:100%">
                    	<thead class="text-primary">
                    	  <tr>
                    		<th>Name</th>
                            <th>ID</th>
                    		<th>Amount</th>
                    		<th>Received</th>
                            <th>Paid By</th>
                            <th>Actions</th>
                    	  </tr>
                    	</thead>
                    	<tbody id="shares-body">
                            @foreach($shares as $share)
                                <tr id="row{{$share->id}}">
                                    <td id="name{{$share->id}}">{{$members[$share->member_id]->name}}</td>
                                    <td id="id{{$share->id}}">{{$members[$share->member_id]->id_no}}</td>
                                    <td id="amount{{$share->id}}">{{$share->amount}}</td>
                                    <td id="date{{$share->id}}">{{$share->date_received}}</td>
                                    <td id="paid_by{{$share->id}}">{{$share->paid_by}}</td>
                                    <td><button id='member-edit' name='member-edit' theid='{{$share->id}}' type='button' rel='tooltip' class='btn btn-xs btn-success btn-simple' style='margin-top:0; margin-bottom:0'><i class='material-icons'>edit</i></button><!--button id='member-delete' name='member-delete' theid='{{$share->id}}' type='button' rel='tooltip' class='btn btn-xs btn-danger btn-simple' style='margin-top:0; margin-bottom:0'><i class='material-icons'>close</i></button--></td>
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
                                <td>{{$shares->links()}}</td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    <div class="table-responsive">
                        <table style="display:none" class="table table-striped table-hover" id="members-shares-search" cellspacing="0" width="100%" style="width:100%">
                            <thead class="text-primary">
                          <tr>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Received</th>
                            <th>Paid By</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody id="shares-body-search">
                        </tbody>
                        </table>
                    </div>
                </div>
			</div>
	</div>

                <!--Add shares modal-->
                <div class="modal fade" id="modal-add-shares" tabindex="-1" role="dialog" aria-labelledby="modal-add-shares-label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="card">
                                        <div class="card-header" data-background-color="purple">
                                            <h4 class="title" style="color:white">Add Shares</h4>
                                        </div>
                                        <div class="card-content">
                                            <form id="AddSharesForm" class="form-horizontal" action="#" method="">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                <div class="form-group label-floating">
                                                    <select class="selectpicker" data-style="btn btn-primary btn-round" title="Select Member" data-size="7" id="shares-choose-member" name="shares-choose-member">
                                                        <option disabled selected value="">Choose Member</option>
                                                        @foreach($allmembers as $member)
                                                            <option value="{{$member->id}}" member-name="{{$member->name}}">{{$member->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Amount</label>
                                                        <input class="form-control" type="text" id="shares-amount" name="shares-amount" required="true" number="true" />
                                                    </div>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div  class="form-group label-floating">
                                                        <label class="label-control">Date Received</label>
                                                        <input class="form-control datepicker" placeholder="MM/DD/YYYY" id="shares_date" name="shares_date" required="true" date="true" style="" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-xs">Save changes</button>
                                                </div>
                                            </div>
                                            </div>
                                            </form>
                                        </div>
                                </div>
                            </div>
                        </div>                          
                    </div>
                </div>
                <!--End add Shares modal-->

</div>
@stop
@section('js')
    <script src="{{asset('/sacco/js/shares.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    var shares_json = @php echo json_encode($shares) @endphp;
    var members_json = @php echo json_encode($members) @endphp;
</script>
@stop