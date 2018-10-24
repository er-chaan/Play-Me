<!DOCTYPE html>
<html lang="en">
<?php include 'structure/_head.php';?>
<body>
	<?php include 'structure/_header.php';?>
	<?php include 'structure/_menu.php';?>
	<!--main-container-part-->
<div id="content"><!--main container start-->

<!--breadcrumbs-->
  <div id="content-header"><!--main container start-->
    <div id="breadcrumb"> <a href="dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
    <h1>Settings</h1>
  </div>
<!--End-breadcrumbs-->

  <div class="container-fluid"><!--main container start-->

    <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Security settings</h5>
            </div>
            <div class="widget-content nopadding">
            

            <form id="settingsFormContact" class="form-horizontal">
                <div id="message-warning-settings-contact" class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#"></a>
                        <h4 class="alert-heading">Error!</h4>
                        <div id="message-warning-settings-contact-msg"></div>
                </div>
                <div class="control-group">
                  <label class="control-label">Contact</label>
                  <div class="controls">
                    <input type="number" id="settings_contact" placeholder="Mobile" required="true" min ="1111111111" max="9999999999" value="<?php echo $contact;?>" />
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Update contact" class="btn btn-info" id="settings_submit_contact">
                </div>
              </form>



            <form id="settingsFormPwd" class="form-horizontal">
                <div id="message-warning-settings-pwd" class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#"></a>
                        <h4 class="alert-heading">Error!</h4>
                        <div id="message-warning-settings-pwd-msg"></div>
                </div>
                <div class="control-group">
                  <label class="control-label">Old Password</label>
                  <div class="controls">
                    <input type="password" id="settings_old_password" placeholder="Old Password" required="true" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">New Password</label>
                  <div class="controls">
                    <input type="password" id="settings_new_password" placeholder="New Password" required="true" />
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Update password" class="btn btn-info" id="settings_submit_pwd">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

  </div><!--main container end-->

</div><!--main container end-->


	<?php include 'structure/_footer.php';?>
  <script type="text/javascript">
  $('#message-warning-settings-pwd').hide();
            $('#message-warning-settings-contact').hide();

            $('form#settingsFormPwd #settings_submit_pwd').click(function() {
              var settings_old_password = $('#settingsFormPwd #settings_old_password').val();
              var settings_new_password = $('#settingsFormPwd #settings_new_password').val();
              var data = 'settings_old_password=' + settings_old_password + '&settings_new_password=' + settings_new_password;

              $.ajax({

                  type: "POST",
                  url: "update_password",
                  data: data,
                  success: function(msg) {

                    if (msg) {
                       $('#message-warning-settings-pwd').show();
                       $('#message-warning-settings-pwd-msg').html(msg); 
                       $('#message-warning-settings-pwd').fadeOut(5000);
                    }
                    else
                    {
                       $('#message-warning-settings-pwd').hide(); 
                    }

                  }

              });
              return false;
           });

            $('form#settingsFormContact #settings_submit_contact').click(function() {
              var settings_contact = $('#settingsFormContact #settings_contact').val();
              var data = 'settings_contact=' + settings_contact;

              $.ajax({

                  type: "POST",
                  url: "update_contact",
                  data: data,
                  success: function(msg) {

                    if (msg) {
                       $('#message-warning-settings-contact').show();
                       $('#message-warning-settings-contact-msg').html(msg); 
                       $('#message-warning-settings-contact').fadeOut(5000);
                    }
                    else
                    {
                       $('#message-warning-settings-contact').hide(); 
                    }

                  }

              });
              return false;
            });
        </script>
</body>
</html>