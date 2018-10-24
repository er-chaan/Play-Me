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
    <h1>Games</h1>
  </div>
<!--End-breadcrumbs-->

  <div class="container-fluid"><!--main container start-->

    <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Playing area</h5>
            </div>
            <div class="widget-content nopadding">
            
            <div id="error_message_games_div" class="alert alert-error alert-block">
                    <a class="close" data-dismiss="alert" href="#"></a>
                    <h4 class="alert-heading">Error!</h4>
                    <div id="error_message_games_msg"></div>
            </div>


            <div class="row-fluid">

              <div class="span12">
                <div class="widget-box">
                  <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                    <h5>In play</h5>
                  </div>
                  <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
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
                        </tr>
                      </thead>
                      <tbody id="inplay_matches">

                      </tbody>
                    </table>
                  </div>
                </div>


                <div id="my_bet_team_a">
                  
                </div>

                <div id="my_bet_team_b">
                  
                </div>
                

                <div class="widget-box">
                  <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                    <h5>Your bet</h5>
                  </div>
                  <div class="widget-content nopadding">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Bet ID</th>
                          <th>Date</th>
                          <th>Match ID</th>
                          <th>Team</th>
                          <th>Team rate</th>
                          <th>Bet units</th>
                          <th>Win amount</th>
                          <th>Result</th>
                          <!-- <th>Status</th> -->
                        </tr>
                      </thead>
                      <tbody id="bets_data">
                       
                      </tbody>
                    </table>
                  </div>
                </div>
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
$('#error_message_games_div').hide();
accounts_data();
bets_data();
setInterval(function(){ accounts_data(); }, 60000);
setInterval(function(){ bets_data(); }, 60000);
function accounts_data()
{
  $('#inplay_matches').empty();
  $('#my_bet_team_a').empty();
  $('#my_bet_team_b').empty();
  $.ajax({
        url: "inplay_matches",
        success: function(data) {
          //var data = JSON.parse(data);
          var data = jQuery.parseJSON(data);
                if(data)
                {
                    var htmlText = '';
                    var htmlText_Team_A ='';
                    var htmlText_Team_B ='';
                    for ( var key in data ) {
                      htmlText += "<tr><td>"+data[key].mid+"</td><td>"+data[key].date+"</td><td>"+data[key].team_A+"<a href='#team_A_modal_"+data[key].mid+"' data-toggle='modal'><span class='badge badge-inverse'> >> </span></a></td><td>"+data[key].team_A_rate+"</td><td>"+data[key].team_B+"<a href='#team_B_modal_"+data[key].mid+"' data-toggle='modal'><span class='badge badge-inverse'> >> </span></a></td><td>"+data[key].team_B_rate+"</td><td>"+data[key].result+"</td><td>"+data[key].status+"</td></tr>";

                      htmlText_Team_A +="<input type='hidden' value='"+data[key].team_A+"' id='team_A_"+data[key].mid+"'><div id='team_A_modal_"+data[key].mid+"' class='modal hide'><div class='modal-body'><button data-dismiss='modal' class='close' type='button'>×</button><h5> your bet for : "+data[key].team_A+"</h5><input class='span11' placeholder='Enter Betting Amount' type='number' max=100 min=10 id='amount_A_"+data[key].mid+"'><a data-dismiss='modal' href='#' class='btn btn-info' onclick='place_bet("+data[key].mid+")'>Confirm</a><a data-dismiss='modal' class='btn' href='#' id='close_modal'>Cancel</a></div></div>";

                      htmlText_Team_B +="<input type='hidden' value='"+data[key].team_B+"' id='team_B_"+data[key].mid+"'><div id='team_B_modal_"+data[key].mid+"' class='modal hide'><div class='modal-body'><button data-dismiss='modal' class='close' type='button'>×</button><h5> your bet for : "+data[key].team_B+"</h5><input class='span11' placeholder='Enter Betting Amount' type='number' max=100 min=10 id='amount_B_"+data[key].mid+"'><a data-dismiss='modal' href='#' class='btn btn-info' onclick='place_bet("+data[key].mid+")'>Confirm</a><a data-dismiss='modal' class='btn' href='#' id='close_modal'>Cancel</a></div></div>";

                    $('#my_bet_team_a').append(htmlText_Team_A);
                    $('#my_bet_team_b').append(htmlText_Team_B);
                    }
                    $('#inplay_matches').append(htmlText);
                }
        }
    });
}
function place_bet(mid)
{
  var team_A = $('#team_A_'+mid+'').val(); 
  var amount_A = $('#amount_A_'+mid+'').val(); 
  var team_B = $('#team_B_'+mid+'').val(); 
  var amount_B = $('#amount_B_'+mid+'').val(); 

  if(amount_A != '')
  {
    var data = 'bet_mid=' + mid + '&bet_team=' +team_A+ '&bet_units=' +amount_A;
    $.ajax({
    type: "POST",
    url: "place_bet",
    data: data,
    success: function(msg) {
        if (msg) {
          accounts_data();
          bets_data();
          $('#error_message_games_div').show();
          $('#error_message_games_msg').html(msg); 
          $('#error_message_games_div').fadeOut(5000);
        }
        else
        {
          $('#error_message_games_div').hide();
        }
      }
    });
    $('#amount_A_'+mid+'').val('');
    $('#amount_B_'+mid+'').val('');
    $('#close_modal').trigger('click');
    return false;
  }
  if(amount_B != '')
  {
    var data = 'bet_mid=' + mid + '&bet_team=' +team_B+ '&bet_units=' +amount_B;
    $.ajax({
    type: "POST",
    url: "place_bet",
    data: data,
    success: function(msg) {
        if (msg) {
          accounts_data();
          bets_data();
          $('#error_message_games_div').show();
          $('#error_message_games_msg').html(msg); 
          $('#error_message_games_div').fadeOut(5000);
        }
        else
        {
          $('#error_message_games_div').hide();
        }
      }
    });
    $('#amount_A_'+mid+'').val('');
    $('#amount_B_'+mid+'').val('');
    $('#close_modal').trigger('click');
    return false;
  }
  if(amount_A != '' && amount_B != '')
  {
    $('#error_message_games_div').show();
    $('#error_message_games_msg').html('you need to wait for 1 minute'); 
    $('#error_message_games_div').fadeOut(5000);
  }

}
function bets_data()
{
  $('#bets_data').empty();
  $.ajax({
        url: "users_bets",
        success: function(data) {
          //var data = JSON.parse(data);
          var data = jQuery.parseJSON(data);
                if(data)
                {
                    var htmlText = '';
                    for ( var key in data ) {
                      htmlText += "<tr class='gradeA'><td>"+data[key].bid+"</td><td>"+data[key].date+"</td><td>"+data[key].mid+"</td><td>"+data[key].team+"</td><td>"+data[key].team_rate+"</td><td>"+data[key].bet_units+"</td><td>"+data[key].win_amount+"</td><td>"+data[key].result+"</td><!--<td class='center'>"+data[key].status+"</td>--></tr>";
                    }
                    $('#bets_data').append(htmlText);

                }
        }
    });
}
</script>

</body>
</html>