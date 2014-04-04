<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SignUpForm extends CFormModel
{
	public $userName;
	public $firstName;
	public $lastName;
	public $email;
	public $password;
	public $passwordConfirm;
	public $userAgreement;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// required fields
			array('email, userName, password, passwordConfirm, userAgreement', 'required'),
			//email must be valid format
			array('email', 'email'),
			// email and username need to be unique
			array('email', 'unique', 'attributeName'=>'memberEmail', 'caseSensitive'=>'false', 'className'=>'Member'),
			array('userName', 'unique', 'attributeName'=>'memberUserName', 'caseSensitive'=>'false', 'className'=>'Member'),
			// password and passwordConfirm must be equal
			array('password, passwordConfirm', 'authenticate'),
			// user agreement must be checked
			array('userAgreement', 'checkUserAgreement'),
			// all fields are safe to assign
			array('firstName, lastName, userName, email, password, passwordConfirm, userAgreement', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'userAgreement'=>'I agree to the <a href="#">user agreement</a>.',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if($this->password !== $this->passwordConfirm)
		{
			$this->addError('password', 'Password and Password Confirm must match.');
		}
	}
	
	public function checkUserAgreement()
	{
		if(!$this->userAgreement)
		{
			$this->addError('userAgreement', 'User agreement must be checked.');
		}
	}
}
