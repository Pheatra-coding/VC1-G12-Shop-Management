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
    // create categoris
    public function create()
    {
        $categories = $this->categories->getCategories();
        $this->view("categories/create", ['categories' => $categories]);
    }
    // store category
    public function store()
    {
        $name = htmlspecialchars($_POST['category_name']);  // Adjusted to match form field name

        if (empty($name)) {
            $errors['general'] = "Category name is required.";
            $categories = $this->categories->getCategories(); // Fetch categories for the view
            $this->view("categories/create", ['categories' => $categories, 'errors' => $errors]);
            return;
        }

        $this->categories->addCategory($name);
        header("Location: /categories");  // Redirect to list page to show new category
        exit();
    }

    
    // Show edit category form
    public function edit($id)
    {
        $category = $this->categories->getCategoryById($id);
        $this->view("categories/edit", ['category' => $category]);
    }

    // Update category
    public function update($id)
    {
        $name = htmlspecialchars($_POST['name']);

        if (empty($name)) {
            $errors['general'] = "Category name is required.";
            $category = $this->categories->getCategoryById($id);
            $this->view("categories/edit", ['category' => $category, 'errors' => $errors]);
            return;
        }

        $this->categories->updateCategory($id, $name);
        header("Location: /categories");
        exit();
    }

    // Delete category
    public function delete($id)
    {
        $this->categories->deleteCategory($id);
        header("Location: /categories");
        exit();
    }
}
