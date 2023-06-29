<?php
include("db.php");


// Retrieve the student information from the query parameters
$name = isset($_GET['name']) ? $_GET['name'] : '';
$surname = isset($_GET['surname']) ? $_GET['surname'] : '';
$studentNo = isset($_GET['studentNo']) ? $_GET['studentNo'] : '';
$program = isset($_GET['program']) ? $_GET['program'] : '';


if (isset($_POST['logoutbtn'])) {
    header("Location: login.html");
    exit();
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if (isset($_POST['submitComment'])) {
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $subject = htmlentities($_POST['subject']);
    $message = htmlentities($_POST['comment']);

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'alicanalican4141@gmail.com';
    $mail->Password = 'ddbrgvaeutlqwcxo';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress($email);
    $mail->Subject = ("$email ($subject)");
    $mail->Body = $message;
    $mail->send();

    try {
        $mail->send();
        echo '<script>alert("Mail sent successfully!");</script>';
    } catch (Exception $e) {
        echo '<script>alert("Failed to send email!");</script>';
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/register_style.css">

    <script src="js/script.js"></script>

    <!-- For icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="images/eul_logo.png" alt="EUL_logo" id="eul_logo">
        </div>
        <div class="page-tittle">
            <h4> EUL Course Registration and Curriculum Management System</h4>
        </div>
        <div class="logout">

            <form action="" method="post">
                <button class="logout-button" name="logoutbtn" type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="section section-profile">
        <div class="profile profile-image">
            <img src="images/student-image.png" alt="Profile Image">
        </div>

        <div class="profile profile-informations">
            <label class="information-label"> <b>Name:</b> <?php echo $name; ?></label>
            <label class="information-label"> <b>Surname:</b> <?php echo $surname; ?></label>
        </div>
        <div class="profile profile-informations">
            <label class="information-label"> <b>Department Name:</b> <?php echo $program; ?></label>
            <label class="information-label"> <b>Student No:</b><?php echo $studentNo; ?> </label>
        </div>
        <div class="profile profile-informations">
            <label class="information-label"> <b>Semester:</b>Spring - 2023 </label>
            <label class="information-label"> <b>CGPA:</b> 3.00</label>
        </div>
    </div>
    <div class="section section-course-selection">
        <div class="card">
            <div class="card-header">
                <h2>Course Selection</h2>
            </div>
            <div class="card-body">
                <div class="course-list">
                    <label for="course">Select Course:</label>
                    <select id="course" name="course">
                        <option value="COMPUTING FOUNDATIONS">COMPUTING FOUNDATIONS</option>
                        <option value="COMPUTER PROGRAMMING">COMPUTER PROGRAMMING</option>
                        <option value="DATA STRUCTURES">DATA STRUCTURES</option>
                        <option value="OPERATING SYSTEMS">OPERATING SYSTEMS</option>
                        <option value="OBJECT-ORIENTED PROGRAMMING I">OBJECT-ORIENTED PROGRAMMING I</option>
                        <option value="ARTIFICIAL NEURAL NETWORK">ARTIFICIAL NEURAL NETWORK </option>
                        <option value="OBJECT-ORIENTED PROGRAMMING II">OBJECT-ORIENTED PROGRAMMING II</option>
                        <option value="ANALYSIS OF ALGORITHMS">ANALYSIS OF ALGORITHMS</option>
                        <option value="DATABASE MANAGEMENT SYSTEMS">DATABASE MANAGEMENT SYSTEMS</option>
                        <option value="INTERNET PROGRAMMING">INTERNET PROGRAMMING</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <form action="" method="post">
                    <button class="btn-primary" type="button" id="addCourse" name="addCourse">Add Course</button>
                </form>
            </div>
        </div>
    </div>
    <div class="section section-selected-courses">
        <div class="card">
            <div class="card-header">
                <h2>Selected Courses</h2>
            </div>
            <div class="card-body">
                <table id="selectedCoursesTable">
                    <tr>
                        <th>Course Name</th>
                        <th>Process</th>
                    </tr>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
    <div class="section section-comment">
        <form action="" method="post">

            <div class="card">
                <div class="card-header">
                    <h2>Comment Section</h2>
                </div>
                <div class="card-body">
                    <label for="comment">Write your comment:</label>
                    <textarea id="comment" name="comment" style="max-width: 800px; max-height: 100px;"></textarea>
                    <input type="hidden" name="name" value="<?php echo $name; ?> <?php echo $surname; ?>">
                    <input type="hidden" name="email" value="doganalican46@hotmail.com">
                    <input type="hidden" name="subject" value="About Course Registration">
                </div>
                <div class="card-footer">
                    <button class="btn-primary" name="submitComment" id="submitComment" type="submit">SEND</button>
                </div>
            </div>
        </form>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectedCourses = JSON.parse(localStorage.getItem('selectedCourses')) || [];
        var addCourseButton = document.getElementById('addCourse');

        // Load selected courses from localStorage
        selectedCourses.forEach(function(course) {
            var tableRow = '<tr><td>' + course + '</td><td><button class="deleteCourse btn-danger" type="button">Delete</button></td></tr>';
            document.getElementById('selectedCoursesTable').innerHTML += tableRow;
            var optionToRemove = document.querySelector('#course option[value="' + course + '"]');
            if (optionToRemove) {
                optionToRemove.remove();
            }
        });

        addCourseButton.addEventListener('click', function() {
            var course = document.getElementById('course').value;

            if (selectedCourses.length < 5) {
                if (selectedCourses.indexOf(course) === -1) {
                    selectedCourses.push(course);
                    var tableRow = '<tr><td>' + course + '</td><td><button name="deleteCourse" class="deleteCourse btn-danger" type="button">Delete</button></td></tr>';
                    document.getElementById('selectedCoursesTable').innerHTML += tableRow;
                    var optionToRemove = document.querySelector('#course option[value="' + course + '"]');
                    optionToRemove.remove();
                    saveSelectedCourses();
                }
            } else {
                alert("You can only select up to 5 courses.");
            }
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('deleteCourse')) {
                var course = event.target.closest('tr').querySelector('td:first-child').textContent;
                var index = selectedCourses.indexOf(course);

                if (index !== -1) {
                    selectedCourses.splice(index, 1);
                    event.target.closest('tr').remove();
                    var option = document.createElement('option');
                    option.value = course;
                    option.text = course;
                    document.getElementById('course').appendChild(option);
                    saveSelectedCourses();
                }
            }
        });

        // Save selected courses to localStorage
        function saveSelectedCourses() {
            localStorage.setItem('selectedCourses', JSON.stringify(selectedCourses));
        }
    });
</script>

</html>