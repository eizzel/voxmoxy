<?php
//require_once '/google/appengine/api/mail/Message.php';
use \google\appengine\api\mail\Message as GAEMailMessage;

class WebUser extends CWebUser
{
	private $_memberSession;
	private $_member;
		
	public function isPartialLogin()
	{
		if(!isset($this->_memberSession))
		{
			$this->_memberSession = MemberSession::model()->findByAttributes(array('memberId' => Yii::app()->user->id));
		}
		
		return $this->_memberSession->memberSessionPartialLogin;
	}
	
	public function logout($destroySession = true)
	{
		//delete member session from db
		MemberSession::model()->deleteAllByAttributes(array('memberId' => Yii::app()->user->id));
		
		return parent::logout($destroySession);
	}
	
	public function sendConfirmationEmail($memberId=null)
	{
		if(!$memberId)
		$memberId = $this->id;
		
		$member = Member::model()->findByPk($memberId);
		
		if(!$member)
		{
			return false;
		}
				
		// save confirmation code
		$bCrypt = new bCrypt();
		$code = substr(sha1(rand()),0,20);
		$memberConfirmation = MemberConfirmation::model()->findByAttributes(array('memberId'=>$memberId));
		if(!$memberConfirmation)
		{
			$memberConfirmation = new MemberConfirmation();
		}			
		$memberConfirmation->memberId = $memberId;
		$memberConfirmation->memberConfirmationCode = $bCrypt->hash($code);
		$memberConfirmation->save();
			
		$confirmLink = Yii::app()->controller->createAbsoluteUrl('/confirm',array('code'=>urlencode($code), 'mId'=>$member->memberId));
		$firstName = $member->memberFirstName;
		$contactLink = "";
		$unsubscribeLink = Yii::app()->controller->createAbsoluteUrl('/site/unsubscribe',array('code'=>urlencode($code), 'mId'=>$member->memberId));
		
		$messageBody = "Hello {$firstName},
			
Thank you for signing up.
You need to verify that this email account is yours before you can start sharing audio files.

Click or copy and paste this link into your internet browser:
{$confirmLink}
	
You are receiving this email because this email was recently registered at ".Yii::app()->name.".
For help or questions, please contact us here.
{$contactLink}
Unsubscribe from ".Yii::app()->name." here.
{$unsubscribeLink}";
			
		$message = new GAEMailMessage();
		$message->setSubject("Thank you for joining ".Yii::app()->name."!".(ENV_DEV)?$confirmLink:"");
		$message->setSender(Yii::app()->params['adminEmail']);
		$message->setTextBody($messageBody);
		$message->addTo($member->memberEmail);
		$message->send();		
	}
	
	public function sendPasswordResetEmail($memberId=null)
	{
		if(!$memberId)
		$memberId = $this->id;
		
		$member = Member::model()->findByPk($memberId);
		
		if(!$member)
		{
			return false;
		}
		
		// save confirmation code
		$bCrypt = new bCrypt();
		$code = substr(sha1(rand()),0,20);
		$memberConfirmation = MemberConfirmation::model()->findByAttributes(array('memberId'=>$memberId));
		if(!$memberConfirmation)
		{
			$memberConfirmation = new MemberConfirmation();
		}			
		$memberConfirmation->memberId = $memberId;
		$memberConfirmation->memberConfirmationCode = $bCrypt->hash($code);
		$memberConfirmation->save();
		
		$message = new YiiMailMessage('Reset Password Request');
		$qFirstName = Question::model()->findByAttributes(array('questionText'=>'First Name'));
		
		$resetPasswordLink = Yii::app()->controller->createAbsoluteUrl('/site/resetPassword',array('code'=>urlencode($code), 'mId'=>$member->memberId));
		$unsubscribeLink = Yii::app()->controller->createAbsoluteUrl('/site/unsubscribe',array('code'=>urlencode($code), 'mId'=>$member->memberId));
		$messageBody = Yii::app()->controller->renderPartial('//email/passwordResetMember', array(
			'firstName' => $member->getMemberData($qFirstName->questionId),
			'resetPasswordLink' => $resetPasswordLink,
			'unsubscribeLink' => $unsubscribeLink, 
		), true);
		
		$message->setBody($messageBody);
						
		$message->from = Yii::app()->params['adminEmail'];
		
		$message->contentType = 'text/html';
		$message->charset = 'UTF-8';
		$message->addTo($member->memberEmail);
		Yii::app()->mail->send($message);
	}
	
	private function loadMember()
	{
		if(!$this->_member)
		{
			$this->_member = Member::model()->findByPk($this->id);
		}
		
		return $this->_member;
	}
	
	public function isUnconfirmed()
	{
		$member = $this->loadMember();
		$unconfirmedStatus = MemberStatus::model()->findByAttributes(array('memberStatusName' => 'unconfirmed'));
		
		return $member->memberStatusId == $unconfirmedStatus->memberStatusId;
	}
	
	public function getMemberAffiliate()
	{
		$member = $this->loadMember();
		return $member->memberAffiliate;
	}
	
	public static function sendConfirmationReminderEmail($memberId, $reminderCount)
	{
		$member = Member::model()->findByPk($memberId);
		
		if(!$member)
		{
			return false;
		}
				
		// save confirmation code
		$bCrypt = new bCrypt();
		$code = substr(sha1(rand()),0,20);
		$memberConfirmation = MemberConfirmation::model()->findByAttributes(array('memberId'=>$memberId));
		if(!$memberConfirmation)
		{
			$memberConfirmation = new MemberConfirmation();
		}			
		$memberConfirmation->memberId = $memberId;
		$memberConfirmation->memberConfirmationCode = $bCrypt->hash($code);
		$memberConfirmation->save();
		
		$message = new YiiMailMessage(Yii::app()->name.' Confirmation Reminder');
		$qFirstName = Question::model()->findByAttributes(array('questionText'=>'First Name'));
		
		$confirmLink = Yii::app()->createAbsoluteUrl('/join/confirm',array('code'=>urlencode($code), 'mId'=>$member->memberId));
		$firstName = $member->getMemberData($qFirstName->questionId);
		$unsubscribeLink = Yii::app()->createAbsoluteUrl('/site/unsubscribe',array('code'=>urlencode($code), 'mId'=>$member->memberId));
		
		$messageBody = WebUser::renderPartialEmail('confirmation'.$reminderCount, array(
			'firstName' => $firstName,
			'confirmLink' => $confirmLink,
			'unsubscribeLink' => $unsubscribeLink,
		));
		
		$message->setBody($messageBody);
						
		$message->from = Yii::app()->params['adminEmail'];
		
		$message->contentType = 'text/html';
		$message->charset = 'UTF-8';
		$message->addTo($member->memberEmail);
		Yii::app()->mail->send($message);
		
	}
	
	public static function renderPartialEmail($view, $params)
	{
		// if Yii::app()->controller doesn't exist create a dummy 
		// controller to render the view (needed in the console app)
		if(isset(Yii::app()->controller))
			$controller = Yii::app()->controller;
		else
			$controller = new CController('YiiMail');

		// renderPartial won't work with CConsoleApplication, so use 
		// renderInternal - this requires that we use an actual path to the 
		// view rather than the usual alias
		$vPath = Yii::getPathOfAlias('application.views.email.'.$view).'.php';
		return $controller->renderInternal($vPath, $params, true); 
	}
	
}