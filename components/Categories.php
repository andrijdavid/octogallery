<?php namespace Zingabory\Gallery\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Zingabory\Gallery\Models\Category as CategoryModel;

class Categories extends ComponentBase
{
    /**
     * @var Collection A collection of categories to display
     */
    public $categories;

    /**
     * @var string Reference to the page name for linking to categories.
     */
    public $categoryPage;

    /**
     * @var string Reference to the current category slug.
     */
    public $currentCategorySlug;

    public function componentDetails()
    {
        return [
            'name'        => 'Categories',
            'description' => 'Categories '
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'category slug',
                'description' => 'slug',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'displayEmpty' => [
                'title'       => 'displayEmpty',
                'description' => 'displayEmpty',
                'type'        => 'checkbox',
                'default'     => 0
            ],
            'categoryPage' => [
                'title'       => 'categoryPage',
                'description' => 'categoryPage',
                'type'        => 'dropdown',
                'default'     => 'gallery/category',
                'group'       => 'Links',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
//        $this->addCss('/plugins/zingabory/gallery/bower_components/photoswipe/dist/photoswipe.css');
//        $this->addJs('/plugins/zingabory/gallery/bower_components/photoswipe/dist/photoswipe.min.js');
//        $this->addJs('/plugins/zingabory/gallery/bower_components/photoswipe/dist/photoswipe-ui-default.min.js');

        $this->currentCategorySlug = $this->page['currentCategorySlug'] = $this->property('slug');
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->categories = $this->page['categories'] = $this->loadCategories();
    }

    protected function loadCategories()
    {
        $categories = CategoryModel::orderBy('name');
        if (!$this->property('displayEmpty')) {
           /* $categories->whereExists(function($query) {
                $query->select(Db::raw(1))
                    ->from('rainlab_blog_posts_categories')
                    ->join('rainlab_blog_posts', 'rainlab_blog_posts.id', '=', 'rainlab_blog_posts_categories.post_id')
                    ->whereNotNull('rainlab_blog_posts.published')
                    ->where('rainlab_blog_posts.published', '=', 1)
                    ->whereRaw('rainlab_blog_categories.id = rainlab_blog_posts_categories.category_id');
            });*/
            $categories->whereGalleryCountNotNull();

        }

        $categories = $categories->get();

        /*
         * Add a "url" helper attribute for linking to each category
         */
        $categories->each(function($category){
            $category->setUrl($this->categoryPage, $this->controller);
        });

        return $categories;
    }

}