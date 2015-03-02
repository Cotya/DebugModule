<?php
/**
 */

namespace Cotya\Debug\Model\Suggestion\BadMethodCall;

use Cotya\Debug\Model\Result;
use Cotya\Debug\Model\SuggestionInterface;

class MissingRequired implements SuggestionInterface
{

    public function match(\Exception $exception)
    {
        return ($exception instanceof \BadMethodCallException
            && preg_match('/Missing required argument (\$.*?) of (.*)\./', $exception->getMessage())
        );
    }

    public function process(Result $result)
    {
        $result->addDocumentationReference(
            '<a href="http://devdocs.magento.com/guides/v1.0/extension-dev-guide/depend-inj.html">Dependency Injection</a>'
        );

        $matches = [];
        preg_match('/Missing required argument (\$.*?) of (.*)\./', $result->getException()->getMessage(), $matches);
        $className = $matches[2];
        $argumentName = $matches[1];
        $result->addSuggestedSolution("You may need to inject a value for $argumentName into $className via di.xml configuration.");
    }
}
