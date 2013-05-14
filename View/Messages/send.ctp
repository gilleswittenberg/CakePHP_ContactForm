<p><?php echo __('Your message has been sent with the following information.'); ?><br><br>
<strong><?php echo __('Name'); ?>: </strong><?php echo $message['Message']['name']; ?><br>
<strong><?php echo __('Email'); ?>: </strong><?php echo $message['Message']['email']; ?><br>
<strong><?php echo __('Subject'); ?>: </strong><?php echo $message['Message']['subject']; ?><br>
<strong><?php echo __('Message'); ?>:</strong><br><?php echo nl2br($message['Message']['message']); ?><br>
</p>
