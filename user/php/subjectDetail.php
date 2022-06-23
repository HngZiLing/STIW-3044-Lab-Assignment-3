<?php
session_start();
if (!isset($_SESSION['sessionid'])) {
echo "<script> alert('Session not available. Please login');</script>";
echo "<script> window.location.replace('login.php')</script>";
}

include_once("dbconnect.php");

if(isset($_GET['subject_id'])) {
$subject_id = $_GET['subject_id'];
$sqlsubject = "SELECT mytutordb.tbl_subjects.subject_id,
mytutordb.tbl_subjects.subject_name,
mytutordb.tbl_subjects.subject_description,
mytutordb.tbl_subjects.subject_price, mytutordb.tbl_subjects.tutor_id,
mytutordb.tbl_subjects.subject_sessions,
mytutordb.tbl_subjects.subject_rating, mytutordb.tbl_tutors.tutor_id,
mytutordb.tbl_tutors.tutor_name, mytutordb.tbl_tutors.tutor_email, 
mytutordb.tbl_tutors.tutor_phone FROM mytutordb.tbl_subjects 
INNER JOIN mytutordb.tbl_tutors ON mytutordb.tbl_subjects.tutor_id =
mytutordb.tbl_tutors.tutor_id WHERE mytutordb.tbl_subjects.subject_id =
'$subject_id'";
$stmt = $conn->prepare($sqlsubject);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" style="css" href="../css/style.css">
        <script src="../js/menu.js" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>

    <body>
        <div class="w3-bar w3-light-grey w3-round w3-card-4 w3-hide-small">
            <a href="index.php" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-normal">Courses</a>
            <a href="tutor.php" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-normal">Tutors</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-normal">Subscription</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-normal">Profile</a>
            <a href="login.php" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-right w3-normal">Logout</a>
        </div>

        <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
            <button class="w3-bar-item w3-button w3-large w3-normal" 
                onclick="w3_close()">Close &times;
            </button>
            <a href="index.php" class="fa fa-book w3-bar-item w3-button w3-padding-16">&emsp;Courses</a>
            <a href="tutor.php" class="fa fa-mortar-board w3-bar-item w3-button w3-padding-16">&emsp;Tutors</a>
            <a href="#" class="fa fa-heart w3-bar-item w3-button w3-padding-16">&emsp;Subcription</a>
            <a href="#" class="fa fa-user w3-bar-item w3-button w3-padding-16">&emsp;Profile</a>
            <a href="login.php" class="fa fa-sign-out w3-bar-item w3-button w3-padding-16">&emsp;Logout</a>
        </div>

        <div class="w3-indigo">
            <button id="openNav" class="w3-button w3-blue w3-xlarge w3-padding-16 w3-hide-large w3-hide-medium " 
                onclick="w3_open()">&#9776;
            </button>
            <a href="index.php" class="w3-xlarge w3-hide-large w3-hide-medium w3-title" style="text-decoration: none;">&nbsp&nbsp&nbspMyTutor</a>
        </div>

        <div class = "w3-container w3-row w3-margin w3-border">
            <?php
                foreach ($rows as $subjects) {
                    $subjectId = $subjects['subject_id'];
                    $subjectName = $subjects['subject_name'];
                    $subjectDesc = $subjects['subject_description'];
                    $subjectPrice = number_format((float)$subjects['subject_price'], 2, '.', '');
                    $tutorId = $subjects['tutor_id'];
                    $subjectSession = $subjects['subject_sessions'];
                    $subjectRating = $subjects['subject_rating'];
                    $tutorName = $subjects['tutor_name'];
                }
                echo "
                <div class = 'w3-container w3-round' style='border-radius:20px'
                    <div>
                        <header class = 'w3-container w3-blue w3-padding'>
                            <div class = 'w3-col' style='width:80%'><h5 class='w3-bold'>$subjectName</h5></div>
                            <div class = 'w3-col' style='width:20%'>
                                <a class='w3-right w3-button w3-white w3-center w3-border w3-normal' style='border-radius:20px;' href='index.php'>Go Back</a>
                            </div>
                        </header>
                    </div>";

                    echo "
                    <div class = 'w3-row'>
                        <div class = 'w3-third w3-center'>
                            <img class = 'w3-image w3-margin' src='../../assets/courses/$subjectId.png'" .
                            " onerror = this.onerror=null; this.src='src=../res/defaultCourse.png'"
                            . " style='width:100%;height:100%;max-height: 375px;max-width:375px'>
                        </div>";
                        echo "
                        <div class = 'w3-twothird' style='padding-left:32px'>
                            <div class = 'w3-row'>
                                <div class = 'w3-twothird'>
                                    <div class = 'w3-row'>
                                        <div class = 'w3-third'>
                                            <p class = 'w3-title w3-xlarge'><i style='font-size:16px'></i><b>RM $subjectPrice</b></p>
                                            <p class='w3-normal'>$subjectSession sessions</p>
                                            <p class = 'w3-normal' style='font-size:16px'>$subjectRating&nbsp<i class='fa fa-star-o'></i></p>
                                        </div>
                                        <div class = 'w3-twothird' style='padding:32px'>
                                            <a class='w3-button w3-hover-amber w3-center w3-border w3-normal' style='border-radius:20px; margin:5px' href='#'><i class='fa fa-heart-o'></i></a>&nbsp&nbsp
                                            <a class='w3-button w3-amber w3-hover-blue w3-center w3-border w3-normal' style='border-radius:20px;margin:5px' href='#'>Buy Now</a>
                                        </div>
                                    </div>
                                    <p class = 'w3-normal' style = 'text-align:justify;line-height:2'><b>Description</b><br>$subjectDesc</p>
                                </div>
                                <div class = 'w3-third' style='padding:16px'>
                                    <img class = 'w3-image w3-margin w3-circle' style='box-shadow:0 6px 20px 0 lightgrey;' src='../../assets/tutors/$tutorId.jpg'" .
                                    " onerror = this.onerror=null; this.src='src=../res/defaultTutor.jpg'"
                                    . " style='width:80%;height:80%;max-height:175px; max-width:175px'>
                                    <div class = 'w3-container w3-middle w3-light-grey w3-center' style='border-radius:20px;height:auto; max-height:200px'>
                                        <p class = 'w3-normal' style='line-height:2'><b>Tutor</b><br>$tutorName</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>"
            ?>
        </div>

        <br><br><br>
        <footer class="w3-footer w3-bottom w3-light-grey w3-center w3-small">
            <p class="w3-small w3-normal">&emsp;Copyright: H'ng Zi Ling</p>
        </footer>
    </body>
</html>