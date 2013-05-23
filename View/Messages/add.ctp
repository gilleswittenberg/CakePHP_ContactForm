<?php
echo $this->Session->flash();
echo $this->Form->create();
foreach ($fields as $name => $options) {
	echo $this->Form->input($name, $options);
}
echo $this->Form->end(__('Send'));
