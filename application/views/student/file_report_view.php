<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
		<link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css" rel="stylesheet">
		<link href="<?php echo base_url('css/styles.css') ?>" rel="stylesheet">
		<title>File a Report</title>	
	</head>
	<body>
		<nav class="navbar navbar-dark bg-danger p-3">
			<div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
				<a class="navbar-brand" href="#">
					SPMS
				</a>
				<button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>
			<div class="col-12 col-md-4 col-lg-2">
				<input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search">
			</div>
			<div class="col-12 col-md-5 col-lg-8 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
				<a href="<?php echo base_url('home/logout') ?>" class="btn btn-outline-light"><i data-feather="log-out"></i><span class="ml-2">Log out</span></a>
			</div>
		</nav>
		<div class="container-fluid">
			<div class="row">
				<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">				
					<div class="position-sticky pt-md-8">
						<ul class="nav flex-column">
							<li class="nav-item">
								<a class="nav-link" aria-current="page" href="<?php echo base_url('student/dashboard') ?>">
									<i data-feather="home"></i>
									<span class="ml-2">Dashboard</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active" href="<?php echo base_url('student/my_permit') ?>">
									<i data-feather="file-text"></i>
									<span class="ml-2">My Permit</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url('student/profile/'.$this->session->userdata('id')) ?>">
									<i data-feather="user"></i>
									<span class="ml-2">Profile</span>
								</a>
							</li>
						</ul>
					</div>
				</nav>

				<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
					<!-- VALIDATION ERROR MESSAGE -->
					<p class="red-text"><?php echo validation_errors(); ?></p>

					<?php if ($this->session->flashdata('file_report_success')) { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('file_report_success') ?>
							<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php } ?>
					<?php if ($this->session->flashdata('file_report_failed')) { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('file_report_failed') ?>
							<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php } ?>
					<div class="row">
						<div class="col-12 col-xl-12 mb-4 mb-lg-0">
							<div class="accordion" id="accordionExample">
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingOne">
										<button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											<b>File Report</b>
										</button>
									</h2>
									<form method="post" action="<?php echo base_url('student/file_report_validation'); ?>">
										<div id="collapseOne" class="accordion-collapse multi-collapse collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
											<div class="accordion-body bg-light">
												<div class="mb-3 row">
													<label class="col-sm-2 col-form-label"><b>Name:</b></label>
													<div class="col-sm-4">
														<input type="text" readonly class="form-control-plaintext" style="text-transform:capitalize" value="<?php echo $this->session->userdata("name") ?>">
													</div>
												</div>
												<div class="mb-3 row">
													<label class="col-sm-2 col-form-label"><b>User ID:</b></label>
													<div class="col-sm-4">
														<input type="text" readonly class="form-control-plaintext" style="text-transform:uppercase" value="<?php echo $this->session->userdata("user_id") ?>">
													</div>
												</div>
												<div class="form-floating">
													<textarea name="description" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
													<label for="floatingTextarea2">Brief description</label>
												</div>

												<div class="mb-3 row" style="padding-top:20px">
													<div class="col-sm-12">
														<button name="report_submit" class="btn btn-primary float-right">
															Submit
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
								<!--
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTwo">
										<button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											<b>Permit details</b>
										</button>
									</h2>
									<div id="collapseTwo" class="accordion-collapse multi-collapse collapse" aria-labelledby="headingTwo">
										<div class="accordion-body bg-light">
											<?php if($permit == null) { ?>
												<h4 align="center">User has no permit</h4>
											<?php } else { ?>
												<div class="mb-3 row">
													<label class="col-sm-2 col-form-label"><b>Semester:</b></label>
													<div class="col-sm-4">
														<input type="text" readonly class="form-control-plaintext" style="text-transform:capitalize" value="<?php echo $permit[0]->value; ?>">
													</div>
													<label class="col-sm-2 col-form-label"><b>Start date:</b></label>
													<div class="col-sm-4">
														<input type="text" readonly class="form-control-plaintext" value="<?php echo date("d-m-Y", strtotime($permit[0]->start_date)); ?>">
													</div>
												</div>
												<div class="mb-3 row">
													<label class="col-sm-2 col-form-label"><b>Parking #:</b></label>
													<div class="col-sm-4">
														<?php if($parking == null) { ?>
															<input type="text" readonly class="form-control-plaintext" value="N/A">
														<?php } else { ?>
															<input type="text" readonly class="form-control-plaintext" value="<?php echo $parking[0]->parking_no; ?>">
														<?php } ?>
													</div>
													<label class="col-sm-2 col-form-label"><b>End date:</b></label>
													<div class="col-sm-4">
														<input type="text" readonly class="form-control-plaintext" value="<?php echo date("d-m-Y", strtotime($permit[0]->end_date)); ?>">
													</div>
												</div>
												<div class="mb-3 row">
													<label class="col-sm-2 col-form-label"><b>Permit status:</b></label>
													<div class="col-sm-4" style="text-transform:capitalize">
														<?php if($permit_status[0]->value == "active") { ?>
															<h5><span class="badge bg-success"><?php echo $permit_status[0]->value; ?></span><h5>
														<?php } else { ?>
															<h5><span class="badge bg-danger"><?php echo $permit_status[0]->value; ?></span><h5>
														<?php } ?>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								-->
							</div>
						</div>
						
						<!--
						<div class="col-6 col-xl-6 mb-4 mb-lg-0">
							<div class="card bg-light">
								<h5 class="card-header">Permit details</h5>
								<div class="card-body">
									<div class="mb-3 row">
										<label class="col-sm-4 col-form-label"><b>Semester:</b></label>
										<div class="col-sm-8">
											<input type="text" readonly class="form-control-plaintext" style="text-transform:uppercase" value="<?php echo $user[0]->user_id; ?>">
										</div>
									</div>
									<div class="mb-3 row">
										<label class="col-sm-4 col-form-label"><b>Issued date:</b></label>
										<div class="col-sm-8">
											<input type="text" name="name" class="form-control" value="<?php echo $user[0]->name; ?>">
										</div>
									</div>
									<div class="mb-3 row">
										<label class="col-sm-4 col-form-label"><b>Exp. date:</b></label>
										<div class="col-sm-8">
											<input type="text" name="email" class="form-control" value="<?php echo $user[0]->email; ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
						-->
					</div>
				</main>
			</div>
		</div>
		<script
			src="https://code.jquery.com/jquery-3.5.1.min.js"
			integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			crossorigin="anonymous"></script>
		<script 
			src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 
			integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" 
			crossorigin="anonymous"></script>
		<script 
			src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" 
			integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" 
			crossorigin="anonymous"></script>
		<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
		<script>
  			feather.replace()
		</script>
		<script>
			var myModal = document.getElementById('myModal')
			var myInput = document.getElementById('myInput')

			myModal.addEventListener('shown.bs.modal', function () {
				myInput.focus()
			})
		</script>						
	</body>
</html>