jQuery(document).ready(function($){
	
	
	$('#add_new').on('click', function(e){
		
		 
		 
				e.preventDefault(); 
				
				
				var first_name = $("#first_name").val();
				var last_name = $("#last_name").val();
				var dob = $("#dob").val();
				var dod = $("#dod").val();
				var city = $("#city").val();
				var memorial_message = $("#memorial_message").val();
				var country = $("#country").val();
				var zipcode = $("#zipcode").val();
				var state = $("#state").val();
				var admin_id = $("#admin_id").val() ;
				
				data = {
					action: 'create_memorial_logged_in', 
					high_nonce: high_memory.high_nonce, 	
					dob:dob, 
					dod:dod, 
					city:city, 
					memorial_message:memorial_message,
					country:country, 
					zipcode:zipcode, 
					state:state, 
					first_name:first_name, 
					last_name:last_name,
					admin_id:admin_id
				},
				  
			  console.log(data)
		
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: high_memory.ajax_url,
				data:data,  
				success: function(data){
					if (data.res == true){
						console.log(data.message);    // success message
					window.location.href("https://staging.memorialkeeper.com/dashboard-view/");
					}else{
						console.log(data.message);    // fail
					}
					
				}
			}) 
			
	}) // end logged in user

// create new memoiral for existing user logging in 
$(".um-login.um-6756 #um-submit-btn").on('click', function(e){
			e.preventDefault();
			 
		alert('logging')
		
    var admin_first_name = $('#admin_first_name-6756').val(),
		admin_last_name = $('#admin_last_name-6756').val(),
		username = $("#username-6756").val(),
		user_password = $("#user_password-6756").val(),
		dob = $('#dob-6756').val(),
		dod = $('#dod-6756').val(),
		city = $('city_state_death-6756').val(),
		memorial_message = $('#memorial_message-6756').val(); 
		
		
	data = {
		action: 'create_memorial_with_logged_in', 
		high_nonce: high_memory.high_nonce, 	
		admin_first_name:admin_first_name, 
		admin_last_name:admin_last_name, 
		username:username, 
		user_password:user_password, 
		dob:dob, 
		dod:dod, 
		city:city, 
		memorial_message:memorial_message, 
	}, 
	 
	 
	 alert('wtf')
      
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: high_memory.ajax_url,
		data:data,  
		success: function(data){
			if (data.res == true){
				alert('yes')
						console.log(data.message);    // success message
		 //window.location.href("https://staging.memorialkeeper.com/dashboard-view/");
					}else{
						alert('wtf')
						console.log(data.message);    // fail
		console.log(data)
					}  
		}, 
	});

});


// create menu for new user registration
$(".um-register.um-5032  #um-submit-btn").on('click', function(e){
 
				 alert('register')
			e.preventDefault();
    var first_name = $("#first_name-5032").val(),
		last_name = $("#last_name-5032").val(),
		username = $("#username-5032").val(),
		user_password = $("#user_password-5032").val(),
		confirm_user_password = $("#confirm_user_password-5032").val(),
		relationship_loved_one = $("#relationship_loved_one").val(),
		admin_first_name = $("#admin_first_name-5032").val(),
		admin_last_name = $("#admin_last_name-5032").val(),
		dob = $("#dob-5032").val(),
		dod = $("#dod-5032").val(),
		city_state_death = $("#city_state_death-5032").val(),
		memorial_message = $("#memorial_message-5032").val(),
		country = $("#city_state_death_17_18-5032").val(),
		zipcode = $("#city_state_death_17-5032").val(),
		state = $("#city_state_death_17_18_19-5032").val();

     
	 data = {
					action: 'create_memorial', 
					high_nonce: high_memory.high_nonce, 	
					admin_first_name:admin_first_name, 
					admin_last_name:admin_last_name, 
					dob:dob, 
					dod:dod, 
					city_state_death:city_state_death, 
					memorial_message:memorial_message,
					country:country, 
					zipcode:zipcode, 
					state:state, 
					first_name:first_name, 
					last_name:last_name, 
					username:username, 
					user_password:user_password, 
					confirm_user_password:confirm_user_password, 
					relationship_loved_one:relationship_loved_one
				},
				
			  console.log(data)
		
      $.ajax({
        type: 'POST',
		dataType: 'json',
		url: high_memory.ajax_url,
		data:data,  
       success: function(data){
					if (data.res == true){
						console.log(data.message);    // success message
					}else{
						console.log(data.message);    // fail
					}
					
					window.location.href("https://staging.memorialkeeper.com/dashboard-view/");
				}
			  })
      
    });
  })// the end