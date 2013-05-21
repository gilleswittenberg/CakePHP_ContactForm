<?php
App::uses('Message', 'ContactForm.Model');

/**
 * Message Test Case
 *
 */
class MessageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.contact_form.contactform_message'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Message = ClassRegistry::init('ContactForm.Message');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Message);

		parent::tearDown();
	}

	public function testValidate () {
		$this->Message->set(array('Message' => array('name' => 'John Doe', 'email' => 'johndoe@example.com', 'subject' => 'Subject', 'Message' => 'Message\nline of text')));
		$this->assertTrue($this->Message->validates());
		$this->Message->set(array('Message' => array('name' => '', 'email' => 'johndoe@example.com', 'subject' => 'Subject', 'Message' => 'Message\nline of text')));
		$this->assertFalse($this->Message->validates());
		$this->Message->set(array('Message' => array('name' => 'John Doe', 'email' => 'invalidemail', 'subject' => 'Subject', 'Message' => 'Message\nline of text')));
		$this->assertFalse($this->Message->validates());
	}
}
