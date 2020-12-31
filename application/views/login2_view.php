<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Log in</title>
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
        <h5 class="black-text">SPMS</h5>
        <div class="section"></div>
        <div class="section"></div>

        <div class="container">
          <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

            <form class="col s12" method="post" action="http://localhost/spms/home/login_validation">
              <div class='row'>
                <div class='col s12'>
                </div>
              </div>

              <div class='row'>
                <div class='input-field col s12'>
                  <input class='validate' type='text' name='user_id' value="<?php echo set_value('user_id'); ?>" id='user_id' />
                  <label for='user_id'>Enter your user ID</label>
                </div>
              </div>

              <div class='row'>
                <div class='input-field col s12'>
                  <input class='validate' type='password' name='password' id='password' />
                  <label for='password'>Enter your password</label>
                </div>

                <label style='float: right;'>
                  <a class="pink-text" href='#!'><b>Forgot Password?</b></a>
                </label>
              </div>

              <!-- SIGNUP SUCCESSFUL MESSAGE -->
              <?php if ($this->session->flashdata('signup_success')) { ?>
                  <p class="green-text"><?= $this->session->flashdata('signup_success') ?></p>
              <?php } ?>

                <!-- ERROR MESSAGE -->
                <p class="red-text"><?php echo $error ?></p>
                            
                <!-- VALIDATION ERROR MESSAGE -->
                <p class="red-text"><?php echo validation_errors(); ?></p>

              <br />
              <center>
                <div class='row'>
                  <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect indigo'>Log in</button>
                </div>
                <div class="row">
                  <label>
                    <b class="black-text">Don't have an account? </b><a class="indigo-text" href="<?php echo base_url("home/signup") ?>"><b>Sign up here.</b></a>
                  </label>
                </div>
              </center>
            </form>
          </div>
        </div>
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