$(function () {

	var $form = $('#ContactFormMessageAddForm');
	var action = $form.attr('action');
	var sending = false;

	function setMessage (message, result) {
		var className = 'message';
		var $messageContainer = $('#message-container');
		if (result === 'success') {
			className += ' success';
		}
		$messageContainer.html($('<p>', {'class': className, text: message}));
	}

	$form.submit(function (e) {
		var $inputs, data = {};
		e.preventDefault();
		// only send once
		if (sending) {
			return;
		}
		// get inputs with data
		$inputs = $form.find(':input[name^="data[Message]"]');
		// set data
		$inputs.each(function () {
			var $this = $(this);
			data[$this.attr('name')] = $this.val();
		});
		// make AJAX call to form's action value
		var jqxhr = $.post(action, data, null, 'json')
		.done(function () {
			setMessage('Message send', 'success');
		})
		.fail(function () {
			setMessage('Message not send');
		})
		.always(function () {
			sending = false;
		});
		sending = true;
	});
});
