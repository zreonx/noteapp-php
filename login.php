<?php 
    include_once 'includes/header.php';

    
?>

<div class="container py-4 px-3">
    <h1 class="fs-5 text-center">Login</h1>
    <div class="card c-login mx-auto">
        
        <div class="card-body"><S></S>
        <?php 
            if(isset($_POST['submit'])) {

                    $email = $_POST['email'];
                    $password = $_POST['password'];
                
                    $sql = "SELECT * FROM accounts INNER JOIN users ON accounts.id = users.user_id WHERE accounts.email = '$email' AND accounts.password = '$password'";

                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) { 
                        $row = mysqli_fetch_assoc($result);

                        $user_data = array(
                            "user_id" => $row["user_id"],
                            "email" => $row["email"],
                            "firstname" => $row["firstname"],
                            "lastname" => $row["lastname"],
                            "gender" => $row["gender"],
                        );

                        $_SESSION["user_data"] = $user_data;

                        header("location: user/index.php");

                    }else {
                        echo '
                                <div class="alert alert-danger" role="alert">
                                    Invalid email or password.
                                </div>
                            ';
                    }
            }
        ?>

    <?php
        echo (isset($_GET['register']) && $_GET['register'] == 'true') ? ' <div class="alert alert-success " role="alert">Account has been created successfully. You can now log in.</div> ' : "" ;
    ?>

    
        

        <form action="login.php" method="POST">
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" required class="form-control tb-d" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email']  : "") ?>"  id="exampleFormControlInput1" placeholder="Email">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Password</label>
                <input type="password" required class="form-control tb-d" name="password" value="" id="exampleFormControlInput1" placeholder="Password">
            </div>
            <div>
                <button type="submit" name="submit" class="btn btn-primary btn-sm px-4">Login</button>
            </div>
        </form>
        </div>
    </div>
</div>







<?php include_once 'includes/footer.php' ?>
