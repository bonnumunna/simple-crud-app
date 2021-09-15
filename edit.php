<?php
    session_start();
    $msg ="";
    $error = "";
// Include connection
    include_once('db_connect.php');
    // Check if ID is set

    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];

        $sql = "SELECT * FROM crud WHERE id='$id'";
        $query = mysqli_query($conn, $sql);
        
        $array = mysqli_fetch_assoc($query);

    }


    // ========================================
    // ============ CHECK FOR UPDATE ==========
    if(isset($_POST['update'])){
        $fname = htmlentities($_POST['firstname']);
    $lname = htmlentities($_POST['lastname']);
    $gender = htmlentities($_POST['gender']);
    $country = htmlentities($_POST['country']);
    if(empty($fname)){
        $error = "<p class='text-danger'>Please fill in firstname</p>";
    }elseif(empty($lname)){
        $error = "<p class='text-danger'>Please fill in laststname</p>";
    }elseif(empty($country)){
        $error = "<p class='text-danger'>Please fill in country</p>";
    }else {
        $sql = "UPDATE crud SET 
        `firstname`='$fname', 
        `lastname`='$lname', 
        `gender`='$gender', 
        `country`='$country'
        WHERE `id`='$id'";
        $query = mysqli_query($conn, $sql);
        if($query == true){
            $msg = "<p class='text-success'>Person Details Updated Successfully</p>";
            header('location: index.php?msg=Person_Details_Updated_Successfully');
        }else{
            $error = "<p class='text-danger'>Update was Unsuccessful. Something happened</p>";
        }
    }
    }
?>
<?php include_once('top.php');?>
    <p>
        <?php
            if($msg !=""){
                echo $msg;
            }
        ?>
    </p>
    <p>
        <?php
            if($error !=""){
                echo $error;
            }
        ?>
    </p>
            <h3 class="text-center text-primary">UPDATE RECORDS</h3>
    <form style="width: 450px; margin:auto; margin-bottom: 100px;" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="form-group mb-3">
            <label>First Name</label>
            <input type="text" name="firstname" id="" value="<?php echo $array['firstname']; ?>" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label>Last Name</label>
            <input type="text" name="lastname" id="" value="<?php echo $array['lastname']; ?>" class="form-control">
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
            <input type="text" name="country" id="" value="<?php echo $array['country']; ?>" class="form-control">
        </div>
        <input type="submit" value="UPDATE" name="update" class="btn btn-primary">
    </form>
    <?php include_once('bottom.php');?>