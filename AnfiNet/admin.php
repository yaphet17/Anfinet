<?php
session_start();
if(!isset($_SESSION['username']) && !isset($_SESSION['mlevel'])){
    header('Location: logout.php');
    exit();
}
if(isset($_SESSION['mlevel'])){
    if($_SESSION['mlevel']!=1){
         header('Location: logout.php');
         exit();
    }
}
include('config.php');
if(isset($_POST['addcurriculum'])){
    $c_code=$_POST['course_code'];
    $c_name=$_POST['course_name'];
    $department=$_POST['department'];
    $year=$_POST['year'];
    $semester=$_POST['semester'];
    $c_hour=$_POST['credit_hour'];
    $c_preq=$_POST['prequisite'];
    $c_desc=$_POST['description'];

    $c_code=stripcslashes($c_code);
    $c_name=stripcslashes($c_name);
    $department=stripcslashes($department);
    $year=stripcslashes($year);
    $semester=stripcslashes($semester);
    $c_hour=stripcslashes($c_hour);
    $c_preq=stripcslashes($c_preq);
    $c_desc=stripcslashes($c_desc);

    $query="INSERT INTO curriculum VALUES('".$c_code."','".$c_name."','".$department."',".$year.",'".$c_hour."','".$c_preq."','".$c_desc."','".$semester."');";

    mysqli_query($con,$query);

}
if(isset($_POST['addmaterial'])){
    $temp=explode('-',$_POST['m_coursecode']);
    $coursecode=$temp[0];


	$file=$_FILES['file'];
	$fileName=$_FILES['file']['name'];
	$fileTmpName=$_FILES['file']['tmp_name'];
	$fileSize=$_FILES['file']['size'];
	$fileError=$_FILES['file']['error'];
	$fileType=$_FILES['file']['type'];


	$fileExt=explode('.', $fileName);
	$fileActualExt=strtolower(end($fileExt));

	$allowed=array('zip','pdf','ppt','docx','txt');
	if(in_array($fileActualExt, $allowed)){
		if ($fileError===0){
			if($fileSize<51200000){
				$fileNameNew=uniqid('',true).'.'.$fileActualExt;
				$fileDestination='Materials/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
                $query1="SELECT course_code FROM curriculum WHERE course_code='".$coursecode."';";
                $query2="INSERT INTO materials VALUES('".$coursecode."','".$fileDestination."');";

                $result=mysqli_query($con,$query1);
                $num=mysqli_num_rows($result);
                if($num===1){
                    mysqli_query($con,$query2);

                }else{
                    echo "<script>alert('There is no such course');</script>";
                }

			}else{
				echo "<script>alert('ERROR:file size is too large');</script>";
			}

		}else{
			echo "<script>alert('Some error occured');</script>";
		}

	}else{
		echo "<script>alert('File type Not allowed');</script>";
	}
}
if(isset($_POST['changeProfile'])){
  $id=$_SESSION['username'];
  $fname=$_POST['p_fname'];
  $lname=$_POST['p_lname'];
  $sex=$_POST['p_sex'];
  $year=$_POST['p_year'];
  $department=$_POST['p_department'];
  $query="UPDATE user SET First_Name='".$fname."',Last_Name='".$lname."',sex='".$sex."',Academic_Year='".$year."',Department='".$department."' WHERE id='".$id."';";
  mysqli_query($con,$query);

}
?>

