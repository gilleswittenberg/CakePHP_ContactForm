#CakePHP 2.3+ ContactForm Plugin

##Usage
In `APP_DIR/Config/bootstrap.php` add:
```php
CakePlugin::load('ContactForm');

Configure::write('ContactForm', array(
	'mailTo' => 'mail@example.com',
	'sendInControllerAction' => 'true'
));
```

##ToDo
- SendMailShell
- Install with Composer
- Clear Session from send mail
- Add option for add extra Fields
- Set fields in config
- Add tests
- Captcha
- Manual
