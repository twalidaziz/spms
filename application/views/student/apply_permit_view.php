<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<title>Apply Permit</title>
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
		<nav class="red">
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
			<li><a href="<?php echo base_url("student/dashboard") ?>"><i class="material-icons">dashboard</i>Dashboard</a></li>
			<li><a class="waves-effect" href="#!"><i class="material-icons">directions_car</i>My Permit</a></li>
			<li><a class="waves-effect" href="#!"><i class="material-icons">email</i>Messages</a></li>
  		</ul>
        <main>
			<form method="post" action="<?php echo base_url('student/apply_permit_validation'); ?>">
				<div class="row">
					<div class="input-field col s4">
						<?php echo form_dropdown('semester_id', $semester); ?>
						<label>Select semester</label>
					</div>
				</div>

				<!-- APPLICATION SUCCESSFUL MESSAGE -->
				<?php if ($this->session->flashdata('apply_success')) { ?>
					<p class="green-text"><?= $this->session->flashdata('apply_success') ?></p>
				<?php } ?>

				<!-- APPLICATION FAILED MESSAGE -->
				<?php if ($this->session->flashdata('apply_failed')) { ?>
					<p class="red-text"><?= $this->session->flashdata('apply_failed') ?></p>
				<?php } ?>

				<!-- USER HAS PERMIT MESSAGE -->
				<?php if ($this->session->flashdata('has_permit')) { ?>
					<p class="red-text"><?= $this->session->flashdata('has_permit') ?></p>
				<?php } ?>
								
				<!-- VALIDATION ERROR MESSAGE -->
				<p style="color: red"><?php echo validation_errors(); ?></p>
				<center>
					<div class='col s4'>
						<button type='submit' name='btn_apply_permit' class='col s12 btn btn-large waves-effect'>apply</button>
					</div>
				</center>
			</form>
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
            $(document).ready(function(){
                $('select').formSelect();
            });
		</script>
	</body>
</html>