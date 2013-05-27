<?php
Configure::write('ContactForm.mailTo', 'mail@example.com');
Configure::write('ContactForm.messageSuccess', __('Message send'));
Configure::write('ContactForm.messageFail', __('Message not send'));
Configure::write('ContactForm.sendInControllerAction', true);
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
