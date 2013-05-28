<?php
App::uses('ComponentCollection', 'Controller');
App::uses('Component', 'Controller');
App::uses('MailComponent', 'ContactForm.Controller/Component');

/**
 * MailComponent Test Case
 *
 */
class MailComponentTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$Collection = new ComponentCollection();
		$this->Mail = new MailComponent($Collection);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Mail);

		parent::tearDown();
	}

/**
 * testSend method
 *
 * @return void
 */
	public function testSend () {
		Configure::write('ContactForm.mailTo', 'mail@example.com');
		$this->assertInternalType('array', $this->Mail->send('johndoe@example.com', 'John Doe'));
	}

	public function testSendDefaultTemplate () {
		Configure::write('ContactForm.mailTo', 'mail@example.com');
		Configure::write('ContactForm.template.view', 'default');
		Configure::write('ContactForm.template.layout', 'default');
		$result = $this->Mail->send('johndoe@example.com', 'John Doe');
		$this->assertContains('This email was sent using the CakePHP Framework', $result['message']);
	}

	public function testSendNoTemplate () {
		Configure::write('ContactForm.mailTo', 'mail@example.com');
		Configure::write('ContactForm.template.view', false);
		Configure::write('ContactForm.template.layout', false);
		$result = $this->Mail->send('johndoe@example.com', 'John Doe');
		$this->assertEmpty('', $result['message']);
	}
}
