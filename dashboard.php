<?php
    session_start();

    // error_reporting(0);

    include 'db_connection.php';
    include 'status.php';

?>

<?php
    $line_query = "SELECT * FROM monthlyearning";
    $line_query_run = mysqli_query($db, $line_query);

    $test=array();
    $count=0;

    while($line_row = mysqli_fetch_array($line_query_run)){
        $test[$count]["label"]=$line_row["Month"];
        $test[$count]["y"]=$line_row["Amount"];

        $count=$count+1;
    }

    $pie_query = "SELECT * FROM yearlyearning";
    $pie_query_run = mysqli_query($db, $pie_query);

    $test2=array();
    $count2=0;

    while($pie_row = mysqli_fetch_array($pie_query_run)){
        $test2[$count2]["label"]=$pie_row["Year"];
        $test2[$count2]["y"]=$pie_row["Amount"];

        $count2=$count2+1;
    }                
?>

<?php
 
    $query = "SELECT COUNT(*) AS my_tenants FROM users WHERE role='tenant' AND houseID!='null'";
    $query_run = mysqli_query($db, $query);

    $row = mysqli_fetch_assoc($query_run);

    $query2 = "SELECT COUNT(*) AS not_tenants FROM users WHERE role='tenant' AND houseID ='null'";
    $query_run2 = mysqli_query($db, $query2);

    $row2 = mysqli_fetch_assoc($query_run2);
    // echo '<h4>'.$row['tenants2'].'</h4>';

    $test4 = array( 
        array("y" => $row['my_tenants'], "label" => "Active tenants" ),
        array("y" => $row2['not_tenants'], "label" => "Inactive tenants" ),
    );
 
?>

<?php
 
    $query = "SELECT COUNT(*) AS occupied FROM houseinfo WHERE houseStatus ='Occupied'";
    $query_run = mysqli_query($db, $query);

    $row = mysqli_fetch_assoc($query_run);

    $query2 = "SELECT COUNT(*) AS unoccupied FROM houseinfo WHERE houseStatus ='Vaccant'";
    $query_run2 = mysqli_query($db, $query2);

    $row2 = mysqli_fetch_assoc($query_run2);
    // echo '<h4>'.$row['tenants2'].'</h4>';

    $test3 = array( 
        array("y" => $row['occupied'], "label" => "Occupied houses" ),
        array("y" => $row2['unoccupied'], "label" => "Vaccant houses" ),
    );
 
