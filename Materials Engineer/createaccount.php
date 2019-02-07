<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" text="type/css" href="../Bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" text="type/css" href="../style.css">
    </head>

    <body>
        <!--Create account container-->
        <div class="loginContainer container h-100 d-flex justify-content-center">
            <div class="jumbotron my-auto">
                <h2>New Golden City Builders</h2>
                <h2>Create Account</h2>
                <form>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="firstname" id="inputFirstname" placeholder="firstname">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="lastname" id="inputCreateLastname" placeholder="lastname">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="username" id="inputCreateUsername" placeholder="username">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="email" id="inputCreateEmail" placeholder="email">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="password" id="inputCreatePassword" placeholder="password">
                    </div>
                    <!--NOT YET WORKING-->
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                        <label class="custom-cotrol-label" for="customRadioInline1">Materials Engineer</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                        <label class="custom-cotrol-label" for="customRadioInline1">View Only</label>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                        <button type="submit" class="btn btn-primary btn-block">Cancel</button>
                    </div>                   
                </form>
            </div>
        </div>
    </body>
</html>