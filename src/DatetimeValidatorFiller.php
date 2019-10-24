<?php

namespace Phramework\ValidateFiller;

use DateTime;
use Faker\Factory;
use Phramework\Validate\BaseValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since  1.1.0
 * @author Alex Kalliontzis <alkallio@gmail.com>
 */
class DatetimeValidatorFiller implements IValidatorFiller
{
    /**
     * @param BaseValidator $validator
     * @return string
     */
    public function fill(BaseValidator $validator)
    {
        $faker = Factory::create();

        $minimum = $validator->formatMinimum ??
            ((new DateTime())
                ->modify('-1 year')
                ->modify(random_int(-100, 100) . ' hours')
                ->format('Y-m-d H:i:s'));

        $maximum = $validator->formatMaximum ??
            ((new DateTime())
                ->modify('1 year')
                ->modify(random_int(-100, 100) . ' hours')
                ->format('Y-m-d H:i:s'));

        if ($maximum === 'now') {
            $maximum = ((new DateTime())
                ->format('Y-m-d H:i:s'));
        }

        return $faker->dateTimeBetween(
            $minimum,
            $maximum
        )->format('Y-m-d H:i:s');
    }
}
