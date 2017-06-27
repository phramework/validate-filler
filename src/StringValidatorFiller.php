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

use Phramework\Validate\BaseValidator;
use Phramework\Validate\StringValidator;
use Phramework\Models;


/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since  0.6.0
 * @author Vasilis Manolas <vasileiosmanolas@gmail.com>
 * @todo satisfy pattern attribute
 */
class StringValidatorFiller implements IValidatorFiller
{
    /**
     * @param StringValidator $validator
     * @return string
     */
    public function fill(BaseValidator $validator)
    {
        $minLength = $validator->minLength;
        $maxLength = $validator->maxLength ?? $validator->minLength + 1;

        $length = random_int($minLength, $maxLength);

        // instead of a string of 'a'
        // $randomString = str_repeat('a', $length);

        // we will use `\Phramework\Models\Util::readableRandomString` to generate a random string
        $randomString = readableRandomString($length);

        return $randomString;
    }
}
