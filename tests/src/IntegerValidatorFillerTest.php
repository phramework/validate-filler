<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\IntegerValidator;
use Phramework\Validate\NumberValidator;

/**
 * @since  {VERSION}
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class IntegerValidatorFillerTest extends TestCase
{
    public function provider() : array
    {
        return [
            [
                0,
                100,
                true,
                false,
                2
            ],
            [
                -100,
                100,
                false,
                false,
                10
            ]
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testFill(
        int $minimum,
        int $maximum,
        bool $exclusiveMinimum,
        bool $exclusiveMaximum,
        int $multipleOf
    ) {
        $validator = new IntegerValidator(
            $minimum,
            $maximum,
            $exclusiveMinimum,
            $exclusiveMaximum,
            $multipleOf
        );

        $result = (new Filler())
            ->fill($validator);

        if ($exclusiveMinimum) {
            $this->assertGreaterThanOrEqual($minimum, $result);
        } else {
            $this->assertGreaterThan($minimum, $result);
        }

        if ($exclusiveMaximum) {
            $this->assertLessThanOrEqual($maximum, $result);
        } else {
            $this->assertLessThan($maximum, $result);
        }

        $this->assertEquals(
            $result / $multipleOf,
            (float)((int) ($result / $multipleOf))
        );
    }
}
