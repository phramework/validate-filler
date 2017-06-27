<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\ArrayValidator;
use Phramework\Validate\EnumValidator;
use Phramework\Validate\StringValidator;
use Phramework\Validate\IntegerValidator;
use Phramework\Validate\NumberValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Vasilis Manolas <vasileiosmanolas@gmail.com>
 * @coversDefaultClass Phramework\ValidateFiller\StringValidatorFiller
 */
class StringValidatorFillerTest extends TestCase
{
    public function testFillReturnValueIsAString()
    {
        $validator = new StringValidator();

        /**
         * @var string
         */
        $returnedString = (new Filler())
            ->fill($validator);

        $this->assertInternalType('string', $returnedString);
    }

    public function testReturnedStringSatisfiesValidatorMinimum()
    {
        $minimum = 10;
        $maximum = 10;

        $validator = new StringValidator(
            $minimum,
            $maximum
        );

        /**
         * @var string
         */
        $returnedString = (new StringValidatorFiller())
            ->fill($validator);

        $this->assertGreaterThanOrEqual(
            $minimum,
            mb_strlen($returnedString),
            'Length of string should be greater or equal than minimum'
        );
    }

    public function testReturnedStringSatisfiesValidatorMaximum()
    {
        $minimum = 0;
        $maximum = 2;

        $validator = new StringValidator(
            $minimum,
            $maximum
        );

        /**
         * @var string
         */
        $returnedString = (new StringValidatorFiller())
            ->fill($validator);

        $this->assertLessThanOrEqual(
            $maximum,
            mb_strlen($returnedString),
            'Length of string should be less or equal than maximum'
        );
    }

    public function testWorksWithUndefinedMaximum()
    {
        $minimum = 0;

        $validator = new StringValidator(
            $minimum,
            null
        );

        /**
         * @var string
         */
        $returnedString = (new StringValidatorFiller())
            ->fill($validator);

        $this->assertInternalType('string', $returnedString);

        $this->assertGreaterThanOrEqual(
            $minimum,
            mb_strlen($returnedString),
            'Length of string should be greater or equal than minimum'
        );
    }
}
