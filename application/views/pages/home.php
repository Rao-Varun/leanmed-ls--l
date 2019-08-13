<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-6 col-lg-offset-3">
			<div class="panel">
				<div class="ui-widget">
					<input class="form-control" id="search" name="search" placeholder="Search Medicine" />
				</div>
			</div>
		</div>
	</div>
	<div class="row" style="height: 480px; overflow-y: auto;">
	</div>
			<!--<div id="searchResults" class="panel panel-primary" style="display: none;">
				<div class="panel-heading">Search Results</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3"><b>Item Name :</b></div>
						<div id="itemName" class="col-sm-9"></div>
					</div>
					<div class="row">
						<div class="col-sm-3"><b>Item Type :</b></div>
						<div id="itemType" class="col-sm-9"></div>
					</div>
					<div class="row">
						<div class="col-sm-3"><b>Item Description :</b></div>
						<div id="itemDesc" class="col-sm-9"></div>
					</div>
					<div class="row">
						<div class="col-sm-3"><b>Item Location :</b></div>
						<div id="storageLoc" class="col-sm-9"></div>
					</div>
					<div class="row">
						<div class="col-sm-3"><b>Room Name :</b></div>
						<div id="roomName" class="col-sm-9"></div>
					</div>
					<div class="row">
						<div class="col-sm-3"><b>Updated By :</b></div>
						<div  id="updatedBy" class="col-sm-9"></div>
					</div>
				</div>-->
</div>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>	
	<script type="text/javascript">
        $(document).ready(function() {
		    $(".nav").find(".nav-active").removeClass("nav-active");
			$('#lookupHeader').addClass("nav-active");
		});
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/home.js"></script>