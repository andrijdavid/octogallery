<?php namespace Zingabory\Gallery\Components;

use Cms\Classes\ComponentBase;
use System\Classes\CombineAssets;
use Zingabory\Gallery\Models\Gallery as GalleryModel;
use Cms\Classes\Page;

class Gallery extends ComponentBase
{

    public $gallery;

    /**
     * @var string Reference to the page name for linking to categories.
     */
    public $categoryPage;

    public function componentDetails()
    {
        return [
            'name'        => 'gallery Component',
            'description' => 'Show unique gallery'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Gallery Slug',
                'description' => 'Slug unique de la gallerie',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'categoryPage' => [
                'title'       => 'Categorie de la gallerie',
                'description' => 'rainlab.blog::lang.settings.post_category_description',
                'type'        => 'dropdown',
                'default'     => 'gallery/category',
            ],
        ];
    }


    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->addCss(CombineAssets::combine([
            '~/plugins/zingabory/gallery/bower_components/photoswipe/dist/photoswipe.css',
            '~/plugins/zingabory/gallery/bower_components/photoswipe/dist/default-skin/default-skin.css'
        ]));

        $this->addJs(CombineAssets::combine([
            '~/plugins/zingabory/gallery/bower_components/photoswipe/dist/photoswipe.js',
            '~/plugins/zingabory/gallery/bower_components/photoswipe/dist/photoswipe-ui-default.js',
            '~/plugins/zingabory/gallery/bower_components/eventie/eventie.js',
            '~/plugins/zingabory/gallery/bower_components/classie/classie.js',
            '~/plugins/zingabory/gallery/bower_components/masonry/dist/masonry.pkgd.js',
            '~/plugins/zingabory/gallery/bower_components/imagesloaded/imagesloaded.pkgd.js',
            '~/plugins/zingabory/gallery/assets/js/gallery.js'
        ]));

        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->gallery = $this->page['gallery'] = $this->loadGallery();
    }

    protected function loadGallery()
    {
        $slug = $this->property('slug');
        $gallery = GalleryModel::where('slug', $slug)->first();

        /*
         * Add a "url" helper attribute for linking to each category
         */
        if ($gallery && $gallery->categories->count()) {
            $gallery->categories->each(function($category){
                $category->setUrl($this->categoryPage, $this->controller);
            });
        }

        return $gallery;
    }

}