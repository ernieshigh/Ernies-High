<?php
/***
	*
	*  Hard code form into Contavt us page tempalte
	* 

***/


include get_theme_file_path('/inc/high-form.php');



?>

<style>
	.robot {
		display: none;
	}
</style>
<div class="container page-container">

	<div class="page-meta" role="header">
		<h1 class="page-title"> <?php get_the_title(); ?> </h1>
	</div>

	<article class="page-entry">

		<?php the_content(); ?>

	</article>

	<section class="form-section">
		<div id="high_thanks" style="display: none;">
			<h2> Thank you for reaching out</h2>
			<p> It takes me a day or so to answer these. </p>

		</div>
		<div class="form-wrap">
			<form id="high_contact" class="high-form contact-form" method="POST" action="">

				<small class="error-message"></small>
				<input type="text" id="high_name" name="high_name" placeholder="Name">

				<small class="error-message"></small>
				<input type="email" id="high_email" name="high_email" placeholder="Email">

				<small class="error-message"></small>
				<select id="high_reason" name="high_reason">
					<option value="">Choose a reason</option>
					<option value=" Looking to get an estimate">Looking to get an estimate</option>
					<option value="Have a question">Have a question</option>
					<option value="Just want to talk to someone">Just want to talk to someone</option>
				</select>

				<small class="error-message"></small>
				<input type="text" id="high_subject" name="high_subject" placeholder="Subject">

				<small class="error-message"></small>
				<textarea id="high_message" name="high_message" placeholder="Message"></textarea>

				<label for="high_term" class="check"><small class="error-message"></small>
					<input type="checkbox" id="high_term" name="high_term">
					I understand that this form is for demostrative purposes. It does save my input to the database.
					However, your information will not be used in any way, shape or form and will be automatically
					deleted in 24hrs. Ernies High does not use cookies. <span class="red" class="red">*</span>
				</label>

				<button id="high_submit" class="g-recaptcha" data-sitekey="6Lfj-VMqAAAAAC1_jUJ2GKogONZsXILMF-Z0eAv1"
					data-callback="onSubmit">Submit</button>
			</form>

			<?php //print_r( $_POST ) ?>
		</div>


		<script>

			/*
						window.addEventListener('load', () => {
							let high_form = document.getElementById('high_contact');
							let high_name = document.getElementById('high_name');
							let high_email = document.getElementById('high_email');
							let high_reason = document.getElementById('high_reason');
							let high_subject = document.getElementById('high_subject');
							let high_message = document.getElementById('high_message');
							let high_term = document.getElementById('high_term');
							let submit_button = document.getElementById('high_submit');
			
							let high_thanks = document.getElementById('high_thanks');
			
							const emailIsValid = email => {
								return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
							}
			
			
			
			
							let validate = (e) => {
								e.preventDefault();
			
								if (high_name.value === "") {
			
									high_name.parentNode.querySelector('small.error-message').innerHTML = 'You have a name?';
									high_name.style.borderColor = '#F70000';
									return false;
								}
			
								if (high_email.value === "") {
			
									high_email.parentNode.querySelector('small.error-message').innerHTML = 'You need an email';
									high_email.style.borderColor = '#F70000';
									return false;
								}
								if (!emailIsValid(high_email.value)) {
									high_email.parentNode.querySelector('small.error-message').innerHTML = 'Please enter a valid email address';
									high_email.style.borderColor = '#F70000';
									high_email.focus();
									return false;
								}
			
								if (high_reason.value == "") {
			
									high_reason.parentNode.querySelector('small.error-message').innerHTML = 'Please make a selection';
									high_reason.style.borderColor = '#F70000';
									return false;
								}
			
								if (high_subject.value === "") {
			
									high_subject.parentNode.querySelector('small.error-message').innerHTML = 'Please add a subject to discuss.';
									high_subject.style.borderColor = '#F70000';
									return false;
								}
			
								if (high_message.value === "") {
			
									high_message.parentNode.querySelector('small.error-message').innerHTML = 'What have you got on your mind?';
									high_message.style.borderColor = '#F70000';
									return false;
								}
								if (high_term.checked == false) {
									high_term.parentNode.querySelector('small.error-message').innerHTML = 'You gotta check the box';
									high_term.style.borderColor = '#F70000';
									return false;
								}
			
								high_thanks_message();
								 alert('wtf')
								//return true; // Can submit the form data to the server
							}
			
						 function high_thanks_message() {
			
								high_form.style.display = 'none';
								high_thanks.style.display = 'block';
			
							}
			
			
						}); */

			function onSubmit(token) {
				document.getElementById("high_contact").submit();
			}

		</script>
	</section>
</div>