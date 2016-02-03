<?php namespace Zingabory\Gallery\Models;

use Model;

/**
 * category Model
 */
class Category extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zingabory_gallery_categories';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|between:3,64|unique:zingabory_gallery_categories',
        'code' => 'unique:zingabory_gallery_categories',
    ];


    public $belongsToMany = [
        'galleries' => [
            Gallery::class,
            'table' => 'zingabory_gal_gal_cat'
        ]
    ];

    public function beforeValidate()
    {
        // Generate a URL slug for this model
        if (!$this->exists && !$this->slug)
            $this->slug = Str::slug($this->name);
    }

    public function afterDelete()
    {
        $this->galleries()->detach();
    }

    public function getGalleryCountAttribute()
    {
        return $this->galleries()->count();
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