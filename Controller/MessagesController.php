<?php
class MessagesController extends ContactFormAppController {

	public $components = array('RequestHandler', 'ContactForm.Mail');

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
						if (!$this->request->is('ajax')) {
							$this->Session->setFlash(Configure::read('ContactForm.messageSuccess'), 'default', array('class' => 'message success'));
							$this->Session->write('ContactForm.Message.id', $this->Message->id);
							$this->redirect('send');
						} else {
							$this->response->statusCode('201');
							$this->set('data', $this->data);
							$this->set('result', 'success');
						}
					} else {
						if (!$this->request->is('ajax')) {
							$this->Session->setFlash(Configure::read('ContactForm.messageFail'));
						} else {
							$this->response->statusCode('400');
							$this->set('data', $this->data);
							$this->set('result', 'fail');
						}
					}
				} else {
					if (!$this->request->is('ajax')) {
						$this->Session->setFlash(Configure::read('ContactForm.messageSuccess'), 'default', array('class' => 'message success'));
						$this->Session->write('ContactForm.Message.id', $this->Message->id);
						$this->redirect('send');
					} else {
						$this->response->statusCode('201');
						$this->set('data', $this->data);
						$this->set('result', 'success');
					}
				}
			} else {
				if (!$this->request->is('ajax')) {
					$this->Session->setFlash(Configure::read('ContactForm.messageFail'));
				} else {
					$this->response->statusCode('400');
					$this->set('data', $this->data);
					$this->set('result', 'fail');
				}
			}
		}
		if (!$this->request->is('ajax')) {
			$this->set('fields', Configure::read('ContactForm.fields'));
			$this->set('messageSuccess', Configure::read('ContactForm.messageSuccess'));
			$this->set('messageFail', Configure::read('ContactForm.messageFail'));
		}
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
