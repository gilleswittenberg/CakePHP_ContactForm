<div id="message-container">
<?php echo $this->Session->flash(); ?>
</div>
<?php
echo $this->Form->create('ContactForm.Message', array('url' => '/contact_form/messages/add', 'id' => 'ContactFormMessageAddForm'));
foreach ($fields as $name => $options) {
	echo $this->Form->input($name, $options);
}
echo $this->Form->end(__('Send'));

// scripts
if (Configure::read('ContactForm.ajax')) {
	if (Configure::read('ContactForm.includeJQuery')) {
		echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js', array('inline' => false));
	}
	if (isset($messageSuccess) && isset($messageFail)) {
		echo $this->Html->scriptBlock('window.ContactForm = {messageSuccess: ' . json_encode($messageSuccess) . ', messageFail: ' . json_encode($messageFail) . '};');
	}
	echo $this->Html->script('ContactForm.contact_form_init', array('inline' => false));
}
