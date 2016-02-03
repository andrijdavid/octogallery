<?php namespace Zingabory\Gallery\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Redirect;
use Zingabory\Gallery\Models\Gallery as GalleryModel;
use Zingabory\Gallery\Models\Category as CategoryModel;

class Galleries extends ComponentBase
{
    /**
     * A collection of galleries to display
     * @var Collection
     */
    public $galleries;

    /**
     * Parameter to use for the page number
     * @var string
     */
    public $pageParam;

    /**
     * If the gallery list should be filtered by a category, the model to use.
     * @var Model
     */
    public $category;

    /**
     * Message to display when there are no messages.
     * @var string
     */
    public $nogalleriesMessage;

    /**
     * Reference to the page name for linking to galleries.
     * @var string
     */
    public $galleryPage;

    /**
     * Reference to the page name for linking to categories.
     * @var string
     */
    public $categoryPage;

    /**
     * If the gallery list should be ordered by another attribute.
     * @var string
     */
    public $sortOrder;

    public function componentDetails()
    {
        return [
            'name'        => 'Galleries ',
            'description' => 'liste des galleries'
        ];
    }

    public function defineProperties()
    {
        return [
            'pageNumber' => [
                'title'       => 'rainlab.blog::lang.settings.galleries_pagination',
                'description' => 'rainlab.blog::lang.settings.galleries_pagination_description',
                'type'        => 'string',
                'default'     => '{{ :page }}',
            ],
            'categoryFilter' => [
                'title'       => 'categoryFilter',
                'description' => 'categoryFilter',
                'type'        => 'string',
                'default'     => ''
            ],
            'galleriesPerPage' => [
                'title'             => 'galleriesPerPage',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'rainlab.blog::lang.settings.galleries_per_page_validation',
                'default'           => '10',
            ],
            'noGalleriesMessage' => [
                'title'        => 'No gallery message',
                'description'  => 'No gallery message',
                'type'         => 'string',
                'default'      => 'No galleries found',
                'showExternalParam' => false
            ],
            'categoryPage' => [
                'title'       => 'Category of gallery',
                'description' => 'Category of gallery',
                'type'        => 'dropdown',
                'default'     => 'gallery/category',
                'group'       => 'Links',
            ],
            'galleryPage' => [
                'title'       => 'Gallerie unique',
                'description' => 'Gallerie unique',
                'type'        => 'dropdown',
                'default'     => 'gallery/gallery',
                'group'       => 'Links',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getgalleryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }



    public function onRun()
    {
        $this->prepareVars();

       /* $this->addCss('/plugins/zingabory/gallery/bower_components/photoswipe/dist/photoswipe.css');
        $this->addJs('/plugins/zingabory/gallery/bower_components/photoswipe/dist/photoswipe.min.js');
        $this->addJs('/plugins/zingabory/gallery/bower_components/photoswipe/dist/photoswipe-ui-default.min.js');*/

        $this->category = $this->page['category'] = $this->loadCategory();
        $this->galleries = $this->page['galleries'] = $this->listGalleries();

        /*
         * If the page number is not valid, redirect
         */
        if ($pageNumberParam = $this->paramName('pageNumber')) {
            $currentPage = $this->property('pageNumber');

            if ($currentPage > ($lastPage = $this->galleries->lastPage()) && $currentPage > 1)
                return Redirect::to($this->currentPageUrl([$pageNumberParam => $lastPage]));
        }
    }

    protected function prepareVars()
    {
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $this->noGalleriesMessage = $this->page['noGalleriesMessage'] = $this->property('noGalleriesMessage');

        /*
         * Page links
         */
        $this->galleryPage = $this->page['galleryPage'] = $this->property('galleryPage');
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
    }

    protected function listGalleries()
    {
        $categories = $this->category ? $this->category->id : null;

        /*
         * List all the galleries, eager load their categories
         */
        $galleries = GalleryModel::with('categories')->listFrontEnd([
            'page'       => $this->property('pageNumber'),
            'perPage'    => $this->property('galleriesPerPage'),
            'categories' => $categories
        ]);

        /*
         * Add a "url" helper attribute for linking to each gallery and category
         */
        $galleries->each(function($gallery){
            $gallery->setUrl($this->galleryPage, $this->controller);

            $gallery->categories->each(function($category){
                $category->setUrl($this->categoryPage, $this->controller);
            });
        });

        return $galleries;
    }

    protected function loadCategory()
    {
        if (!$categoryId = $this->property('categoryFilter'))
            return null;

        if (!$category = CategoryModel::whereSlug($categoryId)->first())
            return null;

        return $category;
    }

}