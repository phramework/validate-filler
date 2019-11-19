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

    public function testReturnedStringSatisfiesFormatMinimumAndMaximum()
    {
        $validator = new StringValidator(
            0,
            null,
            null,
            false,
            'date-time'
        );

        $formatMaximum = '2020-01-01T23:59:59+02:00';
        $validator->setFormatMaximum($formatMaximum);

        $formatMinimum = '2019-12-19T23:59:59+02:00';
        $validator->setFormatMinimum($formatMinimum);

        /**
         * @var string
         */
        $returnedString = (new StringValidatorFiller())
            ->fill($validator);

        $this->assertGreaterThanOrEqual(
            (new \DateTime($formatMinimum))->getTimestamp(),
            (new \DateTime($returnedString))->getTimestamp(),
            'Returned date should be greater or equal than minimum date'
        );

        $this->assertLessThanOrEqual(
            (new \DateTime($formatMaximum))->getTimestamp(),
            (new \DateTime($returnedString))->getTimestamp(),
            'Returned date should be greater or equal than minimum date'
        );
    }
}
