<div id="message-container">
<?php echo $this->Session->flash(); ?>
</div>
<?php
echo $this->Form->create(array('id' => 'ContactFormMessageAddForm'));
foreach ($fields as $name => $options) {
	echo $this->Form->input($name, $options);
}
echo $this->Form->end(__('Send'));

// scripts
echo $this->Html->script(array('//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js', 'ContactForm.contact_form_init'));
