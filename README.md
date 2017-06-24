# phramework/validate-filler
>  Fill forms generated by validate (JSON schema) specification 

[![Build Status](https://travis-ci.org/phramework/validate-filler.svg?branch=master)](https://travis-ci.org/phramework/validate-filler) 
[![Coverage Status](https://coveralls.io/repos/github/phramework/validate-filler/badge.svg?branch=master)](https://coveralls.io/github/phramework/validate-filler?branch=master)

## Usage
Require package using composer

```bash
composer require phramework/validate-filler
```

### Example parsing schema from json
```php
<?php
$validator = \Phramework\Validate\ObjectValidator::createFromJSON('{
  "type": "object",
  "properties": {
    "a": {
      "type": "string",
      "enum": [
        "1",
        "2",
        "3"
      ]
    },
    "b": {
      "type": "string",
      "enum": [
        "i",
        "ii",
        "iii"
      ]
    }
  },
  "required": ["a"]
}');

$value = (new \Phramework\ValidateFiller\Filler())
    ->fill($validator);

var_dump($value);
```

Sample outputs:

```php
class stdClass#1381 (1) {
  public $a =>
  string(1) "2"
}
```

```php
class stdClass#1381 (2) {
  public $a =>
  string(1) "3"
  public $b =>
  string(2) "ii"
}
```

- will always include property `"a"` since it's required
- some times will include property `"b"` *(probabilistic)*

### Example using ObjectValidator constructor
```php
<?php
$validator = new \Phramework\Validate\ObjectValidator(
    (object) [
        'a' => new \Phramework\Validate\EnumValidator([
            '1',
            '2',
            '3'
        ]),
        'b' => new \Phramework\Validate\EnumValidator([
            'i',
            'ii',
            'iii'
        ])
    ],
    ['a'],
    false
);

$value = (new \Phramework\ValidateFiller\Filler())
    ->fill($validator);
```

## Development
### Install dependencies

```bash
composer update
```

### Test and lint code

```bash
composer test
composer lint
```
### Generate documentation

```bash
composer doc
```

## License
Copyright 2015-2017 Xenofon Spafaridis

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at

```
http://www.apache.org/licenses/LICENSE-2.0
```

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
