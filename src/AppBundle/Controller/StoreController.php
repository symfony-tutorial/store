<?php

namespace AppBundle\Controller;

use AppBundle\Service\CatalogService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StoreController extends Controller
{

    public function indexAction(Request $request) {
        $term = $request->get('term', '');
        $page = $request->get('page', 1);
        $categories = $this->get(CatalogService::ID)->getCategories();
        $products = $this->getProducts($term, $page);
        return $this->render(
            'AppBundle:Store:index.html.twig',
            array('products' => $products, 'categories' => $categories)
        );
    }

    private function getProducts($term, $page) {
        $from = ($page - 1) * 10;
        $finder = $this->container->get('fos_elastica.client');

        $query = "products/_search?q=*$term*&from=$from&size=10";
        $result = $finder->request($query)->getData()['hits'];

        $products = array_map(function($product) {
            $product['_source']['id'] = $product['_id'];
            return $product['_source'];
        }, $result['hits']);

        return $products;
    }

}
