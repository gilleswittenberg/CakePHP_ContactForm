<?php

App::uses('CakeEmail', 'Network/Email');

class MailComponent extends Component {

	public function send ($from, $fromName, $subject = '', $message = '') {
		$email = new CakeEmail();
		$send = $email->from(array($from => $fromName))
			->to(Configure::read('ContactForm.mailTo'))
			->subject($subject)
			->send($message);
		return $send;
	}
}
