/***
custom js ajax form

**/

jQuery(document).ready(function ($) {
    
    $('#sh-ajax-login-form').on('submit',function(event){
        event.preventDefault();
        var $this  = $(this);
        var $username = $this.find('#usernameloginajax').val();
        var $password = $this.find('#passwordloginajax').val();
        var $security = $this.find('#security').val();
        var $remember = $this.find('#rememberme').prop('checked');
        
        var $message = $('.ajax-login-message');
        
		alert($username + '-' + $password + ' - ' + $security )
        $message.slideUp(300);
        
        if( $username === "" || $password === "" ){
            $message.html('<p>please fill all fields</p>').slideDown(300);
            return false;
        }

        //var $login_nonce  = $('meta[name="security"]').attr('content');
        //alert($_nonce);
        $.ajax({
            url:data.ajax_url,
            type:'post',
            dataType:'json',
            data : {
                action:'memory_login_form',
                username: $username,
                password: $password,
                remember: $remember,
                security: $security
            },
            success:function(response){

                if( response.error ){
                    $message.html('<p>'+response.message+'</p>').slideDown(300);
                }
                if( response.success ){
                    $message.removeClass('error').addClass('success').html('<p>'+response.message+'</p>').slideDown(300);
                    //window.location.href = 'http://7learn.dev/profile';
                    //window.location.href = data.redirecturlajax;
                }

            },
            error: function () {}

        }).then(function(){
			
				alert('logging')
		
    var  first_name = $('#first_name').val(),
		 last_name = $('#last_name').val(), 
		dob = $('#dob').val(),
		dod = $('#dod').val(),
		city = $('city').val(),
		memorial_message = $('#memorial_message').val(); 
		
		
	data = {
		action: 'create_memorial_with_logged_in', 
			high_nonce: high_memory.high_nonce, 	
			first_name: first_name, 
			last_name: last_name,  
			dob:dob, 
			dod:dod, 
			city:city, 
			memorial_message:memorial_message, 
	}, 
	 
	 console.log(data)
	 alert('wtf')
      
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: high_memory.ajax_url,
		data:data,  
		success: function(data){
			if (data.res == true){
				alert('yea')
						console.log(data.message);    // success message
		 //window.location.href("https://staging.memorialkeeper.com/dashboard-view/");
					}else{
						alert('wtf')
						console.log(data.message);    // fail
		console.log(data)
					}  
		}, 
	});

			
		})
    });
});