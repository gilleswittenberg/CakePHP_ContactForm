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
					if ($this->Mail->send($this->data['Message']['email'], $this->data['Message']['name'], $this->data['Message']['subject'], $this->data['Message']['message'])) {
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
	}

	public function send () {
		$id = $this->Session->read('ContactForm.Message.id', $this->Message->id);
		$message = $this->Message->findById($id);
		if (!$message) {
			$this->redirect('add');
		}
		$this->set('message', $message);
	}
}
