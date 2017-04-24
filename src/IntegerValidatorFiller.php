<?php

namespace Phramework\ValidateFiller;

use Phramework\Validate\BaseValidator;
use Phramework\Validate\IntegerValidator;

class IntegerValidatorFiller
{
    /**
     * @param IntegerValidator $validator
     * @return int
     */
    public function fill(BaseValidator $validator)
    {
        $faker = \Faker\Factory::create();

        $minimum = $validator->minimum ?? PHP_INT_MIN;

        $maximum = $validator->maximum ?? PHP_INT_MAX;

        if ($validator->exclusiveMinimum) {
            $minimum +=1;
        }

        if ($validator->exclusiveMaximum) {
            $maximum -= 1;
        }

        $number = $faker->numberBetween( //not exclusive
            $minimum,
            $maximum
        );

        /*
         * Ensure multipleOf
         */
        $number = ((int) ($number / $validator->multipleOf)) * $validator->multipleOf;

        return $number;
    }
}