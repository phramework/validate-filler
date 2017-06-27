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

use Phramework\Validate\ArrayValidator;
use Phramework\Validate\BaseValidator;
use Phramework\Validate\BooleanValidator;
use Phramework\Validate\EnumValidator;
use Phramework\Validate\IntegerValidator;
use Phramework\Validate\NumberValidator;
use Phramework\Validate\ObjectValidator;
use Phramework\Validate\StringValidator;
use Phramework\Validate\UnsignedIntegerValidator;
use Phramework\ValidateFiller\Injection\ValueInjection;
use Phramework\ValidateFiller\Injection\ValueInjectionCollection;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @since 0.0.0
 * @version 0.4.0 Support ValueInjection
 * @version 0.4.0 Experimental class implementation mapping
 * @version 0.5.0 BooleanValidator
 * @api
 */
class Filler implements IFillerRepository
{
    /**
     * @var ValueInjectionCollection
     */
    protected $valueInjectionCollection;

    public function __construct()
    {
        $this->valueInjectionCollection = new ValueInjectionCollection();
    }

    /**
     * @param BaseValidator $validator
     * @return mixed
     */
    public function fill(BaseValidator $validator)
    {
        $type = get_class($validator);

        $enum = $validator->enum;

        /*
         * If any of the validators has enum attribute set
         */
        if (!empty($enum)) {
            return EnumValidatorFiller::returnRandomItem($validator->enum);
        }

        switch ($type) {
            //todo use DI
            case ArrayValidator::class:
                return (new ArrayValidatorFiller($this))->fill(
                    $validator
                );
            case ObjectValidator::class:
                return (new ObjectValidatorFiller($this))
                    ->setValueInjectionCollection($this->valueInjectionCollection)
                    ->fill(
                        $validator
                    );
            /*case EnumValidator::class:
                return (new EnumValidatorFiller())->fill(
                    $validator
                );*/
            case IntegerValidator::class:
            case UnsignedIntegerValidator::class:
                return (new IntegerValidatorFiller())->fill(
                    $validator
                );
            case NumberValidator::class:
                return (new NumberValidatorFiller())->fill(
                    $validator
                );
            case StringValidator::class:
                break;
            case BooleanValidator::class:
                return (new BooleanValidatorFiller())->fill(
                    $validator
                );
            default:
                //error
        }

        return null;
    }

    /**
     * @return $this
     */
    public function appendValueInjection(
        ValueInjection $valueInjection
    ) {
        $this->valueInjectionCollection->append($valueInjection);

        return $this;
    }
}
