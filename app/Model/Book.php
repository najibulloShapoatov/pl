<?php

namespace App\Model;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Book extends Model
{
    protected $fillable = [
        'title'
    ];

    public function cats(){
        return $this->belongsTo('App\Model\BookCategory', 'book_category_id');
    }
    public function langt(){
        return $this->belongsTo('App\Model\BookLang', 'book_lang_id');
    }
    public function lic(){
        return $this->belongsTo('App\Model\BookLicense','book_license_id');
    }
    public function authorList(){
        return $this->hasMany('App\Model\BookAuthorList');
    }
    public function bookFiles(){
        return $this->hasMany('App\Model\BookFiles');
    }
    public function rating(){
        return $this->hasMany('App\Model\BookRating');
    }

    public static function uploadFileInTemp(Request $request)
    {
        $path = public_path('temp/' );
        $input = $request->all();
        if ($file = $request->file('file')) {
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $myfile = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $ex = self::validateExtension($extension);
            if($ex == 0){
                return [
                    'err' => 1,
                    'msg' => __('lang.choise_correct_format_file')
                ];
            }
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $myfile->move($path, $fileName);
            $res =[
                'file_name' => $fileName,
                'file_type' => $ex
            ];
            return [
                'err' => 0,
                'res' =>$res,
                'input'=>$input
            ];

        }
    }

    public static function validateExtension($e){
        switch ($e){
            case 'pdf':
                return 1;
            break;
            case 'epub':
                return 2;
                break;
            case 'fb2':
                return 3;
                break;
            case 'doc':
            case 'docx':
            case 'txt':
            case 'text':
                return 4;
                break;
            case 'rar':
            case 'zip':
                return 5;
                break;

            case 'mp3':
            case 'wav':
            case 'aac':
            case 'amr':
                return 6;
                break;
            default:
                return 0;
                break;

        }
    }

    public function create(Request $request)
    {
        $input = $request->all();

        $title = htmlspecialchars($input['title']);
        $licID = htmlspecialchars($input['licID']);
        $authorsStr = htmlspecialchars($input['authors']);
        $langID = htmlspecialchars($input['langID']);
        $year = htmlspecialchars($input['year']);
        $publish = htmlspecialchars($input['publish']);
        $catID = htmlspecialchars($input['catID']);
        $secID = htmlspecialchars($input['secID']);
        $typeID = htmlspecialchars($input['typeID']);
        $isbn = htmlspecialchars($input['isbn']);
        $descr = htmlspecialchars($input['descr']);
        $pages = htmlspecialchars($input['pages']);

        $B_Files = json_decode($input['BookFile']);
        $authors = explode(',', $authorsStr);

        $res = $this->validateCreateBook($title, $licID, $authorsStr, $langID, $year, $publish, $secID, $typeID, $pages, $B_Files);
        if($res['err'] == 1){
            return $res;
        }


        if($res['err'] == 0) {
        $book  = new Book();
        $book->title =$title;
        $book->book_lang_id = $langID;
        $book->book_license_id = $licID;
        $book->book_category_id = $secID;
        $book->publish_year = $year;
        $book->publishing_house = $publish;
        $book->book_type_id = $typeID;
        $book->isbn = $isbn;
        $book->description = $descr;
        $book->pages = $pages;
        $book->published_at = new DateTime('now');




            $book->save();

            $path = public_path('/uploads/books/' . $book->id);
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            if ($file = $request->file('file')) {
                $image = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $img = Image::make($image);
                $img->save($path . '/' . $imageName);
                $img->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $book->image = $imageName;
                $book->save();
            }

            foreach ($B_Files as $item) {
                if (File::exists(public_path('/temp/' . $item->file_name))) {
                    File::move(public_path('/temp/' . $item->file_name), $path . '/' . $item->file_name);
                    File::delete(public_path('/temp/' . $item->file_name));
                    $bookFile = new BookFiles();
                    $bookFile->book_id = $book->id;
                    $bookFile->file_name = $item->file_name;
                    $bookFile->file_type = $item->file_type;
                    $bookFile->save();
                }
            }
            foreach ($authors as $item) {
                $bookAuthorList = new BookAuthorList();
                $bookAuthorList->book_id = $book->id;
                $bookAuthorList->author_id = $item;
                $bookAuthorList->save();
            }

            return [
                'err' => 0,
            ];
        }
    }

    private function validateCreateBook( $title,  $licID, $authorsStr,  $langID, $year, $publish, $secID, $typeID, $pages, $B_Files)
    {


        $msg = '';

        if(empty($typeID) || $typeID== ''){
            $msg = __('lang.choise_genre_book');
        }
        if(empty($year) || $year == '') {
            $msg = __('lang.choise_year_publish_book');
        }
        if(empty($publish) || $publish == ''){
            $msg = __('lang.choise_publish_house_book');
        }
        if(empty($pages) || $pages == ''){
            $msg = __('lang.choise_pages_book');
        }
        if(empty($langID) || $langID == ''){
            $msg = __('lang.choise_lang_book');
        }
        if(empty($secID) || $secID== ''){
            $msg = __('lang.choise_category_book');
        }
        if(empty($licID) || $licID== ''){
            $msg = __('lang.choise_lic_book');
        }
        if(!$B_Files){
            $msg = __('lang.upload_file_book');
        }
        if(empty($authorsStr) || $authorsStr == ''){
            $msg = __('lang.choise_author_book');
        }

        if(empty($title) || $title == ''){
            $msg = __('lang.enter_name_book');
        }


        if(!empty($msg)){
            return [
                'err' => 1,
                'msg' => $msg,
            ];
        }
        else{
            return[
                'err' => 0,
                'msg' => $msg,
            ];
        }
    }

