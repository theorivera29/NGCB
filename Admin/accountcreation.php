<!DOCTYPE html>

<html>

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" text="type/css" href="../style.css">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large pulse"><i class="material-icons">menu</i></a>
            <h4 id="NGCB">NEW GOLDEN CITY BUILDERS</h4>
            <ul class="side-nav" id="mobile-demo">
                <li class="collection-item avatar">
                    <span class="title">
                    </span>
                    <span class="title">
                    </span>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="admindashboard.php">Dashboard</a></li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="listofaccounts.php">List of Accounts</a></li>
                <li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="projects.php">Projects</a></li>
                <li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="projects.php">Password Request</a></li>
                <li>
                <li>
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <form action="server.php" method="POST">
            <h2 class="header header-two">Create an Account</h2>
            <div class="row">
                <div class="input-field col s12 m10 offset-m1">
                    <input id="firstname" name="firstname" type="text" class="validate">
                    <label for="firstname">First Name</label>
                </div>

                <div class="input-field col s12 m10 offset-m1">
                    <input id="lastname" name="lastname" type="text" class="validate">
                    <label for="lastname">Last Name</label>
                </div>

                <div class="input-field col s12 m10 offset-m1">
                    <input id="username" name="username" type="text" class="validate">
                    <label for="username">Username</label>
                </div>

                <div class="input-field col s12 m10 offset-m1">
                    <input id="email" name="email" type="text" class="validate">
                    <label for="email">Email</label>
                </div>

                <div class="input-field col s12 m10 offset-m1">
                    <input id="password" name="password" type="text" class="validate">
                    <label for="password">Password</label>
                </div>

                <div class="col s12 m10 offset-m1">
                    <span>Account Type</span>
                    <div class="row">
                        <label>
                            <input class="with-gap" name="account_type" type="radio" checked
                                value="Materials Engineer" />
                            <span>Materials Engineer</span>
                            <input class="with-gap" name="account_type" type="radio" checked value="View Only" />
                            <span>View Only</span>
                        </label>
                    </div>

                </div>

                <div class="row center">
                    <button class="btn waves-effect waves-light create-account-btn" type="submit"
                        name="create_account">Create
                        An Account</button>
                    <a class="waves-effect waves-light btn" href="loginpage.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>


    <div id="addmaterialModal" class="modal modal-fixed-footer">
        <form action="server.php" method="POST">
            <div class="modal-content">
                <h4>Add Material</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="materialname" name="materialname" type="text" class="validate">
                        <label for="materialname">Material Name:</label>
                    </div>
                    <div class="col s12">
                        <label>Category:</label>

                        <div class="input-field col s12">
                            <select class="browser-default" name="categories">
                                <option value="" disabled selected>Choose your option</option>
                               
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <label>Quantifier:</label>
                        </div>
                    </div>
                    <div class="input-field col s5">
                        <select class="browser-default" name="categories">
                            <option value="" disabled selected>Choose your option</option>

                            <option>

                            </option>

                        </select>
                    </div>
                    <div class="input-field col s7">
                        <input id="minquantity" name="minquantity" type="text" class="validate">
                        <label for="minquantity">Minimum quantity of materials when to be quantified:</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
                <button href="#addstockcardModal" type="submit" class="waves-effect waves-teal btn-flat modal-trigger" name="add_materials">Next</button>
            </div>
        </form>
    </div>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
        // SIDEBAR
        $(document).ready(function () {
            $('.button-collapse').sideNav({
                menuWidth: 300, // Default is 300
                edge: 'left', // Choose the horizontal origin
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
                draggable: true // Choose whether you can drag to open on touch screens
            });
            // START OPEN
            $('.button-collapse').sideNav('show');
        });
    </script>

</body>

</html>