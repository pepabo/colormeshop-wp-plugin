<?php
namespace ColormeShop\Shortcode\Cart;

class Button
{
    /**
     * @return string
     */
    public static function name()
    {
        return 'cart_button';
    }

    /**
     * @param \Pimple\Container $container
     * @param array $atts
     * @param string $content
     * @param string $tag
     * @return string
     */
    public static function show($container, $atts, $content, $tag)
    {
        $filteredAtts = shortcode_atts(
            array( 'product_id' => $container['target_id'] ),
            $atts
        );

        return "<script type='text/javascript' src='" . $container['model.shop']->fetch()->url . "/?mode=cartjs&pid=" . $filteredAtts['product_id'] . "&style=washi&name=n&img=n&expl=n&stock=n&price=n&inq=n&sk=n' charset='euc-jp'></script>";
    }
}