    private function validateUpdateBook( $title,  $licID, $authorsStr,  $langID, $year, $publish, $secID, $typeID, $pages)
    {


        $msg = '';

        if(empty($typeID) || $typeID== ''){
            $msg = __('lang.choise_genre_book');
        }
        if(empty($year) || $year == '') {
            $msg = __('lang.choise_year_publish_book');
        }
        if(empty($publish) || $publish == ''){
            $msg = __('lang.choise_publish_house_book');
        }
        if(empty($pages) || $pages == ''){
            $msg = __('lang.choise_pages_book');
        }
        if(empty($langID) || $langID == ''){
            $msg = __('lang.choise_lang_book');
        }
        if(empty($secID) || $secID== ''){
            $msg = __('lang.choise_category_book');
        }
        if(empty($licID) || $licID== ''){
            $msg = __('lang.choise_lic_book');
        }
        if(empty($authorsStr) || $authorsStr == ''){
            $msg = __('lang.choise_author_book');
        }

        if(empty($title) || $title == ''){
            $msg = __('lang.enter_name_book');
        }


        if(!empty($msg)){
            return [
                'err' => 1,
                'msg' => $msg,
            ];
        }
        else{
            return[
                'err' => 0,
                'msg' => $msg,
            ];
        }
    }

    public function getByID($id)
    {
        return $this->where(['id' => $id])->get()->first();
    }

    public function updateBook(Request $request)
    {

        $input = $request->all();

        $id = htmlspecialchars($input['id']);
        $title = htmlspecialchars($input['title']);
        $licID = htmlspecialchars($input['licID']);
        $authorsStr = htmlspecialchars($input['authors']);
        $langID = htmlspecialchars($input['langID']);
        $year = htmlspecialchars($input['year']);
        $publish = htmlspecialchars($input['publish']);
        $catID = htmlspecialchars($input['catID']);
        $secID = htmlspecialchars($input['secID']);
        $typeID = htmlspecialchars($input['typeID']);
        $isbn = htmlspecialchars($input['isbn']);
        $descr = htmlspecialchars($input['descr']);
        $pages = htmlspecialchars($input['pages']);

        $B_Files = json_decode($input['BookFile']);
        $authors = explode(',', $authorsStr);

        $res = $this->validateUpdateBook($title, $licID, $authorsStr, $langID, $year, $publish, $secID, $typeID, $pages);
        if($res['err'] == 1){
            return $res;
        }


        if($res['err'] == 0) {
            $book  = $this->getByID($id);
            $book->title =$title;
            $book->book_lang_id = $langID;
            $book->book_license_id = $licID;
            $book->book_category_id = $secID;
            $book->publish_year = $year;
            $book->publishing_house = $publish;
            $book->book_type_id = $typeID;
            $book->isbn = $isbn;
            $book->description = $descr;
            $book->pages = $pages;
            $book->published_at = new DateTime('now');




            $book->save();

            $path = public_path('/uploads/books/' . $book->id);
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            if ($file = $request->file('file')) {
                if($book->image) {
                    if (File::exists($path . '/' . $book->image)) {
                        File::delete($path . '/' . $book->image);
                    }
                }
                $image = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $img = Image::make($image);
                $img->save($path . '/' . $imageName);
                $img->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $book->image = $imageName;
                $book->save();
            }

            foreach ($B_Files as $item) {
                if (File::exists(public_path('/temp/' . $item->file_name))) {
                    File::move(public_path('/temp/' . $item->file_name), $path . '/' . $item->file_name);
                    File::delete(public_path('/temp/' . $item->file_name));
                    $bookFile = new BookFiles();
                    $bookFile->book_id = $book->id;
                    $bookFile->file_name = $item->file_name;
                    $bookFile->file_type = $item->file_type;
                    $bookFile->save();
                }
            }

            $book->authorList()->delete();
            foreach ($authors as $item) {
                $bookAuthorList = new BookAuthorList();
                $bookAuthorList->book_id = $book->id;
                $bookAuthorList->author_id = $item;
                $bookAuthorList->save();
            }

            return [
                'err' => 0,
            ];
        }

    }

    public function removeBook($id){
        $book = $this->getByID($id);
        $book->authorList()->delete();
        $path = public_path('/uploads/books/' . $book->id);
        if (is_dir($path)) {
            File::deleteDirectory($path);
        }
        $book->bookFiles()->delete();

        return $book->delete();

    }





    /*================Get Books========================*/
    public function getBooksByCatID($id)
    {
        return $this->where(['book_category_id' => $id])->paginate(15);
    }

    public function getBookHome()
    {
        return $this->orderBy("created_at", 'desc')->take(12)->get();
    }

    public function searchGlobal( $search)
    {
        $data = Book::where('title', 'like','%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%')
            ->orWhere('publishing_house', 'like', '%'.$search.'%')
            ->orderBy('created_at', 'desc')
            ->get();


        return $data;
    }

}
