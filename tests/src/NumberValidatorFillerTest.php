<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\NumberValidator;

/**
 * @since  {VERSION}
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class NumberValidatorFillerTest extends TestCase
{
    public function provider() : array
    {
        return [
            [
                0,
                1,
                true,
                true,
                0.5
            ],
            [
                0,
                100,
                true,
                false,
                0.5
            ],
            [
                0,
                4,
                false,
                true,
                0.5
            ],
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testFill(
        float $minimum,
        float $maximum,
        bool $exclusiveMinimum,
        bool $exclusiveMaximum,
        float $multipleOf
    ) {
        $validator = new NumberValidator(
            $minimum,
            $maximum,
            $exclusiveMinimum,
            $exclusiveMaximum,
            $multipleOf
        );

        $result = (new Filler())
            ->fill($validator);

        if ($exclusiveMinimum) {
            $this->assertGreaterThan($minimum, $result);
        } else {
            $this->assertGreaterThanOrEqual($minimum, $result);
        }

        if ($exclusiveMaximum) {
            $this->assertLessThan($maximum, $result);
        } else {
            $this->assertLessThanOrEqual($maximum, $result);
        }

        $this->assertEquals(
            $result / $multipleOf,
            (float) ((int) ($result / $multipleOf))
        );
    }
}
