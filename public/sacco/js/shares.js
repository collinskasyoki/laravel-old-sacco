$(document).ready(function(){
console.log($('meta[name="_token"]').attr('content'));

var url_shares = '/admin/shares';

  /*************************************************************/
  /**************************SEARCH*****************************/
  /*************************************************************/
  var members_shares;
  //var membershare;
  var engine = new Bloodhound({
    remote:{
      url: url_shares+'/find?q=%QUERY%',
      wildcard:'%QUERY%', 
    transform: function(data){
    	members_shares = data;
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
    //source: engine.ttAdapter(),

    //This will be appended to 'tt-dataset-' to form the class name of the suggestion menu.
    name: 'membershares',
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

	for(var share_index in members_shares[id].shares){
		var share_id = members_shares[id].shares[share_index].id;
	thestring += `
		<tr id="search-row`+share_id+`">
			<td id="search-name`+share_id+`">`+members_shares[id].name+`</td>
			<td id="search-id`+share_id+`">`+members_shares[id].id_no+`</td>
			<td id="search-amount`+share_id+`">`+members_shares[id].shares[share_index].amount+`</td>
			<td id="search-date`+share_id+`">`+members_shares[id].shares[share_index].date_received+`</td>
			<td>`+members_shares[id].name+`</td>
			<td><button id='member-edit' name='member-edit' theid='`+share_id+`' type='button' rel='tooltip' class='btn btn-xs btn-success btn-simple' style='margin-top:0; margin-bottom:0'><i class='material-icons'>edit</i></button></td>
		</tr>
	`;
	}
	$('#shares-body-search').empty().append(thestring);
	$('#members-shares').css('display','none');
	$('#members-shares-search').css('display','');
	$('#clear-search').css('display', '');
});

//clear search
$('#thebody').on('click', '#clear-search', function(){
	$('#clear-search').css('display','none');
	$('#members-shares-search').css('display', 'none');
	$('#members-shares').css('display', '');
})

	//add shares
	$('#AddSharesForm').on('submit', function(e){
		e.preventDefault();

		var member = $('#shares-choose-member option:selected').val();
		var amount = $('#shares-amount').val();
		var member_name = $('#shares-choose-member option:selected').attr('member-name');
		var date_received = $('#shares_date').val();

		if(amount=='' || member=='' || date_received==''){
			console.log('not selected');
		}else{
			$.ajaxSetup({
      		headers:{
        		'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      		}
			});

			formData = {
				amount:amount,
				member_id:member,
				paid_by_id:member,
				paid_by:member_name,
				date_received:date_received,
			}

			$.ajax({
				type: "POST",
				url: url_shares,
				data: formData,
				dataType: 'json',

				success: function(data){
					var shares_string = `
						<tr id="row`+data.id+`" member_id="`+data.paid_by_id+`">
							<td id="name`+data.id+`">`+data.paid_by+`</td>
							<td id="id`+data.id+`">`+data.id_no+`</td>
							<td id="amount`+data.id+`">`+data.amount+`</td>
							<td id="date`+data.id+`">`+data.date_received+`</td>
							<td>`+data.paid_by+`</td>
							<td><button id='member-edit' name='member-edit' theid='`+data.id+`' type='button' rel='tooltip' class='btn btn-xs btn-success btn-simple' style='margin-top:0; margin-bottom:0'><i class='material-icons'>edit</i></button></td>
						</tr>
					`;

					$('#shares-body').append(shares_string);

					$.notify({
          				message: "Shares added successfully.",
          			},{
            			type: 'success',
            			timer: 1000,
            			placement: {
                			from: 'top',
                			align: 'center',
            			}
        			});	
        			$('#AddSharesForm').trigger("reset");
        			$('#modal-add-shares').modal('hide');
				},
				error: function(data){
					$.notify({
          				message: "Error Adding Shares.",
          			},{
            			type: 'danger',
            			timer: 3000,
            			placement: {
                			from: 'top',
                			align: 'center',
            			}
        			});	
					console.log("error \n " + data)
				},
			});
		}

	});

	$('#thebody').on('click', '#member-edit', function(){
		var id = $(this).attr('theid');
		var thetype = $(this).parent().parent().parent().attr('id');
		var member_id = $(this).attr('member_id');
		var editor = `
					<td>`+$('#name'+id).text()+`</td>
					<td>`+$('#id'+id).text()+`</td>
					<td><input type="text" class="form-control input-sm" number="true" required="true" id="edit-amount`+id+`" name="edit-amount" value="`+$('#amount'+id).text()+`" /></td>
					<td><input type="date" style="position:relative; z-index:10000000;" class="form-control input-sm datepicker pickdate" id="edit-date`+id+`" name="edit-date`+id+`" required="true" date="true" value="`+$('#date'+id).text()+`" /></td>
					<td><button type="submit" theid='`+id+`' class="btn btn-default btn-xs save-edit">Save</button></td>`;

				var tabletype = (thetype=='shares-body-search') ? '#search-row'+id : '#row'+id;
				$(tabletype).empty().append(editor);
	});

/*
	$('#members-shares').on('focus', '.pickdate', function(){
		initDatePicker();

		function initDatePicker(){
         $('.datepicker').datetimepicker({

            format: 'YYYY-MM-DD',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: false
            },
         });
  		};
	})
*/

	$('#thebody').on('click', '.save-edit', function(){
		var id=$(this).attr('theid');
		var thetype = $(this).parent().parent().parent().attr('id');
		var pre = (thetype=='members-shares-search')?'search-':'';

		var amount=$('#'+pre+'edit-amount'+id).val();
		var date=$('#'+pre+'edit-date'+id).val();

		if(amount==''||date==''){}
		else{
			$.ajaxSetup({
      		headers:{
        		'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
      		}
			});

			formData = {
				amount:amount,
				date_received:date,
				_method: 'PUT',
				_token: $('meta[name="_token"]').attr('content'),
			}

			$.ajax({
				type: "POST",
				url: url_shares+'/'+id+'/edit',
				data: formData,
				dataType: 'json',

				success: function(data){
					var editor=`
						<td id="name`+data.id+`">`+data.paid_by+`</td>
						<td id="id`+data.id+`">`+data.id_no+`</td>
						<td id="amount`+data.id+`">`+data.amount+`</td>
						<td id="date`+data.id+`">`+data.date_received+`</td>
						<td>`+data.paid_by+`</td>
						<td><button id='member-edit' name='member-edit' theid='`+data.id+`' type='button' rel='tooltip' class='btn btn-xs btn-success btn-simple' style='margin-top:0; margin-bottom:0'><i class='material-icons'>edit</i></button></td>
					`;

					$('#row'+data.id).empty().append(editor);

					$.notify({
          				message: "Share edited successfully.",
          			},{
            			type: 'success',
            			timer: 3000,
            			placement: {
                			from: 'top',
                			align: 'center',
            			}
        			});
				},
				error: function(data){
					$.notify({
          				message: "Error Editing Share.",
          			},{
            			type: 'danger',
            			timer: 3000,
            			placement: {
                			from: 'top',
                			align: 'center',
            			}
        			});
				},
			});
		}
	});

	$('#members-shares').on('click', '#member-delete', function(){
		var id=$(this).attr('theid');

		$.ajaxSetup({
      		headers:{
        		'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
      		}
			});

			$.ajax({
				type: "DELETE",
				url: url_shares+'/'+id+'/delete',
				dataType: 'json',

				success: function(data){
					var table = $('#members-shares').DataTable();

					table.row('#row'+id).remove().draw();
					$.notify({
          				message: "Share Deleted successfully.",
          			},{
            			type: 'success',
            			timer: 3000,
            			placement: {
                			from: 'top',
                			align: 'center',
            			}
        			});
				},
				error: function(data){
					//alert(data.toSource());
					//console.log(data);
					if(data.status==422&&data.responseJSON[0]=='fail'){
					$.notify({
          				message: data.responseJSON[1],
          			},{
            			type: 'danger',
            			timer: 3000,
            			placement: {
                			from: 'top',
                			align: 'center',
            			}
        			});
					}else{
					$.notify({
          				message: "Error Deleting Share.",
          			},{
            			type: 'danger',
            			timer: 3000,
            			placement: {
                			from: 'top',
                			align: 'center',
            			}
        			});
        			}
				},
			});
	})



});