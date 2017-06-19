<?php

namespace Phramework\ValidateFiller;

use Phramework\Validate\BaseValidator;

/**
 * @since  {VERSION}
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
interface IFillerRepository
{
    /**
     * @param BaseValidator $validator
     * @return mixed
     */
    public function fill(BaseValidator $validator);
}
