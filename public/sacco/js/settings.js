$(document).ready(function(){
url_settings = '/admin/settings';

console.log(settings_json);
		//set settings values
		if(settings_json.length!=0){
/*
      if(settings_json.share_value!=null){
        $('#share-val').val(settings_json.share_value);
        $('#share-val').parent().removeClass("is-empty");
      }

*/
      if(settings_json.loan_interest!=null){
        $('#settings_loan_duration').val(settings_json.loan_interest);
        $('#settings_loan_duration').parent().removeClass("is-empty");        
      }
      if(settings_json.loan_duration!=null){
        $('#settings_loan_interest').val(settings_json.loan_duration);
        $('#settings_loan_interest').parent().removeClass("is-empty");
      }
      if(settings_json.loan_borrowable!=null){
        $('#settings_loan_borrowable').val(settings_json.loan_borrowable);
        $('#settings_loan_borrowable').parent().removeClass('is-empty');
      }
      if(settings_json.retention_fee!=null){
        $('#settings_retention_fee').val(settings_json.retention_fee);
        $('#settings_retention_fee').parent().removeClass('is-empty');
      }
      if(settings_json.min_guarantors!=null){
        $('#settings_minimum_guarantors').val(settings_json.min_guarantors);
        $('#settings_minimum_guarantors').parent().removeClass('is-empty');
      }
      if(settings_json.name!=null){
        $('#settings_organization_name').val(settings_json.name);
        $('#settings_organization_name').parent().removeClass("is-empty");        
      }
      if(settings_json.notifications!=null){
        settings_json.notifications==true? $('#notifications_on').prop('checked', true) : $('#notifications_off').prop('checked', true);
      }
      if(settings_json.notification_number!=null){
        $('#notification_number').val(settings_json.notification_number);
        $('#notification_number').parent().removeClass('is-empty');
      }
	}


		$('#settingsForm').on('submit', function(e){
			e.preventDefault();

			var the_url = url_settings;

			var name = $('#settings_organization_name').val();
			//var share_val = $('#settings_share_value').val();
			var loan_interest = $('#settings_loan_interest').val();
			var loan_duration = $('#settings_loan_duration').val();
      var loan_borrowable = $('#settings_loan_borrowable').val();
      var retention_fee = $('#settings_retention_fee').val();
      var min_guarantors = $('#settings_minimum_guarantors').val();
      var notifications = $('input:radio[name=notifications]:checked').val();
      var notification_number = $('#notification_number').val();
			var settings = {};

			if(name!=''||retention_fee||loan_interest!=''||loan_duration!=''||min_guarantors!=''||loan_borrowable!=''||notifications!=''||notification_number!=''){
        //if(share_val!='') settings['share_value'] = share_val;
				if(name!='') settings['name'] = name;
				if(loan_interest!='') settings['loan_interest'] = loan_interest;
				if(loan_duration!='') settings['loan_duration'] = loan_duration;
        if(loan_borrowable!='') settings['loan_borrowable']=loan_borrowable;
        if(retention_fee!=='') settings['retention_fee'] = retention_fee;
        if(min_guarantors!='') settings['min_guarantors']=min_guarantors;
        if(notifications!='') settings['notifications']=notifications;
        if(notification_number!='') settings['notification_number']=notification_number;

				//determine type of url to use
				var url_type = 'POST';

				if(settings_json.length!=0){
					url_type = 'PUT';
					the_url = the_url + '/' + settings_json.id;
				}

				$.ajaxSetup({
      				headers:{
        				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      				}
    			});

    			$.ajax({
    				type: url_type,
    				data: settings,
    				dataType: 'json',
    				url: the_url,
    				success: function(data){
    					//refresh data
    					$('#organization_name').empty().append(data.name);
    					$.notify({
          					message: "Saved.",
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
          					message: "Error. Unable to Save.",
          				},{
            				type: 'danger',
            				timer: 3000,
            				placement: {
                				from: 'top',
                				align: 'center',
            				}
        				});
    				},
    			})


			}else{
				console.log('here');
			}
		});


});