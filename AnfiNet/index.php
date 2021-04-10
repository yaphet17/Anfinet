<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head lan="en">
    <meta charset="UTF-8" >
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="signupstyle.css" >
    <script rel="javascript" src="index.js"></script>
</head>
<body>
    <header>
        <div class='header'>
            <p class='title'>Anfi Net</p>
            <div class="loginForm">
                <form action="login.php" method="POST">
                    <span style='margin-right: 10px'>
                        <?php
                            if(isset($_SESSION['error'])){
                                echo "<p style='color:red' id='logNotif'>".$_SESSION['error']."</p>";
                                session_destroy();
                            }
                        ?>
                    </span>
                    <input type="text" class="logField" name="eid" placeholder="Id number" required>
                    <input type="password" class="logField" name="password" placeholder="Password" required>
                    <input type="submit" class="submitLog logField"  name="login" value="Login">
                </form>
            </div>
        </div>
    </header>
    <div class="main_container">
        <div class="signForm">
            <form action='signup.php' method='POST'>
                    <span>
                        <p class='signLabel'>Signup</p>
                    </span>
                    <span><p id="notification" class="notifLabel" >
                        <?php
                            if(isset($_SESSION['takenid'])){
                                echo "".$_SESSION['takenid']."";
                                session_destroy();
                            }

                            if(isset($_SESSION['takenemail'])){
                                    echo "".$_SESSION['takenemail']."";
                                    session_destroy();
                                }
                        ?>
                    </p></span>
                    <input type="text" id="fname"class="fname signField" name='fname' placeholder="First Name" required>
                    <input type="text" id="lname" class="lname signField" name='lname' placeholder="Last Name" required>
                    <input type="text" id="id" class="id signField" name='id' placeholder="Id Number" required>
                    <span><label for="male">Male<input type="radio" id="male" name="sex" id="male" value="M"  class="sex"></label>
                         <label for="female">Female<input type="radio" id="female"name="sex" id="female" value="F" class="sex"></label>
                    </span>
                    <span>
                        <select id="year" class="selectBox signField" name='year' required>
                            <option disabled selected hidden> Academic year</option>
                            <option value=1 >1</option>
                            <option value=2 >2</option>
                            <option value=3 >3</option>
                            <option value=4 >4</option>
                            <option vaue=5 >5</option>
                        </select>
                        <select id="department" class="selectBox signField" name="department" required="">
                            <option disabled selected hidden> Department</option>
                            <option value='CSE'>CSE</option>
                            <option value='ECE'>ECE</option>
                            <option value='EPCE'>EPCE</option>
                        </select>
                    </span>
                    <input type="email" id="email" class="email signField" name='email' placeholder="Email Address" required>
                    <input type="password" id="password" class="password signField" name='password' placeholder="Password" minlength="6" required>
                    <input type="password" id="confirmPass"class="confrimPassword signField" placeholder="Confirm Password"  minlength="6" required>
                    <span><input type="submit" id="signup" class="submitSign"  name='submit' value="Signup"></span>
            </form>
        </div>
    </div>
    <footer>
        <div class="footer">
            <p><a href="mailto:yafetberhanu3@gmail.com">Contact</a> | <a href="#">About</a></p>
            <p>&copy;Copyright 2021 All right reserved.</p>
        </div>
    </footer>
    <noscript>You may have disabled javascript</noscript>
</body>

</html>
