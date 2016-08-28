<?php

class HomeController{
	
function execute($conn) {
		$validator = new Validator();
		$dataArr = [];

		$form_validation = [
			'name'    => 'validRegexName', 
			'surname' => 'validRegexName', 
			'email'   => 'validRegexEmail', 
			'password'=> 'validRegexPassword'
		];
		
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		foreach ($form_validation as $key => $rule) {
				$dataArr[$key] = empty($_POST[$key]) ? '' : trim($_POST[$key]);
				if ($validator->isNotEmpty($dataArr[$key],$key)) {
		  	 	$validator->$rule($dataArr[$key],$key);
				}	
		}

		$errors = $validator->getErrors();
		$confirm_password = md5($_POST['confirm_password']);
		$dataArr['password'] = md5($dataArr['password']);


			if(empty($errors)){

				if($dataArr['password'] === $confirm_password){
					if(!$obj->emailExists($dataArr['email'])){
						$result = $obj->insert($dataArr, 'users');
						header('Location: ' . $_SERVER['PHP_SELF']);
						exit;
									
					}
					$errors['email'] = "There is another account with this email";
				
				}else{
					$errors['confirm_password'] = "passwords does not match";
				}
				return $result;
			}
	}

	
	
		$view = new View('templates/home.php'); 
		return $view->render();
	}


}

?>