<?php

namespace Phramework\ValidateFiller;

use Phramework\Validate\BaseValidator;
use Phramework\Validate\NumberValidator;

class NumberValidatorFiller
{
    /**
     * @param NumberValidator $validator
     * @return int
     * @todo implement multipleOf
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
            null,
            $minimum,
            $maximum
        );

        /*
         * Ensure multipleOf
         */
        $number = ((int) $number / $validator->multipleOf) * $validator->multipleOf;

        return $number;
    }
}