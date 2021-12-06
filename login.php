<?php include("header.php"); ?>
<?php include("nav.php"); ?>

<div class="col-lg-6 col-lg-offset-3">
    <?php validate_user_login(); ?>
</div>

<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-login">
        <div class="panel-heading">
            <div class="col-xs-6">
				<a href="login.php" class="active" id="login-form-link">Login</a>
            </div>
            <div class="col-xs-6">
				<a href="customer_register.php" id="">Register</a>
            </div>
            
        </div>
        <hr>
   
        <div class="panel-body">
            <div class="col-lg-12">
                <form id="login-form"  method="post" role="form" style="display: block;">
                    <div class="form-group">
                        <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" required>
                    </div>
                    
				    <div class="form-group">
                        <input type="password" name="password" id="login-password" tabindex="2" class="form-control" placeholder="Password" required>
				    </div>
                    
				    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-3">
				            <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
					   </div>
				    </div>				
			 </form>					
		  </div>
        </div>
	</div>
</div>
