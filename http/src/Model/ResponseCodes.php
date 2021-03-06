<?php

namespace Zrcms\Http\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ResponseCodes
{
    const FAILED = 'failed';
    const NOT_FOUND = 'not-found';
    const ID_NOT_RECEIVED = 'id-not-received';
    const PROPERTIES_NOT_RECEIVED = 'properties-not-received';
    const NOT_ALLOWED = 'not-allowed';
    const NOT_IMPLEMENTED = 'not-implemented';
    const VALID_USER_REQUIRED = 'valid-user-required';
}
