# DemoNonce 
This is a demo implementation of Wordpress Nonce as a composer package. Uses symfony/http-foundation for session, uri and request parameters.

#### Usage : 
Getting html outputs for the nonce:
```php
<?php
echo \DemoNonce\NonceHtml::getMetaTagNonce();
echo \DemoNonce\NonceHtml::getHiddenInput();
echo \DemoNonce\NonceHtml::getNonceUrl($request->getRequestUri());
?>
```

Validating the token:
```php
try {
    \DemoNonce\NonceHtml::validate();
} catch(InvalidNonceException $e) {
	var_dump($e);
}
```

If its not on packegist add this to your composer json, 
```json
  "repositories": [
    {
      "type":"package",
      "package": {
        "name": "murat-yuksel/demo-nonce",
        "version":"0.1",
        "type":"package",
        "source": {
          "url": "https://github.com/murat-yuksel/demo-nonce.git",
          "type": "git",
          "reference":"master"
        },
        "autoload": {
          "psr-4": {
            "DemoNonce\\": "src/DemoNonce/"
          }
        }
      }
    }
  ],
```
and run this
```sh
composer require murat-yuksel/demo-nonce
```

