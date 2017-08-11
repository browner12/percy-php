# percy

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This package makes it easy to interact with the [Percy](https://percyi.io) service using PHP.

## Install

Via Composer

``` bash
$ composer require browner12/percy
```

## Usage

``` php
$skeleton = new browner12\percy();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email browner12@gmail.com instead of using the issue tracker.

## Credits

- [Andrew Brown][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/browner12/percy.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/browner12/percy/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/browner12/percy.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/browner12/percy.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/browner12/percy.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/browner12/percy
[link-travis]: https://travis-ci.org/browner12/percy
[link-scrutinizer]: https://scrutinizer-ci.com/g/browner12/percy/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/browner12/percy
[link-downloads]: https://packagist.org/packages/browner12/percy
[link-author]: https://github.com/browner12
[link-contributors]: ../../contributors
