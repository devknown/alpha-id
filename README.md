# AlphaID

AlphaID let you convert any integer to a short alphanumeric version. It can be useful for generating short, unique, and obfuscated identifiers.

## AlphaID Library Versions

- [PHP Version](https://github.com/devknown/alpha-id)
- [JavaScript Version](https://github.com/devknown/alpha-id-js)
- [Python Version](https://github.com/devknown/alpha-id-py)

## Requirements

PHP 7.3 and later.

## Installation (Composer)

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require devknown/alpha-id
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Getting Started

Simple usage looks like:

```php

// convert number to a short string
echo \Devknown\AlphaID::convert(258456357951); // Output: '4y7exoH'

// recover the original number from the short string
echo \Devknown\AlphaID::recover('4y7exoH'); // Output: 258456357951

```

Convert with key:

```php
use Devknown\AlphaID;

AlphaID::config('my_key');

echo AlphaID::convert(258456357951);
// the output this time will be '4ymMZq9'

echo AlphaID::recover('4ymMZq9');
// the recover output this time will be 258456357951

```

## License

AlphaID is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
