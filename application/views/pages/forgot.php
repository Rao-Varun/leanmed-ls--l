<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-4 col-md-offset-4 col-lg-offset-4 col-lg-4">
			<h2 class="text-center">Find It!</h2>
			<div class="panel panel-primary">
				<div class="panel-heading">Forgot Password</div>
				<div class="panel-body">
					<form class="form-horizontal" method="post" action="forgot/forgotpass">
						<div class="form-group">
							<div class="col-sm-12">
								<div class='input-group'>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-envelope"></span>
									</span>
									<input type="email" class="form-control" name="emailId" placeholder="Email"  required="required"/> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6">
								<a href="login">Return to Login</a>
							</div>
							<div class="col-sm-6 text-right">
								<button type="submit" class="btn btn-primary">Forgot Password</button>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-center">
								<h5><?php echo $this->session->flashdata('message'); ?></h5>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>