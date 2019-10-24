<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\DateValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Alex Kalliontzis <alkallio@gmail.com>
 */
class DateValidatorFillerTest extends TestCase
{
    public function provider() : array
    {
        return [
            [
                '2010-01-01',
                'now',
            ],
            [
                '2010-12-01',
                '2010-12-30',
            ],
            [
                '2020-08-23',
                '2020-08-23',
            ],
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testThatDateValidatorFillerGeneratesAValidValue(
        string $formatMinimum,
        string $formatMaximum
    ) {
        $validator = new DateValidator(
            $formatMinimum,
            $formatMaximum
        );

        $result = DefaultFillerRepositoryFactory::create()
            ->fill($validator);

        $this->assertGreaterThanOrEqual($formatMinimum, $result);

        $this->assertLessThanOrEqual($formatMaximum, $result);
    }
}
