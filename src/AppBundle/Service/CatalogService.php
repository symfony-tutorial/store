<?php

namespace AppBundle\Service;

class CatalogService
{

    const ID = 'app.catalog';

    /**
     *
     * @var JsonRpcClient
     */
    private $jsonRpcClient;

    function __construct(JsonRpcClient $jsonRpcClient) {
        $this->jsonRpcClient = $jsonRpcClient;
    }

    public function getCategories() {
        $categories = $this->jsonRpcClient->call('getCategories');
        $parentCategories = array_filter($categories, function ($category) {
            return empty($category->parent_id);
        });

        foreach ($parentCategories as $category) {
            $category->children = array_filter($categories, function($child) use($category) {
                return ($child->parent_id === $category->id);
            });
        }

        return $parentCategories;
    }

}
