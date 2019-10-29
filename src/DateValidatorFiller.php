<?php
declare(strict_types=1);

namespace Phramework\ValidateFiller;

use DateTime;
use Faker\Factory;
use Phramework\Validate\BaseValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since  1.1.0
 * @author Alex Kalliontzis <alkallio@gmail.com>
 */
class DateValidatorFiller implements IValidatorFiller
{
    public function fill(BaseValidator $validator): string
    {
        $faker = Factory::create();

        $minimum = $validator->formatMinimum ??
            ((new DateTime())
                ->modify('-1 year')
                ->format('Y-m-d'));

        $maximum = $validator->formatMaximum ??
            ((new DateTime())
                ->modify('1 year')
                ->format('Y-m-d'));

        return $faker->dateTimeBetween(
            $minimum,
            $maximum
        )->format('Y-m-d');
    }
}
