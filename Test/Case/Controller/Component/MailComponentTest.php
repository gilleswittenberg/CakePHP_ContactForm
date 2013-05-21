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
	public function testSend() {
		$this->assertInternalType('array', $this->Mail->send('johndoe@example.com', 'John Doe'));
	}

}
