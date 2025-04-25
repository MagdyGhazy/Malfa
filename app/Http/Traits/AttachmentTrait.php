<?php

namespace App\Http\Traits;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait AttachmentTrait
{

    public function addMedia($model, $file, $key, $name)
    {
        $path = $this->uploadFile($file, $key);

        $model->media()->create([
            'name' => $name,
            'path' => $path,
        ]);
    }

    public function updateMedia($model, $mediaId, $file, $key, $name)
    {
        $media = $model->media()->find($mediaId);

        if ($media) {
            $this->deleteFile($media->path);

            $path = $this->uploadFile($file, $key);

            $media->update([
                'name' => $name,
                'path' => $path,
            ]);

            return true;
        }

        return false;
    }

    public function addGroupMedia($model, $files, $key, $name)
    {
        foreach ($files as $file) {
            $this->addMedia($model, $file, $key, $name);
        }
    }

    public function updateGroupMedia($model, $files, $key, $name)
    {
        $this->deleteGroupMedia($model, $name);

        foreach ($files as $file) {
            $this->addMedia($model, $file, $key, $name);
        }

    }

    public function deleteMedia($model)
    {
        $model->media()->each(function ($media) {
            $this->deleteFile($media->path);
        });
        $model->media()->delete();
    }

    public function deleteGroupMedia($model, $name)
    {
        $group_media = $model->media()->where('name', $name)->get();
        $group_media->each(function ($media) {
            $this->deleteFile($media->path);
            $media->delete();
        });
    }


    public function uploadFile($file, $key)
    {
        $file_name_with_ext = $file->getClientOriginalName();
        $file_name = pathinfo($file_name_with_ext, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $file_name_to_store = $file_name . '.' . $extension;

        return $file->storeAs('uploads/' . $key, $file_name_to_store);
    }


    public function updateFile($file, $key, $current_file_path)
    {
        $this->deleteFile($current_file_path);

        return $this->uploadFile($file, $key);
    }


    public function deleteFile($public_path)
    {
        $count = Media::query()->where('path', $public_path)->count();
        if ($count == 1) {
            if (Storage::exists($public_path)) {
                Storage::delete($public_path);
            }
        }
    }


}
