<?php
class Message extends AppModel {

	public $useTable = 'ContactForm_messages';

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
		),
		'email' => array(
			'rule' => 'email',
		)
	);
}
