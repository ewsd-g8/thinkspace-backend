<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;

class MediaHelper
{
    protected $mediaField;

    protected $media_path;

    protected $upload_path;

    protected $name;

    protected $file;

    public function __construct($file, $name)
    {
        $this->file = $file;
        $this->name = $name;
        $this->mediaField = config("media_value.$name");
        $this->media_path = $this->mediaField['path'];
        $this->upload_path = $this->media_path.'/'.date('Y').'/'.date('m');
    }

    public function save()
    {
        //   $this->checkUploadPath();
        $result = $this->uploadMedia($this->file);

        return $result;
    }

    public function saveMany()
    {
        //   $this->checkUploadPath();

        $media = [
            'data' => [],
            'status' => true,
        ];

        foreach ($this->file as $key => $file) {
            $result = $this->uploadMedia($file);

            if (! $result['status']) {
                return ['status' => false, 'message' => $result['message']];
            }
            $media['data'][$key] = $result['data'];
        }

        return $media;
    }

    protected function uploadMedia($file)
    {
        $file_name = uniqid().'.'.$file->getClientOriginalExtension();

        $data = [
            'name' => $file->getClientOriginalName(),
            'file_name' => $file_name,
            'file_path' => $this->upload_path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'uploaded_at' => now()->toDateTimeString(),
        ];

        $result = $this->verifyAndUpload($file, $data, $this->mediaField);

        if ($result['status']) {
            $data['image_url'] = Storage::url($data['file_path'].'/'.$data['file_name']);
            $result['data'] = $data;
            $result['storage_path'] = $data['image_url'];
        }

        return $result;
    }

    protected function verifyAndUpload($file, $data, $mediaField)
    {
        try {
            $this->fileChecking($data, $mediaField);

            $file->storeAs($data['file_path'], $data['file_name']);

            $result['status'] = true;
            $result['message'] = 'The file has been uploaded.';

            return $result;
        } catch (\Exception $th) {
            $result['status'] = false;
            $result['message'] = $th->getMessage();

            return $result;
        }
    }

    protected function fileChecking($data, $mediaField)
    {
        if (file_exists($data['file_path'].$data['file_name'])) {
            throw new Exception('Sorry, file already exists.');
        }

        if (! in_array($data['file_type'], $mediaField['extensions'])) {
            throw new Exception('Sorry, we are not allow these files type to upload.');
        }

        if ($data['file_size'] > $mediaField['max_size']) {
            throw new Exception('Sorry, your file is too large.');
        }
    }

    protected function checkUploadPath()
    {
        if (! is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0775, true);
            file_put_contents($this->upload_path.'/index.html', '');
        }
    }
}
