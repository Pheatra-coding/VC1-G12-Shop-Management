<?php

require_once 'Models/CategoryModel.php';

class CategoryController extends BaseController
{
    private $categories;

    public function __construct()
    {
        $this->categories = new CategoryModel();
    }

    // List categories
    public function index()
    {
        $categories = $this->categories->getCategories();
        $this->view('categories/category_list', ['categories' => $categories]);
    }
}
