# Cache Key [![Build Status](https://travis-ci.org/EcomDev/cache-key.svg)](https://travis-ci.org/EcomDev/cache-key)  [![Coverage Status](https://coveralls.io/repos/github/EcomDev/cache-key/badge.svg?branch=develop)](https://coveralls.io/github/EcomDev/cache-key?branch=develop)

Library that allows you to generate cache keys based on various data formats.

Main components:
* **Key generator** Allows to generate a cache key based on different data input
* **Key converters** Allows to convert various php data types into key friendly data type
* **Key normalizer** Normalizes characters in generated string to match particular cache key sanity checks of your own cache adapter.  
   
## Installation
```bash
composer require ecomdev/cache-key
```

## Usage

### Automatic non alpha-num characters encoding
```php
use EcomDev\CacheKey\Normalizer\EncodeNormalizer;
use EcomDev\CacheKey\Generator;

$generator = new Generator(new EncodeNormalizer());
$generator->generate('some_bad_#^.;:/\\_character'); // Generates "some_bad_235e2e3b3a2f5c_character"
```

### Multiple normalizers
```php
use EcomDev\CacheKey\Normalizer\EncodeNormalizer;
use EcomDev\CacheKey\Normalizer\LengthNormalizer;
use EcomDev\CacheKey\NormalizerChain;
use EcomDev\CacheKey\Generator;

$normalizer = new NormalizerChain([
    new EncodeNormalizer(),
    new LengthNormalizer(16)
]);

$generator = new Generator($normalizer);
$generator->generate('some_bad_#^.;:/\\_character'); // Generates "some_bad_235e2e3b3a2f5c_character"
```

### Using converter for key value map
```php
use EcomDev\CacheKey\Normalizer\EncodeNormalizer;
use EcomDev\CacheKey\Converter\KeyValueConverter;
use EcomDev\CacheKey\Converter\ScalarConverter;
use EcomDev\CacheKey\Generator;

$generator = new Generator(
    new EncodeNormalizer(), 
    new KeyValueConverter(new ScalarConverter())
);

$generator->generate([
    'some-key' => 'some-value', 
    'another-key' => 'another-value'
]); // Generates "some-key_some-value_another-key_another-value"
```

### Cache Key Info Provider Usage

Your custom cache able model 
```php
class YourCustomModel implements EcomDev\CacheKey\InfoProviderInterface
{
    public function getCacheKeyInfo()
    {
        return [
            'some-key' => 'some-value', 
            'another-key' => 'another-value'
        ];
    }
}
```

Usage in key generation

```php
use EcomDev\CacheKey\Normalizer\EncodeNormalizer;
use EcomDev\CacheKey\Converter\KeyValueConverter;
use EcomDev\CacheKey\Converter\ScalarConverter;
use EcomDev\CacheKey\Generator;

$object = new YourCustomModel();

$generator = new Generator(
    new EncodeNormalizer(), 
    new KeyValueConverter(new ScalarConverter())
);

$generator->generate($object); // Generates "some-key_some-value_another-key_another-value"
```

### PSR-6 compatible key generation
```php
use EcomDev\CacheKey\Normalizer\Psr6Normalizer;
use EcomDev\CacheKey\Generator;

$generator = new Generator(Psr6Normalizer::create());
$generator->generate('give_me-psr-6-compatible_#^.;:/\\-key'); // Generates "give_me-psr-6-compatible_235e.3b3a2f5c-key"
```

### Prefixed Key Generation
```php
use EcomDev\CacheKey\Normalizer\Psr6Normalizer;
use EcomDev\CacheKey\Generator;

$generator = new Generator(Psr6Normalizer::create(), null, 'prefix-');
$generator->generate('some-non-prefixed-key'); // Generates "prefix-some-non-prefixed-key"
```

## Contribution
Make a pull request based on develop branch
