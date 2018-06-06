$(document).ready(function(){

  /*************************************************************/
  /**************************SEARCH*****************************/
  /*************************************************************/
  var members_loans;
  //var membershare;
  var engine = new Bloodhound({
    remote:{
      url: '/admin/loans/find?q=%QUERY%',
      wildcard:'%QUERY%', 
    transform: function(data){
    	members_loans = data;
    	return data;
    }
    },
    datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
  });

  engine.initialize();

  $('.the-search').typeahead({
    hint:true,
    highlight:true,
    minLength:3,
  },{
    display: 'Name',

    //This will be appended to 'tt-dataset-' to form the class name of the suggestion menu.
    name: 'memberloans',
    source:engine,

    //the key from the array we want to display(name,id,email,etc..)
    templates: {
      empty: [
        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
      ],
      header: [
        '<div class="list-group search-results-dropdown">'
      ],
      
      suggestion: function(data){
        return '<a theid="'+data.id+'" clicktype="search" class="list-group-item view-individual" style="cursor:pointer">'+data.name+'</a>';
      }
      
    }
  });


$('#thebody').on('click', '.view-individual', function(){
	var id = $(this).attr('theid');
	var thestring='';

	console.log(members_loans)

	for(var loan_index in members_loans[id].loans){
		var loan_id = members_loans[id].loans[loan_index].id;

		var flag = 0;
		switch(members_loans[id].loans[loan_index].flag){
			case 0:
				flag = "<i style='color:green' class='material-icons'>flag</i>";
				break;
			case 1:
				flag = "<i style='color:red' class='material-icons'>flag</i>";
				break;
			case 2:
				flag = "<i style='color:red' class='material-icons'>flag</i><i style='color:red' class='material-icons'>flag</i>";
				break;
			case 3:
				flag = "<i style='color:red' class='material-icons'>flag</i><i style='color:red' class='material-icons'>flag</i><i style='color:red' class='material-icons'>flag</i>";
				break;
		}

	thestring += `
		<tr id="search-row`+loan_id+`">
			<td id="search-name`+loan_id+`">`+members_loans[id].name+`</td>
			<td id="search-id`+loan_id+`">`+members_loans[id].id_no+`</td>
			<td id="search-amount`+loan_id+`">`+members_loans[id].loans[loan_index].amount+`</td>
			<td id="search-date-borrowed`+loan_id+`">`+members_loans[id].loans[loan_index].date_given+`</td>
			<td id="search-amount-payable`+loan_id+`">`+members_loans[id].loans[loan_index].amount_payable+`</td>
			<td id="search-date-due`+loan_id+`">`+members_loans[id].loans[loan_index].date_due+`</td>
			<td id="search-flag`+loan_id+`">`+flag+`</td>
			<td><button id="loan-view-guarantors" name="loan-view-guarantors" theid="`+loan_id+`" class="btn btn-round btn-info btn-xs">View</button></td>
			<td><button id="loan-pay" name="loan-pay" theid="`+loan_id+`" themember="`+id+`" class="btn btn-xs btn-round btn-default">Payments</button>
                <button id="loan-delete" name="loan-delete" theid="`+loan_id+`" type="button" rel="tooltip" class="btn btn-xs btn-danger btn-simple" style="margin-top:0; margin-bottom: 0"><i class="material-icons">close</i></td>
		</tr>
	`;
	}

	var guarantstring = '';
	for(var guarant_index in members_loans[id].guarants){
		var guarant = members_loans[id].guarants[guarant_index];
		var guarant_id = guarant.id;
		var loan_status = (guarant.loan.paid_full==true) ? 'Paid' : 'Unpaid';

		guarantstring += `
			<tr>
				<td>`+guarant.loan.owner+`</td>
				<td>`+guarant.amount+`</td>
				<td>`+guarant.loan.date_due+`</td>
				<td>`+loan_status+`</td>
			</tr>
		`;
	}

	$('#search-loans-body').empty().append(thestring);
	$('#search-guarants-body').empty().append(guarantstring);
	$('#view-loans').css('display','none');
	$('#search-loans').css('display','');
	$('#search-guarants').css('display', '');
	$('#clear-search').css('display', '');
});

//clear search
$('#thebody').on('click', '#clear-search', function(){
	$('#clear-search').css('display','none');
	$('#search-loans').css('display', 'none');
	$('#search-guarants').css('display', 'none');
	$('#view-loans').css('display', '');
});


	$('#rootwizard').bootstrapWizard({
		onTabShow: function(tab, navigation, index) {
		var $total = navigation.find('li').length;
		var $current = index+1;
		var $percent = ($current/$total) * 100;
		$('#rootwizard .progress-bar').css({width:$percent+'%'
		});
		},
		'tabClass': 'nav nav-pills',
		'onNext': function(tab,navigation,index){
			var $valid = $('#AddLoanForm').valid();
			if(!$valid){
				$validator.focusInvalid();
				if($('#loanee').selectpicker('val')==null || $('#loanee').selectpicker('val').length==0){
					$.notify({
						message: 'Please Select a member to offer loan.',
					},{
						type: 'danger',
						timer: 1000,
						placement:{
							from: 'top',
							align: 'center',
						},
						z_index: 3000,
					});
				}

				if($('#loanee').selectpicker('val')!=null && $('#loanee').selectpicker('val').length!=0){
				if($('#guarantors').selectpicker('val').length < settings_json.min_guarantors){
					$.notify({
        	  				message: settings_json.min_guarantors + ' or more guarantors guarantors needed.',
          				},{
            				type: 'danger',
            				timer: 1000,
            				placement: {
                				from: 'top',
                				align: 'center',
            				},
 							z_index: 3000,
        			});	
				}
				}

				return false;
			}
			if(index==2 && $('#remaining_guarantee').text()!='0'){
				$.notify({
        	  				message: 'Please Ensure that the Amount left to Guarantee is 0',
          				},{
            				type: 'danger',
            				timer: 1000,
            				placement: {
                				from: 'top',
                				align: 'center',
            				},
 							z_index: 3000,
        			});	
				return false;
			}
		},
		onTabClick: function(tab, navigation, index){
			return false;
		}
	});

var maxes = [];

	$('#guarantors').change(function(){
		var guarantors = $('#guarantors').selectpicker('val');
		var thehtml = '';
		var counter = 1;
		for(var g in guarantors){
			var current_guarantor = guarantors[g];
			var id = $("select[name=guarantors] option[value='" + guarantors[g] + "']").val();
        	var shares = Number($("select[name=guarantors] option[value='" + guarantors[g] + "']").attr("theshares"));
			//var max=(1-(Number(settings_json.retention_fee)/100))*shares;
			 thehtml += '<div class="col-sm-6 col-sm-offset-1">';
                thehtml += ' <div class="form-group label-floating is-empty">';
                thehtml += '	<label class="control-label">' + $("select[name=guarantors] option[value='" + guarantors[g] + "']").text() + '</label>';
                thehtml += '       <input id="guarantor' + counter + '" name="guarantor' + counter + '" max='+[guarantors[g]].guarant_max+'  required="true" theid="'+id+'" class="form-control guarantee_loan" type="text" number="true" />';
                thehtml += '	</div></div>';
                thehtml += `<div style="vertical-align:center" class="col-sm-4">
                				<div class="form-group">Max: Kshs `+maxes[guarantors[g]].guarant_max+`</div>
                			</div>`;

                counter++;
		}

		$('#tab2-guarantors').empty().append(thehtml);
	});


var rules = {};

	for(var each_guarantor=1; each_guarantor<=settings_json.min_guarantors; each_guarantor++){
		rules['guarantor' + each_guarantor] = {required:true}
	}

rules['loanee'] = {required:true}
rules['loan-amount'] = {required:true}
rules['guarantors'] = {required:true, minlength:settings_json.min_guarantors}
rules['loan-date-given'] = {required:true, date:true}

	var $validator = $('#AddLoanForm').validate({
		  //ignore: [],
		  rules: rules,
		  messages:{
			loanee: {required: "Please Select a member."},
			guarantors: {required: "Please Select a member."}
		  }
	});

/**********************************************/
/*****************LOANS MANAGEMENT*************/
/**********************************************/
var url_loans = '/admin/loans';


$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
	var target = $(e.target).attr('href');
	e.preventDefault();

	if(target=='#tab2'){

		var total_guarantee = 0;
		$('#tab2 input').each(function(){

			total_guarantee+=Number($(this).val());
		});
		$('#remaining_guarantee').empty().append($('#loan-amount').val()-total_guarantee);

	}else if(target=='#tab3'){}
	else{
	}
});

