<?php
/**
 *
 */

namespace Cotya\Debug\Model;

class Suggestions
{
    /**
     * @var string[] List of class names that implement SuggestionInterface
     */
    private $classes;

    private $suggestions = null;

    /**
     * @param string[] $classes
     */
    public function __construct($classes)
    {
        $this->classes = $classes;
    }

    /**
     * @return SuggestionInterface[]
     */
    public function getSuggestions()
    {
        if (null === $this->suggestions) {
            $this->suggestions = [];
            foreach($this->classes as $className) {
                // trim is needed to allow for newlines in the di.xml that provides the class names
                $className = trim($className);
                /** @var SuggestionInterface $class */
                $class = new $className();
                $this->suggestions[] = $class;
            }
        }
        return $this->suggestions;
    }

    /**
     * @param \Exception $exception
     * @return SuggestionInterface[]
     */
    public function findMatching(\Exception $exception) {
        return array_filter($this->getSuggestions(), function(SuggestionInterface $suggestion) use ($exception) {
                return $suggestion->match($exception);
        });
    }
}
