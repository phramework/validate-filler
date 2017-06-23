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

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since  0.2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class ArrayValidatorFiller implements IArrayValidatorFiller
{
    /**
     * @var IFillerRepository
     */
    protected $fillerRepository;

    /**
     * @param IFillerRepository $repository
     * @return IWithFillerRepository
     * @return $this
     */
    public function withIFillerRepository(
        IFillerRepository $repository
    ) : IWithFillerRepository {
        $copy = clone $this;

        $copy->fillerRepository = $repository;

        return $copy;
    }

    /**
     * @param ArrayValidator $validator
     * @throws \DomainException
     * @return array
     */
    public function fill(BaseValidator $validator)
    {
        $minItems = $validator->minItems;
        $maxItems = $validator->maxItems ?? PHP_INT_MAX;

        $numberOfItems = random_int($minItems, $maxItems);

        $items = [];

        $validatorAllowedItems = $validator->items;

        if ($validatorAllowedItems === null) {
            throw new \DomainException(
                'Not implemented to work without specific items'
            );
        }

        for ($i = 0; $i<$numberOfItems; ++$i) {
            //todo deal with infinite loop
            $item = $this
                ->fillerRepository
                ->fill(
                    $validator->items
                );

            //todo refactor
            while ($validator->uniqueItems && in_array($item, $items, true)) {
                $item = $this
                    ->fillerRepository
                    ->fill(
                        $validator->items
                    );
            }

            $items[] = $item;
        }

        return $items;
    }
}
