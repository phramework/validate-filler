<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\EnumValidator;
use Phramework\Validate\ObjectValidator;
use Phramework\ValidateFiller\Injection\ObjectPropertyValueInjection;

/**
 * Object validator tests specific to x-visibility property
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @coversDefaultClass Phramework\ValidateFiller\ObjectValidatorFiller
 */
class ObjectValidatorFillerXVisibilityTest extends TestCase
{
    /*
     * Todo problematic test, because appearance of b is probabilistic
     */
    public function testEnsureNotRequiredDependedWillNotBeReturned()
    {
        $validator = new ObjectValidator(
            (object) [
                'a' => new EnumValidator([
                    'i',
                    //'ii' impossible to produced regularly
                ]),
                'b' => new EnumValidator(['b'])
            ],
            [
                'a'
            ],
            false,
            0,
            null,
            null,
            (object) [
                'b' => [
                    'member',
                    'a',
                    ['ii']
                ]
            ]
        );

        $filler = DefaultFillerRepositoryFactory::create();

        $value = $filler
            ->fill($validator);

        $this->assertObjectNotHasAttribute('b', $value);
    }

    public function testEnsureRequireDependedXVisibilityWillBeReturned()
    {
        $validator = new ObjectValidator(
            (object) [
                'a' => new EnumValidator([
                    'i',
                    //'ii' impossible to produced regularly
                ]),
                'b' => new EnumValidator(['b'])
            ],
            [
                'b'
            ],
            false,
            0,
            null,
            null,
            (object) [
                'b' => [
                    'member',
                    'a',
                    ['ii']
                ]
            ]
        );

        $filler = DefaultFillerRepositoryFactory::create()
            /*
             * By forcing value to "a" will "trigger" "b" properties x-visibility evaluation to true
             */
            ->appendValueInjection(
                new ObjectPropertyValueInjection('a', 'ii')
            );

        $value = $filler
            ->fill($validator);

        $this->assertObjectHasAttribute('b', $value);

        $this->assertEquals('b', $value->b);
    }

    public function testCascadeDependedXVisibility()
    {

    }
}
