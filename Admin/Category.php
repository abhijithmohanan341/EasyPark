<?php
include("../Assest/Connection/Connection.php");
$category="";
$eid=0;
if(isset($_POST["btn_submit"]))
{
	$category=$_POST["txt_category"];
	$eid=$_POST['txt_eid'];
	if($eid==0)
	{
	$insQry="insert into tbl_category (category_name) values ('".$category."')";
	if($Con->query($insQry))
	{
		?>
        <script>
		alert("Values Inserted");
		</script>
        <?php
	}
	
}
else
{
	$upQry="update tbl_category set category_name='".$category."' where category_id='".$eid."'";
	if($Con->query($upQry))
	{
		?>
	    <script>
	     alert("Value updated");
	     </script>
         <?php
	}
}
}
if(isset($_GET['did']))
{
	$delQry="delete from tbl_category where category_id=".$_GET['did'];
	if($Con->query($delQry))
	{
		?>
		<script>
		alert("value Deleted.");
		window.location="Category.php";
		</script>
        <?php
    }
}
if(isset($_GET['eid']))
{
	$editSel="select * from tbl_category where category_id='".$_GET['eid']."'";
	$editResult=$Con->query($editSel);
	$editRow=$editResult->fetch_assoc();
	$category=$editRow['category_name'];
	$eid=$editRow['category_id'];
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="200" border="1">
    <tr>
      <td>Category</td>
      <td><label for="txt_category"></label>
      <input type="text" name="txt_category" id="txt_category" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>

  </table>
  <table width="200" border="1">
    <tr>
      <td>Slno</td>
      <td>Category name</td>
      <td>Action</td>
    </tr>
     <?php
	 $i=0;
	$SelQry = "select * from tbl_category";
	$result = $Con->query($SelQry);
	while($row=$result->fetch_assoc())
	{
	$i++;	
	?>
    <tr>
      <td ><?php echo $i ?></td>
      <td><?php echo $row['category_name']; ?></td>
      <td><a href ="Category.php?did=<?php echo $row['category_id']?>">Delete</a>
      <a href ="Category.php?did=<?php echo $row['category_id']?>">Edit</a></td>
      
      
    </tr>
    <?php
	}

	?>
    
  </table>
</form>
</body>
</html>