<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Book;
use App\Model\BookAuthor;
use App\Model\BookAuthorList;
use App\Model\BookCategory;
use App\Model\BookFiles;
use App\Model\BookLang;
use App\Model\BookLicense;
use App\Model\BookRating;
use App\Model\BookType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BookController extends Controller
{
    public function index(){
        $BookCats = new BookCategory();

        $data = $BookCats->getBooksWithCats();

        $bookCats = $BookCats->getListCategory();

        return view('web.books.index', compact([
            'data',
            'bookCats'
        ]));
    }

    public function bookSingle($id){

        $Book = new Book();
        $book = $Book->getByID($id);
        $Rating = new BookRating();
        $rating = $Rating->getListRateByBookID($book->id);
        $authors = BookAuthorList::getlistAuthorsByBookID($book->id);
        $point = 0;
        $c_point = 0;
        if(count($rating) > 0) {
            foreach ($rating as $rate) {
                $point += $rate->point;
            }
            $c_point = count($rating);
            $point = $point / $c_point;
        }
        return view('web.books.single-book', compact([
            'book',
            'point',
            'c_point',
            'authors',
        ]));
    }

    public function rateBook(Request $request){
        if (Auth::check()) {
            if ($request->ajax()) {
                $input = $request->all();
                $point = htmlspecialchars($input['point']);
                $b_id = htmlspecialchars($input['b_id']);
                $BookRate =new BookRating();
                $res = $BookRate->rateBook(Auth::user()->id, $b_id, $point);
                $rating = $BookRate->getListRateByBookID($b_id);

                $point = 0;
                foreach ($rating as $rate) {
                    $point += $rate->point;
                }
                $c_point = count($rating);
                $point = $point / $c_point;
                return Response::json([
                    'err'=> 0,
                    'res' => $res,
                    'c_r' => $c_point,
                    'point' => $point,
                ], 200);
            }
        }else{
            return Response::json([
                'err'=> 1,
                'msg'=> __('lang.you_no_created_rating')
            ], 200);
        }
    }

    public function categoryBook($id){
        $B_c = new BookCategory();
        $cat = $B_c->getBooksByCats($id);
        $bookCats = $B_c->getListCategory();

        return view('web.books.book-genre', compact([
            'cat',
            'bookCats',
        ]));
    }

    public function subCatBook($id){

        $B_c = new BookCategory();
        $sub_cat = $B_c->getByID($id);
        $sub_cats = $B_c->getListSubCats($sub_cat->parent_id);
        $book = new Book();
        $books = $book->getBooksByCatID($id);
        $id_active = $id;
        $bookCats = $B_c->getListCategory();


        /*echo '<pre>';
        print_r($books);
        echo '</pre>';*/

        return view('web.books.book-sub-cat', compact([
            'sub_cat',
            'sub_cats',
            'books',
            'id_active',
            'bookCats',
        ]));
    }

    /*========================Booker=================================================*/
    public function indexAdm(){
        if (Auth::check() && Auth::user()->role_id == 4){
            return view('admin.book.index');
        }
        return redirect('/');
    }

    /*=================Categories=========================================*/
    public function adminCategory(){
        if (Auth::check() && Auth::user()->role_id == 4){

            $BookCat = new BookCategory();
            $categories = $BookCat->getList();

            return view('admin.book.category', compact([
                'categories'
            ]));
        }
        return redirect('/');
    }
    //create Category
    public function adminCategoryCreate(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $BookCat = new BookCategory();
            $data = $BookCat->createCategory($input);


            $html = View::make('admin.book._cat', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);
        }
        return redirect('/');

    }

    //create Category
    public function adminPCategoryCreate(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $BookCat = new BookCategory();
            $data = $BookCat->createPCategory($input);


            $html = View::make('admin.book._cat', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);
        }
        return redirect('/');

    }


    //create Category
    public function adminCategoryById($id){

        if(Auth::check() && Auth::user()->role_id == 4){


            $BookCat = new BookCategory();
            $data = $BookCat->getByIDCats($id);
            $dataCat = $BookCat->getByID($id);


           return view('admin.book.pcategory', compact([
               'data',
               'dataCat'
           ]));
        }
        return redirect('/');

    }

    //change bc active
    public function changeActive(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){
            if ($request->ajax())
            {
                $input = $request->all();
                $BookCat = new BookCategory();
                $data = $BookCat->changeActive($input);
                return Response::json($data, 200);
            }
        }
        return redirect('/');

    }



    //remove Forum Category
    public function removeCat(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);

            $BookCat = new BookCategory();
            $res = $BookCat->remove($ID);


            return Response::json($res, 200);

        }
        return route('home');

    }


    //cancel Edit
    public function cancelEdit(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);
            $BookCat = new BookCategory();
            $data = $BookCat->getByID($ID);

            $html = View::make('admin.book._cat', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);

        }
        return route('home');

    }

    //save Edit
    public function saveEdit(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);
            $title = htmlspecialchars($input['title']);
            $BookCat = new BookCategory();
            $data = $BookCat->saveEdited($ID, $title);

            $html = View::make('admin.book._cat', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);

        }
        return route('home');

    }

