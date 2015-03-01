<?php
/**
 * 
 * 
 * 
 * 
 */

namespace Cotya\Debug\Plugin;

use Cotya\Debug\Model\Result;
use Cotya\Debug\Model\Suggestions;
use Cotya\Debug\Traits\Handler;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\HTTP\PhpEnvironment\Response;

class Http
{
    private $suggestions;

    public function __construct(Suggestions $suggestions)
    {
        $this->suggestions = $suggestions;
    }
    
    public function aroundCatchException($subject, \Closure $proceed, Bootstrap $bootstrap, \Exception $exception)
    {
        $result = new Result($exception);
        $matchingSuggestions = $this->suggestions->findMatching($exception);

        if (!$matchingSuggestions) {
            return $proceed($bootstrap, $exception);
        }
        foreach ($matchingSuggestions as $suggestion) {
            $suggestion->process($result);
        }

        $optimizedResponse = $this->generateOptimizedExceptionResponse($result);
        /**
         * @see \Magento\Framework\App\Http::catchException
         * @see \Magento\Framework\App\Http::handleDeveloperMode
         */
        //$proceed($bootstrap, $exceptionOptimized);
        $optimizedResponse->sendResponse();
        return true;
    }
    
    protected function generateOptimizedExceptionResponse(Result $result)
    {
        $response = new Response();
        $response->setHttpResponseCode(500);
        $response->setHeader('Content-Type', 'text/html');
        
        
        $documentationReferenceHtml = '';
        foreach ($result->getDocumentationReferences() as $reference) {
            $documentationReferenceHtml .= "<li>$reference</li>";
        }
        if (!$documentationReferenceHtml) {
            $documentationReferenceHtml = 'There is no official documentation directly related to this,
         please help extending it by contributing to <a href="https://github.com/magento/devdocs">Magento DevDocs</a>';
        }
        $documentationReferenceHtml = "<ul>$documentationReferenceHtml</ul>";

        $suggestedSolutions = '';
        foreach ($result->getSuggestedSolutions() as $suggestedSolution) {
            $suggestedSolutions .= "<li><div>$suggestedSolution</div></li>\n";
        }
        
        $html = "<html>
        <head></head>
        <body>
        <h2>Optimized Exception Display</h2>
        <h3>{$result->getException()->getMessage()}</h3>
        $documentationReferenceHtml
        <h4>Suggested solutions:</h4>
        <div><ul>$suggestedSolutions</ul></div>
        <h4>Exception trace:</h4>
        <pre>{$result->getException()->getTraceAsString()}</pre>
        </body></html>";
        $response->setBody($html);
        //$response->setBody($exception->getMessage() . "\n" . $exception->getTraceAsString());
        //$exception = new \Exception($html);
        return $response;
    }
}
