<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-body">
					<table id="logTable" class="table table-striped table-bordered" style="width:100%">
						<thead>
				            <tr>
				                <th>Date</th>
				                <th>Activity</th>
				                <th>User</th>
				            </tr>
				        </thead>
				        <tbody>
				        	<?php for($x=0;$x<count($logs);$x++) { ?>
				        	<tr>
				        		<td><?=$logs[$x]['createdDate']?></td>
				        		<td><?=$logs[$x]['log']?></td>
				        		<td><?=$logs[$x]['userId']?></td>
				        	</tr>
				        	<?php } ?>
				        </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/datatables.min.js"></script>
	<script type="text/javascript">
        $(document).ready(function() {
        	$('#logTable').DataTable({
        		"order": [[ 0, 'desc' ]]
        	});
		    $(".nav").find(".nav-active").removeClass("nav-active");
			$('#activityHeader').addClass("nav-active");
		});
    </script>