<?php

namespace App\Model;


use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\http\Request;
use Illuminate\Support\Facades\File;

class FileSharing extends Model
{
    protected  $fillable =[
        'file_name',
        'published_at',
    ];
    //
    public function uploadFile( Request $request)
    {
        $input = $request->all();

        $file_share = new FileSharing();

        $path = public_path('uploads/file-shared/');

        if ($file = $request->file('file')) {
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $myfile = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $real_file_name = $file->getClientOriginalName();
            //$real_file_name =str_replace('.'.$extension, '', $real_file_name);
            $fileName =  time() . '_' . uniqid() . '.' . $extension;

            $myfile->move($path, $fileName);


            $file_share->file_real_name = $real_file_name;
            $file_share->file_name = $fileName;
            $file_share->published_at = new DateTime('now');
           // $fileShare->end_date = (new DateTime('now'))->addDays(3);
            $file_share->end_date = date_add(new DateTime('now'), date_interval_create_from_date_string("3 days"));
            $result = $file_share->save();

        }
        return  [
            'file_name' => $real_file_name,
            'file' =>'/file-sharing/' . $file_share->file_name,
            'endate'=> $file_share->end_date,
            ];
    }
}
