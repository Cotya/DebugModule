<?php
/**
 */

namespace Cotya\Debug\Model\Suggestion;

use Cotya\Debug\Model\Result;
use Cotya\Debug\Model\SuggestionInterface;

class ClassDoesNotExist implements SuggestionInterface
{

    public function match(\Exception $exception)
    {
        return preg_match('/Class .* does not exist/', $exception->getMessage());
    }

    public function process(Result $result)
    {
        $result->addSuggestedSolution("The class could have been moved and there is an outdated reference.  Try
            clearing the 'var/generation' and 'var/cache' directories.
");

    }
}