//add loan form
$('#add-loan-btn').click(function(){
	$.get(url_loans+'/add', function(data){
			console.log(data)
		maxes = data.maxes;
		var select_member ='<option disabled selected="selected">Choose Member</option>';
		var guarantor_string = '<option disabled>Choose Guarantors.</option>';

		for(var member_id in data.members){
			//if(data.maxes[member_id].loan_max==0)continue;
			select_member += `
				<option value="`+member_id+`" member-name="`+data.members[member_id].name+`" loan-max="`+data.maxes[member_id].loan_max+`">`+data.members[member_id].name+`</option>
			`;

			guarantor_string += `
				<option id="guarantor`+member_id+`" value="`+member_id+`" member-name="`+data.members[member_id].name+`" theshares="`+data.members[member_id].shares+`">`+data.members[member_id].name+`</option>
			`;
		}

		$('#loanee').empty().append(select_member);
		$('#loanee').selectpicker('refresh');

		$('#guarantors').empty().append(guarantor_string);
		$('#guarantors').selectpicker('refresh');
	});

	$('#modal-add-loan').modal('show');
});
//end add loan form

//add loan
$('#AddLoanForm').submit(function(e){
	e.preventDefault();
	
	var loanee = $('#loanee').selectpicker('val');
	var loanee_name = $("select[name=loanee] option[value='" + loanee + "']").text();
	var amount = $('#loan-amount').val();
	var guarantors = $('#guarantors').selectpicker('val');
	var guarantors_len = guarantors.length;
	var date_given = $('#loan-date-given').val();

	if(loanee=='' || amount=='' || guarantors=='' || date_given==''){}
		else{


				var guarantors_csv = '';
				var guarantors_amounts = {};
				for(var g in guarantors){
					guarantors_csv += $("select[name=guarantors] option[value='" + guarantors[g] + "']").text() + ",";
				}

				$('#tab2 input').each(function(){
					guarantors_amounts[$(this).attr('theid')] = $(this).val();
				});

				$.ajaxSetup({
					headers:{
        				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      				}
				});

				var formData = {
					member_id:loanee,
					owner:loanee_name,
					amount:amount,
					date_given:date_given,
					guarantors:guarantors,
					guarantors_csv:guarantors_csv,
					guarantors_amounts: guarantors_amounts,
				}

				$.ajax({
					url: url_loans,
					data: formData,
					dataType: 'json',
					type: 'POST',
					success: function(data){

					$.notify({
          				message: 'Loan added successfuly to your records.',
          			},{
            			type: 'success',
            			timer: 1000,
            			placement: {
                			from: 'top',
                			align: 'center',
            			},
 						z_index: 1000,
        			});

        			$('#AddLoanForm').trigger('reset');
        			$('#modal-add-loan').modal('hide');

        			var loan_string = `
        				<tr id="loan`+data.loan.id+`">
        					<td>`+data.member.name+`</td>
        					<td>`+data.member.id_no+`</td>
        					<td>`+data.loan.amount+`</td>
        					<td>`+data.loan.date_given+`</td>
        					<td>`+data.loan.amount_payable+`</td>
        					<td>`+data.loan.date_due+`</td>
        					<td><i style="color:green" class="material-icons">flag</i></td>
        					<td><button id="loan-view-guarantors" name="loan-view-guarantors" theid="`+data.loan.id+`" class="btn btn-round btn-info btn-xs">View</button></td>
        					<td>
        						<button id="loan-pay" name="loan-pay" theid="`+data.loan.id+`" themember="`+data.member.id+`" class="btn btn-xs btn-round btn-default">Payments</button>
                                <button id="loan-delete" name="loan-delete" theid="`+data.loan.id+`" type="button" rel="tooltip" class="btn btn-xs btn-danger btn-simple" style="margin-top:0; margin-bottom: 0"><i class="material-icons">close</i></button>
                            </td>
        				</tr>
        			`;

        			$('#loans-body').append(loan_string);
        			$('#AddLoanForm').trigger('reset');
					},
					error: function(data){
						console.log(data)
					}
				});
				}
});
//end add loan

