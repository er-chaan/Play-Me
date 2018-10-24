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
    <h1>Accounts</h1>
  </div>
<!--End-breadcrumbs-->

  <div class="container-fluid"><!--main container start-->

    <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Accounts utility</h5>
            </div>

            <div class="alert alert-info alert-block">
            <a class="close" data-dismiss="alert" href="#"></a>
            <h4 class="alert-heading">Available play-me balance: <div id="accounts_balance"></div></h4>
            </div>

            <div class="widget-content nopadding">

            <form id="AccountNumberForm" class="form-horizontal">
                <div id="AccountNumberForm-message-div" class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#">x</a>
                        <h4 class="alert-heading">Error!</h4>
                        <div id="AccountNumberForm-message"></div>
                </div>
                <div class="control-group">
                  <label class="control-label">Account number</label>
                  <div class="controls">
                    <input type="number" id="account_number" placeholder="Paytm number" required="true" min ="1111111111" max="9999999999" value="<?php echo $contact;?>" />
                  <input type="submit" value="Update paytm account number" class="btn btn-info" id="account_number_submit">
                  </div>
                </div>
            </form>


            <form id="CashoutForm" class="form-horizontal">
                <div id="CashoutForm-message-div" class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#">x</a>
                        <h4 class="alert-heading">Error!</h4>
                        <div id="CashoutForm-message"></div>
                </div>
                <div class="control-group">
                  <label class="control-label">Cashout</label>
                  <div class="controls">
                    <input type="number" id="cashout_amount" placeholder="Enter amount" required="true" min ="10" max="100" />
                  <input type="submit" value="Withdraw cashout amount" class="btn btn-info" id="cashout_amount_submit">
                  </div>
                </div>
            </form>
            </form>


            <form id="CashinForm" class="form-horizontal">
                <div id="CashinForm-message-div" class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#">x</a>
                        <h4 class="alert-heading">Error!</h4>
                        <div id="CashinForm-message"></div>
                </div>
                <div class="control-group">
                  <label class="control-label">Cashin</label>
                  <div class="controls">
                    <input type="number" id="cashin_amount" placeholder="Enter amount" required="true" min ="10" max="100" value="100" readonly="true" />
                  <input type="submit" value="Buy cashin amount" class="btn btn-info" id="cashin_amount_submit">
                  </div>
                </div>
            </form>


              <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                  <h5>Accounts statement</h5>
                </div>
                <div class="widget-content nopadding">
                <!--<table class="table table-bordered data-table">-->
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Particulars</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                      </tr>
                    </thead>
                    <tbody id="accounts_data">
                    
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

  </div><!--main container end-->

</div><!--main container end-->


	<?php include 'structure/_footer.php';?>
  <script type="text/javascript">

  $('#AccountNumberForm-message-div').hide();
  $('#CashinForm-message-div').hide();
  $('#CashoutForm-message-div').hide();
  accounts_data();
  accounts_balance();
  $('form#AccountNumberForm #account_number_submit').click(function() {
    var account_number = $('#AccountNumberForm #account_number').val();
    var data = 'settings_contact=' + account_number;
    $.ajax({
        type: "POST",
        url: "update_contact",
        data: data,
        success: function(msg) {
          if (msg) {
             $('#AccountNumberForm-message-div').show();
             $('#AccountNumberForm-message').html(msg); 
             $('#AccountNumberForm-message-div').fadeOut(5000);
          }
          else
          {
             $('#AccountNumberForm-message-div').hide(); 
          }
        }
    });
    return false;
  });
  $('form#CashinForm #cashin_amount_submit').click(function() {
    var cashin_amount = $('#CashinForm #cashin_amount').val();
    var data = 'cashin_amount=' + cashin_amount;
    $.ajax({
        type: "POST",
        url: "cashin",
        data: data,
        success: function(msg) {
          if (msg) {
            accounts_data();
            accounts_balance();
             $('#CashinForm-message-div').show();
             $('#CashinForm-message').html(msg); 
             $('#CashinForm-message-div').fadeOut(5000);
          }
          else
          {
             $('#CashinForm-message-div').hide(); 
          }
        }
    });
    return false;
  });
  $('form#CashoutForm #cashout_amount_submit').click(function() {
    var cashout_amount = $('#CashoutForm #cashout_amount').val();
    var data = 'cashout_amount=' + cashout_amount;
    $.ajax({
        type: "POST",
        url: "cashout",
        data: data,
        success: function(msg) {
          if (msg) {
            accounts_data();
            accounts_balance();
             $('#CashoutForm-message-div').show();
             $('#CashoutForm-message').html(msg); 
             $('#CashoutForm-message-div').fadeOut(5000);
          }
          else
          {
             $('#CashoutForm-message-div').hide(); 
          }
        }
    });
    return false;
  });
function accounts_data()
{
  $('#accounts_data').empty();
  $.ajax({
        url: "accounts_data",
        success: function(data) {
          var data = jQuery.parseJSON(data);
          //var data = JSON.parse(data);
                if(data)
                {
                    var htmlText = '';
                    for ( var key in data ) {
                      htmlText += "<tr class='gradeA'><td>"+data[key].date+"</td><td>"+data[key].particulars+"</td><td>"+data[key].debit+"</td><td>"+data[key].credit+"</td><td   >"+data[key].balance+"</td></tr>";
                    }
                    $('#accounts_data').append(htmlText);
                }
        }
    });
}
function accounts_balance()
{
  $('#accounts_balance').empty();
  $.ajax({
        url: "accounts_balance",
        success: function(data) {
          //var data = JSON.parse(data);
          var data = jQuery.parseJSON(data);
                if(data)
                {
                    var htmlText = ""+data+"";
                    $('#accounts_balance').text(data);
                }
        }
    });
}

    </script>
</body>
</html>