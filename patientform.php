<?php
// Start the session
session_start();

// Include your database connection logic here
require_once("patientconn.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $ssn = $_POST["ssn"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    
    // Validate the form data (you may add more validation as needed)
    if (!empty($email) && !empty($password) && !empty($ssn) && !empty($name)) {
        // Perform your login authentication logic here (e.g., querying the database)
        // Example:
        $sql = "SELECT * FROM patient WHERE Email = ? AND Password = ? AND SSN = ? AND Name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $email, $password, $ssn, $name); // Assuming SSN is a string, adjust "sss" if needed
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // User authenticated successfully, fetch user details
            $row = $result->fetch_assoc();
            $name = $row['name']; // Assuming 'name' is the column name for the user's name
            // Set session variable and redirect
            $_SESSION["name"] = $name;
            header("Location: patientpage.php");
            exit();
        } else {
            // Invalid credentials, display error message
            echo "<div class='error'>Invalid email, password, or SSN.</div>";
        }
    } else {
        // Username, password, or SSN is empty, display error message
        echo "<div class='error'>Email, password, and SSN are required.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--<img src="adminimage.jpg" alt="Description for image" width="1200" height="600" class="example">-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="registration.css" />
</head>
<body>

<div class="form" id="form" name="form">
    <form method="post" action="patientform.php">
        <h1 class="h1">Login</h1>
        <div class="email"><ul>Email: <input type="email" name="email" placeholder="Enter your email"/> <br/></ul></div>
        <div class="name"><ul>SSN: <input type="number" name="ssn" placeholder="Enter your ssn"/> <br/></ul></div>
        <div class="ssn"><ul>Password: <input type="password" name="password" placeholder="Enter your password"/> <br/></ul></div>
        <div class="ssn"><ul>Name: <input type="text" name="name" placeholder="Enter your name"/> <br/></ul></div>
        <input class="form_button" type="Submit"/></br>
        <div class="others">
            Not registered yet? Click <a href="patientregistration.html">here</a> to register
        </div>
    </form>
</div>

</body>
</html>