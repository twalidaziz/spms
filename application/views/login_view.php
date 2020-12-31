<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>IARMS - Log In or Sign Up</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style type="text/css">
        body {
            background-image: url("http://localhost/spms/images/admin.jpeg");
        }
    </style>
</head>

<div id="login">

<!-- ========================= HEADER =========================== -->
    <div class="container">    
        <header class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <h1 align="center">Students Parking Management System</h1>
        </header>
    </div>
<!-- ========================= MAIN CONTENT =========================== -->
    <div class="container">    
        <div id="loginbox" class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">                    
            <div class="panel panel-default" >
                    <div class="panel-heading">
                        <div class="panel-title">Sign In</div>                        
                    </div>
                    <div style="padding-top:30px" class="panel-body" >
                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>                            
                        <form method="post" action="http://localhost/spms/home/login_validation" id="loginform" class="form-horizontal" role="form">                                    
                            <!-- USER ID -->
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="login-userid" type="text" class="form-control" name="user_id" value="<?php echo set_value('user_id'); ?>" placeholder="User ID">                                        
                            </div>
                            <!-- PASSWORD -->
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                            
                            <!-- UPDATE SUCCESSFUL MESSAGE -->
                            <?php if ($this->session->flashdata('signup_success')) { ?>
                                <div align="center" class="alert alert-success"><?= $this->session->flashdata('signup_success') ?></div>
                            <?php } ?>
                        
                            <!-- ERROR MESSAGE -->
                            <p style="color: red"><?php echo $error ?></p>
                            
                            <!-- VALIDATION ERROR MESSAGE -->
                            <p style="color: red"><?php echo validation_errors(); ?></p>
                            
                            <!-- REMEMBER ME -->    
                            <div class="input-group">
                                <div class="checkbox">
                                    <label>
                                        <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me</input>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- LOGIN BUTTON -->   
                            <div style="margin-top:10px" class="form-group">
                                <div class="col-sm-12 controls">
                                  <button name="login_submit" class="btn btn-success">Log In</button>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                        <!-- SIGN UP -->
                                        <div style="float:left; font-size: 100%; position: relative; top:-10px">    
                                            <a href="<?php echo base_url()."main/signup" ?>" onClick="$('#loginbox').hide(); $('#signupbox').show()">Sign Up Here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>                     
                </div>  
            </div>         
        </div>
        <!-- IARMS LOGO -->
        <?php include 'parking_logo.php'; ?>

        <!-- UNITEN LOGO -->
        <?php include 'uniten_logo.php'; ?>
    </div>        
</div>
</html>