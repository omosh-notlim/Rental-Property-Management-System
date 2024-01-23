<?php

    session_start();

    error_reporting(0);
    include 'db_connection.php';
    include 'status.php';
?>

<?php
    $landlord = mysqli_real_escape_string($db, $_POST['landlordmail']);

    if(isset($_POST['search'])){
        $line_query = "SELECT * FROM landlords_report where landlordEmail='$landlord'";
        $line_query_run = mysqli_query($db, $line_query);

        $line_row = mysqli_fetch_assoc($line_query_run);

        $test = array( 
            array("y" => $line_row['January'], "label" => "January" ),
            array("y" => $line_row['February'], "label" => "February" ),
            array("y" => $line_row['March'], "label" => "March" ),
            array("y" => $line_row['April'], "label" => "April" ),
            array("y" => $line_row['May'], "label" => "May" ),
            array("y" => $line_row['June'], "label" => "June" ),
            array("y" => $line_row['July'], "label" => "July" ),
            array("y" => $line_row['August'], "label" => "August" ),
            array("y" => $line_row['September'], "label" => "September" ),
            array("y" => $line_row['October'], "label" => "October" ),
            array("y" => $line_row['November'], "label" => "November" ),
            array("y" => $line_row['December'], "label" => "December" ),
        );

        $bar_query = "SELECT * FROM landlords_report where landlordEmail='$landlord'";
        $bar_query_run = mysqli_query($db, $bar_query);

        $bar_row = mysqli_fetch_assoc($bar_query_run);

        $test2 = array( 
            array("y" => $bar_row['Y2021'], "label" => "2021" ),
            array("y" => $bar_row['Y2022'], "label" => "2022" ),
            array("y" => $bar_row['Y2023'], "label" => "2023" ),
            array("y" => $bar_row['Y2024'], "label" => "2024" ),
            array("y" => $bar_row['Y2025'], "label" => "2025" ),
            array("y" => $bar_row['Y2026'], "label" => "2026" ),
            array("y" => $bar_row['Y2027'], "label" => "2027" ),
            array("y" => $bar_row['Y2028'], "label" => "2028" ),
            array("y" => $bar_row['Y2029'], "label" => "2029" ),
            array("y" => $bar_row['Y2030'], "label" => "2030" ),
        );

        $query = "SELECT COUNT(*) AS occupied FROM houseinfo WHERE (houseStatus ='Occupied' AND landlordEmail='$landlord')";
        $query_run = mysqli_query($db, $query);

        $row = mysqli_fetch_assoc($query_run);

        $query2 = "SELECT COUNT(*) AS unoccupied FROM houseinfo WHERE (houseStatus ='Vaccant' AND landlordEmail='$landlord')";
        $query_run2 = mysqli_query($db, $query2);

        $row2 = mysqli_fetch_assoc($query_run2);

        $test3 = array( 
            array("y" => $row['occupied'], "label" => "Occupied houses" ),
            array("y" => $row2['unoccupied'], "label" => "Vaccant houses" ),
        );
    }              
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="adminPanel.css">
    <link rel="stylesheet" href="fontboot/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js" integrity="sha512-t2JWqzirxOmR9MZKu+BMz0TNHe55G5BZ/tfTmXMlxpUY8tsTo3QMD27QGoYKZKFAraIPDhFv56HLdN11ctmiTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

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
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Income Generated Per Year"
                },
                axisY: {
                    title: "Amount(KSH)"
                },
                data: [{
                    type: "column",
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
                chart2.set("theme", "light1");
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
        }
    </script>


    <title>Landlord reports</title>
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
        </div><i class="bi bi-graph-down-arrow"></i>
        <ul>
            <li><a href="dashboard"><i class="bi bi-windows"></i>  Dashboard</a></li>
            <li>
                <a href="#" class="serv-btn house-mng"><i class="bi bi-graph-down-arrow"></i> 
                    Landlord reports <i class="bi bi-caret-down-fill"></i>
                </a>
                <ul class="serv-show">
                    <!-- <li><a href="#graph">Graph</a></li> -->
                    <li><a href="#computation">Computation</a></li>
                    <li><a href="#landlords">Landlords</a></li>
                </ul>
            </li>
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
            <form action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <?php echo "$landlord"; ?>
                    <div class="col-2-search">
                        <div class="col-2-search-1">
                            <input type="text" name="landlordmail" id="landlordmail" placeholder="landlord@gmail.com" required/>     
                        </div>
                        <div class="col-2-search-1">
                            <input type="submit" name="search" value="SEARCH"/>
                        </div>
                    </div>
                </fieldset>
            </form>

            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                        <button id="exportButton2">PDF download</button>
                    </div>
                    <div class="swiper-slide">
                        <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
                        <button id="exportButton3">PDF download</button>
                    </div>
                    <div class="swiper-slide">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        <button id="exportButton">PDF download</button>
                    </div>
                </div>
                <div class="swiper-pagination"></div>

                <div class="swiper-button-prev"></div>
                <!-- <div class="swiper-button-next"></div> -->
            </div>

                <div id="computation" class="col-2-report">
                    <div class="col-2-report-1">
                        <form action="" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <?php
                                    // error_reporting(0);
                                    $errors = "";
                                    
                                    if(isset($_SESSION['mail'])){
                                         if(isset($_POST['updateone'])){
                                            $amount = mysqli_real_escape_string($db, $_POST['amount']);
                                            $month = mysqli_real_escape_string($db, $_POST['month']);
                                            $landlord2 = mysqli_real_escape_string($db, $_POST['landlord2']);
                                            
                                            //updating details........
                                            $query = "UPDATE landlords_report SET $month='$amount' WHERE landlordEmail='$landlord2'";
                                            $query_run = mysqli_query($db, $query);

                                            if($query_run){
                                                $errors = "Data updated.....";

                                                if ($errors != ""){
                                                    echo "<span style='color:green; font-weight: 800'>$errors</span>";
                                                }
                                            }else{
                                                echo '<script type="text/javascript"> alert("Upload failed")</script>';
                                            }
                                        }   
                                    }
                                ?>
                                <legend>MONTHLY INCOME UPDATES:</legend>
                                <div class="user-details">
                                    <div class="input-box">
                                        <span class="details"><label for="landlord2">Landlord Email:</label></span><br>
                                        <input type="email" name="landlord2" id="landlord2" placeholder="" required/>
                                    </div>  
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
                                        <input type="submit" name="updateone" value="UPDATE"/>
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
                                    $landlordE = mysqli_real_escape_string($db, $_POST['landlordE']);
                                    $date_1 = mysqli_real_escape_string($db, $_POST['date-1']);
                                    $date_2 = mysqli_real_escape_string($db, $_POST['date-2']);

                                    $query_2 = "SELECT SUM(amount) AS value_sum FROM payments WHERE landlordEmail='$landlordE' AND currentDate BETWEEN '$date_1' AND '$date_2'";
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
                                        <span class="details"><label for="landlordE">Landlord Email:</label></span><br>
                                        <input type="email" name="landlordE" id="landlordE" placeholder="" required/>
                                    </div>  
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

                        <div class="col-2-report-1">
                        <form action="" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <?php
                                    // error_reporting(0);
                                    $errors2 = "";
                                    
                                    if(isset($_SESSION['mail'])){
                                         if(isset($_POST['updatetwo'])){
                                            $amount2 = mysqli_real_escape_string($db, $_POST['amount2']);
                                            $year = mysqli_real_escape_string($db, $_POST['year']);
                                            $landlord3 = mysqli_real_escape_string($db, $_POST['landlord3']);
                                            
                                            //updating details........
                                            $query = "UPDATE landlords_report SET $year='$amount2' WHERE landlordEmail='$landlord3'";
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
                                <legend>YEARLY INCOME UPDATES:</legend>
                                <div class="user-details">
                                    <div class="input-box">
                                        <span class="details"><label for="landlord3">Landlord Emai:</label></span><br>
                                        <input type="text" name="landlord3" id="landlord3" placeholder="" required/>
                                    </div>  
                                    <!-- <div class="input-box">
                                        <span class="details"><label for="year">Year:</label></span><br>
                                        <input type="number" name="year" id="year" placeholder="" required/>
                                    </div> --> 
                                    <div class="input-box">
                                        <span class="details"><label for="year">Year:</label></span><br>
                                        <select name="year" id="year">
                                            <option value="Y2021">2021</option>
                                            <option value="Y2022">2022</option>
                                            <option value="Y2023">2023</option>
                                            <option value="Y2024">2024</option>
                                            <option value="Y2025">2025</option>
                                            <option value="Y2026">2026</option>
                                            <option value="Y2027">2027</option>
                                            <option value="Y2028">2028</option>
                                            <option value="Y2029">2029</option>
                                            <option value="Y2030">2030</option>
                                            <option value="0" selected="selected">--Select year--</option>
                                        </select>
                                    </div>
                                    <div class="input-box">
                                        <span class="details"><label for="amount2">Amount:</label></span><br>
                                        <input type="text" name="amount2" id="amount2" placeholder="Amount" required/>
                                    </div>      
                                </div>
                                <div class="gen-bt">
                                    <div class="button">
                                        <input type="submit" name="updatetwo" value="UPDATE"/>
                                    </div>
                                    
                                    
                                    <div class="button button-2nd">
                                        <input type="button" name="summation" value="COMPUTE &#8594;" onclick="document.getElementById('id01').style.display='block'"/>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        </div>
                    </div>

                <div class="table-users" id="landlords">
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

                        $total_pages_sql = "SELECT COUNT(*) FROM users WHERE role='landlord'";
                        $result = mysqli_query($db,$total_pages_sql);
                        $total_rows = mysqli_fetch_array($result)[0];
                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                        $sql = "SELECT * FROM users WHERE role='landlord' ORDER BY lastlogin DESC LIMIT $offset, $no_of_records_per_page";
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
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="scrolljQuery.js"></script>
    <script>
        $(".col-vaccant").slice(0, 5).show()
        $(".btn-1").on("click", function(){
            $(".col-vaccant:hidden").slice(0, 5).slideDown('slow')
            if ($(".col-vaccant:hidden").length == 0) {
                $(".btn-1").fadeOut('slow')
            }
        })

        $(".col-occupied").slice(0, 5).show()
        $(".btn-2").on("click", function(){
            $(".col-occupied:hidden").slice(0, 5).slideDown('slow')
            if ($(".col-occupied:hidden").length == 0) {
                $(".btn-2").fadeOut('slow')
            }
        })
    </script>
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

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

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