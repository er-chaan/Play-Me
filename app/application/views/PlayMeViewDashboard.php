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
    <h1>Dashboard</h1>
  </div>
<!--End-breadcrumbs-->

  <div class="container-fluid"><!--main container start-->
  <div class="row-fluid">
  <div class="span12">
    <!--Action boxes-->
      <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>My bank
                <div class="quick-actions_homepage">
                  <ul class="quick-actions">
                    <li class="bg_lb"> <a href="javascript:void(0)">Balance<div id="dashboard_accounts_balance"></div></a> </li>
                    <li class="bg_lg"> <a href="javascript:void(0)">Payin<div id="dashboard_total_payin"></div></a></li>
                    <li class="bg_lr"> <a href="javascript:void(0)">Payout<div id="dashboard_total_payout"></div></a></li>
                  </ul>
                </div>
              </h5>
            </div>
      </div>  
    <!--End-Action boxes-->  
<br><br>
    <!--Action boxes-->
    <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>My bets
                <div class="quick-actions_homepage">
                  <ul class="quick-actions">
                    <li class="bg_lb"> <a href="javascript:void(0)">Played<div id="total_played"></div></a> </li>
                    <li class="bg_lg"> <a href="javascript:void(0)">Won<div id="total_won"></div></a> </li>
                    <li class="bg_lr"> <a href="javascript:void(0)">Lost<div id="total_lost"></div></a> </li>
                    <li class="bg_ly"> <a href="javascript:void(0)">No result<div id="total_nr"></div></a> </li> 
                  </ul>
                </div>
              </h5>
            </div>
    </div>
    <!--End-Action boxes-->  

  </div><!--main container end-->
</div>
</div>
</div><!--main container end-->


	<?php include 'structure/_footer.php';?>
  <script type="text/javascript">
  accounts_balance();
  total_payin();
  total_payout();
  total_played();
  total_won();
  total_lost();
  total_nr();
  setInterval(function(){ accounts_balance(); }, 60000);
  setInterval(function(){ total_payin(); }, 60000);
  setInterval(function(){ total_payout(); }, 60000);
  setInterval(function(){ total_played(); }, 60000);
  setInterval(function(){ total_won(); }, 60000);
  setInterval(function(){ total_lost(); }, 60000);
  setInterval(function(){ total_nr(); }, 60000);
    function accounts_balance()
    {
      $('#dashboard_accounts_balance').empty();
      $.ajax({
            url: "accounts_balance",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h2>"+data+"</h2>";
                        $('#dashboard_accounts_balance').append(htmlText);
                    }
            }
        });
    }
    function total_payin()
    {
      $('#dashboard_total_payin').empty();
      $.ajax({
            url: "total_payin",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h2>"+data+"</h2>";
                        $('#dashboard_total_payin').append(htmlText);
                    }
            }
        });
    }
    function total_payout()
    {
      $('#dashboard_total_payout').empty();
      $.ajax({
            url: "total_payout",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h2>"+data+"</h2>";
                        $('#dashboard_total_payout').append(htmlText);
                    }
            }
        });
    }
    function total_played()
    {
      $('#total_played').empty();
      $.ajax({
            url: "total_played",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h3>"+data+"</h3>";
                        $('#total_played').append(htmlText);
                    }
            }
        });
    }
    function total_won()
    {
      $('#total_won').empty();
      $.ajax({
            url: "total_won",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h3>"+data+"</h3>";
                        $('#total_won').append(htmlText);
                    }
            }
        });
    }
    function total_lost()
    {
      $('#total_lost').empty();
      $.ajax({
            url: "total_lost",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h3>"+data+"</h3>";
                        $('#total_lost').append(htmlText);
                    }
            }
        });
    }
    function total_nr()
    {
      $('#total_nr').empty();
      $.ajax({
            url: "total_nr",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h3>"+data+"</h3>";
                        $('#total_nr').append(htmlText);
                    }
            }
        });
    }
  </script>
</body>
</html>