/*===============================================================================================*/
/*===============================================================================================*/
/*=====================================LAngs==========================================================*/
    public function adminLangs(){
        if (Auth::check() && Auth::user()->role_id == 4){

            $BookLang = new BookLang();
            $data = $BookLang->getList();

            return view('admin.book.langs', compact([
                'data'
            ]));
        }
        return redirect('/');
    }

    //create
    public function createLangs(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $BookCat = new BookLang();
            $data = $BookCat->create($input);


            $html = View::make('admin.book._lang', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);
        }
        return route('home');

    }

    //remove
    public function removeLang(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);

            $BookCat = new BookLang();
            $res = $BookCat->remove($ID);


            return Response::json($res, 200);

        }
        return route('home');

    }


    //cancel Edit
    public function cancelEditLang(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);
            $BookCat = new BookLang();
            $data = $BookCat->getByID($ID);

            $html = View::make('admin.book._lang', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);

        }
        return route('home');

    }

    //save Edit
    public function saveEditLang(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);
            $title = htmlspecialchars($input['title']);
            $BookCat = new BookLang();
            $data = $BookCat->saveEdited($ID, $title);

            $html = View::make('admin.book._lang', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);

        }
        return route('home');

    }

    /*===============================================================================================*/
    /*===============================================================================================*/
    /*=====================================Genre==========================================================*/
    public function adminGenre(){
        if (Auth::check() && Auth::user()->role_id == 4){

            $BookLang = new BookType();
            $data = $BookLang->getList();

            return view('admin.book.genre', compact([
                'data'
            ]));
        }
        return redirect('/');
    }

    //create
    public function createGenre(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $BookCat = new BookType();
            $data = $BookCat->create($input);


            $html = View::make('admin.book._genre', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);
        }
        return route('home');

    }

    //remove
    public function removeGenre(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);

            $BookCat = new BookType();
            $res = $BookCat->remove($ID);


            return Response::json($res, 200);

        }
        return route('home');

    }


    //cancel Edit
    public function cancelEditGenre(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);
            $BookCat = new BookType();
            $data = $BookCat->getByID($ID);

            $html = View::make('admin.book._genre', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);

        }
        return route('home');

    }

    //save Edit
    public function saveEditGenre(Request $request){

        if(Auth::check() && Auth::user()->role_id == 4){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);
            $title = htmlspecialchars($input['title']);
            $BookCat = new BookType();
            $data = $BookCat->saveEdited($ID, $title);

            $html = View::make('admin.book._genre', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);

        }
        return route('home');

    }
/*========================================================================================*/
/*========================================================================================*/
/*========================================================================================*/
/*========================================================================================*/

    public function adminAuthor(){
        if (Auth::check() && Auth::user()->role_id == 4){

            $Author = new BookAuthor();
            $data = $Author->getList();

            return view('admin.book.author', compact([
                'data'
            ]));
        }
        return redirect('/');
    }
    public function adminAuthorAddPage(){
        if (Auth::check() && Auth::user()->role_id == 4){
            return view('admin.book.author-add');
        }
        return redirect('/');
    }

    public function adminAuthorAdd(Request $request){
        if (Auth::check() && Auth::user()->role_id == 4){
            if ($request->ajax()) {
                $author = new BookAuthor();
                $res = $author->create($request);
                return Response::json($res, 200);
            }
        }
        return redirect('/');
    }

      public function adminAuthorRemove(Request $request){
        if (Auth::check() && Auth::user()->role_id == 4){
            if ($request->ajax()) {
                $input=$request->all();
                $id = htmlspecialchars($input['id']);
                $author = new BookAuthor();
                $res = $author->remove($id);
                return Response::json($res, 200);
            }
        }
        return redirect('/');
    }

     public function adminAuthorEditPage($id){
        if (Auth::check() && Auth::user()->role_id == 4){

                $author = new BookAuthor();
                $data = $author->getByID($id);

                return view('admin.book.author-edit', compact('data'));
        }
        return redirect('/');
    }

     public function adminAuthorEdit(Request $request){
         if (Auth::check() && Auth::user()->role_id == 4){
             if ($request->ajax()) {
                 $author = new BookAuthor();
                 $res = $author->updateEdit($request);
                 return Response::json($res, 200);
             }
         }
         return redirect('/');
    }

