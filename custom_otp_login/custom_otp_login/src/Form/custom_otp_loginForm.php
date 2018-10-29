<?php

/**
 * @file
 * Contains Drupal\custom_otp_login\Form\custom_otp_loginForm
 */

namespace Drupal\custom_otp_login\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class custom_otp_loginForm extends FormBase {

  public function getFormId() {
	return 'user_login_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
	  
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }
}