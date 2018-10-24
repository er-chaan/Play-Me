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
    <h1>Admin</h1>
  </div>
<!--End-breadcrumbs-->

<div class="container-fluid"><!--main container start-->
  <div class="row-fluid">
    <div class="span12">
     <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Admin stats
                <div class="quick-actions_homepage">
                  <ul class="quick-actions">
                    <li class="bg_lb"> <a href="javascript:void(0)">Users<div id="total_users"></div></a> </li>
                    <li class="bg_ly"> <a href="javascript:void(0)">Matches<div id="total_matches"></div></a></li>
                    <li class="bg_lo"> <a href="javascript:void(0)">Bets<div id="total_bets"></div></a></li>
                    <li class="bg_lg"> <a href="javascript:void(0)">Payin<div id="total_payin"></div></a></li>
                    <li class="bg_lr"> <a href="javascript:void(0)">Payout<div id="total_payout"></div></a></li>
                  </ul>
                </div>
              </h5>
            </div>
      </div> 
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Start bet</h5>
        </div>
        <div class="widget-content nopadding">
          <form id="startBetForm" class="form-horizontal">
            <div id="start_bet_msg_div" class="alert alert-error alert-block">
                    <a class="close" data-dismiss="alert" href="#"></a>
                    <h4 class="alert-heading">Error!</h4>
                    <div id="start_bet_msg"></div>
            </div> 
            <div class="control-group">
              <label class="control-label">Match Date</label>
              <div class="controls">
                <input type="text" class="span11" value="<?php echo date('Y-m-d');?>" id="match_date" required="true"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Team A</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="team A" id="team_A" required="true"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Team A Rate</label>
              <div class="controls">
                <input type="number" step="0.1" max=5 min=0.1 class="span11" placeholder="team A rate" id="team_A_rate" required="true"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Team B</label>
              <div class="controls">
                <input type="text"  class="span11" placeholder="team B" id="team_B" required="true"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Team B Rate</label>
              <div class="controls">
                <input type="number" step="0.1" max=5 min=0.1 class="span11" placeholder="team B rate" id="team_B_rate" required="true"/>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success" id="bet_submit">Save</button>
            </div>
          </form>
        </div>
      </div>

      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
          <h5>Bets in store</h5>
        </div>
        <div class="widget-content nopadding">
          <div id="start_bet_msg_div_x" class="alert alert-error alert-block">
                  <a class="close" data-dismiss="alert" href="#"></a>
                  <h4 class="alert-heading">Error!</h4>
                  <div id="start_bet_msg_x"></div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Match ID</th>
                <th>Date</th>
                <th>Team A</th>
                <th>Team A rate</th>
                <th>Team B</th>
                <th>Team B rate</th>
                <th>Result</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="bets_instore">
             
            </tbody>
          </table>
        </div>
      </div>


    </div>
  </div>
</div><!--main container end-->

