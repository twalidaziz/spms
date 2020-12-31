<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sign up</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
      body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
      }

      main {
        flex: 1 0 auto;
      }

      body {
        background: #fff;
      }

      .input-field input[type=date]:focus + label,
      .input-field input[type=text]:focus + label,
      .input-field input[type=email]:focus + label,
      .input-field input[type=password]:focus + label {
        color: #e91e63;
      }

      .input-field input[type=date]:focus,
      .input-field input[type=text]:focus,
      .input-field input[type=email]:focus,
      .input-field input[type=password]:focus {
        border-bottom: 2px solid #e91e63;
        box-shadow: none;
      }
      body {
          background-image: url("http://localhost/spms/images/admin.jpeg");
      }
    </style>
  </head>

  <body>
    <div class="section"></div>
    <main>
      <center>
        <div class="section"></div>
        <h5 class="black-text">Student Parking Management System</h5>
        <div class="section"></div>
        <div class="section"></div>

        <div class="container">
          <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

            <form class="col s12" method="post" action="<?php echo base_url('home/signup_validation'); ?>">
              <div class='row'>
                <div class='col s12'>
                </div>
              </div>

              <div class='row'>
                <div class='input-field col s6'>
                  <input class='validate' type='text' name='user_id' value="<?php echo set_value('user_id'); ?>" id='user_id' />
                  <label for='user_id'>Enter your user ID</label>
                </div>
                <div class='input-field col s6'>
                  <input class='validate' type='password' name='password' id='password' />
                  <label for='password'>Enter your password</label>
                </div>
              </div>
              <div class='row'>
                <div class='input-field col s12'>
                  <input class='validate' type='text' name='name' id='name' />
                  <label for='name'>Enter your full name</label>
                </div>
              </div>
              <div class='row'>
                <div class='input-field col s6'>
                  <input class='validate' type='email' name='email' id='email' />
                  <label for='email'>Enter your email address</label>
                </div>
                <div class='input-field col s6'>
                  <input class='validate' type='text' name='phone_no' id='phone_no' />
                  <label for='phone_no'>Enter your phone number</label>
                </div>
              </div>

              <!-- SIGNUP FAILED MESSAGE -->
              <?php if ($this->session->flashdata('signup_failed')) { ?>
                  <p class="red-text"><?= $this->session->flashdata('signup_failed') ?></p>
              <?php } ?>
                            
                <!-- VALIDATION ERROR MESSAGE -->
                <p style="color: red"><?php echo validation_errors(); ?></p>

              <br />
              <center>
                <div class='row'>
                  <button type='submit' name='btn_signup' class='col s12 btn btn-large waves-effect indigo'>Sign up</button>
                </div>
                <div class="row">
                  <label>
                    <b class="black-text">Already have an account? </b><a class="indigo-text" href="<?php echo base_url("home/login") ?>"><b>Log in here.</b></a>
                  </label>
                </div>
              </center>
            </form>
          </div>
        </div>
        <!--
        <a href="#!">Create account</a>
        -->
      </center>

      <div class="section"></div>
      <div class="section"></div>
    </main>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $('.button-collapse').sideNav();
        $('.collapsible').collapsible();
        $('select').material_select();
    </script>
  </body>
</html>