?>          


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

    <link rel="stylesheet" type="text/css" href="adminPanel.css">
    
    <link rel="stylesheet" href="fontboot/bootstrap-icons.css">


    <title>Dashboard</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js" integrity="sha512-t2JWqzirxOmR9MZKu+BMz0TNHe55G5BZ/tfTmXMlxpUY8tsTo3QMD27QGoYKZKFAraIPDhFv56HLdN11ctmiTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>

    <script>
        window.onload = function () {
         
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Income Generated (Last 12 Months)"
                },
                axisY: {
                    title: "Amount(KSH)"
                },
                data: [{
                    type: "line",
                    dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

            var chart2 = new CanvasJS.Chart("chartContainer2", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "Income Generated Per Year"
                },
                axisY: {
                    title: "Amount(KSH)"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## tonnes",
                    dataPoints: <?php echo json_encode($test2, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart2.render();

            var chart3 = new CanvasJS.Chart("chartContainer3", {
                theme: "light2",
                animationEnabled: true,
                title: {
                    text: "Occupied Houses Against Unoccupied Houses"
                },
                data: [{
                    type: "pie",
                    indexLabel: "{y}",
                    yValueFormatString: "#,##0\" houses\"",
                    indexLabelPlacement: "inside",
                    indexLabelFontColor: "#36454F", //writings
                    indexLabelFontSize: 18,
                    indexLabelFontWeight: "bolder",
                    showInLegend: true,
                    legendText: "{label}",
                    dataPoints: <?php echo json_encode($test3, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart3.render();

            var chart4 = new CanvasJS.Chart("chartContainer4", {
                theme: "light1",
                animationEnabled: true,
                title: {
                    text: "Active Tenants Against Inactive Tenants"
                },
                data: [{
                    type: "doughnut",
                    indexLabel: "{symbol} {y}",
                    yValueFormatString: "#,##0\"\"",
                    showInLegend: true,
                    legendText: "{label} : {y}",
                    dataPoints: <?php echo json_encode($test4, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart4.render();



            // -------Charts download function
            $("#exportButton").click(function(){
                var pdf = new jsPDF('landscape');
                var chartTheme = chart.get("theme");
                chart.set("theme", "light2");
                var canvas = $("#chartContainer .canvasjs-chart-canvas").get(0);
                var dataURL = canvas.toDataURL();
                chart.set("theme", chartTheme);
                pdf.addImage(dataURL, 'JPEG',15, 15);
                pdf.save("monthly income.pdf");
            });

            $("#exportButton2").click(function(){
                var pdf2 = new jsPDF('landscape');
                var chartTheme2 = chart2.get("theme");
                chart2.set("theme", "light2");
                var canvas2 = $("#chartContainer2 .canvasjs-chart-canvas").get(0);
                var dataURL2 = canvas2.toDataURL();
                chart2.set("theme", chartTheme2);
                pdf2.addImage(dataURL2, 'JPEG',15, 15);
                pdf2.save("yearly income.pdf");
            });

            $("#exportButton3").click(function(){
                var pdf3 = new jsPDF('landscape');
                var chartTheme3 = chart3.get("theme");
                chart3.set("theme", "light2");
                var canvas3 = $("#chartContainer3 .canvasjs-chart-canvas").get(0);
                var dataURL3 = canvas3.toDataURL();
                chart3.set("theme", chartTheme3);
                pdf3.addImage(dataURL3, 'JPEG',15, 15);
                pdf3.save("houses chart.pdf");
            });

            $("#exportButton4").click(function(){
                var pdf4 = new jsPDF('landscape');
                var chartTheme4 = chart4.get("theme");
                chart4.set("theme", "light1");
                var canvas4 = $("#chartContainer4 .canvasjs-chart-canvas").get(0);
                var dataURL4 = canvas4.toDataURL();
                chart4.set("theme", chartTheme4);
                pdf4.addImage(dataURL4, 'JPEG',15, 15);
                pdf4.save("users chart.pdf");
            });

        }
    </script>
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
            <li class="dash"><a href="#"><i class="bi bi-windows"></i>  Dashboard</a></li>
            <li><a href="landlordreports"><i class="bi bi-graph-down-arrow"></i> Landlord reports</a></li>
            <li><a href="ticketreading"><i class="bi bi-ticket-perforated"></i> View tickets</a></li>
            <li><a href="paymentview"><i class="bi bi-cash-coin"></i> Payment view</a></li>
            <li><a href="adminpanel"><i class="bi bi-house-door"></i> House management</a></li>
            <li><a href="adminpaneltwo"><i class="bi bi-people-fill"></i> User management</a></li>
            <li><a href="home"><i class="bi bi-house-fill"></i> Houses</a></li>
            <li><a href="about#contact-us-now"><i class="bi bi-body-text"></i> Raise ticket</a></li>
            <li><a class="dropdown-item" href="profile"><i class="bi bi-person-lines-fill"></i>   Profile</a></li>
            <li><a href="logout"><i class="bi bi-toggles2"></i>    Switch account</a></li>
            <br>
            <br>
            <li><a href="logout">Logout <i class="bi bi-power"></i></a></li>
        </ul>
    </nav>

        <div class="content-area">
            <div class="wrapper">
                <div class="container-info">
                    <a href="#all-users">
                        <div class="info">
                        <h5>All System Users   <i class="bi bi-people-fill"></i></h5><br>
                        <?php
                            $query = "SELECT email FROM users ORDER BY email";
                            $query_run = mysqli_query($db, $query);

                            $row = mysqli_num_rows($query_run);
                            echo '<h4>'.$row.'</h4>';
                        ?>
                    </div>
                    </a>
                    <div class="info">
                        <h5>Admins   <i class="bi bi-person-rolodex"></i></h5><br>
                        <?php
                            $query = "SELECT COUNT(*) AS admins FROM users WHERE role='admin'";
                            $query_run = mysqli_query($db, $query);

                            $row = mysqli_fetch_assoc($query_run);
                            echo '<h4>'.$row['admins'].'</h4>';
                        ?>
                    </div>
                    <div class="info">
                        <h5>Landlords  <i class="bi bi-key-fill"></i></h5><br>
                        <?php
                            $query = "SELECT COUNT(*) AS landlords FROM users WHERE role='landlord'";
                            $query_run = mysqli_query($db, $query);

                            $row = mysqli_fetch_assoc($query_run);
                            echo '<h4>'.$row['landlords'].'</h4>';
                        ?>
                    </div>
                    <div class="info">
                        <h5>All Tenants</h5><br>
                        <?php
                            $query = "SELECT COUNT(*) AS tenants1 FROM users WHERE role='tenant'";
                            $query_run = mysqli_query($db, $query);

                            $row = mysqli_fetch_assoc($query_run);
                            echo '<h4>'.$row['tenants1'].'</h4>';
                        ?>
                    </div>
                    <div class="info">
                        <h5>Active Tenants</h5><br>
                        <?php
                            $query = "SELECT COUNT(*) AS tenants2 FROM users WHERE houseID!='null'";
                            $query_run = mysqli_query($db, $query);

                            $row = mysqli_fetch_assoc($query_run);
                            echo '<h4>'.$row['tenants2'].'</h4>';
                        ?>
                    </div>
                </div>
                <div class="main-graph">
                <div class="swiper col-2-graph">
                <div class="swiper-wrapper">
                <div class="swiper-slide">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        <button id="exportButton">PDF download</button>
                        <form action="" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <?php
                                    error_reporting(0);
                                    $errors = "";

                                    if(isset($_SESSION['mail'])){
                                         if(isset($_POST['update'])){
                                            $amount = mysqli_real_escape_string($db, $_POST['amount']);
                                            $month = mysqli_real_escape_string($db, $_POST['month']);
                                            
                                            //updating details........
                                            $query = "UPDATE monthlyearning SET Amount='$amount' WHERE Month='$month'";
                                            $query_run = mysqli_query($db, $query);

                                            if($query_run){
                                                $errors = "Data updated.....";

                                                if ($errors != ""){
                                                    echo "<span style='color:green; font-weight: 800'>$errors</span>";
                                                }

                                                // header('location: dashboard#chartContainer');
                                            }else{
                                                echo '<script type="text/javascript"> alert("Upload failed")</script>';
                                                // header('location: dashboard#chartContainer');
                                            }
                                        }   
                                    }
                                ?>
                                <div class="user-details">
                                    <div class="input-box">
                                        <span class="details"><label for="month">Month:</label></span><br>
                                        <select name="month" id="month">
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                            <option value="0" selected="selected">--Select month--</option>
                                        </select>
                                    </div>
                                    <div class="input-box">
                                        <span class="details"><label for="amount">Amount:</label></span><br>
                                        <input type="text" name="amount" id="amount" placeholder="Amount" required/>
                                    </div>      
                                </div>
                                <div class="gen-bt">
                                    <div class="button">
                                        <input type="submit" name="update" value="UPDATE"/>
                                    </div>
                                    
                                    <div class="button button-2nd">
                                        <input type="button" name="summation" value="COMPUTE &#8594;" onclick="document.getElementById('id01').style.display='block'"/>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        
                        <form action="" method="post">
                            <?php
                                if (isset($_POST['sum'])) {
                                    $date_1 = mysqli_real_escape_string($db, $_POST['date-1']);
                                    $date_2 = mysqli_real_escape_string($db, $_POST['date-2']);

                                    $query_2 = "SELECT SUM(amount) AS value_sum FROM payments WHERE currentDate BETWEEN '$date_1' AND '$date_2'";
                                    $query_run_2 = mysqli_query($db, $query_2);

                                    $row_2 =mysqli_fetch_assoc($query_run_2);
                                    $sum = $row_2['value_sum'];
                                    echo '<h4>'.'KSH.'.$sum.'</h4>';
                                }
                             ?>  
                        <div id="id01" class="modal">
                            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                            <div class="modal-content">
                              <div class="container-delete">
                                <h1>Rent computation</h1>
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

                                <div class="clearfix">
                                    <button type="button" class="cancelbtn" onclick="cancel()">Cancel</button>
                                    <button type="submit" name="sum" class="deletebtn">Sum</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
                <div class="swiper-slide">
                    <div id="chartContainer3" style="height: 450px; width: 100%;"></div>
                    <button id="exportButton3">PDF download</button>
                </div>
                <div class="swiper-slide">
                    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                    <button id="exportButton2">PDF download</button>
                    <form action="" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <?php
                                    // error_reporting(0);
                                    $errors3 = "";
                                    $errors2 = "";

                                    if(isset($_POST['add'])){
                                        $year = mysqli_real_escape_string($db, $_POST['year']);
                                        $amount = mysqli_real_escape_string($db, $_POST['amount']);

                                        //checking if year is already recorded
                                        $user_check_query = "SELECT * FROM yearlyearning WHERE Year=? LIMIT 1";

                                        //create statement
                                        $stmt = mysqli_stmt_init($db);

                                        //Prepare statement
                                        if (!mysqli_stmt_prepare($stmt, $user_check_query)) {
                                            echo "SQL statement failed";
                                        } else{
                                            // binding parameters
                                            mysqli_stmt_bind_param($stmt, "i", $year);
                                            // running parameters inside the database
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            $year_check = mysqli_fetch_assoc($result);

                                            if ($year_check) {//if year exists
                                                if ($year_check['Year'] == $year) {
                                                    $errors2 = "Sorry, year already recorded!! Please select another year.";
                                                }
                                            }

                                            if ($errors2 != ""){
                                                echo "<span style='color:red; font-weight: 800'>$errors2</span>";
                                            }
                                        }
                                                    

                                        //create user if he/she doesn't exist
                                        if ($errors2 == "") {
                                            $query = "INSERT INTO yearlyearning (Year, Amount) VALUES (?, ?)";
                                            
                                            $stmt2 = mysqli_stmt_init($db);
                                            if (!mysqli_stmt_prepare($stmt2, $query)) {
                                                echo '<script type="text/javascript">
                                                    alert("Upload failed");
                                                </script>';
                                            } else{
                                                mysqli_stmt_bind_param($stmt2, "ii", $year, $amount);
                                                mysqli_stmt_execute($stmt2);
                                            }

                                            // header('location: dashboard#chartContainer2');
                                        }
                                    }

                                    if(isset($_SESSION['mail'])){
                                         if(isset($_POST['updat'])){
                                            $year = mysqli_real_escape_string($db, $_POST['year']);
                                            $amount = mysqli_real_escape_string($db, $_POST['amount']);
                                            
                                            //updating details........
                                            $query2 = "UPDATE yearlyearning SET Amount='$amount' WHERE Year='$year'";
                                            $query_run2 = mysqli_query($db, $query2);

                                            if($query_run2){
                                                $errors3 = "Data updated.....";

                                                if ($errors3 != ""){
                                                    echo "<span style='color:purple; font-weight: 800'>$errors3</span>";
                                                }

                                                // header('location: dashboard#chartContainer2');
                                            }else{
                                                echo '<script type="text/javascript"> alert("Upload failed")</script>';
                                                // header('location: dashboard#chartContainer2');
                                            }
                                        }   
                                    }
                                ?>
                                <div class="user-details">
                                    <div class="input-box">
                                        <span class="details"><label for="year">Year:</label></span><br>
                                        <input type="text" name="year" id="year" placeholder="year" required/>
                                    </div>
                                    <div class="input-box">
                                        <span class="details"><label for="amount">Amount:</label></span><br>
                                        <input type="text" name="amount" id="amount" placeholder="amount" required/>
                                    </div>      
                                </div>
                                <div class="gen-bt">
                                    <div class="button">
                                        <input type="submit" name="updat" value="UPDATE"/>
                                    </div>
                                    <div class="button">
                                        <input type="submit" name="add" value="ADD"/>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    </div>
                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-prev"></div>
                    <!-- <div class="swiper-button-next"></div> -->
                </div>
                <div class="col-2-graph-2">
                    <div id="chartContainer4" style="height: 450px; width: 100%;"></div>
                    <button id="exportButton4">PDF download</button>
                </div>
                </div>


                <div id="updateUser" class="myForm">
                <form action="" method="post" enctype="multipart/form-data">
                <fieldset>
                <legend>ALL SYSTEM USERS</legend>

                <div class="table-users" id="all-users">
                    <?php

                        if (isset($_GET['pageno'])) {
                            $pageno = $_GET['pageno'];
                        } else {
                            $pageno = 1;
                        }
                        $no_of_records_per_page = 10;
                        $offset = ($pageno-1) * $no_of_records_per_page;

                       
                        // Check connection
                        if (mysqli_connect_errno()){
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                            die();
                        }

                        $total_pages_sql = "SELECT COUNT(*) FROM users";
                        $result = mysqli_query($db,$total_pages_sql);
                        $total_rows = mysqli_fetch_array($result)[0];
                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                        $sql = "SELECT * FROM users ORDER BY lastlogin DESC LIMIT $offset, $no_of_records_per_page";
                        $res_data = mysqli_query($db,$sql);
                        ?>
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>House ID</th>
                                <th>Last login</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        
                        <?php
                        while($row = mysqli_fetch_array($res_data)){
                        ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['houseID']; ?></td>
                            <td><?php echo $row['lastlogin']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <button> <?php
                                        // if(isset($_SESSION['mail'])){
                                            echo " <a href='updateuser?usermail={$row['email']}'> Update &#8594; </a>"; 
                                        // }else{
                                        //     echo '<script type="text/javascript"> alert("You are logged out")</script>';
                                        // }
                                ?></button>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        </table>
                         <?php
                            mysqli_close($db);
                        ?>
                                
                            <ul class="pagination">
                                <li><a href="?pageno=1">First</a></li>
                                <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                                </li>
                                <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                    <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                                </li>
                                <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                            </ul>
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