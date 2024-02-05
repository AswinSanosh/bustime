<html>
    <head>
        <TITLE>BUS TIME</TITLE>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <LINK rel="stylesheet" href="style.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Rubik+Doodle+Shadow&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@900&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
            crossorigin=""/>
        
        <script 
            src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin="">
        </script>

        <style>
            #map{
                text-align: center;
                margin:auto;
                margin-block: 20px;
                padding-block: 20px;
                height: 500px;
                width: 100%;
                z-index: 0;
            }
        </style>
    </head>
    <body>
        <section id="page">
            <section id="header">
                <a href="Home.html"><img src="image\logo bgr.png" alt="image not found!" class="logo"></a>
            </section>
            <section id="ctent" style="height:729px;">
                <div id="cont" style="margin:auto;padding:50px;">
                <h1 style="text-align:center;font-size:25px;font-family:'Noto Sans', sans-serif;color:white;">Sign in/Sign Up</h1><br>
                    <div id="login" style="background-color:black;border: 2px solid white;height:500px;width:500px;margin:auto;display:block">
                            <div id="signin" style="display:block"> 
                                <div class="btn" id="user" style="display:block">
                                    <input type="text" name="username" id="username" required style="font-size:20px;padding:20px;width:400px;margin-bottom:40px;" placeholder="Username or Email"><br>
                                    <button onclick="authuser()" style="cursor:pointer;width:400px"><span></span>Next</button>
                                </div>
                                <div class="btn" id="pass" style="display:none">
                                    <input type="password" name="passw" id="passw" required style="font-size:20px;padding:20px;width:400px;margin-bottom:40px;" placeholder="Password">
                                    <button onclick="authpass()" style="width:400px;cursor:pointer;"><span></span>Next</button>
                                </div>
                                <div style="display:inline-flex;margin-left:20px;margin-right:20px;;top:-50px">
                                    <hr style="width:200px;height:0px;margin-top:9px;margin-inline:9px;"><p style="color:white;margin-inline:5px;">or</p><hr style="width:200px;height:0px;margin-top:9px;margin-inline:9px;">
                                </div>
                                <div class="btn">
                                    <a onclick="newuser()" style="width:300px;top:-50px;cursor:pointer;"><span></span>Sign Up</a>
                                </div>
                            </div>
                            <div id="signup" style="display:none"> 
                                <div class="btn" id="newname">
                                    <input type="text" name="newuname" id="newuname" required style="font-size:20px;padding:20px;width:400px;" placeholder="Full Name"><br>
                                </div>
                                <div class="btn" id="newpass">
                                    <input type="password" name="newpassw" id="newpassw" required style="font-size:20px;padding:20px;width:400px;" placeholder="Password">
                                </div>
                                <div class="btn" id="confpass">
                                    <input type="text" id="confpassw" required style="font-size:20px;padding:20px;width:400px;" placeholder="Confirm password">
                                </div>
                                <div class="btn" id="newmail">
                                    <input type="email" id="newusermail" required style="font-size:20px;padding:20px;width:400px;" placeholder="Email">
                                </div>
                                <div class="btn" id="newusername">
                                    <input type="text" id="newusnm" required style="font-size:20px;padding:20px;width:400px;" placeholder="Username">
                                </div>
                                <div class="btn" id="phone">
                                    <input type="number" id="phonenumber" required style="font-size:20px;padding:20px;width:400px;" placeholder="Phone number">
                                </div>
                                <div class="btn" id="place">
                                    <input type="text" name="newplace" id="passw" required style="font-size:20px;padding:20px;width:400px;margin-bottom:40px;" placeholder="Place">
                                    <button onclick="sendOTP()" style="width:400px;cursor:pointer;"><span></span>Next</button>
                                </div>
                                <div style="display:inline-flex;margin-left:20px;margin-right:20px;top:-50px">
                                    <hr style="width:200px;height:0px;margin-top:9px;margin-inline:9px;"><p style="color:white;margin-inline:5px;">or</p><hr style="width:200px;height:0px;margin-top:9px;margin-inline:9px;">
                                </div>
                                <div class="btn">
                                    <a href="dashboard.php" style="width:300px;top:-50px;cursor:pointer;"><span></span>Sign In</a>
                                </div>
                            </div>
                            <form action="adddata.php" method="post" style="display:none"> <!--to adddata-->
                                <input type="hidden" name="name" id="name">
                                <input type="hidden" name="ps" id="ps">
                                <input type="email" name="mail" id="mail" style="display:none">
                                <input type="hidden" name="username" id="username">
                                <input type="number" name="phone" id="phone" style="display:none">
                                <input type="hidden" name="locat" id="locat">
                                <button style="display:none" id="subuser"></button>
                            </form>
                            <form action="validation.php" method="post" style="display:none"> <!--sendOTP-->
                                <input type="hidden" name="usn" id="sendusn">
                                <input type="email" name="mail" id="sendmail" style="display:none">
                                <input type="submit" style="display:none" id="otp">
                            </form>
                            <script>
                                function authuser()
                                {
                                    if(document.getElementById("username").value=="aswinsanosh" || document.getElementById("username").value=="thampuvarghesejacob")
                                    {
                                        document.getElementById("user").style.display="none";
                                        document.getElementById("pass").style.display="block";
                                        document.getElementById("usn").value=document.getElementById("username").value;
                                        document.getElementById("username").value=null;
                                    }
                                    else
                                    {
                                        document.getElementById("username").value=null;
                                        document.getElementById("username").placeholder="Invalid username or email";
                                        document.getElementById("username").style.borderColor="red";
                                    }
                                }
                                function authpass()
                                {
                                    if(document.getElementById("passw").value=="aswin" || document.getElementById("passw").value=="thampuvarghese")
                                    {
                                        document.getElementById("ps").value=document.getElementById("passw").value;
                                        document.getElementById("subuser").click();
                                        document.getElementById("passw").value=null;
                                    }
                                    else
                                    {
                                        document.getElementById("passw").value=null;
                                        document.getElementById("passw").placeholder="Invalid password";
                                        document.getElementById("passw").style.borderColor="red";
                                    }
                                }
                                function newuser()
                                {
                                    document.getElementById("ctent").style.height="1650px";
                                    document.getElementById("login").style.height="1450px";
                                    document.getElementById("signin").style.display="none";
                                    document.getElementById("signup").style.display="block";
                                }
                                function sendOTP()
                                {

                                    document.getElementById("otp").click();
                                }
                            </script>
                    </div>
                </div>
            </section>
        </section>
    </body>
</html>