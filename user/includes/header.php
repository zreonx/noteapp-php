<?php require_once '../db.php'; ?>

<?php
    $page_name = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOTEAPP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/hover.css">
    <link rel="stylesheet" href="../css/style.css?v1.9">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

    <div class="container-fluid bodyName">

                <div class="user-nav d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <a href="index.php" class="btn btn-primary"> <span class="size-def"><i class="fa-solid fa-note-sticky "></i> Notes</span></a>
                        <a href="archive.php" class="btn btn-primary"> <span class="size-def"><i class="fa-solid fa-box-archive"></i> Archive</span></a>
                    </div>
                    <div>
                        <a href="../logout.php" class="btn btn-primary"> <span class="size-def">Logout</span></a>
                    </div>
                </div>
                <?php 
                 

                    if(isset($_POST['submit'])) {
                        $title = $_POST['title'];
                        $desc = $_POST['description'];
                        $uid = $_SESSION['user_data']['user_id'];
                        date_default_timezone_set('Asia/Manila');
                        $dates = date('Y-m-d h:i:sa');
                        

                        $sql = "INSERT INTO notes (user_id, title, description, created_at, deleted_at, status) VALUES ('$uid', '$title', '$desc', '$dates', '', 'active');";
                    
                        $result = mysqli_query($conn, $sql);

                    }
                
                ?>

                <div class="py-2">
       

                <div class="modal fade boder-0 add-note-card" id="addNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content size-def">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fs-6" id="exampleModalLabel">Create Notes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body border-0 pt-0">
                            <form action="index.php" method="POST">
                                <div class="mb-2">
                                    <input type="text" class="form-control tb-d" name="title" required value="<?php echo (isset($_POST['email']) ? $_POST['email']  : "") ?>"  id="exampleFormControlInput1" placeholder="Title">
                                </div>
                                <div class="mb-3">
                                    <textarea name="description" class="form-control tb-d" id="" required cols="30" rows="10" placeholder="Type your notes here"></textarea>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm px-4">Create</button>
                                    <button data-bs-dismiss="modal" type="button" class="btn btn-danger btn-sm px-4">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>



                <div class="modal fade boder-0 add-note-card" id="editNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content size-def">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fs-6" id="exampleModalLabel">Note</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body border-0 pt-0">
                            <form action="<?php echo ($page_name == 'archive.php') ? "restorenote.php" : "index.php" ?>" method="POST">
                                <div class="mb-2">
                                    <input type="hidden" name="id" id="nid">
                                    <input type="text" class="form-control tb-d" name="titleView" id="title" value="<?php echo (isset($_POST['email']) ? $_POST['email']  : "") ?>"  id="exampleFormControlInput1" placeholder="title">
                                </div>
                                <div class="mb-3">
                                    <textarea name="descriptionView" id="description" class="form-control tb-d" cols="30" rows="10" placeholder="Type your notes here"></textarea>
                                </div>
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <div>
                                        <a href="#" onclick="deleteNote();" id="delete-btn" class="btn btn-danger btn-sm" ><i class="fa-solid fa-trash"></i> <?php echo ($page_name == 'archive.php') ? "Delete" : "" ?></a>
                                    </div>
                                    <div class="d-flex gap-2">

                                        <?php if ($page_name == 'archive.php'): ?>
                                            <button type="submit" name="<?php echo "submitRestore"; ?>" class="btn btn-success btn-sm px-4">Restore</button>
                                        <?php else: ?>
                                            <button type="submit" name="<?php echo "submitEdit"; ?>" class="btn btn-primary btn-sm px-4">Save Changes</button>
                                        <?php endif; ?>
                                        <button data-bs-dismiss="modal" type="button" class="btn btn-danger btn-sm px-4">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>

            <script>
                window.onload = () => {
                    function deleteNote() {
                        if ('<?php echo $page_name; ?>' == 'archive.php') {
                        // Display a confirmation dialog
                        var confirmed = confirm('Are you sure you want to delete?');
                        
                        // If user clicks "OK", continue with the deletion
                        if (!confirmed) {
                            e.preventDefault(); // Prevent the default action (following the link)
                            }
                        }
                    }
                }
            </script>
        </div>


