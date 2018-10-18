<?php
/**
*@package LeadsCatcher
*/
?>
<!--Links-->
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <?php
    require(ABSPATH . 'wp-load.php');
    ?>
<!--Links END-->
<!--Pop-up-->


<div class="col-sm">
<div class="popup" id="przycisk" ><img src="../../../../wp-content/plugins/LeadsCatcher/assets/img/logo" onclick="popup()"><img id="exit" src="https://d30y9cdsu7xlg0.cloudfront.net/png/18932-200.png" onClick="xhide()">
</div>
</div>


<!--Pop-up END  -->
<!--Window with posts content -->
<!--Window with posts content END  -->
<!--Communicator-->

<div class="containter">
    <div class="row">
      <div class="col-12">
      </div>
        </div>
        <div class="loginBox slide" id="communicator">
          <h2>Hello!<br>What do you want?</h2>
          <form action="" method="POST">
            <input type="text" name="Tags" placeholder="What do you want?">
            <input type="text" name="Imie" placeholder="Name">
            <input type="text" name="Email" placeholder="Email">
            <div class="col-md-6 col-md-offset-3"></div>
            <input type="submit" class="button" value="Submit">
          </form>
        </div>
      </div>
  </div>
</div>

<!--Communicator END-->
<?php
require(ABSPATH . 'wp-load.php');
require(ABSPATH . 'wp-includes/pluggable.php');

//Reciving form data

$who = $_POST['Imie'];
$what = $_POST['Tags'];
$contact = $_POST['Email'];

if(!empty($_POST['Imie']) || !empty($_POST['Tags']) || !empty($_POST['Email']))
{
//    SQL


  global $wpdb;
  $dbname = $wpdb->dbname;
  $table_name = $wpdb->prefix.'clients_catcher';


  //Checking if Table exist


    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name)
      {


        //Inserting Data


        $sql = $wpdb->prepare("INSERT INTO `$table_name` (`name`, `wanted_products`, `contact`) values (%s, %s, %s)", $who, $what, $contact);
        $wpdb->query($sql);
    }


      //Creating and inserting table if not exist


      else{
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(50) NOT NULL,
          wanted_products VARCHAR(50) NOT NULL,
          contact VARCHAR(50) NOT NULL
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        $qry = $wpdb->prepare("INSERT INTO `$table_name` (`name`, `wanted_products`, `contact`) values (%s, %s, %s)", $who, $what, $contact);
        $wpdb->query($qry);


        //Creating Email to owner and client


      }
      //Client info
      $owneremail = get_option('admin_email');
      $subject="We,ve got your order";
      $message = "Hi ".$who." ,we have your order";
      $headers = 'From:' . " ".$owneremail." ";

      //Owner info

      $subjectowner = "Someone is looking for ".$what."";
      $messageowner = " ".$who." is looking for ".$what." contact: ".$contact." ";
      $headersowner = 'From:' . $contact;

      //Sending

      if(wp_mail($contact, $subject, $message, $headers))
      {

      }
      else
      {

      }

      if(wp_mail($owneremail, $subjectowner, $messageowner, $headersowner))
      {

      }
      else
      {

      }

      //Go back to previous location


}
else
{
  //echo "Enter correct values";
}
?>
