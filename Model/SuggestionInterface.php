<?php
/**
 */

namespace Cotya\Debug\Model;

interface SuggestionInterface
{
    /**
     * Checks if this suggestion is a match for the exception.
     *
     * @param \Exception $exception
     * @return boolean Returns true if a suggestion can be offered for this exception
     */
    public function match(\Exception $exception);

    /**
     * Injects suggestion information into the Result.
     *
     * @param Result $result
     * @return void
     */
    public function process(Result $result);
}
