<?php
include("database.php");
if (isset($_GET["deleteid"])) {
    $deleteid = $_GET["deleteid"];
    $sql = "DELETE FROM usertable WHERE id = $deleteid";
    if (mysqli_query($conn, $sql) == TRUE) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Simple Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-3">

            </div>
            <div class="col-sm-6 border p-4 mb-5">
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                    <div class="input-group">
                        <span class="input-group-text">Username</span>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="input-group mt-2">
                        <span class="input-group-text">Phone No</span>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="input-group mt-2">
                        <span class="input-group-text">Password</span>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="d-grid mt-4">
                        <input type="submit" class="btn btn-primary" role="button">
                    </div>
                </form>
            </div>
            <div class="col-sm-3">

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>

<?php

function f1()
{
    echo <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
    <title></title>
    </head>
    <body>
    <div class="container">
    <div class="alert alert-danger alert-dismissible mt-2">
        <button class="btn-close" data-bs-dismiss="alert"></button>
    Something went wrong!
    </div>
    </div>
    </body>
    </html>
HTML;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    //$username = $_REQUEST['username'];
    //$password = $_REQUEST['password'];
    if (empty($username)) f1();
    else if (empty($password)) f1();
    else if (empty($phone)) f1();
    else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if (usernameExists($username, $conn)) {
?>
            <script>
                alert("Username already exists!");
            </script>
<?php
        } else {

            $sql = "INSERT INTO usertable (username, phone, password) VALUES ('$username', '$phone', '$hash')";
            mysqli_query($conn, $sql);
        }
    }
}
function usernameExists($username = '', $conn)
{
    if (empty($username)) {
        return true;
    }
    // check username
    $sql = "SELECT username FROM usertable WHERE username = '$username'";
    $rows = mysqli_num_rows(mysqli_query($conn, $sql));
    return $rows;
}
$sql = "SELECT * FROM usertable";
$query  = mysqli_query($conn, $sql);
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-9">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Phone Number</th>
                    <th>Action</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $id = $row['id'];
                    $username = $row['username'];
                    $phone = $row['phone'];
                ?>
                    <tr>
                        <td><?php echo $id ?></td>
                        <td><?php echo $username ?></td>
                        <td><?php echo $phone ?></td>
                        <td>
                            <span class="btn btn-success">
                                <a href="#" class="text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $id; ?>">Edit</a>
                            </span>
                            <span class="btn btn-danger">
                                <a href="index.php?deleteid=<?php echo $id ?>" class="text-white text-decoration-none">Delete</a>
                            </span>
                        </td>
                    </tr>
                    <div class="modal fade" id="editModal<?php echo $id; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <!-- Edit Modal START -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Edit Form -->
                                    <form action="update.php" method="post">
                                        <input type="hidden" name="editid" value="<?php echo $id; ?>">
                                        <div class="mb-3">
                                            <label for="edit-username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="edit-username" name="edit-username" value="<?php echo $username; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-phone" class="form-label">Phone No</label>
                                            <input type="text" class="form-control" id="edit-phone" name="edit-phone" value="<?php echo $phone; ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Modal END -->
                    </div>
                <?php
                }
                ?>
            </table>

        </div>
    </div>
</div>