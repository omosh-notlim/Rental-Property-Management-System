<?php
    session_start();
    // error_reporting(0);

    include 'db_connection.php';
    include 'status.php';

    if(isset($_GET['ID'])){
        $id = mysqli_real_escape_string($db, $_GET['ID']);

        $sql33 = "SELECT * from tickets where id='$id'"; 
        $res33 = mysqli_query($db, $sql33);
        $row33 = mysqli_fetch_array($res33);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="adminPanel.css">
    
    <link rel="stylesheet" href="fontboot/bootstrap-icons.css">
    <title>Tickets</title>
</head>
<body>
    <div class="btn">
        <i class="bi bi-list"></i>
        <i class="bi bi-x"></i>
    </div>
    <nav class="sidebar">
        <div class="text"><i class="bi bi-person-circle"></i> 
            <?php

            if(isset($_SESSION['mail'])){
                echo $_SESSION['mail'];
            }

            ?>
        </div>
        <ul>
            <li><a href="dashboard"><i class="bi bi-windows"></i>  Dashboard</a></li>
            <li><a href="landlordreports"><i class="bi bi-graph-down-arrow"></i> Landlord reports</a></li>
            <li><a href="ticketreading"><i class="bi bi-ticket-perforated"></i> View tickets</a></li>
            <li><a href="adminpanel"><i class="bi bi-house-door"></i> House management</a></li>
            <li><a href="adminpaneltwo"><i class="bi bi-people-fill"></i> User management</a></li>
            <li><a href="home"><i class="bi bi-house-fill"></i> Houses</a></li>
            <li><a href="about#contact-us-now"><i class="bi bi-body-text"></i> Raise ticket</a></li>
            <li><a class="dropdown-item" href="profile"><i class="bi bi-person-lines-fill"></i>   Profile</a></li>
            <li><a href="logout"><i class="bi bi-toggles2"></i>   Switch account</a></li>
            <br>
            <br>
            <li><a href="logout">Logout <i class="bi bi-power"></i></a></li>
        </ul>
    </nav>

    <div class="content-area">
        <div class="wrapper">

            <div id="#" class="myForm">
                <form action="" method="post" enctype="multipart/form-data">
                    <fieldset>

                        <?php
                            // error_reporting(0);
                            $errors2 = "";

                            include 'db_connection.php';

                            if(isset($_POST['delete'])){
                                if(isset($_SESSION['mail'])){
                                    $errors = "";
                                    $ticketno = mysqli_real_escape_string($db, $_POST['ticketno']);

                                    //Delete house......
                                    $query = "DELETE FROM tickets WHERE id='$ticketno'";
                                    $query_run = mysqli_query($db, $query);

                                    if($query_run){
                                        $errors = "Data deleted.....";
                                        if ($errors != ""){
                                            echo "<span style='color:red; font-weight: 800'>$errors</span>";
                                        }

                                        header('location: updateuser');
                                    }else{
                                        echo '<script type="text/javascript"> alert("Upload failed")</script>';
                                        header('location: updateuser');
                                    }
                                }else{
                                    echo '<script type="text/javascript"> alert("You are logged out")</script>';
                                }
                            }

                            if(isset($_POST['update'])){
                                if(isset($_SESSION['mail'])){
                                    $ticketno = mysqli_real_escape_string($db, $_POST['ticketno']);
                                    $status = mysqli_real_escape_string($db, $_POST['status']);
                                    $handler = mysqli_real_escape_string($db, $_POST['handler']);
                                
                                    $query = "UPDATE tickets SET status='$status', handler='$handler' WHERE id='$ticketno'";
                                    $query_run = mysqli_query($db, $query);

                                    if($query_run){
                                        $errors2 = "Data updated.....";

                                        if ($errors2 != ""){
                                            echo "<span style='color:green; font-weight: 800'>$errors2</span>";
                                        }
                                    }else{
                                        echo '<script type="text/javascript"> alert("Upload failed")</script>';
                                    }
                                }
                            }
                        ?>
                        <div class="user-details">
                            <div class="input-box">
                                <span class="details"><label for="ticketno">Ticket number:</label></span><br>
                                <input type="text" name="ticketno" id="ticketno" value="<?php echo $row33['id']; ?>" readonly required/>
                            </div>
                            <div class="input-box">
                                <span class="details"><label for="raisedby">Raised by:</label></span><br>
                                <input type="text" name="raisedby" id="raisedby" value="<?php echo $row33['raisedby']; ?>" readonly required/>
                            </div>
                            <div class="input-box">
                                <span class="details"><label for="email">Email:</label></span><br>
                                <input type="email" name="email" id="email" value="<?php echo $row33['email']; ?>" readonly required/>
                            </div>
                            <div class="input-box">
                                <span class="details"><label for="concern">Concern:</label></span><br>
                                <textarea name="concern" id="concern" readonly><?php echo $row33['concern']; ?></textarea>
                            </div>
                            <div class="input-box">
                                <span class="details"><label for="datetime">Date-time:</label></span><br>
                                <input type="text" readonly name="datetime" id="datetime" value="<?php echo $row33['currentdate']; ?>" readonly required/>
                            </div>
                            <div class="input-box">
                                <span class="details"><label for="handler">Handled by:</label></span><br>
                                <input type="text" name="handler" id="handler" value="<?php echo $row33['handler']; ?>" required/>
                            </div>
                            <div class="input-box">
                                <span class="details"><label for="status">Status:</label></span><br>
                                <select name="status" id="status">
                                    <option value="<?php echo $row33['status']; ?>" selected="selected"><?php echo $row33['status']; ?></option>
                                    <option value="closed">Closed</option>
                                    <option value="pending">Pending</option>
                                    <option value="open">Open</option>
                                </select>
                            </div>           
                        </div>

                        <div class="gen-bt">
                            <div class="button">
                                <input type="submit" name="update" value="UPDATE"/>
                            </div>
                            <div class="button button-2nd">
                                <input type="button" name="del" value="DELETE" onclick="document.getElementById('id01').style.display='block'"/>
                            </div>



                            <div id="id01" class="modal">
                                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                                <div class="modal-content">
                                  <div class="container-delete">
                                    <h1>Delete house</h1>
                                    <p>Are you sure you want to delete this house?</p>

                                    <div class="clearfix">
                                      <button type="button" class="cancelbtn" onclick="cancel()">Cancel</button>
                                      <button type="submit" name="delete" class="deletebtn">Delete</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>  
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="scrolljQuery.js"></script>
    <script>
        $('.btn').click(function(){
            $(this).toggleClass("click");
            $('.sidebar').toggleClass("show");
        });

        $('.feat-btn').click(function(){
            $('nav ul .feat-show').toggleClass("show");
        });

        $('.serv-btn').click(function(){
            $('nav ul .serv-show').toggleClass("show1");
        });

        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

    </script>

    <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }

        function cancel(){
            modal.style.display = "none";
        }
    </script>

</body>
</html>