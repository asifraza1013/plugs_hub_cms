<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveImageVersions($folder,$laravel_image_resource,$versions){
        //Make UUID
        $uuid = Str::uuid()->toString();

        //Make the versions
        foreach ($versions as $key => $version) {
            if(isset($version['w'])&&isset($version['h'])){
                $img = Image::make($laravel_image_resource->getRealPath())->fit($version['w'], $version['h']);
                $img->save(public_path($folder).$uuid."_".$version['name']."."."jpg");
            }else{
                //Original image
                $laravel_image_resource->move(public_path($folder), $uuid."_".$version['name']."."."jpg");
            }


        }
        return $uuid;
    }
}
