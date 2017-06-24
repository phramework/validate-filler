<?php

namespace Phramework\ValidateFiller;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since   1.0.0
 * @author  Xenofon Spafaridis <nohponex@gmail.com>
 */
abstract class AbstractEnumValidatorFiller implements IValidatorFiller
{
    /**
     * @param array $enum
     * @return mixed
     */
    public static function returnRandomItem(array $enum)
    {
        return $enum[array_rand($enum)];
    }
}