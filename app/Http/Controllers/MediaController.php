<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function store(UploadFileRequest $request,$model,$id){
        $myModel = app('App\\Models\\'.$model)::find($id);
        $file = $request->file;
        $myModel->addMedia($file)->toMediaCollection();
        return redirect()->back();
    }

    public function download(Media $media){
        return $media;
    }

    public function destroy(Media $media){
        $media->delete();
        return redirect()->back();
        
    }
}
