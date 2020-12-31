<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<title>Student Home</title>
		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<style type="text/css">
			header, main, footer {
					padding-left: 298px;
				}

				@media only screen and (max-width : 992px) {
					main {
						padding-left: 0;
					}
				}
		</style>
	</head>
	<body>
		<!-- NAVBAR -->
		<nav>
			<div class="nav-wrapper">
				<a href="#" class="brand-logo center">Logo</a>
				<a href="#" data-target="slide-out" class="sidenav-trigger left show-on-large"><i class="material-icons">menu</i></a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li><a href="<?php echo base_url("home/logout") ?> "><i class="material-icons">power_settings_new</i></a></li>
				</ul>
			</div>
		</nav>
		<!-- SIDENAV -->
		<ul id="slide-out" class="sidenav sidenav-fixed">
    		<li><div class="user-view">
				<!--
      			<div class="background">
        			<img src="images/office.jpg">
      			</div>
				-->
				<!--<a href="#user"><img class="circle" src="images/yuna.jpg"></a>-->
				<span class="black-text name"><?php echo $this->session->userdata("name") ?></span>
				<span class="black-text email"><?php echo $this->session->userdata("user_id") ?></span>
    		</div></li>
			<li><div class="divider"></div></li>
			<li class="active"><a href="<?php echo base_url("student/dashboard") ?>"><i class="material-icons">dashboard</i>Dashboard</a></li>
			<li><a class="waves-effect" href="<?php echo base_url('student/my_permit') ?>"><i class="material-icons">directions_car</i>My Permit</a></li>
			<li><a class="waves-effect" href="#!"><i class="material-icons">email</i>Messages</a></li>
		</ul>
		  
		<main>
			<?php if ($this->session->flashdata('has_pending_report')) { ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= $this->session->flashdata('has_pending_report') ?>
					<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col s6">
					<div style="padding: 35px;" align="center" class="card">
						<div class="row">
							<div class="left card-title">
							<b>Permit</b>
							</div>
						</div>

						<div class="row">
							<a href="<?php echo base_url("student/apply_permit") ?>">
							<div style="padding: 30px;" class="grey lighten-3 col s5 waves-effect">
								<i class="red-text text-lighten-1 large material-icons">fact_check</i>
								<span class="red-text text-lighten-1"><h5>Apply Permit</h5></span>
							</div>
							</a>
							<div class="col s1">&nbsp;</div>
							<div class="col s1">&nbsp;</div>

							<a href="<?php echo base_url("student/file_report") ?>">
							<div style="padding: 30px;" class="grey lighten-3 col s5 waves-effect">
								<i class="red-text text-lighten-1 large material-icons">report_problem</i>
								<span class="red-text text-lighten-1"><h5>Make Report</h5></span>
							</div>
							</a>
						</div>
					</div>
				</div>
				<!-- MAKE REPORT FAILED MESSAGE -->
				<?php if ($this->session->flashdata('permit_required')) { ?>
					<p class="red-text"><?= $this->session->flashdata('permit_required') ?></p>
				<?php } ?>
			</div>
		</main>

		<script
			src="https://code.jquery.com/jquery-3.5.1.min.js"
			integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script>
			$(document).ready(function(){
    			$('.sidenav').sidenav();
  			});
		</script>
	</body>
</html>