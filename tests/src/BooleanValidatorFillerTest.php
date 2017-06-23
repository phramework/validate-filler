<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\ArrayValidator;
use Phramework\Validate\BooleanValidator;
use Phramework\Validate\EnumValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Vasileios Manolas <vasileiosmanolas@gmail.com>
 * @coversDefaultClass Phramework\ValidateFiller\BooleanValidatorFiller
 */
class BooleanValidatorFillerTest extends TestCase
{
    public function testFill()
    {
        $validator = new BooleanValidator();

        $value = DefaultFillerRepositoryFactory::create()
            ->fill($validator);

        $this->assertInternalType('boolean', $value);
    }
}
