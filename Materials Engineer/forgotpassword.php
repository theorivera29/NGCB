<!DOCTYPE html>

<html>

<head>
    <title>NGCB</title>
  <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css"  media="screen,projection"/>
  <link rel="stylesheet" text="type/css" href="../style.css">
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
</head>

<body>

    <div class="container valign center">
        <div class="row">
            <div class="col s6 m6 offset-m3">
                <div class="card white darken-1">
                    <div class="card-content black-text">
                        <h2 class="card-title">New Golden City Builders</h2>
                        <h2 class="card-title">Reset Password</h2>
                        <form action="server.php" method="POST">
                        <div class="row">
                            <div class="input-field col s7 offset-m2">
                                <i class="material-icons prefix">account_circle</i>
                                <input placeholder="username" id="login-username" name="username" type="text" class="validate">
                            </div>

                            <div class="row">
                                <div class="col s4 m6 offset-m3">
                                    <a href="createaccount.php" class="btn waves-effect waves-light" type="submit" name="action">Submit</a>
                                    <a href="loginpage.php" class="btn waves-effect waves-light" type="submit" name="action">Cancel</a>
                                </div>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>