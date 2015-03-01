<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Debug\Traits;

use Cotya\Debug\Model\Result;

trait Handler
{


    /**
     * @param \Exception $exception
     *
     * @return Result
     */
    protected function processException(\Exception $exception)
    {
        $result = new Result();
        $result->exception = $exception;
        
        return $result;
    }

}
