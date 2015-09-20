<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Debug\Lib;

use Twig_Error_Loader;

class TwigLoader implements \Twig_LoaderInterface
{
    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getSource($name)
    {
        $source = null;
        if ($name === 'TwigTest')
        {
            $source = <<<TWIG
<strong>Twig works</strong>
<span>{{ greet }}</span>
TWIG;
        }
        
        if ($source === null) {
            throw new Twig_Error_Loader('No Template found');
        }
        return $source;
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getCacheKey($name)
    {
        // TODO: Implement getCacheKey() method.
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int    $time Timestamp of the last modification time of the
     *                     cached template
     *
     * @return bool true if the template is fresh, false otherwise
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function isFresh($name, $time)
    {
        // TODO: Implement isFresh() method.
    }


}
