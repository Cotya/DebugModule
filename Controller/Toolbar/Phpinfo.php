<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Debug\Controller\Toolbar;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Phpinfo extends \Magento\Framework\App\Action\Action
{
    
    /** @var ScopeConfigInterface  */
    protected $scopeConfig;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }
    
    public function execute()
    {
        phpinfo();
        exit();
    }
}
