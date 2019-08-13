<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<ul class="nav nav-tabs nav-justified">
				<li role="presentation" class="active"><a data-toggle="tab" href="#problemStatement">Problem Statement</a></li>
				<li role="presentation"><a data-toggle="tab" href="#sitemap">Site Map</a></li>
				<li role="presentation"><a data-toggle="tab" href="#aboutme">About</a></li>
			</ul>
			<div class="tab-content">
				<div id="problemStatement" class="tab-pane fade in active">
					<div class="panel panel-primary">
						<div class="panel-body">
							<h3>Topic</h3>
							<p>The purpose of this project is to create a website that will assist users in finding out the exact location of any household item that they need by simply looking it up on the web page.</p>
							<h3>Reason</h3>
							<p>Our motive stems from the fact that, we all have certain things in our daily lives that we use more frequently than others. Things that we often need in short notices of time when they are required. Since these things tend to be used a lot, they often end up in different places every time. This is true especially in the case of shared items in an apartment. Considering this, it would be helpful to have an interactive inventory system that would catalogue the names of such common items along with their permanent locations.</p>
							<h3>Accomplishments</h3>
							<p>Based on the above need we plan to build an application that will:</p>
							<ol>
								<li>Allow users to sign up and create an admin account or a user account</li>
								<li>Allow admin users to create a “Housing Group”, which includes the layout, item inventory and residents of that house.</li>
								<li>Allow admin users to add or remove users from a “Housing Group”</li>
								<li>Allow users to describe the layout of their apartment</li>
								<li>Allow users to create a list of items and specify their location</li>
								<li>Allow users to mark items as shared or personal</li>
								<li>Allow users to perform search for items and display location of the searched item</li>
								<li>Allow users to update and/or delete personal items from the inventory and request for any update and/or delete of shared items to the “Housing Group” admin</li>
								<li>Allow admin users to approve or reject the update/delete request</li>
								<li>Allow users to view the catalog of items in their house</li>
								<li>Notify users if the location of an item is updated or deleted</li>
							</ol>
							<h3>Deliverable</h3>
							<p>By the end of the semester we intend to deliver:</p>
							<ol>
								<li>A full-fledged web application capable of performing the aforementioned tasks.</li>
								<li>A PowerPoint presentation detailing the specifics of the web app.</li>
								<li>A demonstration of the web app.</li>
								<li>A thorough documentation of the web app.</li>
							</ol>
							<h3>Users</h3>
							<p>The primary users of this system will be:</p>
							<ol>
								<li><p>People staying in shared apartments:</p>
									<ul><li>University Students who share apartments</li>
										<li>Bachelors</li>
										<li>Families who own or rent a house</li></ul> </li>
										<li>By extension the application can be implemented as an industrial inventory system</li>
									</ol>
									<h3>Content</h3>
									<p>The main content of our database will include the users , list of items and their locations.
									We shall have a table to store user’s login credentials and other tables to store the items in the user’s house and their exact locations. We are planning to keep a house as an entity which will be mapped to the User Id and the house will be a key to all the items and their locations inside the specific house.</p>

								</div>
							</div>
						</div>
						<div id="sitemap" class="tab-pane fade">
							<div class="panel panel-primary">
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-6">
											<h3>Site Map</h3>
											<ul>
												<li><a href="login">SignIn/SignUp</a></li>
												<li><a href="home">Look Up</a></li>
												<li><a href="inventory">Inventory</a>
													<ul>
														<li><a href="inventory#items">Items</a></li>
														<li><a href="inventory#storage">Storage</a></li>
														<li><a href="inventory#rooms">Rooms</a></li>
													</ul>
												</li>
												<li><a href="activity">Activity Center</a></li>
												<li><a href="admin">Admin</a>
													<ul>
														<li><a href="admin#approvals">Manage Approvals</a></li>
														<li><a href="admin#users">Manage Users</a></li>
													</ul>
												</li>
												<li><a href="about">About</a>
													<ul>
														<li><a href="about#problemStatement">Problem Statement</a></li>
														<li><a href="about#sitemap">Site Map</a></li>
														<li><a href="about#aboutme">About</a></li>
													</ul>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="aboutme" class="tab-pane fade">
							<div class="panel panel-primary">
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12 text-center">
											<h3>Item Finder</h3>
											<p>Item Finder is an academic project to learn and get hands on experience on Web tools. We have used HTML, CSS, Javascript, Jquery, Bootstrap and Code Ignitor for the project</p>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-2 col-lg-offset-3">
											<h4>Name</h4>
											<h5>Vaibhav Naik</h5>
											<h5>Prakhar Sapre</h5>
											<h5>Kaustubh Agnihotri</h5>
											<h5>Mansoor Ali Abbas</h5>
										</div>
										<div class="col-lg-2">
											<h4>UTA ID</h4>
											<h5>1001518044</h5>
											<h5>1001514586</h5>
											<h5>1001554290</h5>
											<h5>1001453343</h5>
										</div>
										<div class="col-lg-2">
											<h4>Email</h4>
											<h5><a href="mailto:vaibhav.naik@mavs.uta.edu">vaibhav.naik@mavs.uta.edu</a></h5>
											<h5><a href="mailto:@mavs.uta.edu">prakhar.sapre@mavs.uta.edu</a></h5>
											<h5><a href="mailto:@mavs.uta.edu">kaustubhsanjiv.agnihotri@mavs.uta.edu</a></h5>
											<h5><a href="mailto:@mavs.uta.edu">mansoor.abbas@mavs.uta.edu</a></h5>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>	
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
		    $(".nav").find(".nav-active").removeClass("nav-active");
			$('#aboutHeader').addClass("nav-active");
		});
    </script>