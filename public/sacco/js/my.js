$(document).ready(function(){
  //ajax loader
  $(document).ajaxStart(function(){
    $('.ajax-loader').css('visibility', 'visible');
  });
  $(document).ajaxStop(function(){
    $('.ajax-loader').css('visibility', 'hidden');
 });

  //send message to all
$('#sendMessageForm').on('submit', function(e){
  e.preventDefault();

  var message = $('#message').val();
  if(message!=''){
    $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

    $.ajax({
      url: 'api/messages/send',
      data: {message:message},
      dataType:'json',
      type:'POST',
      success: function(data){
        var notify_message; var type;
        if(data=='notifications off'){
          notify_message = "Please turn on the notifications in settings first.";
          type = 'danger';
        }else{
          notify_message = "Sending Message..";
          type = "success";
        }

        $.notify({
          message:notify_message,
        },{
          type:type,
          timer:1000,
          placement:{
            from: 'top',
            align: 'center',
          },
          z_index: 1000,
        });

        $('#sendMessageForm').trigger('reset');

      }
    })
  }
})
  //end send message to all
		/***********************************************************/
		/******************SETTINGS MANAGEMENT**********************/
		/***********************************************************/

		//set quick settings values
		if(settings_json.length!=0){
      if(settings_json.share_value!=null){
        $('#share-val').val(settings_json.share_value);
        $('#share-val').parent().removeClass("is-empty");
      }
      if(settings_json.loan_interest!=null){
        $('#loan-interest').val(settings_json.loan_interest);
        $('#loan-interest').parent().removeClass("is-empty");
      }
      if(settings_json.loan_duration!=null){
        $('#loan-duration').val(settings_json.loan_duration);
        $('#loan-duration').parent().removeClass("is-empty");
      }
      if(settings_json.loan_borrowable!=null){
        $('#loan-borrowable').val(settings_json.loan_borrowable);
        $('#loan-borrowable').parent().removeClass('is-empty');
      }
      if(settings_json.min_guarantors!=null){
        $('#min-guarantors').val(settings_json.min_guarantors);
        $('#min-guarantors').parent().removeClass('is-empty');
      }
		}

		url_settings = '/admin/settings';

		$('#quick-settings-form').on('submit', function(e){
			e.preventDefault();

			var the_url = url_settings + '/quick';

			var share_val = $('#share-val').val();
			var loan_interest = $('#loan-interest').val();
			var loan_duration = $('#loan-duration').val();
      var loan_borrowable = $('#loan-borrowable').val();
      var min_guarantors = $('#min-guarantors').val();
			var settings = {};

			if(share_val!='' || loan_interest!='' || loan_duration!='' || min_guarantors!='' || loan_borrowable!=''){
				if(share_val!='') settings['share_value'] = share_val;
				if(loan_interest!='') settings['loan_interest'] = loan_interest;
				if(loan_duration!='') settings['loan_duration'] = loan_duration;
        if(loan_borrowable!='') settings['loan_borrowable']=loan_borrowable;
        if(min_guarantors!='') settings['min_guarantors']=min_guarantors;

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



//date picker
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
                inline: true
            }
         });
  };

//init form validations
    function setFormValidation(id) {
        $(id).validate({
            errorPlacement: function(error, element) {
                $(element).parent('div').addClass('has-error');
            }
        });
    }

    $(document).ready(function() {
        setFormValidation('#RegisterValidation');
        setFormValidation('#AddMemberForm');
        setFormValidation('#quick-settings-form');
        setFormValidation('#AddSharesForm');
        setFormValidation('#AddLoanForm');
        setFormValidation('#settingsForm');
        setFormValidation('#pay-loan-form');
    });

//developer stuff
$('#developer').click(function(){
  show_developer()
})
function show_developer(){
    swal({
    buttonsStyling: false,
    confirmButtonClass: "btn btn-primary btn-sm",
    html: `
        <div class="card">
          <div class="card-content table-responsive text-center">
            <table class="table">
              <tr>
                <td rowspan="4">
                  <img src="/images/faces/developer-contact-qr.png" style="width:80%; height:auto;" />
                </td>
                <td colspan="3">
                  <i class="material-icons">person_outline</i><br />Collins Kasyoki Thano
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <i class="material-icons">phone</i><br /> +254701035316
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <i class="material-icons">email</i> collinskasyoki@gmail.com
                </td>
              </tr>
            </table>
          </div>
        </div>
                `
  })
}

});
