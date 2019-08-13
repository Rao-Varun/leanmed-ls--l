<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<ul class="nav nav-tabs nav-justified">
				<li role="presentation" class="active"><a  data-toggle="tab" href="#items">Items</a></li>
				<li role="presentation"><a data-toggle="tab" href="#storage">Storage</a></li>
				<?php if($this->session->userdata('user')['userType'] == 1){?>
				<li role="presentation"><a data-toggle="tab" href="#rooms">Rooms</a></li>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<div id="items" class="tab-pane fade in active">
					<div class="panel panel-primary">
						<div class="panel-body">
							<table id="itemsjqGrid" style="width:100%"></table>
		    				<div id="itemsjqGridPager"></div>
						</div>
					</div>
				</div>
				<div id="storage" class="tab-pane fade">
					<div class="panel panel-primary">
						<div class="panel-body">
							<table id="storagejqGrid" style="width:100%"></table>
		    				<div id="storagejqGridPager"></div>
						</div>
					</div>
				</div>
				<?php if($this->session->userdata('user')['userType'] == 1){?>
				<div id="rooms" class="tab-pane fade">
					<div class="panel panel-primary">
						<div class="panel-body">
							<table id="roomsjqGrid" style="width:100%"></table>
		    				<div id="roomsjqGridPager"></div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/grid.locale-en.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.jqGrid.js"></script>
	<script type="text/javascript">
        $(function() {
          var hash = document.location.hash;
          if (hash) {
            $('.nav-tabs a[href='+hash+']').tab('show');
          }
          $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            window.location.hash = e.target.hash;
          });
        });
        $(document).ready(function() {
        	$.jgrid.defaults.width = 780;
			$.jgrid.defaults.responsive = true;
			$.jgrid.defaults.styleUI = 'Bootstrap';
		    $(".nav").find(".nav-active").removeClass("nav-active");
			$('#inventoryHeader').addClass("nav-active");
			$rooms='<?= $storagerooms ?>';
			$storages='<?= $storages ?>';
			$itemTypes='<?= $itemTypes ?>';
		});
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/inventory.js"></script>