<?php
echo $this->Session->flash();
echo $this->Form->create();
echo $this->Form->input('name');
echo $this->Form->input('email');
echo $this->Form->input('subject');
echo $this->Form->input('message', array('type' => 'textarea'));
echo $this->Form->end(__('Send'));
