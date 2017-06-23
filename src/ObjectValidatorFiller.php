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

use Phramework\Validate\BaseValidator;
use Phramework\Validate\ObjectValidator;
use Phramework\ValidateFiller\Injection\ValueInjection;
use Phramework\ValidateFiller\Injection\ValueInjectionCollection;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since 0.3.0
 * @version 0.4.0 Implement IObjectValidatorFiller
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class ObjectValidatorFiller implements IObjectValidatorFiller
{
    /**
     * @var IFillerRepository
     */
    protected $fillerRepository;

    /**
     * @var ValueInjectionCollection
     */
    protected $valueInjectionCollection;

    /**
     * @inheritdoc
     */
    public function withValueInjectionCollection(
        ValueInjectionCollection $collection = null
    ) : IObjectValidatorFiller {
        $copy = clone $this;

        $copy->valueInjectionCollection = $collection;

        return $copy;
    }

    /**
     * @inheritdoc
     */
    public function withIFillerRepository(
        IFillerRepository $repository
    ) : IWithFillerRepository {
        $copy = clone $this;

        $copy->fillerRepository = $repository;

        return $copy;
    }

    /**
     * @return ValueInjectionCollection
     */
    public function getValueInjectionCollection()
    {
        return $this->valueInjectionCollection;
    }

    /**
     * @param ObjectValidator $validator
     * @throws \DomainException
     * @return \stdClass
     */
    public function fill(BaseValidator $validator)
    {
        $value = $this->fillRegular($validator);

        if ($this->getValueInjectionCollection() !== null) {
            $properties = $validator->properties;

            foreach ($this->valueInjectionCollection as $i) {
                /* @var ValueInjection $i */

                if (property_exists($properties, $i->getProperty())) {
                    $value->{$i->getProperty()} = $i->getValue();
                }
            }
        }

        return $value;
    }

    /**
     * @param ObjectValidator $validator
     * @throws \DomainException
     * @return \stdClass
     */
    protected function fillRegular(ObjectValidator $validator)
    {
        $required = $validator->required;

        $object = new \stdClass();

        /*
         * Fill all required properties
         */
        foreach ($required as $r) {
            $object->{$r} = $this
                ->fillerRepository
                ->fill(
                    $validator->properties->{$r}
                );
        }

        $notRequired = array_diff(
            array_keys((array) $validator->properties),
            $required
        );

        /*
         * 50% possibility to fill not required properties
         */
        foreach ($notRequired as $r) {
            if (random_int(0, 1) === 1) {
                $object->{$r} = $this
                    ->fillerRepository
                    ->fill(
                        $validator->properties->{$r}
                    );
            }
        }

        return $object;
    }
}
