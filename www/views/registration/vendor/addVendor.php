<?php require_once('Connections/reeltrips.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO vendors (name, location_id, company_address, billing_address, email, phone, website, contact_name) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['location_id'], "int"),
                       GetSQLValueString($_POST['company_address'], "text"),
                       GetSQLValueString($_POST['billing_address'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['website'], "text"),
                       GetSQLValueString($_POST['contact_name'], "text"));

  mysql_select_db($database_reeltrips, $reeltrips);
  $Result1 = mysql_query($insertSQL, $reeltrips) or die(mysql_error());

  $insertGoTo = "addVessel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
	
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo."id=" . mysql_insert_id()));
}

mysql_select_db($database_reeltrips, $reeltrips);
$query_Recordset1 = "SELECT * FROM regions";
$Recordset1 = mysql_query($query_Recordset1, $reeltrips) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);



?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Charter Name:</td>
      <td><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Company Address:</td>
      <td><input type="text" name="company_address" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">City</td>
      <td><input name="city" type="text" id="city" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">State</td>
      <td><input name="city2" type="text" id="city2" size="2"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Zip</td>
      <td><input name="city3" type="text" id="city3" size="5"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Region:</td>
      <td><select name="location_id" id="regions">
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['region_name']?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Billing Address:</td>
      <td><input type="text" name="billing_address" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email:</td>
      <td><input type="text" name="email" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Phone:</td>
      <td><input type="text" name="phone" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Website:</td>
      <td><input type="text" name="website" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Contact Name:</td>
      <td><input type="text" name="contact_name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Next">
      <input name="cancel" type="button" id="cancel" value="Cancel"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($Recordset1);
?>
