<?php
declare(strict_types=1);

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\DatetimeValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Alex Kalliontzis <alkallio@gmail.com>
 */
class DatetimeValidatorFillerTest extends TestCase
{
    public function provider() : array
    {
        return [
            [
                '2010-01-01 12:00',
                '2020-12-12 19:00',
            ],
            [
                '2010-12-01 13:00',
                '2010-12-30 00:00',
            ],
            [
                '2020-08-23 01:00:00',
                '2020-08-23 02:00:00',
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
        $validator = new DatetimeValidator(
            $formatMinimum,
            $formatMaximum
        );

        $result = DefaultFillerRepositoryFactory::create()
            ->fill($validator);

        $this->assertGreaterThanOrEqual($formatMinimum, $result);

        $this->assertLessThanOrEqual($formatMaximum, $result);
    }
}
