<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login_style.css">
    <link rel="stylesheet" href="C:\Users\hp\Desktop\a/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>
    <div class="row ">
        <div class="col-7 colomn1" style="height:625px;">
            <h1>مرحبًا بك في حسابك الخاص            </h1><br>
           <div class="row">
           <p class="col-5">منظومة معلوماتية متكاملة تُمكِّن من تطوير أساليب جديدة لإدارة العمليات التعليمية في مؤسسات التكوين المهني، تمزج بين الابتكار والكفاءة</p>
          <img class="col-6" src="images/login.png" width="650px" height="350px" alt="">
          </div></div>
        <div class="col-5 ligne">
            <div class="row colomn2">
                <img src="images/wizara.png" height="100%" style="margin-left: 10%;">
            </div>
            <!--logo-->
            <div class="row colomn3">
                <h1 style="margin-left: 25%;"><span style="color: green;">O</span>fppt &nbsp;<span style="color: blue;"> N</span>otes</h1>
            </div>

            <div class="colomn4">
                <form action="athentification.php" method="POST">
                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="num">matricule de formateur</label>

                      <input type="text" name="matricule" id="num" class="form-control" />
                    </div>
                  
                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="pass">Password</label>

                      <input type="password" name="pass" id="pass" class="form-control" />
                    </div>
                  
                    <!-- 2 column grid layout for inline styling -->
                    <div class="row mb-4">
                      <div class="col d-flex justify-content-center">
                        <!-- Checkbox -->
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                          <label class="form-check-label" for="form2Example31"> Remember me </label>
                        </div>
                      </div>
                  
                      <div class="col">
                        <!-- Simple link -->
                        <a href="#!">Forgot password?</a>
                      </div>
                    </div>
                  
                    <!-- Submit button -->
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary submit">Sign in</button>
                  
                    
                  </form>
            </div>

        </div>
    </div>
    </body>
</html>