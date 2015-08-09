<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StoreController extends Controller
{

    public function indexAction(Request $request) {
        $categories = $this->getCategories();
        $products = $this->getProducts();
        return $this->render(
            'AppBundle:Store:index.html.twig',
            array('products' => $products, 'categories' => $categories)
        );
    }

    /**
     * 
     * @todo real implementation
     */
    private function getCategories() {
        return array(
            array('label' => 'computers', 'children' => array(
                    array('label' => 'laptops'),
                    array('label' => 'desktop'),
                    array('label' => 'servers')
                )),
            array('label' => 'phones & tablets', 'children' => array(
                    array('label' => 'phones'),
                    array('label' => 'tablets'),
                    array('label' => 'accessories')
                ))
        );
    }

    /**
     * 
     * @todo real implementation
     */
    private function getProducts() {
        return array(
            array('id' => 1, 'title' => 'title1', 'description' => 'description1', 'price' => 1522),
            array('id' => 2, 'title' => 'title2', 'description' => 'description2', 'price' => 4452),
            array('id' => 3, 'title' => 'title3', 'description' => 'description3', 'price' => 7755),
            array('id' => 4, 'title' => 'title4', 'description' => 'description4', 'price' => 4522),
            array('id' => 5, 'title' => 'title5', 'description' => 'description5', 'price' => 4545),
        );
    }

}
