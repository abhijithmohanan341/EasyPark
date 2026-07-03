<?php
include("../Connection/Connection.php");
?>
          <?php
		  $placeSel="select * from tbl_place where district_id='".$_GET['did']."'";
		  $placeResult=$Con->query($placeSel);
		  while($placeRow=$placeResult->fetch_assoc())
		  {
		  ?>
          <option value="<?php echo $placeRow['place_id']?>"><?php echo $placeRow['place_name']?></option>
          <?php
		  }
		  ?>