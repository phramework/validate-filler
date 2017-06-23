<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\IntegerValidator;
use Phramework\Validate\NumberValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
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
                0,
                4,
                false,
                true,
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

        $result = DefaultFillerRepositoryFactory::create()
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
            (float)((int) ($result / $multipleOf))
        );
    }
}
