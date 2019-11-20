<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\StringValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Alex Kalliontzis <alkallio@gmail.com>
 */
class StringValidatorFillerTestWithDateTimeFormat extends TestCase
{
    public function testFillReturnValueIsAString()
    {
        $validator = new StringValidator(
            0,
            null,
            null,
            false,
            'date-time'
        );

        /**
         * @var string
         */
        $returnedString = DefaultFillerRepositoryFactory::create()
            ->fill($validator);

        $this->assertIsString('string', $returnedString);
    }

    public function minimumMaximumProvider(): array
    {
        //input
        return [
            ['2020-01-01T23:59:59+02:00', '2020-01-01T23:59:59+02:00'],
            ['2020-01-01T00:59:59+02:00', '2020-01-01T23:59:59+02:00'],
            ['2010-01-01T23:59:59+02:00', '2019-01-01T23:23:59+02:00'],
        ];
    }

    /**
     * @dataProvider minimumMaximumProvider
     */
    public function testReturnedStringSatisfiesFormatMinimumAndMaximum(
        string $minimum,
        string $maximum
    ) {
        $validator = new StringValidator(
            0,
            null,
            null,
            false,
            'date-time'
        );

        $validator->setFormatMaximum($maximum);

        $validator->setFormatMinimum($minimum);

        /**
         * @var string
         */
        $returnedString = (new StringValidatorFiller())
            ->fill($validator);

        $this->assertGreaterThanOrEqual(
            (new \DateTimeImmutable($minimum))
                ->getTimestamp(),
            (new \DateTimeImmutable($returnedString))
                ->getTimestamp(),
            'Returned date should be greater or equal than minimum date'
        );

        $this->assertLessThanOrEqual(
            (new \DateTimeImmutable($maximum))
                ->getTimestamp(),
            (new \DateTimeImmutable($returnedString))
                ->getTimestamp(),
            'Returned date should be lower or equal than maximum date'
        );
    }
}
