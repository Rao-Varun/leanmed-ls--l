<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-4 col-md-offset-4 col-lg-offset-4 col-lg-4" >
			<div class="panel panel-primary margin-style">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<h1 class="text-center">LeanMed</h1>
							<p class="text-center">Small Description</p>
						</div>
						<div class="col-sm-4 col-sm-offset-4">
							<img src="<?php echo base_url(); ?>images/logo1.png" alt="app logo" width="100%" class="pull-center"/>
						</div>
					</div>
					<form class="form-horizontal" action="home/login" method="post">
						<div class="form-group">
							<div class="col-sm-12">
								<div class='input-group'>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-user"></span>
									</span>
									<input type="email" class="form-control" name="emailId" placeholder="Email" required="required" /> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class='input-group'>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-pencil"></span>
									</span>
									<input type="password" class="form-control" name="password" placeholder="Password"  required="required"/> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<h5><?php echo $this->session->flashdata('message'); ?></h5>
							</div>
							<div class="col-sm-4 text-right">
								<button type="submit" class="btn btn-primary">Login</button>
							</div>
						</div>
						<div class="col-sm-12 text-center">
							<a href="forgot">Forgot Password?</a><br/>
							<a href="register">New User? Register</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>