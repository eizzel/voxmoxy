<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//generate the dashboard menu here
$this->beginClip('dashboardNav');
$this->widget('bootstrap.widgets.TbMenu', 
		array(
			'type' => 'list',
			'items' => array(
				array('label' => 'Main', 'url' => $this->createUrl('/dashboard'), 'itemOptions' => array('class' => ($this->action->id == 'index')?'active':'')),
				array('label' => 'My Account', 'url' => $this->createUrl('/dashboard/myAccount'), 'itemOptions' => array('class' => ($this->action->id == 'myAccount')?'active':'')),
			)
		));
$this->endClip();
?>
<h1>My Uploads</h1>
