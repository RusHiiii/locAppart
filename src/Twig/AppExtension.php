<?php
namespace App\Twig;

use App\Entity\Price;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('price', array($this, 'formatPrice')),
        );
    }

    /**
     * RECUPERATION DU PRIX MIN
     * @param $prices
     * @return int|string
     */
    public function formatPrice($prices)
    {
        $minPrice = 9999;
        foreach ($prices as $key => $price){
            if($price->getPrice() < $minPrice){
                $minPrice = $price->getPrice();
            }
        }

        return ($minPrice == 9999) ? 'XX' : $minPrice;
    }
}