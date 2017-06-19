<?php

namespace Phramework\ValidateFiller;

use Phramework\Validate\ArrayValidator;
use Phramework\Validate\BaseValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since  {VERSION}
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class ArrayValidatorFiller implements IValidatorFiller
{
    /**
     * @var IFillerRepository
     */
    protected $fillerRepository;

    public function __construct(IFillerRepository $fillerRepository)
    {
        $this->fillerRepository = $fillerRepository;
    }

    /**
     * @param ArrayValidator $validator
     * @throws \DomainException
     * @return array
     * @todo $uniqueItems
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
            $item = $this->fillerRepository->fill(
                $validator->items
            );

            //todo refactor
            while ($validator->uniqueItems && in_array($item, $items, true)) {
                $item = $this->fillerRepository->fill(
                    $validator->items
                );
            }

            $items[] = $item;
        }

        return $items;
    }
}
