<?php
	
	session_start();
	
	function logged_in() {
		return isset($_SESSION['ACCOUNT_USER']);
		return isset($_SESSION['ACCOUNT_NAME']);
		return isset($_SESSION['ACCOUNT_TYPE']);
	}

	//this function if session member is not set then it will be redirected to login.php
	function confirm_logged_in() {
		if (!logged_in()) {?>
			<script type="text/javascript">
				window.location = "login.php";
			</script>
		<?php
		}
	}
	
	function studlogged_in() {
		return isset($_SESSION['IDNO']);
	}
	
	function studconfirm_logged_in() {
		if (!studlogged_in()) {?>
			<script type="text/javascript">
				window.location = "login.php";
			</script>

		<?php
		}
	}

	function message($msg="", $msgtype="") {
	  if(!empty($msg)) {
	    $_SESSION['message'] = $msg;
	    $_SESSION['msgtype'] = $msgtype;
	  } else {
			return $message;
	  }
	}
	function check_message(){
	
		if(isset($_SESSION['message'])){
			if(isset($_SESSION['msgtype'])){
				if ($_SESSION['msgtype']=="info"){
	 				echo  '<div class="alert alert-info">'. $_SESSION['message'] . '</div>';
	 				 
				}elseif($_SESSION['msgtype']=="error"){
					echo  '<div class="alert alert-danger">' . $_SESSION['message'] . '</div>';
									
				}elseif($_SESSION['msgtype']=="success"){
					echo  '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
				}	
				unset($_SESSION['message']);
	 			unset($_SESSION['msgtype']);
	   		}
  
		}	

	}

?>
