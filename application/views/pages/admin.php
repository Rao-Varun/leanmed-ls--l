<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<ul class="nav nav-tabs nav-justified">
				<li role="presentation" class="active"><a  data-toggle="tab" href="#approvals">Manage Approvals</a></li>
				<li role="presentation"><a data-toggle="tab" href="#users">Manage Users</a></li>
			</ul>
			<div class="tab-content">
				<div id="approvals" class="tab-pane fade in active">
					<div class="panel panel-primary">
						<div class="panel-body">
							<table id="approvalsjqGrid" style="width:100%"></table>
		    				<div id="approvalsjqGridPager"></div>
						</div>
					</div>
				</div>
				<div id="users" class="tab-pane fade">
					<div class="panel panel-primary">
						<div class="panel-body">
							<table id="usersjqGrid" style="width:100%"></table>
		    				<div id="usersjqGridPager"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/datatables.min.js"></script>
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
		    $('#approvalsTable').DataTable();
		    $.jgrid.defaults.width = 780;
			$.jgrid.defaults.responsive = true;
			$.jgrid.defaults.styleUI = 'Bootstrap';
		    $(".nav").find(".nav-active").removeClass("nav-active");
			$('#adminHeader').addClass("nav-active");
		});
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/admin.js"></script>