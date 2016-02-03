<?php namespace Zingabory\Gallery\Models;

use Model;
use Zingabory\Gallery\Models\Category as CategoryModel;

/**
 * gallery Model
 */
class Gallery extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zingabory_gallery_galleries';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
        'description',
        'slug'
    ];

    /**
     * Validation
     */
    public $rules = [
        'title' => 'required',
        'slug' => [
            'required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'
        ],
    ];


    public $belongsToMany = [
        'categories' => [
            CategoryModel::class,
            'table' => 'zingabory_gal_gal_cat'
        ]
    ];

    public $attachMany = [
        'images' => [
            'System\Models\File',
            'order' => 'sort_order'
        ]
    ];

    public $attachOne = [
        'feature_image' => 'System\Models\File'
    ];

    /**
     * Lists posts for the front end
     * @param  array $options Display options
     * @return self
     */
    public function scopeListFrontEnd($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page'       => 1,
            'perPage'    => 30,
            'categories' => null,
            'published'  => true
        ], $options));


        /*
         * Categories
         */
        if ($categories !== null) {
            if (!is_array($categories)) $categories = [$categories];
            $query->whereHas('categories', function($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }

        return $query->paginate($perPage, $page);
    }

    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'slug' => $this->slug,
        ];

        if (array_key_exists('categories', $this->getRelations())) {
            $params['category'] = $this->categories->count() ? $this->categories->first()->slug : null;
        }

        return $this->url = $controller->pageUrl($pageName, $params);
    }

}