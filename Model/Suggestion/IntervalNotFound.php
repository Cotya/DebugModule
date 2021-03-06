<?php
/**
 */

namespace Cotya\Debug\Model\Suggestion;

use Cotya\Debug\Model\Result;
use Cotya\Debug\Model\SuggestionInterface;

class IntervalNotFound implements SuggestionInterface
{

    public function match(\Exception $exception)
    {
        return (strpos($exception->getMessage(), 'Interval not found by config') === 0);
    }

    public function process(Result $result)
    {
        $trace = $result->getException()->getTrace();
        if ($trace[0]['class'] == 'Magento\Framework\Search\Dynamic\IntervalFactory') {
            $missedIntervalName = str_replace(
                'Interval not found by config ',
                '',
                $result->getException()->getMessage()
            );
            if ($trace[0]['args'][2] == 'catalog/search/engine') {
                $missedIntervalModel = 'Magento\CatalogSearch\Model\Price\Interval';
            } else {
                $missedIntervalModel = 'Unknown';
            }

            $codeExample = <<<XML
<type name="Magento\Framework\Search\Dynamic\IntervalFactory">
    <arguments>
        <!--
        this usually is of type "const" with a reference to a php constant,
        but we cant resolve this automagically yet
        -->
        <argument name="configPath" xsi:type="string">{$trace[0]['args'][2]}</argument>
        <argument name="intervals" xsi:type="array">
            <item name="$missedIntervalName" xsi:type="string">$missedIntervalModel</item>
        </argument>
        <argument name="scope" xsi:type="const">\Magento\Store\Model\ScopeInterface::SCOPE_STORE</argument>
    </arguments>
</type>
XML;
            $codeExample = htmlspecialchars($codeExample);
            $result->addSuggestedSolution("you are missing an Interval definition for one of your classes.
You need to extend your module di.xml to solve this. The needed code should look similar to this:
<pre style='border: 1px dotted;padding:5px;'>
$codeExample
</pre>
            ");
        }
    }
}
