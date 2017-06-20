<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\ArrayValidator;
use Phramework\Validate\EnumValidator;
use Phramework\Validate\ObjectValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @coversDefaultClass Phramework\ValidateFiller\ObjectValidatorFiller
 */
class ObjectValidatorFillerTest extends TestCase
{
    public function testFill()
    {
        $validator = new ObjectValidator(
            (object) [
                'a' => new EnumValidator(['aa']),
                'b' => new EnumValidator(['bb'])
            ],
            ['a'],
            false
        );

        $value = (new Filler())
            ->fill($validator);

        $this->assertInternalType('object', $value);

        $this->assertObjectHasAttribute('a', $value);
        $this->assertSame($value->a, 'aa');

        $this->assertLessThanOrEqual(
            2,
            count(array_keys((array) $value)),
            'Since only "a" property is required it will always be there, and b might appear some times'
        );

        if (property_exists($value, 'b')) {
            $this->assertSame($value->b, 'bb');
        }
    }
}
