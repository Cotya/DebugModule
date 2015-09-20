<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Debug\Block;


use Cotya\Debug\Lib\AbstractTwigBlock;

class TwigTest extends AbstractTwigBlock
{

    public function getParams()
    {
        return [
            'greet' => 'Hello World',
        ];
    }
    
    public function getSourceName()
    {
        return "TwigTest";
    }
}
