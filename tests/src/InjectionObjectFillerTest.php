<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\BaseValidator;
use Phramework\Validate\EnumValidator;
use Phramework\Validate\ObjectValidator;
use Phramework\ValidateFiller\Injection\ValueInjection;
use Phramework\ValidateFiller\Injection\ValueInjectionCollection;
use Phramework\ValidateFiller\Injection\ObjectPropertyValueInjection;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class InjectionObjectFillerTest extends TestCase
{
    public function testInjectionToOverrideAnExistingPropertyValue()
    {
        $expected = (object) [
            'a' => 'aaa',
            'b' => 'b'
        ];

        $filler = DefaultFillerRepositoryFactory::create();

        $validator = new ObjectValidator(
            (object) [
                'a' => new EnumValidator(['a']),
                'b' => new EnumValidator(['b']),
            ],
            ['a', 'b'],
            false
        );

        $filler = $filler
            ->appendValueInjection(
                new ObjectPropertyValueInjection('a', $expected->a)
            );

        $value = $filler
            ->fill($validator);

        $this->assertEquals(
            $expected,
            $value
        );
    }

    public function testIgnoreInjectionOfNonExistingProperty()
    {
        $expected = (object) [
            'a' => 'a',
            'b' => 'b'
        ];

        $validator = new ObjectValidator(
            (object) [
                'a' => new EnumValidator(['a']),
                'b' => new EnumValidator(['b']),
            ],
            ['a', 'b'],
            false
        );

        $filler = DefaultFillerRepositoryFactory::create()
            ->appendValueInjection(
                new ObjectPropertyValueInjection('not-exists', 'some value')
            );

        $value = $filler
            ->fill($validator);

        $this->assertEquals(
            $expected,
            $value
        );
    }
}
