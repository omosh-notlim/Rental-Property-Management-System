<?php
    session_start();

    // error_reporting(0);

    include 'db_connection.php';
    include 'status.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

    <link rel="stylesheet" type="text/css" href="adminPanel.css">
    
    <link rel="stylesheet" href="fontboot/bootstrap-icons.css">


    <title>Ticket</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

   <!--  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js" integrity="sha512-t2JWqzirxOmR9MZKu+BMz0TNHe55G5BZ/tfTmXMlxpUY8tsTo3QMD27QGoYKZKFAraIPDhFv56HLdN11ctmiTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

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
            <li><a href="home"><i class="bi bi-house-fill"></i> Houses</a></li>
            <li><a href="about#contact-us-now"><i class="bi bi-body-text"></i> Raise ticket</a></li>
            <li>
                <a href="#" class="serv-btn house-mng"><i class="bi bi-person-lines-fill"></i> 
                    Profile <i class="bi bi-caret-down-fill"></i>
                </a>
                <ul class="serv-show">
                    <li><a href="#userDetails">Profile</a></li>
                    <li><a href="#rentview">View all</a></li>
                    <li><a href="#rentsearch">Rent search</a></li>
                </ul>
            </li>
            <li><a href="logout"><i class="bi bi-toggles2"></i>  Switch account</a></li>
            <li><a href="logout">Logout <i class="bi bi-power"></i></a></li>
        </ul>
    </nav>

    <div class="content-area">
        <div class="wrapper">
            <div id="userDetails" class="myForm">
                <form action="" method="post" enctype="multipart/form-data">
                    <fieldset>

                            <?php
                                // error_reporting(0);

                                $errors = "";
                                $errors2 = "";

                                if(isset($_SESSION['mail'])){
                                     // = ;
                                     $searchDetail = mysqli_real_escape_string($db, $_SESSION['mail']);

                                     if(isset($_POST['update'])){
                                        $name = mysqli_real_escape_string($db, $_POST['name']);
                                        $email = mysqli_real_escape_string($db, $_POST['email']);
                                        $phone = mysqli_real_escape_string($db, $_POST['phone']);
                                        $role = mysqli_real_escape_string($db, $_POST['role']);
                                        $password = mysqli_real_escape_string($db, $_POST['password']);
                                        $conpassword = mysqli_real_escape_string($db, $_POST['conpassword']);
                                        $houseID = mysqli_real_escape_string($db, $_POST['houseID']);
                                        
                                        if($password !== $conpassword) {
                                            $errors = "Password mismatch!!";
                                        }

                                        if ($errors != ""){
                                            echo "<span style='color:red; font-weight: 800'>$errors</span>";
                                        }

                                        //updating details........
                                        if ($errors == "") {
                                            $query = "UPDATE users SET name='$name', phone='$phone', role='$role', password='$password', conpassword='$conpassword', houseID='$houseID' WHERE email='$email'";
                                            $query_run = mysqli_query($db, $query);

                                            if($query_run){
                                                $errors2 = "Data updated.....";

                                                if ($errors2 != ""){
                                                    echo "<span style='color:green; font-weight: 800'>$errors2</span>";
                                                }

                                                header('location: profile');
                                            }else{
                                                echo '<script type="text/javascript"> alert("Upload failed")</script>';
                                                header('location: profile');
                                            }
                                        }
                                        
                                    }

                                    $res = mysqli_query($db, "SELECT * from users WHERE email='$searchDetail'");
                                    while ($row = mysqli_fetch_array($res)) {
                                        ?>
                                <div class="user-details">

                                        <div class="input-box">
                                            <span class="details"><label for="name">Name:</label></span><br>
                                            <input type="text" name="name" id="name" value="<?php echo $row['name']; ?>" required/>
                                        </div>
                                        <div class="input-box">
                                            <span class="details"><label for="email">Email:</label></span><br>
                                            <input type="email" readonly name="email" id="email" value="<?php echo $row['email']; ?>" required/>
                                        </div>
                                        <div class="input-box">
                                            <span class="details"><label for="phone">Phone no:</label></span><br>
                                            <input type="text" name="phone" id="phone" value="<?php echo $row['phone']; ?>" required/>
                                        </div>
                                        <div class="input-box">
                                            <span class="details"><label for="phone">User role:</label></span><br>
                                            <input type="text" readonly name="role" id="role" value="<?php echo $row['role']; ?>" required/>
                                        </div>
                                        <div class="input-box">
                                            <span class="details"><label for="password">Set password:</label></span><br>
                                            <input type="Password" name="password" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" value="<?php echo $row['password']; ?>" required/>
                                        </div>
                                        <div class="input-box">
                                            <span class="details"><label for="conpassword">Confirm password:</label></span><br>
                                            <input type="Password" name="conpassword" id="conpassword" placeholder=" Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" value="<?php echo $row['conpassword']; ?>" required/>
                                        </div>
                                        <div class="input-box">
                                            <span class="details"><label for="houseID">House ID:</label></span><br>
                                            <input type="text" readonly name="houseID" id="houseID" value="<?php echo $row['houseID']; ?>" required/>
                                        </div>
                                        <div class="input-box" >
                                            <?php
                                                if($row['houseID'] != 'null'){ ?>
                                                    <button> <?php
                                                        if(isset($_SESSION['mail'])){

                                                         echo " <a href='houseView?houseID={$row['houseID']}'> View House </a>"; 
                                                        }else{
                                                            echo '<script type="text/javascript"> alert("You are logged out")</script>';
                                                        } 
                                                    ?></button>
                                                <?php } else{ ?>
                                                    <button type="button" disabled> <?php

                                                         echo "View House"; 
                                                    ?></button>
                                                <?php }
                                             ?>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>

                        <div class="gen-bt">
                            <div class="button">
                                <input type="submit" name="update" value="UPDATE"/>
                            </div>
                            <div class="button">
                                <input type="reset" name="rest" value="CLEAR"/>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            
            <div id="rentview" class="myForm">
            <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>ALL RENT PAYMENTS</legend>

            <div class="table-users" id="all-users">
                <?php
                    $myrent = $_SESSION['mail'];

                    $sql = "SELECT * FROM payments WHERE tenantEmail='$myrent' ORDER BY currentDate DESC";
                    $res_data = mysqli_query($db,$sql);
                    ?>
                    <table>
                        <tr>
                            <th>Transaction number</th>
                            <th>Payment ID</th>
                            <th>Amount (KSH)</th>
                            <th>Receipt number</th>
                            <th>Phone number</th>
                            <th>House ID</th>
                            <th>Tenant email</th>
                            <th>Landlord email</th>
                            <th>Date-Time (Y-M-D)</th>
                        </tr>
                    
                    <?php
                    while($row = mysqli_fetch_array($res_data)){
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['payment_id']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['receiptnumber']; ?></td>
                        <td><?php echo $row['payerphone']; ?></td>
                        <td><?php echo $row['houseID']; ?></td>
                        <td><?php echo $row['tenantEmail']; ?></td>
                        <td><?php echo $row['landlordEmail']; ?></td>
                        <td><?php echo $row['currentDate']; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </table>
            </div>
            </fieldset>
            </form>
            </div>

            <!-- ----------table 2 ------------ -->
            <div id="rentsearch" class="myForm">
            <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>RENT PAYMENTS SEARCHING</legend>

            <div class="user-details">
                <div class="input-box">
                    <span class="details"><label for="searchinfo"> Start date:  </label></span><br>
                    <input type="datetime-local" id="date-1" name="date-1">
                </div>
                <div class="input-box">
                    <span class="details"><label for="searchinfo"> End date:  </label></span><br>
                    <input type="datetime-local" id="date-2" name="date-2">
                </div>
            </div>
            <div class="gen-bt">
                <div class="button button-2nd">
                    <input type="submit" name="find" value="SEARCH DATE"/>
                </div>
            </div>
            <hr>


            <div class="user-details">
                <div class="input-box">
                    <span class="details"><label for="searchinfo"> Search info:  </label></span><br>
                    <input type="text" name="searchinfo" id="searchinfo" placeholder="amount/receipt number/house id..." />
                </div>
            </div>
            <div class="gen-bt">
                <div class="button button-2nd">
                    <input type="submit" name="find2" value="FIND"/>
                </div>
            </div>
            <hr>

            <div class="table-users">
                <?php

                    $searchinfo = mysqli_real_escape_string($db, $_POST['searchinfo']);
                    $date_1 = mysqli_real_escape_string($db, $_POST['date-1']);
                    $date_2 = mysqli_real_escape_string($db, $_POST['date-2']);

                    if(isset($_POST['find'])){
                        $sql2 = "SELECT * from payments WHERE tenantEmail='$myrent' AND currentDate BETWEEN '$date_1' AND '$date_2' ORDER BY currentDate DESC";
                    
                    $res_data2 = mysqli_query($db,$sql2);
                    ?>
                    <table>
                        <tr>
                            <th>Transaction number</th>
                            <th>Payment ID</th>
                            <th>Amount (KSH)</th>
                            <th>Receipt number</th>
                            <th>Phone number</th>
                            <th>House ID</th>
                            <th>Tenant email</th>
                            <th>Landlord email</th>
                            <th>Date-Time (Y-M-D)</th>
                        </tr>
                    
                    <?php
                    while($row2 = mysqli_fetch_array($res_data2)){
                    ?>
                    <tr>
                        <td><?php echo $row2['id']; ?></td>
                        <td><?php echo $row2['payment_id']; ?></td>
                        <td><?php echo $row2['amount']; ?></td>
                        <td><?php echo $row2['receiptnumber']; ?></td>
                        <td><?php echo $row2['payerphone']; ?></td>
                        <td><?php echo $row2['houseID']; ?></td>
                        <td><?php echo $row2['tenantEmail']; ?></td>
                        <td><?php echo $row2['landlordEmail']; ?></td>
                        <td><?php echo $row2['currentDate']; ?></td>
                    </tr>
                    <?php
                    }
                    }elseif(isset($_POST['find2'])){
                        $sql2 = "SELECT * from payments WHERE tenantEmail='$myrent' AND (id='$searchinfo' or payment_id='$searchinfo' or amount='$searchinfo' or receiptnumber='$searchinfo' or payerphone='$searchinfo' or houseID='$searchinfo' or tenantEmail='$searchinfo' or landlordEmail='$searchinfo')";
                    
                    $res_data2 = mysqli_query($db,$sql2);
                    ?>
                    <table>
                        <tr>
                            <th>Transaction number</th>
                            <th>Payment ID</th>
                            <th>Amount (KSH)</th>
                            <th>Receipt number</th>
                            <th>Phone number</th>
                            <th>House ID</th>
                            <th>Tenant email</th>
                            <th>Landlord email</th>
                            <th>Date-Time (Y-M-D)</th>
                        </tr>
                    
                    <?php
                    while($row2 = mysqli_fetch_array($res_data2)){
                    ?>
                    <tr>
                        <td><?php echo $row2['id']; ?></td>
                        <td><?php echo $row2['payment_id']; ?></td>
                        <td><?php echo $row2['amount']; ?></td>
                        <td><?php echo $row2['receiptnumber']; ?></td>
                        <td><?php echo $row2['payerphone']; ?></td>
                        <td><?php echo $row2['houseID']; ?></td>
                        <td><?php echo $row2['tenantEmail']; ?></td>
                        <td><?php echo $row2['landlordEmail']; ?></td>
                        <td><?php echo $row2['currentDate']; ?></td>
                    </tr>
                    <?php
                    }
                    }
                    ?>
                    </table>    
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


    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <!-- <script src="swiperjQuery.js"></script> -->

    <script>
        const swiper = new Swiper('.swiper', {
            // autoplay: {
            //     delay: 10000,
            //     disableOnInteraction: false,
            // },

            loop: true,

            pagination:{
                el: '.swiper-pagination',
                // clickable: true,
            },

  
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

        });

    </script>
</body>
</html>