<?php 
    include_once 'includes/header.php';

    
?>

<div class="container py-4 px-3">
    <h1 class="fs-5 text-center">Signup</h1>
    <div class="card c-login mx-auto">
        
        <div class="card-body"><S></S>
        <?php 
            if(isset($_POST['submit'])) {

                    $email = $_POST['email'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $gender = $_POST['gender'];

                    $selectEmail = "SELECT * FROM accounts WHERE email = '$email'";
                    $resultEmail = mysqli_query($conn, $selectEmail);
                    if(mysqli_num_rows($resultEmail) > 0) { 

                        echo '<div class="alert alert-danger" role="alert"> Email already exist. </div>';

                    }else {

                        $selectUser = "SELECT username FROM accounts WHERE username = '$username';";

                        $result = mysqli_query($conn, $selectUser);
                        if(mysqli_num_rows($result) > 0) {
                            echo '<div class="alert alert-danger" role="alert"> Username already exist. </div>';
                        }else {
                            $insert = "INSERT INTO accounts (username, email, password, user_type, status) VALUES ('$username', '$email', '$password', 'user', 'active');";
                            $resultAcc = mysqli_query($conn, $insert);
                            if($resultAcc) {

                                $selectEmail = "SELECT * FROM accounts WHERE email = '$email'";
                                $resultSelect = mysqli_query($conn, $selectEmail);
                                $row = mysqli_fetch_assoc($resultSelect);
                                
                                $id = $row["id"];
                                
                                $insertPerson = "INSERT INTO users (user_id, firstname, lastname, gender) values ('$id', '$firstname', '$lastname', '$gender');";
                                $resultPerson = mysqli_query($conn, $insertPerson);

                                if($resultPerson) { 
                                    header("location: login.php?register=true");
                                }
                            }else{
                                echo '<div class="alert alert-danger" role="alert"> Failed to create an account. </div>';
                            }
                        }

                    }

                    //$sql = "SELECT * FROM accounts INNER JOIN users ON accounts.id = users.user_id WHERE accounts.email = '$email' AND accounts.password = '$password'";

                    // $result = mysqli_query($conn, $sql);
                    // if(mysqli_num_rows($result) > 0) { 
                    //     $row = mysqli_fetch_assoc($result);

                    //     $user_data = array(
                    //         "user_id" => $row["user_id"],
                    //         "email" => $row["email"],
                    //         "firstname" => $row["firstname"],
                    //         "lastname" => $row["lastname"],
                    //         "gender" => $row["gender"],
                    //     );

                    //     $_SESSION["user_data"] = $user_data;


                    //     header("location: user/index.php");


                    // }else {
                    //     echo '
                    //             <div class="alert alert-danger" role="alert">
                    //                 Invalid email or password.
                    //             </div>
                    //         ';
                    // }
            }
        ?>
        <form action="signup.php" method="POST">
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Firstname</label>
                <input type="text" required class="form-control tb-d" name="firstname" value="<?php echo (isset($_POST['firstname']) ? $_POST['firstname']  : "") ?>"  id="exampleFormControlInput1" placeholder="Firstname">
            </div>
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Lastname</label>
                <input type="text" required class="form-control tb-d" name="lastname" value="<?php echo (isset($_POST['lastname']) ? $_POST['lastname']  : "") ?>"  id="exampleFormControlInput1" placeholder="Lastname">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Gender</label>
                <div class="d-flex gap-2">
                    <div class="form-check">
                        <input class="form-check-input" required type="radio" value="male" name="gender">
                        <label class="form-check-label">Male </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" required type="radio" value="female" name="gender">
                        <label class="form-check-label">Female </label>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control tb-d" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email']  : "") ?>"  id="exampleFormControlInput1" placeholder="Email">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Username</label>
                <input type="text" required class="form-control tb-d" name="username" value="<?php echo (isset($_POST['username']) ? $_POST['username']  : "") ?>" id="exampleFormControlInput1" placeholder="Username">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Password</label>
                <input type="password" required class="form-control tb-d" name="password" value="" id="exampleFormControlInput1" placeholder="Password">
            </div>
            <div>
                <button type="submit" name="submit" class="btn btn-primary btn-sm px-4">Register</button>
            </div>
        </form>
        </div>
    </div>
</div>







<?php include_once 'includes/footer.php' ?>
