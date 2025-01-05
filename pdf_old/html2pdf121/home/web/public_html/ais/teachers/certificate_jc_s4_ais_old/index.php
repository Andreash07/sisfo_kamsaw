<html>
<head>
<title>Bina Bangsa School</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link href="css/font-awesome.min.css" type="text/css" rel="stylesheet">
<link href="css/AdminLTE.css" type="text/css" rel="stylesheet">
<link href="css/jQueryUI/jquery-ui-1.11.css" type="text/css" rel="stylesheet">
<script src="js/number.js" type="text/javascript"></script>
	<script src="jquery/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/get_data.js?version=<?php echo time(); ?>"></script>
<head>
<body>
<?php
$class=$_GET['classroom'];
$camp=$_GET['camp'];
$room_id=$_GET['room_id'];
$level_id=$_GET['level_id'];
?>
<input type="hidden" id="campus" value="<?php echo $camp; ?>"\>
<input type="hidden" id="kelas" value="<?php echo $class; ?>"\>
<input type="hidden" id="room_id" value="<?php echo $room_id; ?>"\>
<input type="hidden" id="level_id" value="<?php echo $level_id; ?>"\>
<div class="tab-content bg-search form-horizontal" style="width:500px; height:300px; margin-left:10px; margin-top:10px; padding-left:20px; box-shadow: 3px 4px 5px gray;">
	<ul class="nav nav-tabs">
        <li class="header">
            <h4><i class="fa fa-ellipsis-v small"></i> <?php echo "Search"; ?></h4>
        </li>
    </ul>
	<div class="form-group">
		<label class="col-sm-2 text-left" style="width:150px">Graduate Date</label>
		<div id="graduation_date" class="col-sm-2"></div>
	</div>
</div>
	<button style="margin-left:10px;" button id="generate" class="btn btn-sm btn-primary">Generate</button>
	<button style="margin-left:10px;" button id="generate_ecert" class="btn btn-sm btn-primary">Generate E-Certificate</button>
	<div id="variabel"> </div>
	<br>
	<br>
	<br>
 </body>
 </html>