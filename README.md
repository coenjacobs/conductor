# Conductor [![Latest Stable Version](https://poser.pugx.org/coenjacobs/conductor/v/stable.svg)](https://packagist.org/packages/coenjacobs/conductor) [![License](https://poser.pugx.org/coenjacobs/conductor/license.svg)](https://packagist.org/packages/coenjacobs/conductor)

Conductor allows you to check the requirements for your WordPress plugin, before you start your plugin. Say you require a certain PHP version, or a minimum version of another plugin to be active. Conductor has you covered with an easy to use set of checks.

This package requires PHP 5.3 or higher in order to run the tool.

**Warning:** This package is very experimental and breaking changes are very likely until version 1.0.0 is tagged. Use with caution, always wear a helmet when using this in production environments.

## Installation

This package can be best installed inside your plugin, by using Composer:

`composer require coenjacobs/conductor`

Best results are achieved when installing this library in combination with the [Mozart package](https://github.com/coenjacobs/mozart), so Conductor will be installed in your own namespace to prevent conflicts.

## Checks

Conductor is based on simple Check classes that check a single conditional. This can be to check for the PHP version on the current server, or another plugin being active (and of a minimum version number itself).

These Check classes are registered with a central Handler and provided with the right details to check for through a single array of settings. A single call to the `check()` method on the Handler will then run through all those checks and will let you know whether those requirements are being satisfied. A simple example of how this works in code:

```php
$handler = new CoenJacobs\Conductor\Handler();
$handler->setup([
    [
        'type' => 'php',
        'version' => '5.6.0',
    ],
    [
        'type' => 'plugin',
        'name' => 'WooCommerce',
        'slug' => 'woocommerce/woocommerce.php',
        'version' => '3.1.0',
    ],
]);

if ( $handler->check() === false ) {
    // if you end up here, something failed...
}
```

The provided arguments speak for itself, but to summarize the checks this will perform:

- The minimum PHP version has to be 5.6.0.
- The WooCommerce plugin has to be active, with a minimum version of 3.1.0.

If `$handler->check()` returns `false`, one or more of these requirements failed and you can stop the plugin from doing _anything_, if you like. The next step would be to report the fact that the requirements for you plugin haven't been satisfied.

## Messages

Conductor also provides a simple interface to output messages to your end user about why your plugin couldn't run. You can output these messages by using the `Messages` class and provide it with the failed Checks:

```php
if ( $handler->check() === false ) {
    $messages = new CoenJacobs\Conductor\Messages();
    $messages->setup($handler->getFailures());
}
```

Each Check is provided with a method that formats a line of text, using the details of your plugin requirements provided to the check. For example, if the WooCommerce plugin wasn't activated and you required it to be at least version 3.1.0, the message output would be:

> This plugin requires **WooCommerce 3.1.0** or higher to be installed and activated, in order to run.

You can also request the Checks that have failed from the Handler, but using the `getFailures()` method, to format and output your own messages based on the failed Checks.

## What about PHP 5.2?

You might have noticed that all classes in this package are using namespaces and WordPress is notorious for still supporting PHP 5.2 (although that is about to change) and you would be correct! If you *really* want to support PHP 5.2 in your plugin, or at least make your main plugin file compatible with PHP 5.2, you can use the `LegacyCondutor` class, which is a PHP 5.2 compatible class to check if the version of PHP being used is at least capable of parsing namespaces.

> But wait, Coen, you have this WPupdatePHP project already which does just this?!

Correct again! With the [Servehappy](https://make.wordpress.org/core/features/servehappy/) project gaining more traction and WordPress' intentions to [bump the minimum required version](https://make.wordpress.org/core/2018/12/08/updating-the-minimum-php-version/) to at least PHP 5.6 soon, I have decided to sunset the WPupdatePHP project. WordPress core can do a far better job at reaching more users of the WordPress software than I can and Servehappy is doing a great job already.

Conductor does *more* than just check for PHP versions already though. And there is more to come. :)