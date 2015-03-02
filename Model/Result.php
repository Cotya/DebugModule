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
    protected $suggestedSolutions = [];
    
    public function __construct(\Exception $exception)
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
    
    public function addSuggestedSolution($solution)
    {
        $this->suggestedSolutions[] = $solution;
    }
    
    public function getSuggestedSolutions()
    {
        return $this->suggestedSolutions;
    }
}
