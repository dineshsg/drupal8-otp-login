<?php
namespace Drupal\custom_otp_login\Controller;

use Drupal\Core\Controller\ControllerBase;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Serialization\Json;

class custom_otp_loginController extends ControllerBase{
	public function content(){
		$pin = rand(1000,2000);
		$numArray = explode(" ", $pin);
		$arraySum = array_sum($numArray);  
		$remainder = $arraySum % 9;
		$difference = 9 - $remainder;
		$otp_pin = $pin.$difference;
		return $otp_pin;
	}
	public function usernameValidateCallback(array &$form, FormStateInterface $form_state, $param) {
		$ajax_response = new AjaxResponse();
		if(user_load_by_name($form_state->getValue('name')) && $form_state->getValue('name') != false){
			$login_user = user_load_by_name($form_state->getValue('name'));
			$user_phone = $login_user->get('field_phone')->value;
			if(!empty($user_phone)){
				$color = 'green';
				$obj = new custom_otp_loginController;
				$otp = $obj->content();
				$user_phone = '+91'.$user_phone;
				$client = \Drupal::httpClient();
				//API url to send SMS
				$request = $client->post('https://url', [
					'json' => [
						'phone'=> $user_phone,
						'message' => $otp,
						'key' => 'textbelt'
					]
				]);
				$text = $user_phone.'-'.$otp;
				//$temp_text = json_decode($request->getBody());
			}else{
				$text = 'Phone Number not Found';
				$color = 'red';
			}
		}else{
			$text = 'No User Found';
			$color = 'red';
		}
		$ajax_response->addCommand(new HtmlCommand('#edit-name--description', $text));
		$ajax_response->addCommand(new InvokeCommand('#edit-name--description', 'css', array('color', $color)));
		return $ajax_response;
	}
	
	public function userValidateCallback($param) {
		if(user_load_by_name($param) && $param != false){
			$login_user = user_load_by_name($param);
			$user_phone = $login_user->get('field_phone')->value;
			if(!empty($user_phone)){
				$obj = new custom_otp_loginController;
				$apiKey = urlencode("secret code");
				$apikey = array($apiKey);
				$numbers = '91'.$user_phone;
				$sender = urlencode('sender name');
				$otp = rawurlencode($obj->content());
				$message = rawurlencode($otp);
				$client = \Drupal::httpClient();
				//API url to send SMS
				$request = $client->post('url', [
					'verify' => false,
					'form_params' => ['apikey'=> $apiKey,'numbers' => $numbers,'sender' => $sender,'message' => $message,'test'=>true],
					'headers' => ['Content-type' => 'application/x-www-form-urlencoded']
				]);
				$res = json_decode($request->getBody(),true);
				$resp_msg = $res['status'];
				$response = $request->getStatusCode();

				if($resp_msg=='success'){
					header("HTTP/1.1 ".$response);
					$status = 'success';
					$message = "OTP has been sent to your mobile- ".$otp;
				}else{
					header("HTTP/1.1".$response);
					$status = 'error';
					$message = "Please try requesting again.";
				}
			}else{
				header("HTTP/1.1 404");
				$status = 'error';
				$message = 'Phone Number not Found';
			}
		}else{
			header("HTTP/1.1 404");
			$status = 'error';
			$message = 'No User Found';
		}
		header('Content-Type: application/json');
		$response = array('status'=>$status,'message'=>$message);
		return $response;
	}
}