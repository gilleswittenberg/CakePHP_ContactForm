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

## Create schema
Run cake shell schema
```bash
cake schema create --plugin ContactForm
```

## Usage
In `APP_DIR/Config/bootstrap.php` add:
```php
CakePlugin::load('ContactForm', array('bootstrap' => true, 'routes' => true));

Configure::write('ContactForm', array(
	'mailTo' => 'mail@example.com',
	'sendInControllerAction' => 'true'
));
```

##ToDo
- Configurable validation for fields
- Configurable flash messages
- SendMailShell
- Captcha
- Clear Session from send mail
- Disable form after submit (Javascript)
- Allow for multiple different forms per application
