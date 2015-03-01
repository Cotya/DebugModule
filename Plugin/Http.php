<?php
/**
 * 
 * 
 * 
 * 
 */

namespace Cotya\Debug\Plugin;

use Cotya\Debug\Model\Result;
use Cotya\Debug\Traits\Handler;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\HTTP\PhpEnvironment\Response;

class Http
{
    use Handler;
    
    
    public function aroundCatchException($subject, \Closure $proceed, Bootstrap $bootstrap, \Exception $exception)
    {
        $optimizedResponse = $this->generateOptimizedExceptionResponse($this->processException($exception));
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
        $html = "<html>
        <head></head>
        <body>
        <h2>optimized Exception Display</h2>
        <span>{$result->getException()->getMessage()}</span>
        <pre>{$result->getException()->getTraceAsString()}</pre>
        </body></html>";
        $response->setBody($html);
        //$response->setBody($exception->getMessage() . "\n" . $exception->getTraceAsString());
        //$exception = new \Exception($html);
        return $response;
    }
}
