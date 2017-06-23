<?php

namespace Phramework\ValidateFiller;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @since   0.4.0
 * @author  Xenofon Spafaridis <nohponex@gmail.com>
 */
interface IWithFillerRepository
{
    /**
     * @param IFillerRepository $repository
     * @return $this
     */
    public function withIFillerRepository(
        IFillerRepository $repository
    ): IWithFillerRepository;
}