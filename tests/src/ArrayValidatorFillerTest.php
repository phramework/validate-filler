<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\ArrayValidator;
use Phramework\Validate\EnumValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @coversDefaultClass Phramework\ValidateFiller\ArrayValidatorFiller
 */
class ArrayValidatorFillerTest extends TestCase
{
    public function testFillNotUnique()
    {
        $enum = ['a', 'b', 'c'];

        $minItems = 2;
        $maxItems = 2;

        $validator = new ArrayValidator(
            $minItems,
            $maxItems,
            new EnumValidator($enum),
            false
        );

        $value = (new Filler())
            ->fill($validator);

        $c = array_diff($value, $enum);

        $this->assertGreaterThanOrEqual($minItems, count($value));
        $this->assertLessThanOrEqual($maxItems, count($value));

        $this->assertEmpty($c, 'Expect no other element');
    }

    public function testFillUniqueEnum()
    {
        $enum = ['a', 'b', 'c'];

        $minItems = 3;
        $maxItems = 3;

        $validator = new ArrayValidator(
            $minItems,
            $maxItems,
            new EnumValidator($enum),
            true
        );

        $value = (new Filler())
            ->fill($validator);

        /*
         * To ensure order
         */
        sort($value);

        $this->assertEquals(
            $enum,
            $value,
            'Since we requested unique, and same number of item, we expect them to be same'
        );
    }
}
