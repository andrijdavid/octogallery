<?php namespace Zingabory\Gallery\Components;

use Cms\Classes\ComponentBase;
use System\Classes\CombineAssets;

class Masonry extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'masonry',
            'description' => 'provide masonry js and eventie js'
        ];
    }

   public function onRun(){
        $this->addJs(CombineAssets::combine([
            '~/plugins/zingabory/gallery/bower_components/eventie/eventie.js',
            '~/plugins/zingabory/gallery/bower_components/classie/classie.js',
            '~/plugins/zingabory/gallery/bower_components/masonry/dist/masonry.pkgd.js',
            '~/plugins/zingabory/gallery/bower_components/imagesloaded/imagesloaded.pkgd.js'
        ]));
    }

}