$(document).ready(function(){

	// flat check input
	//Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
	// date range
    var dstart = 0;
	var dend;
	$('.daterange').daterangepicker({
	    ranges: {
	      'Today': [moment(), moment()],
	      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	      'This Month': [moment().startOf('month'), moment().endOf('month')],
	      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	    },
	    startDate: moment().subtract(29, 'days'),
	    endDate: moment()
	  }, function (start, end) {
	  	dstart = start.format('YYYY-MM-DD');
	  	dend = end.format('YYYY-MM-DD');
	  	$('#dstart').html(start.format('YYYY-MM-DD'));
	  	$('#dend').html(end.format('YYYY-MM-DD'));
		$('input[name="dstart"]').val(dstart);
		$('input[name="dend"]').val(dend);

	   // window.alert("You chose: " + start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
	  });
	// event click filter
	$('#btn-filter').on('click', function(){
		var url_query = "?";
		var cat_id = $('select[name="s-cat-id"]').val();
		var text = $('input[name="s-text"]').val();
		var s_url = $('input[name="s-url"]').val();
		var date_start = $('input[name="dstart"]').val();
		var date_end = $('input[name="dend"]').val();

		if(date_start != '' ){
			url_query += "dstart="+date_start+"&dend="+date_end;
		}
		if(cat_id != '0'){
			url_query += "&cat="+cat_id;
		}
		if(text != ''){
			url_query += "&text="+text;
		}
		if(url_query != '?'){
			window.location.href = s_url + url_query;
		}else{
			alert('Please fill category or range date or text before search...');
		}

	});
	// function convert date to Y-M-D
	function convertYmd(userDate){
		var date    = new Date(userDate),
	    yr      = date.getFullYear(),
	    month   = date.getMonth() < 10 ? '0' + date.getMonth() : date.getMonth(),
	    day     = date.getDate()  < 10 ? '0' + date.getDate()  : date.getDate(),
	    newDate = yr + '-' + month + '-' + day;
	    return newDate;
	}


	// event click change avatar
	$('#btn-ava-edit').on('click', function(){
		$('#modal-edit-avatar').modal('show');
	});
	$('#btn-save-avatar').on('click', function(){
		var img = $('input[id="img-avatar"]').val();
		var url = $('form[name="frm-avatar"]').attr('action');
		var _token = $('form[name="frm-avatar"]').find('input[name="_token"]').val();
		$('#btn-save-avatar').attr('disabled','disabled');
		$('#btn-save-avatar').append('<i class="fa fa-spinner fa-spin"></i>');

		$.ajax({
	        url: url,
	        type: 'POST',
	        data: new FormData($('form[name="frm-avatar"]')[0]),
	        cache: false,
	        dataType: 'json',
	        processData: false,
    		contentType: false,
	        success: function(data)
	        {
	            if(data.status=='success'){
	            	$('.ava-alert').removeClass('hidden');
	            	$('.ava-alert').addClass('alert-success');
	            	$('.ava-alert').html(data.msg);
	            	setTimeout(function(){
	            		$('#modal-edit-avatar').modal('hide');
	            		$('#btn-save-avatar').removeAttr('disabled');
	            		$('input[id="img-avatar"]').val('');
	            		location.reload();
	            	}, 1300);
	            }else{
	            	$('.ava-alert').removeClass('hidden');
	            	$('.ava-alert').addClass('alert-danger');
	            	$('#btn-save-avatar').removeAttr('disabled');
	            	$('#btn-save-avatar i').remove();
	            	$('.ava-alert').append(data.msg);
	            }
	            
	        },
	        error: function(jqXHR, textStatus, errorThrown)
	        {
	            // Handle errors here
	            console.log('ERRORS: ' + textStatus);
	            alert("Errors, Please Try Again!!!");
	            // STOP LOADING SPINNER
	        }
    	});
	});

	//event click change fullname
	$('#btn-fullname-edit').on('click', function(){
		$('#modal-edit-fullname').modal('show');
	});
	$('#btn-save-fullname').on('click', function(){
		var fullname = $('input[name="fullname"]').val();
		var userid = $('input[name="userid"]').val();
		var url = $('form[name="frm-fullname"]').attr('action');
		var _token = $('form[name="frm-fullname"]').find('input[name="_token"]').val();
		$('#btn-save-fullname').attr('disabled','disabled');
		$('#btn-save-fullname').append('<i class="fa fa-spinner fa-spin"></i>');

		$.ajax({
	        url: url,
	        type: 'POST',
	        data: {'_token': _token, 'userid': userid, 'fullname':fullname },
	        cache: false,
	        dataType: 'json',
	        success: function(data)
	        {
	            if(data.status=='success'){
	            	$('.fn-alert').removeClass('hidden');
	            	$('.fn-alert').addClass('alert-success');
	            	$('.fn-alert').html(data.msg);
	            	setTimeout(function(){
	            		$('#modal-edit-fullname').modal('hide');
	            		$('#btn-save-fullname').removeAttr('disabled');
	            		location.reload();
	            	}, 1300);
	            }else{
	            	$('.fn-alert').removeClass('hidden');
	            	$('.fn-alert').addClass('alert-danger');
	            	$('#btn-save-fullname').removeAttr('disabled');
	            	$('#btn-save-fullname i').remove();

	            	$('.fn-alert').html(data.msg);
	            }
	            
	        },
	        error: function(jqXHR, textStatus, errorThrown)
	        {
	            // Handle errors here
	            console.log('ERRORS: ' + textStatus);
	            alert("Errors, Please Try Again!!!");
	            // STOP LOADING SPINNER
	        }
    	});
	});


	//event click change email
	$('#btn-email-edit').on('click', function(){
		$('#modal-edit-email').modal('show');
	});
	$('#btn-save-email').on('click', function(){
		var email = $('input[name="email"]').val();
		var userid = $('input[name="userid"]').val();
		var url = $('form[name="frm-email"]').attr('action');
		var _token = $('form[name="frm-email"]').find('input[name="_token"]').val();
		$('#btn-save-email').attr('disabled','disabled');
		$('#btn-save-email').append('<i class="fa fa-spinner fa-spin"></i>');

		$.ajax({
	        url: url,
	        type: 'POST',
	        data: {'_token': _token, 'userid': userid, 'email':email },
	        cache: false,
	        dataType: 'json',
	        success: function(data)
	        {
	            if(data.status=='success'){
	            	$('.email-alert').removeClass('hidden');
	            	$('.email-alert').addClass('alert-success');
	            	$('.email-alert').html(data.msg);
	            	setTimeout(function(){
            			$('#modal-edit-email').modal('hide');
            			$('#btn-save-email').removeAttr('disabled');
	            		location.reload();
	            	}, 1300);
	            }else{
	            	$('.email-alert').removeClass('hidden');
	            	$('.email-alert').addClass('alert-danger');
	            	$('#btn-save-email').removeAttr('disabled');
	            	$('#btn-save-email i').remove();
	            	$('.email-alert').html(data.msg);
	            }
	            
	        },
	        error: function(jqXHR, textStatus, errorThrown)
	        {
	            // Handle errors here
	            console.log('ERRORS: ' + textStatus);
	            alert("Errors, Please Try Again!!!");
	            // STOP LOADING SPINNER
	        }
    	});
	});


	//event click add cat
	$('#btn-add-cat').on('click', function(){
		$('#modal-add-cat').modal('show');
	});
	$('#btn-modal-add-cat').on('click', function(){
		var cat_name = $('input[name="cat_name"]').val();
		var cat_color = $('select[name="cat_color"]').children('option:selected').val();
		var url = $('form[name="frm-add-cat"]').attr('action');
		var _token = $('form[name="frm-add-cat"]').find('input[name="_token"]').val();
		$('#btn-modal-add-cat').attr('disabled','disabled');
		$('#btn-modal-add-cat').append('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
	        url: url,
	        type: 'POST',
	        data: {'_token': _token, 'cat_name': cat_name, 'cat_color':cat_color },
	        cache: false,
	        dataType: 'json',
	        success: function(data)
	        {
	            if(data.status=='success'){
	            	$('.add-cat-alert').removeClass('hidden');
	            	$('.add-cat-alert').addClass('alert-success');
	            	$('.add-cat-alert').html(data.msg);
	            	setTimeout(function(){
            			$('#modal-add-cat').modal('hide');
            			$('#btn-modal-add-cat').removeAttr('disabled');
	            		location.reload();
	            	}, 1300);
	            }else{
	            	$('.add-cat-alert').removeClass('hidden');
	            	$('.add-cat-alert').addClass('alert-danger');
	            	$('#btn-modal-add-cat').removeAttr('disabled');
	            	$('#btn-modal-add-cat i').remove();
	            	$('.add-cat-alert').html(data.msg);
	            }
	            
	        },
	        error: function(error)
	        {
	            // Handle errors here
	            // console.log('ERRORS: ' + textStatus);
	            alert("Errors, Please Try Again!!!");
	            // STOP LOADING SPINNER
	        }
    	});
	});


	//event click edit cat
	$('.btn-edit-cat').on('click', function(){
		var catid = $(this).attr('catid');
		$.ajax({
	        url: 'inex/showInfoCat',
	        type: 'GET',
	        data: {'catid': catid },
	        cache: false,
	        dataType: 'json',
	        success: function(data)
	        {
	        	var rdata = $.parseJSON(data);
	           $('#modal-edit-cat form[name="frm-edit-cat"]').find('input[name="catid"]').val(catid);
	           $('#modal-edit-cat form[name="frm-edit-cat"]').find('input[name="cat_name"]').val(rdata.cat_name);
	           $('#modal-edit-cat form[name="frm-edit-cat"]').find('option[value="'+rdata.color+'"]').attr('selected', 'selected');
	       		
				$('#modal-edit-cat').modal('show');


	        },
	        error: function(error)
	        {
	            // Handle errors here
	            // console.log('ERRORS: ' + textStatus);
	            alert("Errors, Please Try Again!!!");
	            // STOP LOADING SPINNER
	        }
    	});
		
	});
	$('#btn-modal-edit-cat').on('click', function(){
		var cat_id = $('form[name="frm-edit-cat"]').find('input[name="catid"]').val();
		var cat_name = $('form[name="frm-edit-cat"]').find('input[name="cat_name"]').val();
		var cat_color = $('form[name="frm-edit-cat"]').find('select[name="cat_color"]').children('option:selected').val();
		var url = $('form[name="frm-edit-cat"]').attr('action');
		var _token = $('form[name="frm-edit-cat"]').find('input[name="_token"]').val();
		$('#btn-modal-edit-cat').attr('disabled','disabled');
		$('#btn-modal-edit-cat').append('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
	        url: url,
	        type: 'POST',
	        data: {'_token': _token,'cat_id':cat_id,  'cat_name': cat_name, 'cat_color':cat_color },
	        cache: false,
	        dataType: 'json',
	        success: function(data)
	        {
	            if(data.status=='success'){
	            	$('.edit-cat-alert').removeClass('hidden');
	            	$('.edit-cat-alert').addClass('alert-success');
	            	$('.edit-cat-alert').html(data.msg);
	            	setTimeout(function(){
            			$('#modal-edit-cat').modal('hide');
            			$('#btn-modal-edit-cat').removeAttr('disabled');
	            		location.reload();
	            	}, 1300);
	            }else{
	            	$('.edit-cat-alert').removeClass('hidden');
	            	$('.edit-cat-alert').addClass('alert-danger');
	            	$('#btn-modal-edit-cat').removeAttr('disabled');
	            	$('#btn-modal-edit-cat i').remove();
	            	$('.edit-cat-alert').html(data.msg);
	            }
	            
	        },
	        error: function(error)
	        {
	            // Handle errors here
	            // console.log('ERRORS: ' + textStatus);
	            alert("Errors, Please Try Again!!!");
	            // STOP LOADING SPINNER
	        }
    	});
	});

	//script add IE data
	$('#btn-add-iedata').on('click', function(){
		$('#modal-add-iedata').modal('show');
	});
	$('#btn-modal-add-iedata').on('click', function(){
		var ie_type = $('input[name="ie_type"]:checked').val();
		var amount = $('input[name="amount"]').val();
		var note = $('input[name="note"]').val();
		var cat_id = $('input[name="cat_id"]:checked').val();
		var url = $('form[name="frm-add-iedata"]').attr('action');
		var _token = $('form[name="frm-add-iedata"]').find('input[name="_token"]').val();
		$('#btn-modal-add-iedata').attr('disabled','disabled');
		$('#btn-modal-add-iedata').append('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
	        url: url,
	        type: 'POST',
	        data: {'_token': _token, 'ie_type': ie_type, 'amount':amount, 'note':note, 'cat_id':cat_id },
	        cache: false,
	        dataType: 'json',
	        success: function(data)
	        {
	            if(data.status=='success'){
	            	$('.add-iedata-alert').removeClass('hidden');
	            	$('.add-iedata-alert').addClass('alert-success');
	            	$('.add-iedata-alert').html(data.msg);
	            	setTimeout(function(){
            			$('#modal-add-iedata').modal('hide');
            			$('#btn-modal-add-iedata').removeAttr('disabled');
	            		location.reload();
	            	}, 1300);
	            }else{
	            	$('.add-iedata-alert').removeClass('hidden');
	            	$('.add-iedata-alert').addClass('alert-danger');
	            	$('#btn-modal-add-iedata').removeAttr('disabled');
	            	$('#btn-modal-add-iedata i').remove();
	            	$('.add-iedata-alert').html(data.msg);
	            }
	            
	        },
	        error: function(error)
	        {
	            // Handle errors here
	            // console.log('ERRORS: ' + textStatus);
	            alert("Errors, Please Try Again!!!");
	            // STOP LOADING SPINNER
	        }
    	});
	});


	//event click edit IE data
	$('.btn-edit-iedata').on('click', function(){
		var ieid = $(this).attr('ieid');
		//alert(catid);
		// $('#modal-edit-cat form[name="frm-edit-cat"]').find('option').removeAttr('selected');
		$.ajax({
	        url: 'inex/showInfoIeData',
	        type: 'GET',
	        data: {'ieid': ieid },
	        cache: false,
	        dataType: 'json',
	        success: function(data)
	        {
	        	var rdata = $.parseJSON(data);
	           $('#modal-edit-iedata').find('input[name="ieid"]').val(rdata.id);
	           $('#modal-edit-iedata').find('input[name="ie_type"][value="'+rdata.ie_type+'"]').attr('checked', 'true');;
	           $('#modal-edit-iedata').find('input[name="cat_id"][value="'+rdata.cat_id+'"]').attr('checked', 'true');;
	           $('#modal-edit-iedata').find('input[name="amount"]').val(rdata.amount);
	           $('#modal-edit-iedata').find('input[name="note"]').val(rdata.note);
	           
	       		
				$('#modal-edit-iedata').modal('show');


	        },
	        error: function(error)
	        {
	            // Handle errors here
	            // console.log('ERRORS: ' + textStatus);
	            alert("Errors, Please Try Again!!!");
	            // STOP LOADING SPINNER
	        }
    	});
		
	});
	$('#btn-modal-edit-iedata').on('click', function(){
		var ie_id = $('form[name="frm-edit-iedata"]').find('input[name="ieid"]').val();
		var ie_type = $('form[name="frm-edit-iedata"]').find('input[name="ie_type"]:checked').val();
		var amount = $('form[name="frm-edit-iedata"]').find('input[name="amount"]').val();
		var note = $('form[name="frm-edit-iedata"]').find('input[name="note"]').val();
		var cat_id = $('form[name="frm-edit-iedata"]').find('input[name="cat_id"]:checked').val();
		var url = $('form[name="frm-edit-iedata"]').attr('action');
		var _token = $('form[name="frm-edit-iedata"]').find('input[name="_token"]').val();
		$('#btn-modal-edit-iedata').attr('disabled','disabled');
		$('#btn-modal-edit-iedata').append('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
	        url: url,
	        type: 'POST',
	        data: {'_token': _token,'ie_id':ie_id, 'ie_type': ie_type, 'amount':amount, 'note':note, 'cat_id':cat_id },
	        cache: false,
	        dataType: 'json',
	        success: function(data)
	        {
	            if(data.status=='success'){
	            	$('.edit-iedata-alert').removeClass('hidden');
	            	$('.edit-iedata-alert').addClass('alert-success');
	            	$('.edit-iedata-alert').html(data.msg);
	            	setTimeout(function(){
            			$('#modal-add-iedata').modal('hide');
            			$('#btn-modal-add-iedata').removeAttr('disabled');
	            		location.reload();
	            	}, 1300);
	            }else{
	            	$('.edit-iedata-alert').removeClass('hidden');
	            	$('.edit-iedata-alert').addClass('alert-danger');
	            	$('#btn-modal-edit-iedata').removeAttr('disabled');
	            	$('#btn-modal-edit-iedata i').remove();
	            	$('.edit-iedata-alert').html(data.msg);
	            }
	            
	        },
	        error: function(error)
	        {
	            // Handle errors here
	            // console.log('ERRORS: ' + textStatus);
	            alert("Errors, Please Try Again!!!");
	            // STOP LOADING SPINNER
	        }
    	});
	});
	


});