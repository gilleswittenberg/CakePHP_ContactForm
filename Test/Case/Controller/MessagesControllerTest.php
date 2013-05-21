<?php
App::uses('MessagesController', 'ContactForm.Controller');
App::uses('Message', 'ContactForm.Model');

/**
 * MessagesController Test Case
 *
 */
class MessagesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.contact_form.ContactForm_message'
	);

/**
 * testAdd method
 *
 * @return void
 */
	public function testAddSendInControllerAction () {
		Configure::write('ContactForm.sendInControllerAction', true);
		$Messages = $this->generate('ContactForm.Messages', array(
			'components' => array(
				'ContactForm.Mail' => array('send')
			)
		));
		$Messages->Message->useTable = 'ContactForm_messages';
		$Messages->Mail
			->expects($this->once())
			->method('send')
			->will($this->returnValue(true));
		$result = $this->testAction('/contact_form/messages/add', array(
			'data' => array('Message' => array('name' => 'John Doe', 'email' => 'johndoe@example.com', 'subject' => 'Subject', 'message' => 'Message\nline of text'))
		));
	}

	public function testAddSendInControllerActionFalse () {
		Configure::write('ContactForm.sendInControllerAction', false);
		$Messages = $this->generate('ContactForm.Messages', array(
			'components' => array(
				'ContactForm.Mail' => array('send')
			)
		));
		$Messages->Message->useTable = 'ContactForm_messages';
		$Messages->Mail
			->expects($this->never())
			->method('send')
			->will($this->returnValue(true));
		$result = $this->testAction('/contact_form/messages/add', array(
			'data' => array('Message' => array('name' => 'John Doe', 'email' => 'johndoe@example.com', 'subject' => 'Subject', 'message' => 'Message\nline of text'))
		));
	}

	public function testSendInvalidId () {
		$Messages = $this->generate('ContactForm.Messages', array(
			'methods' => array(
				'redirect'
			)
		));
		$Messages->Message->useTable = 'ContactForm_messages';
		$Messages
			->expects($this->once())
			->method('redirect');
		$result = $this->testAction('/contact_form/messages/send');
	}

	public function testSendValidId () {
		$Messages = $this->generate('ContactForm.Messages', array(
			'methods' => array(
				'redirect'
			),
			'components' =>  array(
				'Session'
			)
		));
		$Messages->Message->useTable = 'ContactForm_messages';
		$Messages->Session
			->expects($this->once())
			->method('read')
			->will($this->returnValue(1));
		$Messages
			->expects($this->never())
			->method('redirect');
		$result = $this->testAction('/contact_form/messages/send');
	}

/**
 * testSend method
 *
 * @return void
 */
	public function testSend() {
		// no session set

	}
}
