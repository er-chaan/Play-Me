<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Enjoy quick and easy online betting with Play-me">
    <meta name="author" content="Er-Chaan">
    <title>Play-Me | Online Betting Portal</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/matrix-login.css'); ?>" />
        <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
    <div id="message-warning-signup" class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#"></a>
                        <h4 class="alert-heading">Error!</h4>
                        <h4>wait for 5 seconds</h4>
                        <div id="message-warning-signup-msg"></div>
                </div> 
        <div id="loginbox">           
            <form id="loginform" class="form-vertical">
                
				 <div class="control-group normal_text"> <h3><a href="../../web/"><img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo" /></a></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="email" id="signup_email" placeholder="Email" required="true" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" id="signup_password" placeholder="Password" required="true" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-phone"></i></span><input type="number" id="signup_contact" placeholder="Mobile" required="true" min ="1111111111" max="9999999999"/>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><a type="submit" id="signup_submit" class="btn btn-success" /> Register</a></span>
                </div>
            </form>
            <form id="recoverform" class="form-vertical">
                <div id="message-warning-recover" class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Error!</h4>
                        <div id="message-warning-recover-msg"></div>
                </div>
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="email" id="recover_email" placeholder="E-mail address" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to signup</a></span>
                    <span class="pull-right"><a class="btn btn-info" id="recover_submit"/>Recover</a></span>
                </div>
            </form>
        </div>
        
        <!--<script src="<?php //echo base_url('assets/js/jquery.min.js'); ?>"></script>-->  
        <script src="<?php echo base_url('assets/js/matrix.login.js'); ?>"></script> 
        <script type="text/javascript">

            $('#message-warning-signup').hide();
            $('#message-warning-recover').hide();
            $('form#loginform #signup_submit').click(function() {
              var signup_email = $('#loginform #signup_email').val();
              var signup_password = $('#loginform #signup_password').val();
              var signup_contact = $('#loginform #signup_contact').val();
              var data = 'signup_email=' + signup_email + '&signup_password=' + signup_password + '&signup_contact=' + signup_contact;

              $.ajax({

                  type: "POST",
                  url: "register",
                  data: data,
                  success: function(msg) {

                    if (msg) {
                       $('#message-warning-signup').show();
                       $('#message-warning-signup-msg').html(msg); 
                    }
                    else
                    {
                       $('#message-warning-signup').hide(); 
                       $(location).attr('href', 'dashboard'); 
                    }
                    $('#loginbox').hide();
                    setTimeout(location.reload.bind(location), 5000);
                  }

              });
              return false;
           });
            $('form#recoverform #recover_submit').click(function() {
              var recover_email = $('#recoverform #recover_email').val();
              var data = 'recover_email=' + recover_email;

              $.ajax({

                  type: "POST",
                  url: "recover",
                  data: data,
                  success: function(msg) {

                    if (msg) {
                       $('#message-warning-recover').show();
                       $('#message-warning-recover-msg').html(msg); 
                    }
                    else
                    {
                       $('#message-warning-recover').hide();
                    }

                  }

              });
              return false;
           });

        </script>
    </body>

</html>
