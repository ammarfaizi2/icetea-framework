<?php

namespace System\Crayner\Contracts\Input;

/**
 * @author Ammar Faizi    <ammarfaizi2@gmail.com>
 */

interface InputBinding
{
    /**
     * @param int $cat
     */
    public function escape($cat);

    /**
     * @param string $key
     */
    public function encrypt($key);

    /**
     * @param string $ley
     */
    public function decrypt($key);
}
