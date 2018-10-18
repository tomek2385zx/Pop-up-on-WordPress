<!DOCTYPE html>
<?php
/**
*@package LeadsCatcher
*/
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- Pure CSS-->
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
</head>

<?php
//Wordpress functions and enqueue style and script for administrator's panel
define('WP_USE_THEMES', false);
require(ABSPATH . 'wp-load.php');
wp_enqueue_style('adminstyle',plugins_url('/admin.css',__FILE__));
wp_enqueue_script('tags',plugins_url('/assets/tags.js',__FILE__));

// Admin footer modification to delete information about creating with Wordpress
function remove_footer_admin ()
{
    echo '<span id="footer-thankyou"></span>';
}

add_filter('admin_footer_text', 'remove_footer_admin');



//
//Section about uploading images
//
//Allowing this extensions of image files to be uploaded
$allow = array("jpg", "jpeg", "png");

//Destination WHERE images will be uploaded
$todir = get_home_path().'/wp-content/plugins/LeadsCatcher/assets/img/';

if ( !!$_FILES['file']['tmp_name'] ) // is the file uploaded yet?
{
    $info = explode('.', strtolower( $_FILES['file']['name']) ); // whats the extension of the file
    $newfilename = "logo" . '.' . end($info);
    if($newfilename == 'logo.png'){
        if(file_exists($todir.'/logo.jpg')){//Does file exists??
        unlink($todir. '/logo.jpg');
        }
        else
        {

        }

    }
    elseif($newfilename == 'logo.jpg'){
        if(file_exists($todir. '/logo.png')){//Does file exists??
        unlink($todir.'/logo.png');
        }
        else
        {

        }
    }

    if ( in_array( end($info), $allow) ) // is this file allowed
    {
        if ( move_uploaded_file( $_FILES['file']['tmp_name'], $todir . $newfilename ) )
        {
            // the file has been moved correctly
        }
    }
    else
    {
        // error this file ext is not allowed
    }
}
?>
<body>
    <div class="control">
        <div class="czcionka">
            <div class="container-fluid row">
                <div col-xs-12><h1>Control Panel</h1></div>
            </div>
           <form action="" method="POST" enctype="multipart/form-data">
               <div class="container-fluid">
                              <label class="upload">
                                        <!--Upload Button -->
                                        <input type="file" class="upload-default" name="file" id="file">
                                  <span class="upload-custom">Choose logo
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                  </span>
                              </label>
                              <div class="email">
                                  <!--Email input -->
                                <input id="email" name="email" type="text" placeholder="Email">
                              </div>
                          <div class="on">
                              <!--Pop-up disabling Button -->
                             <input type="checkbox" name="onoff" value="true" data-val="true" checked data-toggle="toggle" data-onstyle="primary">
                             <!--Sending form -->
                             <input type="submit" value="Confirm" data-onstyle="primary" style="border: 0;">

                          </div>
              </div>
          </div>
      </div>
          </form>
 <!-- Table with leads -->
           <section>
          <div class="container-fluid "><br><br>
              <div class="control">
                  <form method="POST" action="">
                      <input type="text" name="lead" />
                      <input type="submit" name="lead-submit" value="Add lead">
                  </form>
                  <?php
                  //Checking if Table exist
                  global $wpdb;
                  $lead = $_POST['lead'];
                  $dbname = $wpdb->dbname;
                  $table_name = $wpdb->prefix.'leads';
                  if(!empty($_POST['lead'])){
                    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name)
                      {


                        //Inserting Data


                        $sql = $wpdb->prepare("INSERT INTO `$table_name` (`name`) values (%s)", $lead);
                        $wpdb->query($sql);
                    }


                      //Creating and inserting table if not exist


                      else{
                        $charset_collate = $wpdb->get_charset_collate();

                        $sql = "CREATE TABLE $table_name (
                          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(50) NOT NULL
                        ) $charset_collate;";
                        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                        dbDelta($sql);

                        //Inserting Data
                        $sql = $wpdb->prepare("INSERT INTO `$table_name` (`name`) values (%s)", $lead);
                        $wpdb->query($qry);
                    }
                    }
                    else{}
                  ?>


            </div>
          <div class="tbl-header lead-table">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th>Leads</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content lead-table">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <!-- DATABASE -->
                <?php
                      global $wpdb;
                      $myrows = $wpdb->get_results( "SELECT name FROM wp_leads" );
                      foreach ( $myrows as $print )   {
                        ?>
                        <tr>
                          <td><?php echo $print->name;?></td>
                        </tr>
                    <?php }

                ?>
              </tbody>
            </table>
        </div>
        <div class="col-md-4">
        </div>
      </div>


 <!--Table with clients data-->
          <div class="container-fluid">
          <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th>Client name</th>
                  <th>Tags</th>
                  <th>Email</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <!-- DATABASE CONNECTION -->
          <?php
                global $wpdb;
                $myrows = $wpdb->get_results( "SELECT name,wanted_products,contact FROM wp_clients_catcher" );
                foreach ( $myrows as $print )   {
                  ?>
                  <tr>
                    <td><?php echo $print->name;?></td>
                    <td><?php echo $print->wanted_products;?></td>
                    <td><?php echo $print->contact;?></td>
                  </tr>
              <?php }

          ?>
              </tbody>
            </table>

          </div>
            </div>
          </section>
         </div>
        </div>
    </div>


<?php
//Informations from form
$NewMail = $_POST['email'];
$Activation = $_POST['onoff'];
$owneremail = get_option('admin_email');
update_option_new_admin_email( $owneremail, $NewMail );

?>
</body>
</html>
