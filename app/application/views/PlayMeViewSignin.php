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
    <div id="message-warning-signin" class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Error!</h4>
                        <h4>wait for 5 seconds</h4>
                        <div id="message-warning-signin-msg"></div>
                </div>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical" action="index.html">  
				 <div class="control-group normal_text"> <h3><a href="../../web/"><img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo" /></a></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="email" placeholder="Email" id="signin_email" required="true" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" placeholder="Password" id="signin_password" required="true" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><a type="submit" class="btn btn-success" id="signin_submit"/> Login</a></span>
                </div>
            </form>
            <form id="recoverform" action="#" class="form-vertical">
            <div id="message-warning-recover" class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#"></a>
                        <h4 class="alert-heading">Error!</h4>
                        <div id="message-warning-recover-msg"></div>
                </div>
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" id="recover_email"/>
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info" id="recover_submit"/>Recover</a></span>
                </div>
            </form>
        </div>
        
        <!--<script src="<?php //echo base_url('assets/js/jquery.min.js'); ?>"></script>-->  
        <script src="<?php echo base_url('assets/js/matrix.login.js'); ?>"></script> 
                <script type="text/javascript">

            $('#message-warning-signin').hide();
            $('#message-warning-recover').hide();
            $('form#loginform #signin_submit').click(function() {
              var signin_email = $('#loginform #signin_email').val();
              var signin_password = $('#loginform #signin_password').val();
              var data = 'signin_email=' + signin_email + '&signin_password=' + signin_password ;

              $.ajax({

                  type: "POST",
                  url: "authentication",
                  data: data,
                  success: function(msg) {

                    if (msg) {
                       $('#message-warning-signin').show();
                       $('#message-warning-signin-msg').html(msg); 
                    }
                    else
                    {
                       $('#message-warning-signin').hide(); 
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
