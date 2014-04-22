<?php

class m140419_025914_initialize_member_status extends CDbMigration
{
	public function up()
	{
		// Initialize MemberStatus records
		$memberStatuses= array(
			array(
				'memberStatusId'=>1, 
				'memberStatusName'=>'unconfirmed',
				'memberStatusDescription'=>'Members who filled up the join form but did not click on the confirmation link in the email.'),
			array(
				'memberStatusId'=>2, 
				'memberStatusName'=>'confirmed',
				'memberStatusDescription'=>'Confirmed Members'),
			);
		
		foreach($memberStatuses as $memberStatus)
		{
			$newStatus = new MemberStatus();
			
			foreach($memberStatus as $key=>$value)
				$newStatus->$key = $value;
			
			$newStatus->save();
		}
	}

	public function down()
	{
		//echo "m140419_025914_initialize_member_status does not support migration down.\n";
		//return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}