<?php

App::uses('CakeEmail', 'Network/Email');

class MailComponent extends Component {

	public function send ($from, $fromName, $subject = '', $message = '', $viewVars = null) {
		$email = new CakeEmail();
		$email->from(array($from => $fromName))
			->to(Configure::read('ContactForm.mailTo'))
			->subject($subject);
		if (Configure::read('ContactForm.template.view') === false && Configure::read('ContactForm.template.layout') === false) {
			$send = $email->send($message);
		} else {
			$email->template(Configure::read('ContactForm.template.view'), Configure::read('ContactForm.template.layout'));
			$email->viewVars($viewVars);
			$send = $email->send();
		}
		return $send;
	}
}
