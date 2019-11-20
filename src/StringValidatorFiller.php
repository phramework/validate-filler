<?php
/**
 * Copyright 2015-2017 Xenofon Spafaridis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Phramework\ValidateFiller;

use DateTimeZone;
use Phramework\Util\Util;
use Phramework\Validate\BaseValidator;
use Phramework\Validate\StringValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since  0.6.0
 * @author Vasilis Manolas <vasileiosmanolas@gmail.com>
 * @author Alex Kalliontzis <alkallio@gmail.com>
 * @todo satisfy pattern attribute
 *
 * @version 1.2.0 Support for 'date-time' format in type 'string'
 */
class StringValidatorFiller implements IValidatorFiller
{
    /**
     * @param StringValidator $validator
     * @return string
     */
    public function fill(BaseValidator $validator)
    {
        if ($validator->format !== null && $validator->format === 'date-time') {
            $dateMin = (new \DateTimeImmutable())
                ->modify('-1 months')
                ->getTimestamp();

            if ($validator->formatMinimum !== null) {
                $dateMin = (new \DateTimeImmutable(
                    $validator->formatMinimum
                ))->getTimestamp();
            }

            $dateMax = (new \DateTimeImmutable())
                ->modify('+1 months')
                ->getTimestamp();
            if ($validator->formatMaximum !== null) {
                $dateMax = (new \DateTimeImmutable(
                    $validator->formatMaximum
                ))->getTimestamp();
            }

            $randomEpoch = mt_rand($dateMin, $dateMax);

            return (new \DateTimeImmutable(
                'now',
                (new DateTimeZone($this->pickRandomTimezone()))
            ))
                ->setTimestamp($randomEpoch)
                ->format(DATE_RFC3339);
        }

        $minLength = $validator->minLength;
        $maxLength = $validator->maxLength ?? $validator->minLength + 1;

        $length = random_int($minLength, $maxLength);

        return Util::readableRandomString($length);
    }

    private function pickRandomTimezone(): string
    {
        $timezones = [
            'America/Chicago',
            'America/New_York',
            'America/Los_Angeles',
            'America/Phoenix',
            'America/Anchorage',
            'Pacific/Honolulu',
            'Europe/Athens',
            'Europe/Amsterdam',
            'Europe/Vienna',
            'Europe/London',
            'Europe/Saratov',
            'Atlantic/Madeira',
            'US/Mountain',
            'Australia/Canberra',
            'Indian/Mauritius',
            'Asia/Kathmandu',
            'Asia/Kolkata',
            'Asia/Ulaanbaatar',
            'Arctic/Longyearbyen',
            'Antarctica/McMurdo',
            'Antarctica/Troll',
            'Antarctica/Macquarie',
            'Australia/Eucla',
        ];

        return $timezones[
            array_rand($timezones, 1)
        ];
    }
}
