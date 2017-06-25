<?php

namespace Phramework\ValidateFiller;

use Phramework\Validate\BaseValidator;
use Phramework\Validate\IntegerValidator;

/**
 * @since  0.1.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
interface IValidatorFiller
{
    /**
     * @param BaseValidator $validator
     * @return mixed
     */
    public function fill(BaseValidator $validator);
}
