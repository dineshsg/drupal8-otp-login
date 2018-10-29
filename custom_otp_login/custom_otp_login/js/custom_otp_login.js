Drupal.behaviors.custom_otp_login = {
  attach: function (context, settings) {
    var otpBtn = document.getElementById('custom-get-otp');
    /*otpBtn.addEventListener('click', function() {
        jQuery(".region-highlighted").find("div").remove();
		var emailVal = document.getElementById('edit-name').value;
		if(emailVal.length=="0"){
			jQuery(".region-highlighted").prepend("<div><div class='messages__wrapper layout-container'><div role='contentinfo' aria-label='Error message' class='messages messages--error'><div role='alert'><h2 class='visually-hidden'>Error message</h2>Invalid Username!</div></div></div></div>");
		}else{
			
		}
    }, false);*/

  }
};