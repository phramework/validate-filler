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
    public function testRequiredValueShouldAlwaysBeReturned()
    {
        global $container;

        $validator = new ObjectValidator(
            (object) [
                'a' => new EnumValidator(['aa']),
                'b' => new EnumValidator(['bb'])
            ],
            ['a'],
            false
        );

        $value = $container
            ->get(FillerRepository::class)
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

    /**
     * @todo can be improved, to reflect the requirement
     * @dataProvider provider
     */
    public function testNonRequiredValueSometimesIsReturned()
    {
        $validator = new ObjectValidator(
            (object) [
                'a' => new EnumValidator(['aa']),
                'b' => new EnumValidator(['bb'])
            ],
            ['a'],
            false
        );

        $value = (new FillerRepository(
            new ObjectValidatorFiller(),
            new ArrayValidatorFiller(),
            new EnumValidatorFiller()
        ))
            ->fill($validator);

        $this->assertInternalType('object', $value);

        $this->assertObjectHasAttribute('a', $value);

        $this->assertLessThanOrEqual(
            2,
            count(array_keys((array) $value)),
            'Since only "a" property is required it will always be there, and b might appear some times'
        );

        if (property_exists($value, 'b')) {
            $this->assertSame($value->b, 'bb');
        }
    }

    public function provider() : array
    {
        return array_fill(0, 6, [null]);
    }
}