</div>


	<?php include 'structure/_footer.php';?>
  <script type="text/javascript">
  $('#start_bet_msg_div').hide();
  $('#start_bet_msg_div_x').hide();
  bets_instore();
  total_users_X();
  total_matches_X();
  total_bets_X();
  total_payin_X();
  total_payout_X();
  setInterval(function(){ total_users_X(); }, 60000);
  setInterval(function(){ total_matches_X(); }, 60000);
  setInterval(function(){ total_bets_X(); }, 60000);
  setInterval(function(){ total_payin_X(); }, 60000);
  setInterval(function(){ total_payout_X(); }, 60000);
  $('form#startBetForm #bet_submit').click(function() {
    var match_date = $('#startBetForm #match_date').val();
    var team_A = $('#startBetForm #team_A').val();
    var team_A_rate = $('#startBetForm #team_A_rate').val();
    var team_B = $('#startBetForm #team_B').val();
    var team_B_rate = $('#startBetForm #team_B_rate').val();
    var data = 'match_date='+match_date+'&team_A='+team_A+'&team_A_rate='+team_A_rate+'&team_B='+team_B+'&team_B_rate='+team_B_rate;
      $.ajax({
          type: "POST",
          url: "start_bet",
          data: data,
          success: function(msg) {
            if (msg) {
              bets_instore();
               $('#start_bet_msg_div').show();
               $('#start_bet_msg').html(msg); 
               $('#start_bet_msg_div').fadeOut(5000);
            }
            else {
               $('#start_bet_msg_div').hide(); 
            }
          }
      });
    return false;
  });
  function total_users_X()
  {
    $('#total_users').empty();
      $.ajax({
            url: "total_users_X",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h2>"+data+"</h2>";
                        $('#total_users').append(htmlText);
                    }
            }
        });
  }
  function total_matches_X()
  {
    $('#total_matches').empty();
      $.ajax({
            url: "total_matches_X",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h2>"+data+"</h2>";
                        $('#total_matches').append(htmlText);
                    }
            }
        });
  }
  function total_bets_X()
  {
    $('#total_bets').empty();
      $.ajax({
            url: "total_bets_X",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h2>"+data+"</h2>";
                        $('#total_bets').append(htmlText);
                    }
            }
        });
  }
  function total_payin_X()
  {
    $('#total_payin').empty();
      $.ajax({
            url: "total_payin_X",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h2>"+data+"</h2>";
                        $('#total_payin').append(htmlText);
                    }
            }
        });
  }
  function total_payout_X()
  {
    $('#total_payout').empty();
      $.ajax({
            url: "total_payout_X",
            success: function(data) {
              //var data = JSON.parse(data);
              var data = jQuery.parseJSON(data);
                    if(data)
                    {
                        var htmlText = "<h2>"+data+"</h2>";
                        $('#total_payout').append(htmlText);
                    }
            }
        });
  }
  function bets_instore()
  {
    $('#bets_instore').empty();
    $.ajax({
          url: "bets_instore",
          success: function(data) {
            //var data = JSON.parse(data);
            var data = jQuery.parseJSON(data);
                  if(data)
                  {
                      var htmlText = '';
                      for ( var key in data ) {
                        htmlText += "<tr><td>"+data[key].mid+"</td><td>"+data[key].date+"</td><td>"+data[key].team_A+"</td><td>"+data[key].team_A_rate+"</td><td>"+data[key].team_B+"</td><td>"+data[key].team_B_rate+"</td><td><input type='text' required='true' id='result_"+data[key].mid+"' value='"+data[key].result+"'></td><td><input type='text' required='true' id='status_"+data[key].mid+"' value='"+data[key].status+"'></td><td><button class='btn btn-success btn-mini' onclick='bet_update("+data[key].mid+")'>update</button> <button class='btn btn-danger btn-mini' onclick='bet_delete("+data[key].mid+")'>delete</button></td></tr>";
                      }
                      $('#bets_instore').append(htmlText);

                  }
          }
      });
  }
  function bet_delete(mid)
  {
    var data = 'mid=' + mid;
    $.ajax({
        type: "POST",
        url: "start_bet_delete",
        data: data,
        success: function(msg) {
          if (msg) {
            bets_instore();
             $('#start_bet_msg_div_x').show();
             $('#start_bet_msg_x').html(msg); 
             $('#start_bet_msg_div_x').fadeOut(5000);
          }
          else
          {
             $('#start_bet_msg_div_x').hide(); 
          }
        }
    });
    return false;
  }
  function bet_update(mid)
  {
    var  result = $('#result_'+mid+'').val();
    var  status = $('#status_'+mid+'').val();
    var data = 'mid=' + mid + '&result=' +result+ '&status=' +status;
    $.ajax({
        type: "POST",
        url: "start_bet_update",
        data: data,
        success: function(msg) {
          if (msg) {
            bets_instore();
             $('#start_bet_msg_div_x').show();
             $('#start_bet_msg_x').html(msg); 
             $('#start_bet_msg_div_x').fadeOut(5000);
          }
          else
          {
             $('#start_bet_msg_div_x').hide(); 
          }
        }
    });
    return false;
  }


  </script>
</body>
</html>