//view pay loan
$('#thebody').on('click', '#loan-pay', function(){
	var member_id = $(this).attr('themember');
	var loan_id = $(this).attr('theid');

	$.get(url_loans+'/'+loan_id+'/payments', function(data){

	$('#pay-loanee-id').empty().append("ID: "+data.member.id_no);
	$('#pay-loanee-name').empty().append(data.member.name);
	$('#pay-loan-amount').empty().append("Amount Taken: "+data.loan.amount);
	$('#pay-loan-topay').empty().append("To Pay: Kshs "+data.loan.amount_payable);
	$('#loanee_member_id').val(member_id);
	$('#loan_id').val(loan_id);

	if(data.loan.amount_payable==0){
		$('#pay-form').css('display', 'none');
		$('#paid-form').css('display', '');
	}else{
		$('#paid-form').css('display', 'none');
		$('#pay-form').css('display', '');
	}

	$('#modal-pay-loan').modal('show');

		var body='';
		for(var index in data.payments){
			body+=`
			<tr><td>`+data.payments[index].received_date+`</td>
				<td>`+data.payments[index].amount+`</td>
				<td>`+data.payments[index].paid_by+`</td></tr>
			`;
		}

		$('#payments-table-body').empty().append(body);
	})
});
//end view pay loan

//submit pay loan
$('#pay-loan-form').submit(function(e){
	e.preventDefault();

	var amount = $('#pay-loan').val();
	var date = $('#pay-date').val();
	var member_id = $('#loanee_member_id').val();
	var loan_id = $('#loan_id').val();
	var paid_by_id = member_id;

	if(amount=='' || date== ''){}
	else{
		$.ajaxSetup({
			headers:{
        		'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      		}
		});

		var formData = {
			amount:amount,
			date_given:date,
			member_id:member_id,
			loan_id:loan_id,
			paid_by_id:paid_by_id,
		}

		$.ajax({
			url:url_loans+'/'+loan_id+'/pay',
			data:formData,
			dataType:'json',
			type:'POST',
			success: function(data){
				console.log('hh');
				$('#pay-loan-form').trigger('reset');
				$('#modal-pay-loan').modal('hide');

					$.notify({
          				message: 'Payment added successfuly to your records.',
          			},{
            			type: 'success',
            			timer: 1000,
            			placement: {
                			from: 'top',
                			align: 'center',
            			},
 						z_index: 1000,
        			});
			},
			fail:function(data){
				console.log(data);
			}
		});
	}
})
//end submit pay loan

//edit loan
$('#view-loans').on('click', '#loan-edit', function(){
})
//end edit loan

$('#modal-add-loan').on('keyup', '.guarantee_loan', function(){
	var total_guaranteed = 0;
	$('#tab2 input').each(function(){
		total_guaranteed += Number($(this).val());
	});
	$('#remaining_guarantee').empty().append($('#loan-amount').val() - total_guaranteed);
});




$('.modal').on('hidden.bs.modal', function(e){
	$(this).removeData();
});


$('#loanee').change(function(){
	$('#guarantors').selectpicker('deselectAll');
	$('#guarantors > option').each(function(){
		if(typeof($(this).attr('val'))!='undefined' && $(this).attr('disabled')){
			$(this).removeAttr('disabled');
		}
	});
	var theid = $(this).attr('id');
	var selected_member = $(this).selectpicker('val');
	var loanmax = ($("select[name=loanee] option[value='" + selected_member + "']").attr('loan-max'));

	$('#loan-amount').attr({
		'max':loanmax,
	});

	//$('#guarantor' + selected_member).attr('disabled', 'disabled');
	$('#loan-max').empty().append("Max: Kshs "+loanmax);
	$('#guarantors').selectpicker('refresh');
});


//view guarantors
$('#loan-list').on('click', '#loan-view-guarantors', function(){
	var id = $(this).attr('theid');

	$.get(url_loans + '/' + id + '/guarantors', function(data){
		var to_show = "<div class='card'><div class='card-content text-center'>"
			to_show += "<table class='table'><thead class='text-primary'>";
			to_show += "<td>Name</td><td>Amount</td>";
			to_show += "</thead><tbody>";
		for(var each in data){
			if(typeof(data[each].member_info) != 'undefined'){
			to_show += "<tr><td>" + data[each].member_info.name + "</td><td>Kshs " + Number(data[each].guarant.amount) + "</td></tr>";
			}
		}


		to_show += "</tbody></table></div>";
		to_show += "<div class='card-footer'><div class='stats'><i class='material-icons'>person</i>Loanee: " + data.loan.owner + " , <i class='material-icons'>attach_money</i>Kshs " + data.loan.amount + "</div>";
		to_show += "</div>";

		show_guarantor(to_show);
	});
});
//end view guarantors


//sweet alert
function show_guarantor(html){
	swal({
		buttonsStyling: false,
		confirmButtonClass: "btn btn-success btn-sm",
		html: html
	})
}

//delete loan
$('#loan-list').on('click', '#loan-delete', function(){
	var id = $(this).attr('theid');
	var row = this;

	$.ajaxSetup({
		headers:{
    		'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      	}
	});

	$.ajax({
		url:url_loans + '/' + id + '/delete',
		type: 'POST',
		success: function(data){
			$('#loan'+id).remove();
		},
		error: function(data){
			console.log("Error: \n" + data)
		}
	})
});


});