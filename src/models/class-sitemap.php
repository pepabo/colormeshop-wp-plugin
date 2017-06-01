<?php
namespace ColorMeShop\Models;

use Tackk\Cartographer\Sitemap as S;
use Tackk\Cartographer\ChangeFrequency;

class Sitemap {
    /**
     * @var stringg
     */
    private $product_page_url;

    /**
     * @var \ColorMeShop\Models\Product_Api
     */
    private $product_api;

    /**
     * @var \Tackk\Cartographer\Sitemap
     */
    private $sitemap;

    /**
     * @param string
     * @param \ColorMeShop\Models\Product_Api $product_api
     */
    public function __construct($product_page_url, $product_api)
    {
        $this->product_page_url = $product_page_url;
        $this->product_api = $product_api;
        $this->sitemap = new S();
    }

    /**
     * サイトマップを返す
     *
     * @return string
     */
    public function output()
    {
        foreach ($this->product_api->fetchAll()['products'] as $p) {
            $this->sitemap->add($this->make_feed_url($p), $p['update_date'], ChangeFrequency::WEEKLY, 1.0);
        }

        return $this->sitemap->toString();
    }

    /**
     * 商品ページ URL
     *
     * @param array $product
     * @return string
     */
    private function make_feed_url($product)
    {
        if (strpos($this->product_page_url, '?') === false) {
            return trim($this->product_page_url, '/') . '/?colorme_item=' . $product['id'];
        }

        return $this->product_page_url . '&colorme_item=' . $product['id'];

    }
}
