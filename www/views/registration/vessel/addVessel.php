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
  $insertSQL = sprintf("INSERT INTO boats (name, vendor_id, vendor_location, occupancy, dock_location, captain_name, captain_number, vessel_location, vessel_fishing_type) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['vendor_id'], "int"),
                       GetSQLValueString($_POST['vendor_location'], "int"),
                       GetSQLValueString($_POST['occupancy'], "int"),
                       GetSQLValueString($_POST['dock_location'], "text"),
                       GetSQLValueString($_POST['captain_name'], "text"),
                       GetSQLValueString($_POST['captain_number'], "text"),
                       GetSQLValueString($_POST['vessel_location'], "text"),
                       GetSQLValueString($_POST['vessel_fishing_type'], "int"));

  mysql_select_db($database_reeltrips, $reeltrips);
  $Result1 = mysql_query($insertSQL, $reeltrips) or die(mysql_error());

  $insertGoTo = "confirmVendor.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_reeltrips, $reeltrips);
$query_fishing_type = "SELECT * FROM charter_fishing_type";
$fishing_type = mysql_query($query_fishing_type, $reeltrips) or die(mysql_error());
$row_fishing_type = mysql_fetch_assoc($fishing_type);
$totalRows_fishing_type = mysql_num_rows($fishing_type);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Fishing Type</td>
      <td><select name="vessel_fishing_type" id="fishing_type">
        <?php
do {  
?>
        <option value="<?php echo $row_fishing_type['id']?>"><?php echo $row_fishing_type['type']?></option>
        <?php
} while ($row_fishing_type = mysql_fetch_assoc($fishing_type));
  $rows = mysql_num_rows($fishing_type);
  if($rows > 0) {
      mysql_data_seek($fishing_type, 0);
	  $row_fishing_type = mysql_fetch_assoc($fishing_type);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Occupancy:</td>
      <td><input type="text" name="occupancy" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Dock Location:</td>
      <td><input type="text" name="dock_location" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Captain Name:</td>
      <td><input type="text" name="captain_name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Captain Number:</td>
      <td><input type="text" name="captain_number" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Vessel Location:</td>
      <td><input type="text" name="vessel_location" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="add" type="button" id="add" value="Add More">
        <input type="submit" value="Finish">
      <input name="cancel" type="button" id="cancel" value="Cancel"></td>
    </tr>
  </table>
  
  <input type="hidden" name="vendor_id" value="<?php print($_GET['id']); ?>">
  <input type="hidden" name="vendor_location" value="1">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($fishing_type);
?>
