<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") 
    {
        $recipient = $_POST["mail"];
        //echo "<script>alert('".$recipient."');<script>";
        $username = $_POST["usn"];
        $otp = rand(100000, 999999);


        $result = mail($recipient, "OTP for Bus time", "Your OTP to Sign UP into Bus Time: '" . $otp . "'.");
        if($result)
        {
            echo'<script>alert("OTP sent to your mail.");<script>';
        }
    }
?>