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

use PHPUnit\Framework\TestCase;
use Phramework\Validate\ObjectValidator;
use Phramework\Validate\StringValidator;
use Phramework\Validate\UUIDv4Validator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @coversDefaultClass Phramework\ValidateFiller\Filler
 */
class FillerRepositoryTest extends TestCase
{
    public function testFillUnknownValidator()
    {
        $value = DefaultFillerRepositoryFactory::create()
            ->fill(
                new UUIDv4Validator()
            );

        $this->assertNull($value);
    }

    public function testAnyValidatorWithEnumDefined()
    {
        $enum = [
            (object) [
                'a' => 'aabaa'
            ],
            (object) [
                'a' => 'ababa'
            ]
        ];

        $value = DefaultFillerRepositoryFactory::create()
            ->fill(
                (new ObjectValidator(
                    (object) [
                        'a' => new StringValidator(1, 5),
                    ],
                    ['a'],
                    false
                ))
                    ->setEnum($enum)
            );

        $this->assertContains(
            $value,
            $enum
        );
    }
}
