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

        $value = DefaultFillerRepositoryFactory::create()
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

        $value = DefaultFillerRepositoryFactory::create()
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

    /**
     * @expectedException \DomainException
     */
    public function testExpectExceptionWhenItemsNotSet()
    {
        $validator = new ArrayValidator(
            1,
            3,
            null
        );

        DefaultFillerRepositoryFactory::create()
            ->fill($validator);
    }

    public function testArrayValidatorWithArrayItemsShouldWork()
    {
        $validator = new ArrayValidator(
            1,
            1,
            new ArrayValidator(
                1,
                1,
                new EnumValidator(['1']),
                false
            ),
            false
        );

        $value = DefaultFillerRepositoryFactory::create()
            ->fill($validator);

        $this->assertInternalType('array', $value);
        $this->assertInternalType('array', $value[0]);
        $this->assertEquals('1', $value[0][0]);
    }
}