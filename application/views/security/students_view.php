<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
		<link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="<?php echo base_url('css/styles.css') ?>" rel="stylesheet">
		<title>Students</title>	
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
				<div class="text-light" style="padding-right:50px">Logged in as (<?php echo $this->session->userdata("name") ?>)</div>
				<a href="<?php echo base_url('home/logout') ?>" class="btn btn-outline-light"><i data-feather="log-out"></i><span class="ml-2">Log out</span></a>
			</div>
		</nav>
		<div class="container-fluid">
			<div class="row">
				<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">				
					<div class="position-sticky pt-md-8">
						<ul class="nav flex-column">
							<li class="nav-item">
								<a class="nav-link" aria-current="page" href="<?php echo base_url('security/dashboard') ?>">
									<i data-feather="grid">dashboard</i>
									<span class="ml-2">Dashboard</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active" href="<?php echo base_url('security/students') ?>">
									<i data-feather="users"></i>
									<span class="ml-2">Students</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url('security/permits') ?>">
									<i data-feather="file-text"></i>
									<span class="ml-2">Permits</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url('security/parking') ?>">
									<i data-feather="columns"></i>
									<span class="ml-2">Parking</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url('security/semesters') ?>">
									<i data-feather="calendar"></i>
									<span class="ml-2">Semesters</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url('security/reports') ?>">
									<i data-feather="alert-triangle"></i>
									<span class="ml-2">Reports</span>
								</a>
							</li>
						</ul>
					</div>
				</nav>

				<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
					<?php if ($this->session->flashdata('add_success')) { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('add_success') ?>
							<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php } ?>
					<?php if ($this->session->flashdata('add_failed')) { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('add_failed') ?>
							<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php } ?>
					<div class="row">
						<div class="col-12 col-xl-12 mb-4 mb-lg-0">
							<div class="card bg-light">
								<h5 class="card-header">Student List</h5>
								<div class="card-body">
									<div class="table-responsive">
										<table id="myTable" class="table table-sm table-hover">
											<thead>
												<tr>
													<td style="display:none;"></td>
													<td><b>#</b></td>
													<td><b>User ID</b></td>
													<td><b>Name</b></td>
													<td><b>Email</b></td>
													<td><b>Status</b></td>
													<td><b><b></td>
												</tr>
											</thead>
											<?php
												$i = 1;
												$j = 0;
												foreach($student as $row) {
											?>
											<tr>
												<td style="display:none;"><?php echo $row->id;?></td>
												<td><?php echo $i++;?>.</td>
												<td style="text-transform:uppercase"><b><?php echo $row->user_id;?></b></td>
												<td><?php echo $row->name;?></td>
												<td><?php echo $row->email;?></td>
												<td style="text-transform:capitalize">
													<?php if($status[$j]->value == "active") { ?>
														<span class="badge bg-success"><?php echo $status[$j]->value;?></span>
													<?php } else { ?>
														<span class="badge bg-secondary"><?php echo $status[$j]->value;?></span>
													<?php } ?>
												</td>
												<td>
													<a href="<?php echo base_url('security/view_student/'.$row->id) ?>" class="btn btn-sm btn-outline-primary">
														View
													</a>
												</td>
											<?php   
												$j++;
											?>
											<?php   
												}
											?>
											</tr> 
										</table>
									</div>
								</div>
							</div>
						</div>
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
			$(document).ready(function() {
				$('#myTable').DataTable();
			});

			var myModal = document.getElementById('myModal')
			var myInput = document.getElementById('myInput')
			myModal.addEventListener('shown.bs.modal', function () {
				myInput.focus()
			})
		</script>						
	</body>
</html>