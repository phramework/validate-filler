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
use Phramework\Validate\DatetimeValidator;
use Phramework\Validate\DateValidator;
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
 * @version 0.5.0 Support BooleanValidator
 * @version 0.6.0 Support StringValidator
 * @version 1.1.0 Support DateValidator and DatetimeValidator
 * @api
 */
class FillerRepository implements IFillerRepository
{
    /**
     * @var ValueInjectionCollection
     */
    protected $valueInjectionCollection;

    /**
     * @var IValidatorFillerObjectValidatorFiller
     */
    protected $objectValidatorFiller;
    /**
     * @var IValidatorFillerArrayValidatorFiller
     */
    protected $arrayValidatorFiller;

    /**
     * @var EnumValidatorFiller
     */
    protected $enumValidatorFiller;

    /**
     * @var IntegerValidatorFiller
     */
    protected $integerValidatorFiller;
    /**
     * @var NumberValidatorFiller
     */
    protected $numberValidatorFiller;

    /**
     * @var StringValidatorFiller
     */
    protected $stringValidatorFiller;

    /**
     * @var BooleanValidatorFiller
     */
    protected $booleanValidatorFiller;

    /**
     * @var DateValidatorFiller
     */
    protected $dateValidatorFiller;

    /**
     * @var DatetimeValidatorFiller
     */
    protected $datetimeValidatorFiller;


    public function __construct() {
        $this->objectValidatorFiller   = new ObjectValidatorFiller();
        $this->arrayValidatorFiller    = new ArrayValidatorFiller();
        $this->enumValidatorFiller     = new EnumValidatorFiller();
        $this->integerValidatorFiller  = new IntegerValidatorFiller();
        $this->numberValidatorFiller   = new NumberValidatorFiller();
        $this->stringValidatorFiller   = new StringValidatorFiller();
        $this->booleanValidatorFiller  = new BooleanValidatorFiller();
        $this->dateValidatorFiller     = new DateValidatorFiller();
        $this->datetimeValidatorFiller = new DatetimeValidatorFiller();

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
            return $this
                ->enumValidatorFiller::returnRandomItem($validator->enum);
        }

        switch ($type) {
            case ArrayValidator::class:
                return $this->arrayValidatorFiller
                    ->withIFillerRepository($this)
                    ->fill(
                        $validator
                    );
            case ObjectValidator::class:
                return $this->objectValidatorFiller
                    ->withValueInjectionCollection($this->valueInjectionCollection)
                    ->withIFillerRepository($this)
                    ->fill(
                        $validator
                    );
            case IntegerValidator::class:
            case UnsignedIntegerValidator::class:
                return $this->integerValidatorFiller
                    ->fill(
                        $validator
                    );
            case NumberValidator::class:
                return $this->numberValidatorFiller
                    ->fill(
                        $validator
                    );
            case StringValidator::class:
                return $this->stringValidatorFiller
                    ->fill(
                        $validator
                    );
            case BooleanValidator::class:
                return $this->booleanValidatorFiller
                    ->fill(
                        $validator
                    );
            case DateValidator::class:
                return $this->dateValidatorFiller
                    ->fill(
                        $validator
                    );
            case DatetimeValidator::class:
                return $this->datetimeValidatorFiller
                    ->fill(
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
    ) : IFillerRepository {
        $this->valueInjectionCollection->append($valueInjection);

        return $this;
    }

    /**
     * @since 1.0.0
     * @param ValueInjectionCollection $valueInjectionCollection
     * @return $this
     */
    public function setValueInjectionCollection(
        ValueInjectionCollection $valueInjectionCollection
    ): FillerRepository {
        $this->valueInjectionCollection = $valueInjectionCollection;

        return $this;
    }

    /**
     * @since 1.0.0
     * @param IValidatorFillerObjectValidatorFiller $objectValidatorFiller
     * @return $this
     */
    public function setObjectValidatorFiller(
        IValidatorFillerObjectValidatorFiller $objectValidatorFiller
    ): IFillerRepository {
        $this->objectValidatorFiller = $objectValidatorFiller;

        return $this;
    }

    /**
     * @since 1.0.0
     * @param IValidatorFillerArrayValidatorFiller $arrayValidatorFiller
     * @return $this
     */
    public function setArrayValidatorFiller(
        IValidatorFillerArrayValidatorFiller $arrayValidatorFiller
    ): IFillerRepository {
        $this->arrayValidatorFiller = $arrayValidatorFiller;

        return $this;
    }

    /**
     * @since 1.0.0
     * @param EnumValidatorFiller $enumValidatorFiller
     * @return $this
     */
    public function setEnumValidatorFiller(
        EnumValidatorFiller $enumValidatorFiller
    ): IFillerRepository {
        $this->enumValidatorFiller = $enumValidatorFiller;

        return $this;
    }

    /**
     * @since 1.0.0
     * @param IntegerValidatorFiller $integerValidatorFiller
     * @return $this
     */
    public function setIntegerValidatorFiller(
        IntegerValidatorFiller $integerValidatorFiller
    ): IFillerRepository {
        $this->integerValidatorFiller = $integerValidatorFiller;

        return $this;
    }

    /**
     * @since 1.0.0
     * @param NumberValidatorFiller $numberValidatorFiller
     * @return $this
     */
    public function setNumberValidatorFiller(
        NumberValidatorFiller $numberValidatorFiller
    ): IFillerRepository {
        $this->numberValidatorFiller = $numberValidatorFiller;

        return $this;
    }

    /**
     * @since 1.0.0
     * @param StringValidatorFiller $stringValidatorFiller
     * @return $this
     */
    public function setStringValidatorFiller(
        StringValidatorFiller $stringValidatorFiller
    ): IFillerRepository {
        $this->stringValidatorFiller = $stringValidatorFiller;

        return $this;
    }

    /**
     * @since 1.0.0
     * @param BooleanValidatorFiller $booleanValidatorFiller
     * @return $this
     */
    public function setBooleanValidatorFiller(
        BooleanValidatorFiller $booleanValidatorFiller
    ): IFillerRepository {
        $this->booleanValidatorFiller = $booleanValidatorFiller;

        return $this;
    }

    /**
     * @since 1.1.0
     * @param DateValidatorFiller $dateValidatorFiller
     * @return $this
     */
    public function setDateValidatorFiller(
        DateValidatorFiller $dateValidatorFiller
    ): IFillerRepository {
        $this->dateValidatorFiller = $dateValidatorFiller;

        return $this;
    }

    /**
     * @since 1.1.0
     * @param DatetimeValidatorFiller $datetimeValidatorFiller
     * @return $this
     */
    public function setDatetimeValidatorFiller(
        DatetimeValidatorFiller $datetimeValidatorFiller
    ): IFillerRepository {
        $this->datetimeValidatorFiller = $datetimeValidatorFiller;

        return $this;
    }
}
