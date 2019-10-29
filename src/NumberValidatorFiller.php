<?php

namespace Phramework\ValidateFiller;

use Phramework\Validate\BaseValidator;
use Phramework\Validate\NumberValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since  0.1.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class NumberValidatorFiller implements IValidatorFiller
{
    /**
     * @param NumberValidator $validator
     * @return int
     */
    public function fill(BaseValidator $validator)
    {
        $faker = \Faker\Factory::create();

        $minimum = $validator->minimum ?? PHP_INT_MIN;

        $maximum = $validator->maximum ?? PHP_INT_MAX;

        if ($validator->exclusiveMinimum) {
            $minimum += 0.0000000001;
        }

        if ($validator->exclusiveMaximum) {
            $maximum -= 0.0000000001;
        }

        $number = $faker->randomFloat(
            8,
            $minimum,
            $maximum
        );

        $multipleOf = $validator->multipleOf;

        if ($multipleOf !== null && $multipleOf != 0) {
            $div = (int) $number / $validator->multipleOf;

            /*
             * Ensure is multipleOf
             */
            $number = ($div ? : 1) * $validator->multipleOf;
        }

        return $number;
    }
}
