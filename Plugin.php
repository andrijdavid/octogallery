<?php namespace Zingabory\Gallery;

use Backend;
use RainLab\Blog\Components\Categories;
use Rebel59\Isogallery\Controllers\Galleries;
use System\Classes\PluginBase;
use Zingabory\Gallery\Components\Categories as CategoriesComponent;
use Zingabory\Gallery\Components\Gallery as GalleryComponent;
use Zingabory\Gallery\Components\Galleries as GalleriesComponent;
use Zingabory\Gallery\Components\Masonry as MasonryComponent;

/**
 * gallery Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Galeries',
            'description' => 'Gérer les galeries',
            'author' => 'zingabory',
            'icon' => 'icon-camera'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            GalleryComponent::class => 'galery',
            GalleriesComponent::class => 'galleries',
            CategoriesComponent::class => 'categories',
            MasonryComponent::class => 'masonry'
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [
            'gallery' => [
                'label' => 'Galeries',
                'url' => Backend::url('zingabory/gallery/gallery'),
                'icon' => 'icon-camera',
                'order' => 500,
                'sideMenu' => [
                    'gallery' => [
                        'label' => 'Galeries',
                        'url' => Backend::url('zingabory/gallery/gallery'),
                        'icon' => 'icon-camera-retro',
                        'order' => 500,
                    ],
                    'category' => [
                        'label' => 'Catégories',
                        'url' => Backend::url('zingabory/gallery/category'),
                        'icon' => 'icon-list-ul',
                        'order' => 510,
                    ]
                ],
            ]
        ];
    }

}
