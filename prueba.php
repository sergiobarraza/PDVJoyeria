<!DOCTYPE html>
			  	<html>
			  	<head>
			  		<!-- Ignore these prerequisites if you have already included them in your project -->
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
					<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
			  	</head>
			  	<body>
			  		<div class="input-group date" id="datePicker">
					    <input type="text" class="form-control" placeholder="YYYY/MM/DD"/>
					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-calendar"></span>
					    </span>
					</div>

					<script type="text/javascript">
					    $(function() {
					        $("#datePicker").datepicker({
					            // Here you can add any additional parameters
					            format: "yyyy/mm/dd"
					        });
					    });
					</script>
			  	</body>
			  	</html>