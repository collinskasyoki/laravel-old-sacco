$(document).ready(function(){
	/***********************************/
	/********Members Management*********/
	/***********************************/

	var url_members = '/admin/members';
  var url_shares = '/admin/shares';

  if(typeof(members_json)=='undefined')
    members_json = {};

  /*************************************************************/
  /**************************SEARCH*****************************/
  /*************************************************************/
  var engine = new Bloodhound({
    remote:{
      url: url_members+'/find?q=%QUERY%',
      wildcard:'%QUERY%'
    },
    datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
    queryTokenizer: Bloodhound.tokenizers.whitespace
  });

  $('.the-search').typeahead({
    hint:true,
    highlight:true,
    minLength:4,
  },{
    display: 'Name',
    source: engine.ttAdapter(),

    //This will be appended to 'tt-dataset-' to form the class name of the suggestion menu.
    name: 'membersList',

    //the key from the array we want to display(name,id,email,etc..)
    templates: {
      empty: [
        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
      ],
      header: [
        '<div class="list-group search-results-dropdown">'
      ],
      suggestion: function(data){
        //console.log(data);
        return '<a theid="'+data.id+'" clicktype="search" class="list-group-item view-individual" style="cursor:pointer">'+data.name+' : '+data.id_no+'</a>'
      }
    }
  });

  //add member to db
	$('#AddMemberForm').on('submit', function(e){
    e.preventDefault();

		var member_name = $('#member_name').val();
		var member_id = $('#member_id').val();
		//var member_email = $('#member_email').val();
		var member_tel = $('#member_tel').val();
		var member_gender = $('input:radio[name=member_gender]:checked').val();
    var member_reg_date = $('#member_reg_date').val();
    var next_kin_name = $('#next_kin_name').val();
    var next_kin_id = $('#next_kin_id').val();
    var next_kin_tel = $('#next_kin_tel').val();
    var reg_fee = $('#member_reg_fee').val();

		if(member_name==''||member_id==''||member_tel==''||typeof(member_gender)=='undefined'||member_reg_date==''||next_kin_name==''||next_kin_id==''||next_kin_tel=='' || reg_fee==''){
		}else{
		$.ajaxSetup({
      		headers:{
        		'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      		}
    	});

    e.preventDefault();
    	var formData = {
    		name:member_name,
    		id_no:member_id,
        //email:member_email,
    		gender:member_gender,
    		phone:member_tel,
        registered_date:member_reg_date,
        next_kin_name:next_kin_name,
        next_kin_phone:next_kin_tel,
        next_kin_id:next_kin_id,
        registration_fee:reg_fee,
    	}

      var the_url = '';
      if($('#submit').text()=='Update'){
        the_url = url_members + '/' + $('#members_id').val() + '/update';
        url_type='POST';
        formData['_token'] = $('meta[name="_token"]').attr('content');
        formData['_method'] = 'PUT';
      }else{
        url_type='POST';
        the_url = url_members;
      }

    	$.ajax({
      		type: url_type,
      		url: the_url,
      		data: formData,
      		dataType: 'json',
      		success: function(data){
            if($('#submit').text()=='Save'){

            $('#AddMemberForm').trigger("reset");
            $('#modal-add-member').modal('hide');

            var member_string = '';
            member_string += `
              <tr id="row`+data.id+`">
                  <td class="view-individual" style="cursor:pointer" theid="`+data.id+`">`+data.name+`</td>
                  <td>`+data.id_no+`</td>
                  <td>`+data.shares+`</td>
                  <td>`+data.shares_held+`</td>
                  <td>
                                                  <div class="togglebutton">
                                                    <label id="togglelabel`+data.id+`">
                                                      <input class="toggledefaulter" id="toggledefaulter`+data.id+`" theid="`+data.id+`" type="checkbox" `+defector+`>
                                                      <span class="toggle"></span>
                                                    </label>
                                                  </div>
                  </td>
                  <td>
                    <button id="member-edit" class="btn btn-xs btn-success btn-simple" name="member-edit" theid="`+data.id+`" type="button" rel="tooltip" style="margin-top:0; margin-bottom:0;" data-original-title="" title=""><i class="material-icons">edit</i></button>
                  </td>
              </tr>
            `;

            $('#members-body').append(member_string);

        		$.notify({
          			message: data.name + " added successfully.",
          		},{
            		type: 'success',
            		timer: 1000,
            		placement: {
                		from: 'top',
                		align: 'center',
            		}
        		});
            members_json[data.id]={};

            members_json[data.id].id = data.id;
            members_json[data.id].name = data.name;
            members_json[data.id].id_no = data.id_no;
            members_json[data.id].phone = data.phone;
            //members_json[data.id].email = data.email;
            members_json[data.id].gender = data.gender;
            members_json[data.id].next_kin_name = data.next_kin_name;
            members_json[data.id].next_kin_id = data.next_kin_id;
            members_json[data.id].next_kin_phone = data.next_kin_phone;
            members_json[data.id].registered_date = data.registered_date;

            //console.log(members_json)

            }else{

            $('#AddMemberForm').trigger("reset");
            $('#modal-add-member').modal('hide');

            var member_edit_string = '';
            var defector = data.is_defector ? 'checked' : '';
            member_edit_string += `
                  <td class="view-individual" style="cursor:pointer" theid="`+data.id+`">`+data.name+`</td>
                  <td>`+data.id_no+`</td>
                  <td>`+data.shares+`</td>
                  <td>`+data.shares_held+`</td>
                  <td>
                                                  <div class="togglebutton">
                                                    <label id="togglelabel`+data.id+`">
                                                      <input class="toggledefaulter" id="toggledefaulter`+data.id+`" theid="`+data.id+`" type="checkbox" `+defector+`>
                                                      <span class="toggle"></span>
                                                    </label>
                                                  </div>
                  </td>
                  <td>
                    <button id="member-edit" class="btn btn-xs btn-success btn-simple" name="member-edit" theid="`+data.id+`" type="button" rel="tooltip" style="margin-top:0; margin-bottom:0;" data-original-title="" title=""><i class="material-icons">edit</i></button>
                  </td>
            `;
console.log(member_edit_string);
            $('#row'+data.id).empty().append(member_edit_string);

                $.notify({
                    message: data.name + " details edited successfully.",
                  },{
                    type: 'success',
                    timer: 3000,
                    placement: {
                        from: 'top',
                        align: 'center',
                    }
                });

            members_json[data.id].id = data.id;
            members_json[data.id].name = data.name;
            members_json[data.id].id_no = data.id_no;
            members_json[data.id].phone = data.phone;
            //members_json[data.id].email = data.email;
            members_json[data.id].gender = data.gender;
            members_json[data.id].next_kin_name = data.next_kin_name;
            members_json[data.id].next_kin_id = data.next_kin_id;
            members_json[data.id].next_kin_phone = data.next_kin_phone;
            members_json[data.id].registered_date = data.registered_date;

            //console.log(members_json)
            }
      		},
      		error: function(data){
            //console.log('error');
            //console.log(data)
            if(typeof data.responseJSON != 'undefined'){
            var stuff = JSON.parse(data.responseText);
          
          var errors = "";
          for(var error in stuff){ errors += stuff[error][0] + '<br>'; }
        }else{ errors = "There Seems to be a problem";}

        if(state="add"){
          $('#warningPlace').empty();
          $('#warningPlace').append(errors);
          $('#warningPlace').removeAttr('hidden');
        }
      		}
    	});	

		}
	});
  //end add member

//edit member
$('#members-area').on('click', '#member-edit', function(){
  var id = $(this).attr('theid');
  //console.log(members_json)

  for(var member in members_json){
    if(members_json[member].id==id){
      cur_member=members_json[member]
    }
  }
  $('#member_name').val(cur_member.name); $('#member_name').parent().removeClass("is-empty");
  $('#member_id').val(cur_member.id_no); $('#member_id').parent().removeClass("is-empty");
  $('#member_tel').val(cur_member.phone); $('#member_tel').parent().removeClass("is-empty");
  //$('#member_email').val(cur_member.email); $('#member_email').parent().removeClass("is-empty");
  $('#next_kin_name').val(cur_member.next_kin_name); $('#next_kin_name').parent().removeClass("is-empty");
  $('#next_kin_id').val(cur_member.next_kin_id); $('#next_kin_id').parent().removeClass("is-empty");
  $('#next_kin_tel').val(cur_member.next_kin_phone); $('#next_kin_tel').parent().removeClass("is-empty");
  cur_member.gender=='Male'? $('#gender_male').prop('checked', true) : $('#gender_female').prop('checked', true);
  $('#member_reg_date').val(cur_member.registered_date); $('#member_reg_date').parent().removeClass("is-empty");
  $('#member_reg_fee').val(cur_member.registration_fee); $('#member_reg_fee').parent().removeClass('is-empty');
  $('#submit').empty().append('Update');
  $('#title').empty().append('Update Member Details');
  $('#members_id').val(id);

  $('#modal-add-member').modal('show');
});
//end edit member

//toggle defaulter
$('#thebody').on('click', '.toggledefaulter', function(e){
  e.preventDefault();
  var id=$(this).attr('theid');
  $.get('/api/user/'+id+'/defaulter', function(data){
    if(data==true){
      $('#toggledefaulter'+id).prop('checked', true);
      $('#row'+id).css('background-color','red');
      $('#row'+id).css('color','white');
    }
    else{
      $('#toggledefaulter'+id).prop('checked', false);
      $('#row'+id).css('background-color','white');
      $('#row'+id).css('color','black');
    }
  });
});
//end toggle defaulter

//reset edit/add member form
$('#reset-add').click(function(e){
  e.preventDefault();
  $('#AddMemberForm').trigger('reset');
});

$('#show-add').click(function(){
  $('#AddMemberForm').trigger('reset');
  $('#submit').empty().append('Save');
  $('#title').empty().append('Add Member');
})

  //view one member info
  $('#thebody').on('click', '.view-individual', function(e){
    if($(this).attr('clicktype')=='search'){
      $('.the-search').val('');
    }
    e.preventDefault();
    var id = $(this).attr('theid');
    $.get(url_members+ '/' + id, function(data){
      var cur_member=data.member

      $('#total-shares').empty().append('Kshs '+data.shares);
      $('#total-loans').empty().append("Kshs "+data.loans);
      $('#total-guaranteed').empty().append("Kshs "+data.guaranteed);

      $('#member-view-name').empty().append(cur_member.name); 
      $('#member-view-add-share-name').val(cur_member.name);
      $('#member_view_tel').empty().append(cur_member.phone);
      //$('#member-view-email').empty().append(cur_member.email);
      $('#member-view-id').empty().append(cur_member.id_no);
      $('#member-view-add-share-id').val(cur_member.id);
      $('#member-loan-name').empty().append(cur_member.name + ' Loans');
      $('#next_of_kin_name').empty().append(cur_member.next_kin_name);
      $('#next_of_kin_id').empty().append(cur_member.next_kin_id);
      $('#next_of_kin_tel').empty().append(cur_member.next_kin_phone);
      $('#registration-fee').empty().append(cur_member.registration_fee);

      $('#modal-view-member').modal('show');
    });
  });
  //end view member info

});