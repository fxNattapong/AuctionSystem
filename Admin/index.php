<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <title>ADMIN PANEL</title>
        <link rel="stylesheet" href="../css/styles-admin.css">
    </head>

    <body>
        <div class="bg-color">
            <div class="card card-login">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                      <img src="../uploads/logo-admin.png" class="img-fluid" alt="img">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form name="formAdminLogin"  method="post" action="../Member/MembersLogin.php">
                            <div>
                              <center><b><h3>ADMIN PANEL</h3></b></center>
                            </div><br>
                            <div class="form-outline mb-4">
                                <label class="form-label">Username</label>
                                <input type="text" name="member_username" id="member_username" class="form-control"/>
                            </div>
                            <div class="form-outline mb-3">
                              <label class="form-label" for="form3Example4">Password</label>
                              <input type="password" name="member_password" id="member_password" class="form-control"/>
                            </div>
                            <div class="text-center mt-4 pt-2">
                              <hr>
                              <button type="submit" class="btn btn-login">LOGIN</button>
                            </div>
                        </form>
                  </div>
            </div>
        </div>
    </body>
</html>