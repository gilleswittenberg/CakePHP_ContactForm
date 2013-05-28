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
	public function testAddNonValid () {
		Configure::write('ContactForm.messageFail', 'Message not send');
		Configure::write('ContactForm.sendInControllerAction', true);
		$Messages = $this->generate('ContactForm.Messages', array(
			'components' => array(
				'ContactForm.Mail' => array('send'),
				'Session'
			)
		));
		$Messages->Message = new Message();
		$Messages->Mail
			->expects($this->never())
			->method('send');
		$Messages->Session
			->expects($this->once())
			->method('setFlash')
			->with('Message not send');
		$result = $this->testAction('/contact_form/messages/add', array(
			'data' => array('Message' => array('name' => '', 'email' => 'johndoe@example.com'))
		));
	}

	public function testAddSendInControllerAction () {
		Configure::write('ContactForm.messageSuccess', 'Message send');
		Configure::write('ContactForm.sendInControllerAction', true);
		$Messages = $this->generate('ContactForm.Messages', array(
			'components' => array(
				'ContactForm.Mail' => array('send'),
				'Session'
			)
		));
		$Messages->Message = new Message();
		$Messages->Mail
			->expects($this->once())
			->method('send')
			->will($this->returnValue(true));
		$Messages->Session
			->expects($this->once())
			->method('setFlash')
			->with('Message send');
		$result = $this->testAction('/contact_form/messages/add', array(
			'data' => array('Message' => array('name' => 'John Doe', 'email' => 'johndoe@example.com', 'subject' => 'Subject', 'message' => 'Message\nline of text'))
		));
	}

	public function testAddSendInControllerActionFalse () {
		Configure::write('ContactForm.messageSuccess', 'Message send');
		Configure::write('ContactForm.sendInControllerAction', false);
		$Messages = $this->generate('ContactForm.Messages', array(
			'components' => array(
				'ContactForm.Mail' => array('send'),
				'Session'
			)
		));
		$Messages->Mail
			->expects($this->never())
			->method('send');
		$Messages->Session
			->expects($this->once())
			->method('setFlash')
			->with('Message send');
		$result = $this->testAction('/contact_form/messages/add', array(
			'data' => array('Message' => array('name' => 'John Doe', 'email' => 'johndoe@example.com', 'subject' => 'Subject', 'message' => 'Message\nline of text'))
		));
	}

	public function testAddIncompleteData () {
		Configure::write('ContactForm.sendInControllerAction', true);
		$Messages = $this->generate('ContactForm.Messages', array(
			'components' => array(
				'ContactForm.Mail' => array('send')
			)
		));
		$Messages->Mail
			->expects($this->once())
			->method('send')
			->will($this->returnValue(true));
		$result = $this->testAction('/contact_form/messages/add', array(
			'data' => array('Message' => array('name' => 'John Doe', 'email' => 'johndoe@example.com'))
		));
	}

	public function testSendInvalidId () {
		$Messages = $this->generate('ContactForm.Messages', array(
			'methods' => array(
				'redirect'
			)
		));
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
		$Messages->Session
			->expects($this->once())
			->method('read')
			->will($this->returnValue(1));
		$Messages
			->expects($this->never())
			->method('redirect');
		$result = $this->testAction('/contact_form/messages/send');
	}

	public function testViewInputs () {
		Configure::write('ContactForm.fields', array(
			'name' => array(),
			'email' => array(),
			'subject' => array(),
			'message' => array(
				'type' => 'textarea'
			)
		));
		$Messages = $this->generate('ContactForm.Messages');
		$html = $this->testAction('/contact_form/messages/add', array('method' => 'get', 'return' => 'view'));
		$matcherLabelName = array('tag' => 'label', 'content' => 'Name');
		$matcherInput = array('tag' => 'input', 'attributes' => array('type' => 'email', 'name' => 'data[Message][email]'));
		$matcherTextarea = array('tag' => 'textarea', 'attributes' => array('name' => 'data[Message][message]'));
		$this->assertTag($matcherLabelName, $html);
		$this->assertTag($matcherInput, $html);
		$this->assertTag($matcherTextarea, $html);
	}

	public function testViewInputsCustomLabels () {
		Configure::write('ContactForm.fields', array(
			'name' => array(
				'label' => 'Your name'
			),
			'email' => array(),
			'subject' => array(),
			'message' => array(
				'type' => 'textarea',
				'label' => false
			)
		));
		$Messages = $this->generate('ContactForm.Messages');
		$html = $this->testAction('/contact_form/messages/add', array('method' => 'get', 'return' => 'view'));
		$matcherLabelName = array('tag' => 'label', 'content' => 'Your name');
		$matcherLabels = array('tag' => 'label');
		$this->assertTag($matcherLabelName, $html);
		$this->assertEquals(preg_match('/<label for="MessageMessage">Message<\/label>/', $html), 0);
	}

	public function testViewInputsHiddenAndValue () {
		Configure::write('ContactForm.fields', array(
			'name' => array(),
			'email' => array(),
			'subject' => array(
				'type' => 'hidden',
				'value' => 'Default subject'
			),
			'message' => array(
				'type' => 'textarea',
				'label' => false
			)
		));
		$Messages = $this->generate('ContactForm.Messages');
		$html = $this->testAction('/contact_form/messages/add', array('method' => 'get', 'return' => 'view'));
		$matcherLabel = array('tag' => 'input', 'attributes' => array('name' => 'data[Message][subject]', 'type' => 'hidden', 'value' => 'Default subject'));
		$this->assertTag($matcherLabel, $html);
	}

	public function testViewInputsExtraFields () {
		Configure::write('ContactForm.sendInControllerAction', true);
		$Messages = $this->generate('ContactForm.Messages', array(
			'components' =>  array(
				'Mail'
			)
		));
		$data = array(
			'Message' => array(
				'name' => 'John Doe',
				'email' => 'john@example.com',
				'website' => 'www.example.com',
				'subject' => 'Subject',
				'message' => 'message'
			)
		);
		$Messages->Mail
			->expects($this->once())
			->method('send')
			->with('john@example.com', 'John Doe', 'Subject', 'message', $data['Message'])
			->will($this->returnValue(true));
		$html = $this->testAction('/contact_form/messages/add', array('method' => 'post', 'data' => $data));
	}

	public function testAjaxResponseFail () {
		$_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$_SERVER['HTTP_ACCEPT'] = 'application/json';
		$Messages = $this->generate('ContactForm.Messages');
		$data = array(
			'Message' => array(
				'name' => '',
				'email' => 'john@example.com',
				'subject' => 'Subject',
				'message' => 'message'
			)
		);
		$Messages = $this->generate('ContactForm.Messages');
		$result = $this->testAction('/contact_form/messages/add', array('method' => 'post', 'data' => $data, 'return' => 'view'));
		$json = json_decode($result, true);
		$this->assertEquals('fail', $json['result']);
	}

	public function testAjaxResponseSuccess () {
		$_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$_SERVER['HTTP_ACCEPT'] = 'application/json';
		$Messages = $this->generate('ContactForm.Messages');
		$data = array(
			'Message' => array(
				'name' => 'John Doe',
				'email' => 'john@example.com',
				'subject' => 'Subject',
				'message' => 'message'
			)
		);
		$Messages = $this->generate('ContactForm.Messages');
		$result = $this->testAction('/contact_form/messages/add', array('method' => 'post', 'data' => $data, 'return' => 'view'));
		$json = json_decode($result, true);
		$this->assertEquals('success', $json['result']);
	}
}
