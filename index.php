<?php 
include("server_list.php");
include("whois_class.php");
 error_reporting(E_ALL);
$my_whois = new Whois_domain;
$my_whois->possible_tlds = array_keys($servers); // this is the array from the included server list

if (isset($_POST['submit'])) {
  $my_whois->tld = $_POST['tld'];
  $my_whois->domain = $_POST['domain'];
  $my_whois->free_string = $servers[$_POST['tld']]['free'];
  $my_whois->whois_server = $servers[$_POST['tld']]['address'];
  $my_whois->whois_param = $servers[$_POST['tld']]['param'];
  $my_whois->full_info = (isset($_POST['all_info'])) ? $_POST['all_info'] : "no"; // between "no" and "yes" to get all whois information
  $my_whois->process();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Check Ketersediaan Domain</title>
</head>

<body>
  <h2>Script WHOIS dan Check ketersediaan Domain</h2>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form">
  Nama Domain <input type="text" name="domain" size="30" maxlength="63" value="<?php echo (isset($_POST['domain'])) ? $_POST['domain'] : ""; ?>">
    <?php echo $my_whois->create_tld_select(); // this method generates the select menu woth all tld's ?>
    <br>
  <input name="all_info" type="checkbox" value="yes">Tampilkan Data Whois 
    <input name="submit" type="submit" value="Check">     
  </form>
  <p><?php echo ($my_whois->msg != "") ? $my_whois->msg : ""; ?></p>
  
  <!-- Tampilkan Data Whois jika diinginkan -->
  <?php if ($my_whois->info != "") { ?>
  <h2><?php echo "Whois ".$my_whois->compl_domain."?" ?></h2>
  <blockquote>
    <?php echo nl2br($my_whois->info); ?>
  </blockquote>
  <?php } else {
    echo "no data";
  } ?>
  
</body>
</html>
