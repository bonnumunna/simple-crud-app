<?php
session_start();
$msg = "";
$error = "";
include_once('db_connect.php');
if(isset($_POST['upload'])){
    $fname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    if(empty($fname)){
        $error = "<p class='text-danger'>Please fill in firstname</p>";
    }elseif(empty($lname)){
        $error = "<p class='text-danger'>Please fill in laststname</p>";
    }elseif(empty($country)){
        $error = "<p class='text-danger'>Please fill in country</p>";
    }else {
        // First Check for existence of person before uploading
        $sql = "SELECT firstname, lastname FROM crud WHERE firstname='$fname' AND lastname='$lname'";
        $query = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($query);
        if($num_rows >0){
            $error = "<p class='text-danger'>Person already exists</p>";
        }else {
            // echo "$fname, $lname, $gender, $country";
            $sql = "INSERT INTO crud(`firstname`, `lastname`, `gender`, `country`) VALUES(
                '$fname', '$lname', '$gender', '$country')";

            $query = mysqli_query($conn, $sql);
            if($query){
                $msg = "<p class='text-success'>Person Added</p>";
            }else{
                $error = "<p class='text-danger'>Upload Unsuccessful. Something happened</p>";
            }
        }
    }
}
//=============================================================
// ================== DELETE BUTTON ===================
if(isset($_POST['delete'])){
    $id = $_POST['id'];
    // echo $id;
    $sql = "DELETE FROM crud WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
    if($query == true){
        $msg = "<p class='text-success'>Person Successfully Removed</p>"; 
    }else {
        $msg = "<p class='text-danger'>Person Could Not be Removed</p>";
    }
}

// ================== EDIT BUTTON ===================
if(isset($_POST['edit'])){
    // $id = $_POST['id'];
    $_SESSION['id'] = $_POST['id'];
    header('location: edit.php?id='.$id);
    
}
?>
<?php include_once('top.php');?>
    <div class="bg-primary p-2 text-center">
        <h1 class="text-white">SIMPLE CRUD APPLICATION WITH PHP</h1>
        <p class="text-warning">By. Bonn Umunna</p>
        <p class="text-white">Date: September, 2021</p>
    </div>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-2"><b>First Name</b></div>
            <div class="col-md-2"><b>Last Name</b></div>
            <div class="col-md-2"><b>Gender</b></div>
            <div class="col-md-2"><b>Country</b></div>
            <div class="col-md-4"><b>Operation</b></div>

        </div>
        <ul class="list-item list-unstyled">
            <!-- <li class="list-group-item">
            <div class="row">
                <div class="col-md-2">John</div>
                <div class="col-md-2">Doe</div>
                <div class="col-md-2">Male</div>
                <div class="col-md-2">USA</div>
                <div class="col-md-1"><button class="btn btn-danger">Delete</button></div>
                <div class="col-md-1"><button class="btn btn-success">Edit</button></div>
            </div>
            </li> -->

            <?php
                $sql = "SELECT * FROM crud";
                $query = mysqli_query($conn, $sql);
                $people = mysqli_fetch_all($query, MYSQLI_ASSOC);
                foreach ($people as $person) {
                    // print_r($person);
                    echo "<li class='list-group-item'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-2'>".$person['firstname']."</div>";
                        echo "<div class='col-md-2'>".$person['lastname']."</div>";
                        echo "<div class='col-md-2'>".$person['gender']."</div>";
                        echo "<div class='col-md-2'>".$person['country']."</div>";
                        // hidden form for buttons
                        // DELETE BUTTON
                        echo "<div class='col-md-2'>";
                            echo "<form method='POST', action='index.php'>
                            <input type='hidden' name='id' value='".$person['id']."'>
                            <input type='submit' name='delete' value='DELETE' class='btn btn-danger'>
                            </form>";
                        echo "</div>";
                        // EDIT BUTTON
                        echo "<div class='col-md-2'>";
                            echo "<form method='POST', action='index.php'>
                            <input type='hidden' name='id' value='".$person['id']."'>
                            <input type='submit' name='edit' value='EDIT' class='btn btn-success'>
                            </form>";
                        echo "</div>";

                    echo "</div>";
                    echo "</li>";
                }
            ?>
        </ul>
        
    </div>
    <br>
    <br>
    <br>
    <br>
    
    
    <form style="width: 450px; margin:auto; margin-bottom: 100px;" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <span>
            <?php
                if($msg !=""){
                    echo $msg;
                }
                if($error !=""){
                    echo $error;
                }
            ?>
        </span>
        <div class="form-group mb-3">
            <label>First Name</label>
            <input type="text" name="firstname" id="" value="<?php echo (isset($fname))? $fname: ""; ?>" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label>Last Name</label>
            <input type="text" name="lastname" id="" value="<?php echo (isset($lname))? $lname: ""; ?>" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label>Gender</label>
            <select name="gender" id="" class="form-control">
                <option value="">select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Country</label>
            <input type="text" name="country" id="" value="<?php echo (isset($country))? $country: ""; ?>" class="form-control">
        </div>
        <input type="submit" value="UPLOAD" name="upload" class="btn btn-primary">
        
    </form>
<?php include_once('bottom.php');?>