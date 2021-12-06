<?php


/*-----------------------------helper funcion------------------------*/
function clean($string) {
    return htmlentities($string);
}


function redirect($location) {
    return header("Location: {$location}");
}


function set_message($message) {
    if(!empty($message)) {
        $_SESSION['message'] = $message;
    }
    
    else{
        $message = "";
    }
}


function display_message() {
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}


function token_generator() {
    $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));
    return $token;
}



/*----------------------email and username already exist-----------*/


function email_exists($email) {
    $sql = "SELECT id FROM customer WHERE email = '$email'";
    $result = query($sql);
    if(row_count($result) == 1 ) {
        return true;
    }
    else{
        return false;
    }
}

function username_exists($username) {
    $sql = "SELECT id FROM customer WHERE username = '$username'";
    $result = query($sql);
    if(row_count($result) == 1 ) {
        return true;
    }
    else{
        return false;
    }
}

function mobile_exists($mobile) {
    $sql = "SELECT id FROM customer WHERE username = '$username'";
    $result = query($sql);
    if(row_count($result) == 1 ) {
        return true;
    }
    else{
        return false;
    }
}




/*-----------------------------Validation funcion------------------------*/



function validate_errors($error) {
    echo ' 
    
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
                <strong>Warning!</strong>
                '.$error .'
        </div>
    ';
}

function validate_user_registration() {
    $errors = [];
    $min = 3;
    $max = 20;
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $first_name          = clean($_POST['first_name']);
        $last_name           = clean($_POST['last_name']);
        $username            = clean($_POST['username']);
        $mobile              = clean($_POST['mobile']);
        $age                 = clean($_POST['age']);
        $email               = clean($_POST['email']);
        $password            = clean($_POST['password']);
        $confirm_password    = clean($_POST['confirm_password']);
        
        if(strlen($first_name) < $min) {
            $errors[] = "Your first name cannot be less than {$min} characters";
        }
        
        if(strlen($first_name) > $max) {
            $errors[] = "Your First Name cannot be more than {$max} characters";
        }
        
        if(strlen($last_name) < $min) {
            $errors[] = "Your last name cannot be less than {$min} characters";
        }
        
        if(username_exists($username)) {
            $errors[] = "Sorry that username already taken";
        }
        
        if(mobile_exists($mobile)) {
            $errors[] = "Sorry that moblie number already associates with an account";
        }
        
        if(strlen($email) > $max) {
            $errors[] = "Your First Name cannot be more than {$max} characters";
        }

        if(email_exists($email)) {
            $errors[] = "Sorry that email already registered";
        }
        
        if($password !== $confirm_password) {
            $errors[] = "Your password fields do not match";
        }
        
        if(!empty($errors)) {
            foreach ($errors as $error) {
                echo validate_errors($error);
                
            }

        }
        
        else{
            if(register_user($first_name, $last_name, $username, $mobile, $age, $email, $password)){
                echo "user registered";
            }
        }
    }
}



/*----------------------------register user------------------------*/


function register_user($first_name, $last_name, $username, $mobile, $age, $email, $password) {
    
    $first_name      = escape($first_name);
    $last_name       = escape($last_name);
    $username        = escape($username);
    $mobile          = escape($mobile);
    $age             = escape($age);
    $email           = escape($email);
    $password        = escape($password);  
    
    if(email_exists($email)) {
        return false;
    }
    
    else if (username_exists($username)) {
        return false;
    }
    
    else if (mobile_exists($mobile)) {
        return false;
    }
    
    else{
        $password = md5($password);
        $sql  = "INSERT INTO customer(first_name,last_name,username,mobile,age,email,password)               VALUES('$first_name','$last_name','$username','$mobile','$age','$email','$password')";
        $result = query($sql);
        confirm($result);
        return true;
    }
}



/*----------------------------remember funcion------------------------*/


function login_user($email,$password) {
    $sql = "SELECT password FROM customer WHERE email = '".escape($email)."'";
    $result = query($sql);
    if(row_count($result) == 1) {
        $row = fetch_array($result);
        $db_password = $row['password'];
        
        if(md5($password) == $db_password) {
            return true;
            }
        else{
            return false;
        }
    }

}


/*-----------------------------Login funcion------------------------*/



function validate_user_login() {
    
    $errors = [];
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $email       = clean($_POST['email']);
        $password    = clean($_POST['password']);
        
        
        if(empty($email)) {
            $errors[] = "Email field cannot be empty";
        }
        
        if(empty($password)) {
            $errors[] = "Password field cannot be empty";
        }
        
        if(!empty($errors)) {
            foreach ($errors as $error) {
                echo validate_errors($error);
            }
        }

        else {
            if(login_user($email,$password)) {
                $sql = "SELECT username FROM customer WHERE email = '".escape($email)."'";
                $result = query($sql);
                $row=fetch_array($result);
                $id = $row['username'];
                echo $id;
                function data($id)
                {
                    return $id;
                }
                redirect("login_data.php");
                
                

                }
            else {
                echo validate_errors("Your credentials are not correct");
                }
        }
            
    }
}


/*-----------------------------Logged in function------------------------*/

function logged_in() {
    if(isset($_SESSION['email'])){
        return true;
    }
    else{
        return false;
    }
}

/*-----------------------------Login data------------------------*/

function login_user_data() {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $area_name           = clean($_POST['area_name']);
        $street              = clean($_POST['street']);
        $pincode             = clean($_POST['pincode']);
        $city                = clean($_POST['city']);
        $distance            = clean($_POST['distance']);
        $mode_of_payment     = clean($_POST['mode_of_payment']);
        
    if(user_data($area_name, $street, $pincode, $city, $distance))
    {
        echo validate_errors1("Booked successfully");
    }
    if(book($pincode, $mode_of_payment))
    {
        echo validate_errors1("insert successfully");
    }
       
    else
    {
        echo "error";
    }
}
}

    
function book($pincode, $mode_of_payment) {
        $pincode            = escape($pincode);
        $mode_of_payment    = escape($mode_of_payment);
    $sql  = "INSERT INTO booking(pincode,Mode_of_payment) 
    
    VALUES('$pincode','$mode_of_payment')";
        $result = query($sql);
        confirm($result);
        return true;   

}
        
function validate_errors1($error) {
    echo ' 
    
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
                '.$error .'
        </div>
    ';
}
        
function user_data($area_name, $street, $pincode, $city, $distance) {
            $area_name          = escape($area_name);
            $street             = escape($street);
            $pincode            = escape($pincode);
            $city               = escape($city);
            $distance           = escape($distance);
    
    $sql  = "INSERT INTO area(area_name,street,pincode,city,distance) 
    
    VALUES('$area_name','$street','$pincode','$city','$distance')";
        $result = query($sql);
        confirm($result);
        return true;   
    
    
}
    



?>