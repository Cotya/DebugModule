<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Debug\Model;

class Result
{

    protected $exception;
    protected $documentationReferences = [];
    protected $suggestedSolution = '';
    
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return \Exception|null
     */
    public function getException()
    {
        return $this->exception;
    }
    
    public function addDocumentationReference($reference)
    {
        $this->documentationReferences[] = $reference;
    }
    
    public function getDocumentationReferences()
    {
        return $this->documentationReferences;
    }
    
    public function setSuggestedSolution($solution)
    {
        $this->suggestedSolution = $solution;
    }
    
    public function getSuggestedSolution()
    {
        return $this->suggestedSolution;
    }
}