<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="signupstyle.css?v<?php echo time();?>"/>
        <link type="text/css" rel="stylesheet" href="user.css?v<?php echo time();?>"/>
        <link type="text/css" rel="stylesheet" href="Adminstrator.css?v<?php echo time();?>"/>
    </head>
    <body>
        <header>
            <div class="header">
              <p class="title">Anfi Net</p>
              <p class="username" style="font-size:18px; color:white;"><?php echo $_SESSION['fname']." ".$_SESSION['lname']?></p>
              <div class="nav">
                <a href="admin.php" title="Home"><img src="home.png" width="25" height="30"/></a>
                <p  id="dropbtn" class='dropbtn hidden-in-lw'>MORE <i style='margin-left:5px;' class='fa fa-caret-down'></i></p>
                <div class='dropdown'>
                  <div id="dropdown-content" class='dropdown-content'>
                    <a href="#" title="Notification"><img src="notification2.png" width="25" height="27" /> <p>Notification</p></a>
                    <a href="#" title="Profile"><img src="profile2.png" width="25" height="27" /> <p>Profile</p></a>
                    <a href="logout.php" title="Logout"><img src="logout2.png" width="25" height="27" /><p>Logout</p></a>
                  </div>
                  </div>
                <a href="#" class="hidden-in-sw" title="Notification"><img src="notification.png" width="25" height="27" /></a>
                <a href="#" onclick="showProfile();" class="hidden-in-sw" title="Profile"><img src="profile.png" width="25" height="27" /></a>
                <a href="logout.php" class="hidden-in-sw" title="Logout"><img src="logout.png" width="25" height="27" /></a>
              </div>
          </div>
          </header>
          <div id="mainC" class="main-container">
            <div class="tab">
                <button class="tablinks" id="userTab" onclick="openTab(event,'userAdmin')" >User Administration</button>
                <button class="tablinks" onclick="openTab(event,'curriculum');innerTab('showCm')" >Curriculum</button>
                <button class="tablinks" onclick="openTab(event,'course')"> Course</button>
                <button class="tablinks" onclick="openTab(event,'materials')" >Materials</button>
            </div>
            <div id="userAdmin" class="tabcontent">
                <div class="userdata">
                        <table id="userTable">
                        <tr>
                            <th>User id</th>
                            <th>Full name</th>
                            <th>Academic Year</th>
                            <th>School/ Department</th>
                            <th>Edit</th>

                        </tr>
                        <?php
                            $query="SELECT id,First_Name,Last_Name,Academic_Year,Department FROM user;";

                            $result=mysqli_query($con,$query);
                            $num=mysqli_num_rows($result);

                            while($row=mysqli_fetch_assoc($result)){
                                echo "<tr><td>".$row['id']."</td> <td>".$row['First_Name']." ".$row['Last_Name']."</td> <td>"
                                .$row['Academic_Year']."</td><td>".$row['Department']."</td> <td>
                                <button><i class='fa fa-close'></i></button>
                                </td></tr>";
                            }

                        ?>
                </table>
                </div>
            </div>
            <div id="curriculum" class="tabcontent">
                <div class="tab_2">
                    <button id="showCm" class="tablinks_2" onclick="openTab2(event,'showCurriculum');innerTab('csebtn');innerTab('ecebtn');innerTab('epcebtn')">Show curriculum</button>
                    <button class="tablinks_2" onclick="openTab2(event,'addCurriculum')">Add new curriculum</button>
                </div>
                <div id="showCurriculum" class="tabcontent_2">
                    <div class="curriculumData">

                        <div class="sc-container">
                            <button  id="csebtn" class="scbtn">Computer Science and engineering<i class="fa fa-angle-down" style="font-size: 24px;"></i></button>
                            <div class="c-container">
                                <table id="cseTable">
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Credit Hour</th>
                                        <th>School/ Department</th>
                                        <th>Edit</th>
                                    </tr>

                                    <?php
                                        $query="SELECT course_code,course_name,department,credit_hour,course_description FROM curriculum WHERE department='CSE';";

                                        $result=mysqli_query($con,$query);
                                        $num=mysqli_num_rows($result);
                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row['course_code']."</td> <td>".$row['course_name']."</td> <td>"
                                                .$row['department']."</td><td>".$row['credit_hour']."</td> <td>
                                                <button><i class='fa fa-close'></i></button>
                                                </td></tr>";
                                        }

                                     ?>
                                </table>
                            </div>
                        </div>
                        <div class="sc-container">
                            <button id="ecebtn" class="scbtn">Electrical communication engineering<i class="fa fa-angle-down" style="font-size: 24px;"></i></button>
                            <div class="c-container">
                                <table id="eceTable">
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Credit Hour</th>
                                        <th>School/ Department</th>
                                        <th>Edit</th>
                                    </tr>
                                    <?php
                                        $query="SELECT course_code,course_name,department,credit_hour FROM curriculum WHERE department='ECE';";

                                        $result=mysqli_query($con,$query);
                                        $num=mysqli_num_rows($result);

                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row['course_code']."</td> <td>".$row['course_name']."</td> <td>"
                                                .$row['department']."</td><td>".$row['credit_hour']."</td> <td>
                                                <button><i class='fa fa-close'></i></button>
                                                </td></tr>";
                                        }
                                    ?>

                                </table>
                            </div>
                        </div>
                        <div class="sc-container">
                            <button id="epcebtn" class="scbtn">Power and control engineering<i class="fa fa-angle-down" style="font-size: 24px;"></i></button>
                            <div class="c-container">
                                <table id='epceTable'>
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Credit Hour</th>
                                        <th>School/ Department</th>
                                        <th>Edit</th>
                                    </tr>
                                    <?php
                                        $query="SELECT course_code,course_name,department,credit_hour FROM curriculum WHERE department='EPCE';";

                                        $result=mysqli_query($con,$query);
                                        $num=mysqli_num_rows($result);

                                         while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row['course_code']."</td> <td>".$row['course_name']."</td> <td>"
                                                .$row['department']."</td><td>".$row['credit_hour']."</td> <td>
                                                <button><i class='fa fa-close'></i></button>
                                                </td></tr>";
                                            }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="addCurriculum" class="tabcontent_2">
                    <div class="addCur">
                        <form action='<?=$_SERVER['PHP_SELF']?>' method='POST'>
                            <input type="text" class="curField" name='course_code' placeholder="Enter Course Code">
                            <input type="text" class="curField" name='course_name' placeholder="Enter Course Name">
                            <select class="curField" name='department'>
                                <option selected disable hidden>Target Department</option>
                                <option value='CSE'>CSE</option>
                                <option value='ECE'>ECE</option>
                                <option value='EPCE'>EPCE</option>
                            </select>
                            <select class="curField" name='year'>
                                <option selected disable hidden>Target Year</option>
                                <option value=1 >1</option>
                                <option value=2 >2</option>
                                <option value=3 >3</option>
                                <option value=4 >4</option>
                                <option value=5 >5</option>
                            </select>
                            <select class="curField" name='semester'>
                                <option selected disable hidden>Target Semester</option>
                                <option value=1 >1</option>
                                <option value=2 >2</option>

                            </select>

                            <input type="number" class="curField" name='credit_hour' placeholder="Enter Credit Hour" max='4' min='1'>
                            <input type="text" class="curField" name='prequisite' placeholder="Enter Prerequisite course">
                            <textarea class="curField" name='description' placeholder="Enter Course Description" row='30' col='50'></textarea>
                            <input type="submit" class="curField" name='addcurriculum' value="Add">
                            </div>
                        </form>
                </div>
            </div>
            <div id="course" class="tabcontent">
                <table id="courseTable">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credit Hour</th>
                        <th>Prequisite</th>
                        <th>Edit</th>
                    </tr>
                    <?php
                        $query="SELECT course_code,course_name,credit_hour,prerequisite FROM curriculum ORDER BY academic_year;";

                        $result=mysqli_query($con,$query);
                        $num=mysqli_num_rows($result);

                        while($row=mysqli_fetch_assoc($result)){
                            echo "<tr><td>".$row['course_code']."</td> <td>".$row['course_name']."</td> <td>"
                                  .$row['credit_hour']."</td><td>".$row['prerequisite']."</td> <td>
                                    <button><i class='fa fa-close'></i></button>
                                    </td></tr>";
                        }
                    ?>

                </table>
            </div>
            <div id="materials" class="tabcontent">
            <div class="Add_material">
                <form action="<?=$_SERVER['PHP_SELF']?>" method='POST' enctype='multipart/form-data'>
                    <fieldset style='display:flex; flex-direction: column; border: 1px solid black;'>
                        <legend>Add Materials</legend>
                        <span style='display:flex; flex-direction: row; width:450px;'>
                            <input list='courses' name='m_coursecode' placeholder='Select course' style='margin-right:10px;' required>
                            <datalist id='courses'>
                            <?php
                                $query="SELECT course_code,course_name FROM curriculum ORDER BY academic_year;;";
                                $result=mysqli_query($con,$query);
                                $num=mysqli_num_rows($result);

                                while($row=mysqli_fetch_assoc($result)){
                                    echo "<option value='".$row['course_code']."-".$row['course_name']."'>";
                                }
                            ?>
                            </datalist>
                            <input type='file' name='file' required>
                        </span>
                        <input type='submit' name='addmaterial' style='margin:10px 0px 0px 135px; width:80px;' value='Add'>
                    </fieldset>
                </form>
            </div>
            <div class="show_material">
                <table class="material_table">
                   <tr>
                        <th>Course</th>
                        <th>Download</th>
                        <th>Edit</th>
                   </tr>
                   <?php
                        $query="SELECT m.course_code,c.course_name,m.path FROM curriculum c,materials m WHERE c.course_code=m.course_code";
                        $result=mysqli_query($con,$query);

                        while($row=mysqli_fetch_assoc($result)){
                           echo "<tr><td>".$row['course_code']."-".$row['course_name']."</td><td><a href='".$row['path']."' download><i class='fa fa-download' style='font-size:24px; margin-right:5px;'></i>download file</a></td>
                           <td><button><i class='fa fa-close'></i></button></td></tr>";
                       }

                   ?>

                </table>

            </div>
            </div>
          </div>
          <div id="profileC" class="profile-container">
                <form actiom="<?=$_SERVER['PHP_SELF']?>" method="POST">
                    <fieldset style="border:1px solid #0A0638;">
                    <legend>Edit profile</legend>
                    <span><p id='notify' class='notify'>Notification</p></span>
                    <?php
                        $query="SELECT First_Name,Last_Name,Sex,Academic_Year,Department,Email FROM user  WHERE Id='".$_SESSION['username']."';";
                        $result=mysqli_query($con,$query);
                        if($row=mysqli_fetch_assoc($result)){
                            echo "<input type='text' name='p_fname' id='p_fname' value='".$row['First_Name']."' placeholder='First Name' disabled required>
                                  <input type='text' name='p_lname' id='p_lname' value='".$row['Last_Name']."' placeholder='Last Name' disabled required>
                                  <input type='text' name='p_sex' id='p_sex' value='".$row['Sex']."' placeholder='Email' disabled required>
                                  <input type='number' name='p_year' id='p_year' value='".$row['Academic_Year']."' placeholder='Academic Year' max=5 min=0 disabled required>
                                  <input type='text' name='p_department' id='p_department' value='".$row['Department']."' placeholder='Department' disabled required>
                                  <input type='email' name='p_email' id='p_email' value='".$row['Email']."' placeholder='Email' disabled required>";
                        }
                    ?>
                    <span>
                        <input type='button' id='editBtn' value='Edit'>
                        <button type='button' onclick="showFilter(event,'passBox');">Change Passowrd <i class='fa fa-angle-down' style="font-size:15px;margin-left: 5px; margin-top:none;"></i></button>
                    </span>
                        <div id='passBox' class='passBox'>
                            <input type='password' name='oldPass' placeholder='old password' disabled>
                            <input type='password' name='newPass' placeholder='new password' disabled>
                            <input type='password' placeholder='confirm password' disabled>
                        </div>
                    <span><input type='submit'  name='changeProfile' id='changeProfile' value='Save Change'></span>
                    </fieldset>
               </form>

          </div>
          <footer>
            <div class="footer">
              <p><a href="mailto:yafetberhanu3@gmail.com">Contact</a> | <a href="#">About</a></p>
              <p>&copy;Copyright 2021 All right reserved.</p>
            </div>
          </footer>
          <script>
              var dropbtn=document.getElementById("dropbtn");
              var dropdown = document.getElementsByClassName("scbtn");
              var i;
             for (i = 0; i < dropdown.length; i++) {
                dropdown[i].addEventListener("click", function() {
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
            }
                function showProfile(){
                    var mainC=document.getElementById("mainC");
                    var profileC=document.getElementById("profileC");
                    mainC.style.display="none";
                    profileC.style.display="flex";
                    profileC.style.justifyContent="center";

                }
              function showDrop(){
                var dropdown=document.getElementById("dropdown-content");
                if(dropdown.style.display==="flex"){
                    dropdown.style.display='none';
                    dropbtn.childNodes[1].className="fa fa-caret-down";

                }
                else{
                    dropdown.style.display='flex';
                    dropdown.style.flexDirection='column';
                    dropbtn.childNodes[1].className="fa fa-caret-up";
                }
            }
            function openTab(evt,tabName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

               document.getElementById(tabName).style.display="block";
                evt.currentTarget.className += " active";
            }
            function openTab2(evt,tabName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent_2");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks_2");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
               document.getElementById(tabName).style.display="block";
                evt.currentTarget.className += " active";
            }
            function showFilter(evt,val){
                var filterBox;
                filterBox=document.getElementById(val);
                if(filterBox.style.display==="flex"){
                    filterBox.style.display='none';
                    evt.currentTarget.childNodes[1].className="fa fa-angle-down";

                }
                else{
                    filterBox.style.display='flex';
                    filterBox.style.flexDirection='row';
                    evt.currentTarget.childNodes[1].className="fa fa-angle-up";
                }

            }
            function innerTab(val){
                document.getElementById(val).click();

            }
            function deleteRow(val,tabName){
                var target;
                target=document.getElementById(val);
                document.getElementById(tabName).deleteRow(target.rowIndex);
            }

            dropbtn.addEventListener('click',showDrop,false);
            document.addEventListener("DOMContentLoaded", function(event) {
                document.getElementById('userTab').click();
            });
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);

            }
            function disableBackBtn(){
                window.history.forward();
            }
            function editProfile(){
                if(document.getElementById("p_fname").disabled===true){
                    document.getElementById("p_fname").disabled=false;
                    document.getElementById("p_lname").disabled=false;
                    document.getElementById("p_sex").disabled=false;
                    document.getElementById("p_year").disabled=false;
                    document.getElementById("p_department").disabled=false;
                    document.getElementById("p_email").disabled=false;
                }else{
                    document.getElementById("p_fname").disabled=true;
                    document.getElementById("p_lname").disabled=true;
                    document.getElementById("p_sex").disabled=true;
                    document.getElementById("p_year").disabled=true;
                    document.getElementById("p_department").disabled=true;
                    document.getElementById("p_email").disabled=true;

                }
            }
            var row=document.getElementsByClassName('row');
            for (i = 0; i < row.length; i++) {
               row[i].addEventListener("click", function() {
                alert('Yes');
            });
        }
            var changeProfile=document.getElementById('changeProfile');
            var editBtn=document.getElementById("editBtn");

            editBtn.addEventListener('click',editProfile,false);
            changeProfile.addEventListener('click',checkData,false);

            window.onload=disableBackBtn;

          </script>
          <noscript>You may have disabled javascript</noscript>

        </body>
</html>
