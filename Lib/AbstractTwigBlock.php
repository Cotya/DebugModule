<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Debug\Lib;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\BlockInterface;

abstract class AbstractTwigBlock extends AbstractBlock implements BlockInterface
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;
    
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    
    abstract public function getSourceName();
    
    abstract public function getParams();

    public function toHtml()
    {
        return $this->twig->render(
            $this->getSourceName(),
            $this->getParams()
        );
    }
}
