<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\ArrayValidator;
use Phramework\Validate\EnumValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @coversDefaultClass Phramework\ValidateFiller\EnumValidatorFiller
 */
class EnumValidatorFillerTest extends TestCase
{
    public function testFill()
    {
        $enum = ['a', 'b', 'c'];

        $validator = new EnumValidator($enum);

        $value = (new EnumValidatorFiller())
            ->fill($validator);

        $this->assertContains(
            $value,
            $enum
        );
    }
}
