<?php

namespace Phramework\ValidateFiller;

use Phramework\Validate\BaseValidator;

/**
 * @since  {VERSION}
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class EnumValidatorFiller implements IValidatorFiller
{
    public function fill(BaseValidator $validator)
    {
        return static::returnRandomItem($validator->enum);
    }

    /**
     * @param array $enum
     * @return mixed
     */
    public static function returnRandomItem(array $enum) {
        return $enum[array_rand($enum)];
    }
}
