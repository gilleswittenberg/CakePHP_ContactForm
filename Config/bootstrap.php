<?php
Configure::write('ContactForm.template.view', 'default');
Configure::write('ContactForm.template.layout', 'default');
Configure::write('ContactForm.fields', array(
	'name' => array(),
	'email' => array(),
	'subject' => array(),
	'message' => array(
		'type' => 'textarea'
	)
));
