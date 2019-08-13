<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-4 col-md-offset-4 col-lg-offset-4 col-lg-4">
			<h2 class="text-center">Item Finder</h2>
			<div class="panel panel-primary">
				<div class="panel-heading">Change Password</div>
				<div class="panel-body">
					<form class="form-horizontal" action="../../forgot/update" method="post">
						<div class="form-group">
							<div class="col-sm-12">
								<div class='input-group'>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-user"></span>
									</span>
									<input type="email" class="form-control" name="emailId" placeholder="Email" readonly="readonly" value="<?= $user['emailId'] ?>" /> 
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
							<div class="col-sm-12">
								<div class='input-group'>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-pencil"></span>
									</span>
									<input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password"  required="required"/> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6">
								<h5><?php echo $this->session->flashdata('message'); ?></h5>
							</div>
							<div class="col-sm-6 text-right">
								<button type="submit" class="btn btn-primary">Change Password</button>
							</div>
						</div>
						<div class="col-sm-12 text-center">
							<a href="login">Return to Login</a><br/>
							<a href="register">New User? Register</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>