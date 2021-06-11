<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class BookFiles extends Model
{
    protected $fillable = [
        'file_name',
        'file_type',
    ];

    public function getFilesByBookID($id)
    {
        return $this->where(['book_id' => $id])->get();
    }

    public function getByID($id){
        return $this->where('id', $id)->get()->first();
    }

    public function remove($id)
    {
        $file = $this->getByID($id);
        $path = public_path('/uploads/books/' . $file->book_id);
        if (File::exists($path . '/' . $file->file_name)) {
        File::delete($path . '/' . $file->file_name);
        }
        $file->delete();
    }
}
