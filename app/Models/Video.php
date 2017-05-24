<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $table = 'files';
    protected $guarded = [];

    public function attachments()
    {
        return $this->belongsToMany('App\Models\File', 'video_attachment', 'video_id', 'attachment_id')
            ->withPivot('no');
    }

    public function pictures()
    {
        return $this->belongsToMany('App\Models\File', 'video_attachment', 'video_id', 'attachment_id')
            ->where('mime', 'like', 'image%')
            ->withPivot('no');
    }


}
