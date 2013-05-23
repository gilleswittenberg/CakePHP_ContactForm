<?php
class MessagesController extends ContactFormAppController {

	public $components = array('ContactForm.Mail');

	public function beforeFilter () {
		parent::beforeFilter();
		if ($this->Auth) {
			$this->Auth->allow('add', 'send');
		}
	}

	public function add () {
		if ($this->request->is('post')) {
			if ($this->Message->save($this->data)) {
				if (Configure::read('ContactForm.sendInControllerAction')) {
					$email = !empty($this->data['Message']['email']) ? $this->data['Message']['email'] : '';
					$name = !empty($this->data['Message']['name']) ? $this->data['Message']['name'] : '';
					$subject = !empty($this->data['Message']['subject']) ? $this->data['Message']['subject'] : '';
					$message = !empty($this->data['Message']['message']) ? $this->data['Message']['message'] : '';
					$viewVars = !empty($this->data['Message']) ? $this->data['Message'] : array();
					if ($this->Mail->send($email, $name, $subject, $message, $viewVars)) {
						if (!$this->Message->save(array('send' => true, 'send_datetime' => date('Y-m-d H:i:s')))) {
							$this->log('ContactForm', 'Saving send and send_datetime failed');
						}
						$this->Session->write('ContactForm.Message.id', $this->Message->id);
						$this->redirect('send');
					} else {
						$this->Session->setFlash(__('Message not send'));
					}
				} else {
					$this->Session->write('ContactForm.Message.id', $this->Message->id);
					$this->redirect('send');
				}
			} else {
				$this->Session->setFlash(__('Message not send'));
			}
		}
		$this->set('fields', Configure::read('ContactForm.fields'));
	}

	public function send () {
		$id = $this->Session->read('ContactForm.Message.id', $this->Message->id);
		$message = $this->Message->findById($id);
		if (empty($message)) {
			return $this->redirect('add');
		}
		$this->set('message', $message);
	}
}
