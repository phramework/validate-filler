<?php

namespace Phramework\ValidateFiller\Injection;

use PHPUnit\Framework\TestCase;
use Phramework\Validate\BaseValidator;
use Phramework\Validate\EnumValidator;
use Phramework\Validate\ObjectValidator;
use Phramework\ValidateFiller\Injection\ValueInjection;
use Phramework\ValidateFiller\Injection\ObjectPropertyValueInjection;

class InjectionCollectionTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testExpectTypeError()
    {
        (new ValueInjectionCollection())
            ->append(new \stdClass());
    }

    /**
     *
     */
    public function testSuccess()
    {
        $c = new ValueInjectionCollection();

        $c->append(new ObjectPropertyValueInjection('a', null));

        $this->assertCount(1, $c);
    }
}
