<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editid"])) {
    $editid = $_POST["editid"];
    $editUsername = filter_input(INPUT_POST, "edit-username", FILTER_SANITIZE_SPECIAL_CHARS);
    $editPhone = filter_input(INPUT_POST, "edit-phone", FILTER_SANITIZE_SPECIAL_CHARS);

    // Update the user data in the database
    $sql = "UPDATE usertable SET username = '$editUsername', phone = '$editPhone' WHERE id = $editid";
    mysqli_query($conn, $sql);

    // Redirect back to index.php after updating
    header("Location: index.php");
}
?>
