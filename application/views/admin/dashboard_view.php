<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<title>Home</title>
		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

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
			<li class="active"><a class="waves-effect" href="<?php echo base_url("admin/dashboard") ?>"><i class="material-icons">dashboard</i>Dashboard</a></li>
			<li><a class="waves-effect" href="<?php echo base_url("admin/users") ?>"><i class="material-icons">people</i>Users</a></li>
  		</ul>

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