# CakePHP 2.3+ ContactForm Plugin

## Installation

_[Composer]_

Add the following to `composer.json`

```json
"require": {
	"gilleswittenberg/contact-form": "dev-master"
}
```
_[Manual]_

1. Download http://github.com/gilleswittenberg/CakePHP_ContactForm/zipball/master
2. Unzip the downloaded ZIP file.
3. Copy the resulting folder to `APP_DIR/Plugin`
4. Rename the folder you just copied to `ContactForm`

_[GIT Submodule]_

In your `APP_DIR` type:
```bash
git submodule add git://github.com/gilleswittenberg/CakePHP_ContactForm.git Plugin/ContactForm
git submodule init
git submodule update
```
_[GIT Clone]_

In `APP_DIR/Plugin` directory type
```bash
git clone git://github.com/gilleswittenberg/CakePHP_ContactForm.git ContactForm
```

## Usage
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
- Clear Session from send mail
- Add option for add extra Fields
- Set fields in config
- Add tests
- Captcha
- Improve README Usage (add Schema generate, open page, etc.)
- Disable form after submit (Javascript)
