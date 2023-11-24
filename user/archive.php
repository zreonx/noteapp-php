

<?php include_once 'includes/header.php' ?>

    
    <?php 
        if(isset($_POST['submitEdit'])) { 
            $id = $_POST['id'];
            $title = $_POST['titleView'];
            $desc = $_POST['descriptionView'];

            date_default_timezone_set('Asia/Manila');
            $dates = date('Y-m-d h:i:sa');

            $sql = "UPDATE notes SET title = '$title', description = '$desc', deleted_at = '$dates' WHERE id = '$id'";

            $result = mysqli_query($conn, $sql);
            
        }
    ?>

    <?php
        echo (isset($_GET['deleted']) && $_GET['deleted'] == 'true') ? ' <div class="alert alert-danger " role="alert"> Notes has been permanently deleted. </div> ' : "" ;
    ?>

    <div class="allnotes">
        <?php
            $uid = $_SESSION['user_data']['user_id'];

            $select = "SELECT * FROM notes WHERE user_id = '$uid' AND status = 'deleted' ORDER BY deleted_at DESC";
                
            $result = mysqli_query($conn, $select);

            if(mysqli_num_rows($result) > 0) { 

                while ($row = mysqli_fetch_assoc($result)) { 

                    echo '
                    <div class="card notes hvr-float myshadow d-flex flex-column" data="'. $row['id'] .'">
                        <div class="card-body note pb-1">
                            <h1 class="ntitle fs-6 m-0">'. $row['title'] .'</h1>
                            <p class="date size-mini  m-0">'. date("M, d Y h:i A", strtotime($row['created_at'])) .'</p>
                            <div class="py-1 note-data">
                                <p class="ndesc m-0 mt-1">'. $row['description'] .'</p>
                            </div>
                        </div>
                        <div class="card-footer border-0 nfoot d-flex gap-2 pt-0 mt-auto">
                        </div>
                    </div>
                    ';
                }

            }else {
                echo "<div class='notfound'> <img src='https://img.freepik.com/free-vector/hand-drawn-no-data-illustration_23-2150696458.jpg?w=740&t=st=1700788318~exp=1700788918~hmac=c8c87324c334bb85a5199db6eed48c266da26a70dd94c24d913b9065f958d872' /><h1 class='text-center fs-5 text-secondary'> No archive notes found </h1> </div>
                    
                ";
            }
            
        ?>
    </div>

    <script>
        let noteObj = document.getElementsByClassName("notes");

        let disableEdit = (elem) => {
           let {nId, title, desc} = elem;
           let inputs = [nId, title, desc];

           inputs.forEach((value) => {
                value.setAttribute('readonly', null);
                value.style.background = "#ececec";
           });

        };


        for(let i = 0; i < noteObj.length; i++) {
            let id = noteObj[i].getAttribute('data');

            noteObj[i].addEventListener('click', () => {
                $.ajax({
                    type: "POST",
                    url: "getnotes.php",
                    data: {
                        id : id,
                    },
                    success: function(result) {
                        let data = JSON.parse(result);

                        let nId = document.getElementById('nid');
                        let title = document.getElementById('title');
                        let desc = document.getElementById('description');

                        nId.value = data.id;
                        title.value = data.title;
                        desc.value = data.description;

                        disableEdit({nId, title, desc});
                        let deleteBtn = document.getElementById('delete-btn');


                        let page_name = '<?php echo $page_name ?>';
                        if(page_name == 'archive.php') {
                            deleteBtn.setAttribute('href', "deletepermanent.php?id="+ data.id +"");
                            deleteBtn.setAttribute('target', '_self');
                        }else {
                            deleteBtn.setAttribute('href', "deletenote.php?id="+ data.id +"");
                            deleteBtn.setAttribute('target', '_self');
                        }

                        
                        $("#editNote").modal("show");
                    }
                })
            });


            
        }
    </script>

<?php include_once 'includes/footer.php' ?>




    

