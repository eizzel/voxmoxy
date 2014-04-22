<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate($partialLogin = false)
	{
		$bCrypt = new bCrypt();
		$user = Member::model()->findByAttributes(array('memberEmail'=>$this->username));
		
		if(!$user || !$user->memberId)
		{
			$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
			Yii::app()->user->setFlash('error', 'Invalid username or password');
		}
		else if(!($bCrypt->verify($this->password, $user->memberPassword) 
				|| ($partialLogin && $this->password == $user->memberPassword)))
		{
			$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
			Yii::app()->user->setFlash('error', 'Invalid username or password');
			
		}
		// @TODO: add code to handle member status types
		else if($user->memberStatusId == 6) //hard opted out, can't login
		{
			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
			Yii::app()->user->setFlash('error', 'Our records show that your account has been unsubscribed. Please <a href="/contact">contact us</a> if you want to reactivate your account.');
		}
		else
		{	
			$this->_id = $user->memberId;
			$user->memberLastLogin = new CDbExpression('Now()');// Save last login
			$user->save();
			$this->errorCode=self::ERROR_NONE;
			
			//remove existing sessions
			MemberSession::model()->deleteAll('memberId = :memberId',array(':memberId'=>$user->memberId));
			
			//create a new member session entry
			$memberSession = new MemberSession();
			$memberSession->memberSessionIdentifier = Yii::app()->session->getSessionId();
			$memberSession->memberId = $user->memberId;
			$memberSession->memberSessionPartialLogin = $partialLogin;
			$memberSession->save();
		}
			
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
	}
}