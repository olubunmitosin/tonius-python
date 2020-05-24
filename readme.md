# python
================================================================================

[![Latest Stable Version](https://poser.pugx.org/tonius/python/v)](//packagist.org/packages/tonius/python)
[![Total Downloads](https://poser.pugx.org/tonius/python/downloads)](//packagist.org/packages/tonius/python)
[![Latest Unstable Version](https://poser.pugx.org/tonius/python/v/unstable)](//packagist.org/packages/tonius/python)
[![License](https://poser.pugx.org/tonius/python/license)](//packagist.org/packages/tonius/python)
[![Monthly Downloads](https://poser.pugx.org/tonius/python/d/monthly)](//packagist.org/packages/tonius/python)
[![Daily Downloads](https://poser.pugx.org/tonius/python/d/daily)](//packagist.org/packages/tonius/python)

Tonius Python :: A package built to smooth-run simple and complex python scripts inside PHP and Laravel projects. 
This is very useful when we need to perform system based operations and at the same time want to use the result in out PHP Applications. Credits to [Symfony Foundation](https://symfony.com/).

## Installation


Via Composer

``` bash
$ composer require tonius/python
```

## Usage

You must have python installed.


```
use tonius\python\Facades\Python;
$response = Python::run($fileName);
```
Available options;
````php
$options = [
    'test' => true, // To run a default test script if filename is not passes
    'output' => 'json', // Output types : json, file, raw. it's raw by default
    'fileName' => 'example.json' // .txt, php, e.t.c If you specify output to be file, you must pass the name of file to dump the output
];
````

#### Run Example script
```php
use tonius\python\Facades\Python;
$response = Python::run(null, ['test' => true ]);
```
## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email olubunmivictor6@gmail.com instead of using the issue tracker.

## Credits

- [olubunmi tosin][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/tonius/python.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tonius/python.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/tonius/python/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/tonius/python
[link-downloads]: https://packagist.org/packages/tonius/python
[link-travis]: https://travis-ci.org/tonius/python
[link-styleci]: https://github.styleci.io/repos/266439652
[link-author]: https://github.com/olubunmitosin
[link-contributors]: ../../contributors