/*========================================================================================*/
/*========================================================================================*/
/*========================================================================================*/
/*========================================================================================*/

    public function adminLicense(){
        if (Auth::check() && Auth::user()->role_id == 4){

            $Author = new BookLicense();
            $data = $Author->getList();

            return view('admin.book.license', compact([
                'data'
            ]));
        }
        return redirect('/');
    }

    public function adminLicenseAddPage(){
        if (Auth::check() && Auth::user()->role_id == 4){
            return view('admin.book.license-add');
        }
        return redirect('/');
    }

    public function adminLicenseAdd(Request $request){
        if (Auth::check() && Auth::user()->role_id == 4){
            if ($request->ajax()) {
                $author = new BookLicense();
                $res = $author->create($request);
                return Response::json($res, 200);
            }
        }
        return redirect('/');
    }

      public function adminLicenseRemove(Request $request){
        if (Auth::check() && Auth::user()->role_id == 4){
            if ($request->ajax()) {
                $input=$request->all();
                $id = htmlspecialchars($input['id']);
                $author = new BookLicense();
                $res = $author->remove($id);
                return Response::json($res, 200);
            }
        }
        return redirect('/');
    }

     public function adminLicenseEditPage($id){
        if (Auth::check() && Auth::user()->role_id == 4){

                $author = new BookLicense();
                $data = $author->getByID($id);

                return view('admin.book.license-edit', compact('data'));
        }
        return redirect('/');
    }

     public function adminLicenseEdit(Request $request){
         if (Auth::check() && Auth::user()->role_id == 4){
             if ($request->ajax()) {
                 $author = new BookLicense();
                 $res = $author->updateEdit($request);
                 return Response::json($res, 200);
             }
         }
         return redirect('/');
    }
/*=======================================================================================*/
/*=======================================================================================*/
/*=======================================================================================*/
/*=======================================================================================*/










public function addBookPage(){
    if (Auth::check() && Auth::user()->role_id == 4){

        $Authors = new BookAuthor();
        $authors = $Authors->getListAuthor();
        $Model = new BookLang();
        $langs = $Model->getList();
        $Model = new BookCategory();
        $cats = $Model->getListCategory();
        $Model = new BookType();
        $genres = $Model->getList();
        $Model = new BookLicense();
        $lics = $Model->getListLic();

        return view('admin.book.add-book', compact([
            'authors',
            'langs',
            'cats',
            'lics',
            'genres'
        ]));
    }
    return redirect('/');
}


public function editBookPage($id){
    if (Auth::check() && Auth::user()->role_id == 4){

        $Book = new Book();
        $book = $Book->getByID($id);
        $Authors = new BookAuthor();
        $authors = $Authors->getListAuthor();
        $Model = new BookLang();
        $langs = $Model->getList();
        $Model = new BookCategory();
        $cats = $Model->getListCategory();
        $Model = new BookType();
        $genres = $Model->getList();
        $Model = new BookLicense();
        $lics = $Model->getListLic();
        $Model = new BookCategory();
        //print_r($book);
        $catBook = $Model->getByID($book->book_category_id);
        $catID = $catBook->parent_id;
        $sections = $Model->getListSection($catID);
        $B_authors = BookAuthorList::getlistAuthorsByBookID($book->id);
        $BookFiles = new BookFiles();
        $files = $BookFiles->getFilesByBookID($book->id);


        return view('admin.book.edit-book', compact([
            'book',
            'authors',
            'B_authors',
            'langs',
            'cats',
            'lics',
            'genres',
            'sections',
            'catID',
            'files',
        ]));
    }
    return redirect('/');
}



public function uploadFileInTemp(Request $request){
    if (Auth::check() && Auth::user()->role_id == 4){
        if ($request->ajax()){
            $res = Book::uploadFileInTemp($request);
            return Response::json($res, 200);
        }
    }
}
public function getSectionCat(Request $request){
    if (Auth::check() && Auth::user()->role_id == 4){
        if ($request->ajax()){
            $input = $request->all();
            $id = htmlspecialchars($input['id']);
            $data = BookCategory::getListSection($id);
            $html = View::make('admin.book._section', compact('data'))->render();
            return Response::json(['html' => $html], 200);
        }
    }
}
public function getSectionCategory(Request $request){
    if ($request->ajax()){
        $input = $request->all();
        $id = htmlspecialchars($input['id']);
        $data = BookCategory::getListSection($id);
        $html = View::make('admin.book._section', compact('data'))->render();
        return Response::json(['html' => $html], 200);
    }

}

public function createNewBook(Request $request){
    if (Auth::check() && Auth::user()->role_id == 4){
        if ($request->ajax()){

            $book = new Book();
            $data = $book->create($request);

            return Response::json($data, 200);
        }
    }
}

public function updateBook(Request $request){
    if (Auth::check() && Auth::user()->role_id == 4){
        if ($request->ajax()){

            $book = new Book();
            $data = $book->updateBook($request);

            return Response::json($data, 200);
        }
    }
}

public function removeBookFile(Request $request){
    if (Auth::check() && Auth::user()->role_id == 4){
        if ($request->ajax()){
            $input = $request->all();
            $id = htmlspecialchars($input['id']);
            $book = new BookFiles();
            $data = $book->remove($id);

            return Response::json($data, 200);
        }
    }
}


public function removeBook(Request $request){
    if (Auth::check() && Auth::user()->role_id == 4){
        if ($request->ajax()){
            $input = $request->all();
            $id = htmlspecialchars($input['id']);
            $book = new Book();
            $data = $book->removeBook($id);

            return Response::json($data, 200);
        }
    }
}

public function readBook($id, $file_name){

    $path = public_path('/uploads/books/' . $id . '/' . $file_name);

    $arr =explode(".", $file_name);
    $mime =  end($arr);

    return Response::make(file_get_contents($path), 200, [

        'Content-Type'
        => 'application/' . $mime,

        'Content-Disposition' => 'inline; filename="'.$file_name.'"'

    ]);
}




}
