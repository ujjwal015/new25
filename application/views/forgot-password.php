<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <link rel="icon" href="logo/favicon.png" type="image/png" sizes="16x16">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
      <title>Forgot Password</title>
      <style>
         body {
         font-family: 'IBM Plex Sans', sans-serif;
         /*background: #b3c0d0;
*/ 
          background-image: url(assets/image/auth-bg.jpg);
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
          }

        p,small,a{
          font-family: 'IBM Plex Sans', sans-serif;
         }

         h2{
          font-family: 'Rubik', sans-serif;
         }
         
         
         .cont {
         overflow: hidden;
         position: relative;
         width: 80%;
         margin: 40px auto 100px;
         background: #fff;
         display: flex;
         flex-direction: row;
         box-shadow: -8px 20px 25px 0 rgba(25,42,70,.3);
         
         }
        
         .form-right{
         flex-basis: 50%;
         padding: 50px;
         }

         .form-left{
          flex-basis: 50%;
         padding: 50px;
         background-color: #f2f4f4;
         padding-top: 10%;
         }
         .form-left img{
          width: 100%;
         }
         h2 {
         font-weight: 400;
         font-size: 2rem;
      margin-top: 0;
    margin-bottom: 20px;
    color: #475F7B;
  
         }
         .text-bold-600 {
    font-weight: 600;
    font-family: 'Rubik', sans-serif;
    text-transform: uppercase;
}

.text-left {
    text-align: left!important;
}

.btn-login{
  background-color: #5A8DEE!important;
    border-color: #2C6DE9!important;
    font-weight: 600;
    border: none;
    box-shadow: 0 2px 4px 0 rgba(90,141,238,.5)!important;
    padding: 5px 30px;
    width: 100%;
    color: #fff;
    font-size: 14px;
    line-height: 30px;
}

.btn-login i{
  float: right;
  padding-top: 8px;
}

.btn-login:hover{
    background-color: #719DF0!important;
    color: #FFF;
        box-shadow: 0 4px 12px 0 rgba(90,141,238,.6)!important;
}


.checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio]{
  margin-left: 0;
}

.checkbox {
    position: relative;
    display: inline-block;
}

.d-flex{
  display: flex;
}

.check1{
  flex-basis: 50%;
}

.check2{
  flex-basis: 50%;
  padding-top: 10px;
}


.form-control {
    display: block;
    width: 100%;
    height: 38px;
    font-size: 14px;
    font-weight: 500;
    padding: .47rem .8rem;
    line-height: 1.4;
   color: #475F7B;
   border: 1px solid #DFE3E7;
   box-shadow: unset;
}

small {
    font-size: 90%;
    font-weight: 400;
}
label {
    color: #475F7B;
    font-size: 12px;
    font-weight: 400;
   
}
         .form-control:focus {
    color: #475F7B;
    background-color: #FFF;
    border-color: #5A8DEE;
    outline: 0;
    box-shadow: 0 3px 8px 0 rgba(0,0,0,.1);
}
        
        
         .link2{
         background-image: linear-gradient(90deg,  #38b1d8 , #CA62D0);
         border: 0;
         border-radius: 200px;
         border: none;
         -webkit-box-shadow: 0px 9px 56px 0px rgba(109, 206, 247,.1);
         box-shadow: 0px 9px 5px 0px rgba(109, 206, 247,.1);
         padding: 5px 30px;
         }
         .link2:hover{
         background-image: linear-gradient(90deg,  #38b1d8 , #38b1d8);
         color: #fff;
         text-decoration: none!important;
         }
         .link2:active {
         color: #fff;
         text-decoration: none!important;
         }
         .para3 {
         font-size: 15px;
         line-height: 40px;
         }

         .signinlogo{
         position: absolute;
         color: #c465d0;
         display: inline-block;
         font-size: 3.1rem;
         font-weight: 600;
         padding: 0;
         padding-top: 23px;
         }

         @media screen and (max-width: 992px){
          .cont {
              overflow: hidden;
              position: relative;
              width: 100%;
              margin: 40px auto 0;
              background: #fff;
              display: flex;
              flex-direction: row;
              box-shadow: -8px 20px 25px 0 rgba(25,42,70,.3);
          }

          .form-right {
              flex-basis: 50%;
              padding: 15px;
          }

          .form-left {
              flex-basis: 50%;
              padding: 15px;
          }
         }

         @media screen and (max-width: 600px){
          .cont{
            display: inherit;
            width: 100%;
          }

          .form-right{
            padding: 15px;
          }
          .form-left{
            padding: 15px;
          }
          .signinlogo{
            font-size: 2.1rem;
                padding-top: 4px;
          }
         }
      </style>
   </head>
   <body>
      <section class="container">
         <a href="index.html" class="signinlogo">TeamifyMe</a>
         <span class="rig5"><a href="register.html" class="link2">Try it Free</a></span>
         <span class="rig5">
            <p class="para3">Not a TeamifyMe user?</p>
         </span>
      </section>
      <section class="container">
   <div class="cont">
      <div class="form-right">
       
            
            <div class="card-body">
              <h2 class="text-center">Forgot Password?</h2>
              <form action="index.html">
                <div class="row">
                  <div class="col-lg-6 col-sm-6 col-12">
                    <a href="login.html" class="btn btn-login">Sign in<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></a>
                  </div>

                  <div class="col-lg-6 col-sm-6 col-12">
                    <a href="register.html" class="btn btn-login">Sign up<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></a>
                  </div>
                </div>

                <br>

                <p class="text-center" style="margin-top: 10px; margin-bottom: 10px;">Enter the email ID you used when you joined and we will send you temporary password</p>
                <br>
                <div class="form-group mb-50">
                  <label class="text-bold-600">Email ID</label>
                  <input type="text" class="form-control" placeholder="Email ID">
                </div>
                <br>
                
                
              <button type="button" class="btn btn-login">Send Password<i class="fa fa-arrow-right"></i></button>
            </form>
            <hr>
            <div class="text-center"><a href="login.html"><small>I remembered my password</small></a></div>
          </div>
        
      </div>
      <div class="form-left">
        <img src="assets/image/forgottop.png" class="img-responsive">
      </div>
   </div>
</section>
   </body>
</html>