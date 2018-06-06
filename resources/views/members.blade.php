@extends('main')
@section('content')
<script type="text/javascript">
    var t_members_json = @php echo json_encode($members->toArray()['data']); @endphp;
    var members_json = {}
    for(var member_index in t_members_json){
        members_json[t_members_json[member_index].id]=t_members_json[member_index];
    }
    t_members_json='';
</script>
<div class="container-fluid" id="members-area">
                    <div class="row">
                        <div class="col-md-12">
                        	<div class="card">
                        		<div class="card-content">
                        			<!-- Button trigger modal -->
									<button type="button" id='show-add' class="btn btn-info" data-toggle="modal" data-target="#modal-add-member">
    								Add Member
									</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="card" id="members-list">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title" style="color:white">Members</h4>
                                    <p>A list of members</p>
                                    <p class="category">Click on a member's name to see more details</p>
                                    <p class="category">Defaulters flagged in red</p>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table table-striped table-hover" id="view-members" width="100%" style="width:100%">
                                        <thead class="text-primary">
                                            <th>Name</th>
                                            <th>ID Number</th>
                                            <th>Shares (KShs)</th>
                                            <th>Shares Held (Kshs)</th>
                                            <th>Defaulter?</th>
															<th>Actions</th>
                                        </thead>
                                        <tbody id="members-body">
                                            @foreach($members as $member)
                                            <tr style="@php echo $member->is_defector===true?'background-color:red;color:white;':''; @endphp" id="row{{$member->id}}">
                                                <td style="cursor:pointer" class="view-individual" theid="{{$member['id']}}">{{$member->name}}</td>
                                                <td>{{$member->id_no}}</td>
                                                <td>{{$member->shares}}</td>
                                                <td>{{$member->shares_held}}</td>
                                                <td>
                                                  <div class="togglebutton">
                                                    <label id="togglelabel{{$member->id}}">
                                                      <input class="toggledefaulter" id="toggledefaulter{{$member->id}}" theid="{{$member->id}}" type="checkbox" @php echo $member->is_defector?'checked':''; @endphp>
                                                    </label>
                                                  </div>
                                                </td>
                                                <td><button id='member-edit' name='member-edit' theid='{{$member->id}}' type='button' rel='tooltip' class='btn btn-xs btn-success btn-simple' style='margin-top:0; margin-bottom:0'><i class='material-icons'>edit</i></button><!--button id='member-delete' name='member-delete' theid='' type='button' rel='tooltip' class='btn btn-xs btn-danger btn-simple' style='margin-top:0; margin-bottom:0'><i class='material-icons'>close</i></button--></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{$members->links()}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                    </div>

                                    <!-- Add Member Modal -->
                                    <div class="modal fade" id="modal-add-member" tabindex="-1" role="dialog" aria-labelledby="modal-add-memberLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important">
                                            <div class="modal-content">
                                                <form id="AddMemberForm" class="form-horizontal">

                                                <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y:auto;">
                                        <div class="card">
                                        <div class="card-header" data-background-color="purple">
                                            <h4 id='title' class="title" style="color:white">Add Member</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div id="warningPlace" style="background-color: red; color:white"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" name="member_name" id="member_name" class="form-control" required="true"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">ID Number</label>
                                                    <input class="form-control" name="member_id" id="member_id" required="true" type="text" number="true"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Telephone</label>
                                                    <input class="form-control" name="member_tel" id="member_tel" required="true" type="text" />
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Registration Fee</label>
                                                    <input type="text" name="member_reg_fee" required="true" number="true" id="member_reg_fee" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                <label class="radio-inline">
                                                    <input id="gender_male" required="true" value="Male" name="member_gender" type="radio" class="load-results" />
                                                    Male
                                                </label>
                                                <label class="radio-inline">
                                                    <input id="gender_female" required="true" value="Female" name="member_gender" type="radio" class="load-results" />
                                                    Female
                                                </label>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Next of Kin Name</label>
                                                    <input type="text" name="next_kin_name" id="next_kin_name" class="form-control" required="true"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Next of Kin ID</label>
                                                    <input class="form-control" name="next_kin_id" id="next_kin_id" required="true" type="text" number="true"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Next of Kin Telephone</label>
                                                    <input class="form-control" name="next_kin_tel" id="next_kin_tel" required="true" type="text"/>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-xs-12">
                                                <div  class="form-group label-floating">
                                                    <label class="control-label">Date of Registration (MM/DD/YYYY)</label>
                                                    <input class="form-control datepicker" id="member_reg_date" name="member_reg_date" required="true" date="true" type="text">
                                                </div>
                                                
                                            </div>
                                            </div> 
                                            
                                        </div>
                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <!--button float='left' class="btn btn-secondary btn-xs" id='reset-add'>Reset Form</button-->
                                                    <input type="hidden" id="members_id" value="" />
                                                    <button type="submit" class="btn btn-primary btn-xs" id='submit'>Save</button>
                                                    <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                                                
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Add Member Modal-->

                            <!-- View Member Modal-->
                            <div class="modal fade" id="modal-view-member" tabindex="-1" role="dialog" aria-labelledby="modal-view-memberLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important">
                                    <div class="modal-content">
                                    <div class="modal-body">
                                    <div class="tab-content">
                                        <div class="card">
                                                <div class="content">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped" cellspacing="0" width="100%" style="width:100%">
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="4" style="text-align: center"><b>Member's Info</b></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Phone</th>
                                                            <th>.</th>
                                                            <th>ID Number</th>
                                                        <tr>
                                                            <td><span class="card-title" value="" id="member-view-name"></span></td>
                                                            <td><span id="member_view_tel"></span></td>
                                                            <td><span id="member-view-email"></span></td>
                                                            <td><span id="member-view-id"></span></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <hr />
                                                    <table class="table table-striped" cellspacing="0" width="100%" style="width:100%">
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="3" style="text-align: center"><b>Next of Kin</b></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Phone</th>
                                                            <th>ID Number</th>
                                                        </tr>
                                                        <tr>
                                                            <td id="next_of_kin_name"></td>
                                                            <td id="next_of_kin_tel"></td>
                                                            <td id="next_of_kin_id"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <hr />
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <strong>Registration Fee : Kshs</strong> <span id="registration-fee"></span>
                                                        </div>
                                                        <div class="col-sm-6">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3"><h5><b>Loans Taken</b></h5></div>
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-3"><h5><b></b></h5></div>
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-3"><h5><b>Shares</b></h5></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3" id="total-loans"></div>
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-3" id="total-guaranteed.b"></div>
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-3" id="total-shares"></div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-xs btn-round" data-dismiss="modal">Close</button>
                                    </div>
                            <!--End view Member Modal-->
							

                        </div>
                    </div>
                </div>
            </div>
</div>
@stop
@section('js')
    <script src="{{asset('/sacco/js/members.js')}}" type="text/javascript"></script>
@stop