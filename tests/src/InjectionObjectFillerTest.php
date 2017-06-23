<?php

namespace Phramework\ValidateFiller;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\BaseValidator;
use Phramework\Validate\EnumValidator;
use Phramework\Validate\ObjectValidator;
use Phramework\ValidateFiller\Injection\ValueInjection;
use Phramework\ValidateFiller\Injection\ValueInjectionCollection;
use Phramework\ValidateFiller\Injection\ObjectPropertyValueInjection;

class InjectionObjectFillerTest extends TestCase
{
    public function testInjectionToOverrideAnExistingPropertyValue()
    {
        $expected = (object) [
            'a' => 'aaa',
            'b' => 'b'
        ];

        $filler = (new FillerRepository());

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

        $filler = (new FillerRepository())
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
