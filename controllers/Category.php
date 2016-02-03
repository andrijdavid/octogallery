<?php namespace Zingabory\Gallery\Controllers;
use Flash;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Category Back-end Controller
 */
class Category extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Zingabory.Gallery', 'gallery', 'category');
    }

     public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $postId) {
                if ((!$post = \Zingabory\Gallery\Models\Category::find($postId)))
                    continue;

                $post->delete();
            }

            Flash::success('Supprimé avec succès');
        }

        return $this->listRefresh();
    }
}