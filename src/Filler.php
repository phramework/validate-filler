<?php
/**
 * Copyright 2015 - 2016 Xenofon Spafaridis
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

use Phramework\Validate\BaseValidator;
use Phramework\Validate\IntegerValidator;
use Phramework\Validate\NumberValidator;
use Phramework\Validate\StringValidator;
use Phramework\Validate\UnsignedIntegerValidator;


/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @since 0.0.0
 */
class Filler
{
    public function __construct()
    {
    }

    /**
     * @param BaseValidator $validator
     * @return mixed
     */
    public function fill(BaseValidator $validator)
    {
        $type = get_class($validator);

        switch ($type) {
            case IntegerValidator::class:
            case UnsignedIntegerValidator::class:

                $faker = \Faker\Factory::create();

                $minimum = (
                    $validator->minimum !== null
                    ? $validator->minimum
                    : PHP_INT_MIN
                );

                $maximum = (
                    $validator->maximum !== null
                    ? $validator->maximum
                    : PHP_INT_MAX
                );

                if ($validator->exclusiveMinimum) {
                    $minimum +=1;
                }

                if ($validator->exclusiveMaximum) {
                    $maximum -=1;
                }

                //todo multiple of
                
                return $faker->numberBetween( //not exclusive
                    $minimum,
                    $maximum
                );

                break;
            case NumberValidator::class:
                break;
            case StringValidator::class:
                break;
            default:
                //error
        }

        return null;
    }
}
