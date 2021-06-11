<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Index
use Illuminate\Support\Facades\Route;

Route::get('/', 'Web\HomePageController@index')->name('home');
Route::get('/bitrix', 'Web\HomePageController@bitrix');

//001660110-nazrulloh

Route::get('/change-lang/{locale}', 'Web\HomePageController@setLang');


//Poolling
Route::get('/poolling', 'Web\PoolController@index');
Route::post('/pool', 'Web\PoolController@pooling');
Route::post('/pool-get', 'Web\PoolController@poolingGet');
Route::get('/admin-pool', 'Web\PoolController@indexADMPool');
Route::get('/pool-add', 'Web\PoolController@addADMPool');
Route::get('/pool-edit/{id}', 'Web\PoolController@editADMPool');
Route::post('/pool-add', 'Web\PoolController@createPool');
Route::post('/pool-edit', 'Web\PoolController@updatePool');
Route::post('/pool-remove', 'Web\PoolController@removePool');
Route::post('/change-active-pool', 'Web\PoolController@changeActivePool');

//customize
Route::get('/site-customize', 'Web\SiteCustomizationController@indexAdmin');
Route::get('/edit-site-customize', 'Web\SiteCustomizationController@editindexAdmin');
Route::post('/save-edited-site-customize', 'Web\SiteCustomizationController@saveEditedAdmin');



//Subscribe
Route::post('/subscribe', 'Web\SubscribeController@subscribe');


//Contacts
Route::get('/contacts', 'FeedbackController@index');
Route::post('captcha', 'FeedbackController@captchaValidate');
Route::get('refreshcaptcha', 'FeedbackController@refreshCaptcha');
Route::get('/about-manage', 'FeedbackController@fedbackToIndex');
//Route::get('/about-manage', 'FeedbackController@indexAdmin');
//Route::get('/about-manage/{id}', 'FeedbackController@singleAbout');
//Route::post('/remove-about-item', 'FeedbackController@removesingleAbout');
//Route::get('/fedback-to', 'FeedbackController@fedbackToIndex');
Route::post('/create-new-fed-to', 'FeedbackController@createFedTo');
Route::get('/edit-fed-to/{id}', 'FeedbackController@getEdit');
Route::post('/update-fed-to', 'FeedbackController@updateFedTo');
Route::get('/remove-fed-to/{id}', 'FeedbackController@removeFedTo');
Route::get('/get-by-fac-to-whom/{id}', 'FeedbackController@getByFacFedTo');

Route::post('/update-mail-admin', 'FeedbackController@updateAdminMail');
Route::post('/update-mail-booker', 'FeedbackController@updateBookerMail');




//vebinar
Route::get('/vebinar', 'Web\WebinarController@index');

//Search
Route::get('/search', 'Web\SearchController@search');
Route::post('/search', 'Web\SearchController@searchData');
//Route::get('/search', 'Web\SearchController@index')->name('search.index');



//User
Route::get('/login', 'Web\UserController@login');
Route::get('/register', 'Web\UserController@register');
Route::get('/profile', 'Web\UserController@profile');
Route::post('/register_data', 'Web\UserController@registerData');
Route::post('/login', 'Web\UserController@loginData');
Route::get('/logout', 'Web\UserController@logout');
Route::post('/profile/password', 'Web\UserController@profileChangePassword');
Route::post('/profile/info', 'Web\UserController@profileChangeInfo');
Route::post('/image_crop/upload', 'Web\UserController@uploadIMG');
Route::post('/edit-name-user', 'Web\UserController@updateName');

Route::get('/view-user-info-modal/{id}', 'Web\UserController@viewUserInfo');

// Ticket
//Route::get('/tickets', 'Web\TicketController@index');
////Route::get('/tickets/{id}', 'Web\TicketController@ticketInfo');
////Route::post('/ticket/add-msg', 'Web\TicketController@addTicketMsg');
////Route::post('/ticket/close', 'Web\TicketController@ticketClose');
////Route::post('/ticket/add-ticket', 'Web\TicketController@addTicket');
////Route::post('/ticket-load', 'Web\TicketController@loadMoreTicket');


//news
Route::get('/news', 'Web\NewsController@index');
Route::post('/news', 'Web\NewsController@loadMore');
Route::post('/news/year', 'Web\NewsController@loadByYear');
Route::get('/news/{news_id}', 'Web\NewsController@single');

//news Admin
Route::get('/news-manage', 'Web\NewsController@indexAdmin');
Route::get('/news-manage/edit/{id}', 'Web\NewsController@editNews');
Route::get('/add-new-news', 'Web\NewsController@createNewsPage');
Route::post('/add-news', 'Web\NewsController@createNews');
Route::post('/change-active-news', 'Web\NewsController@changeActiveNews');
Route::post('/delete-news', 'Web\NewsController@deleteNews');
Route::post('/update-news', 'Web\NewsController@updateNews');

//To-Do
Route::get('/to-do', 'Web\TodoController@index');
Route::post('/to-do/change_status', 'Web\TodoController@changeStatus');
Route::post('/to-do/change_content', 'Web\TodoController@changeContent');
Route::post('/to-do/remove_task', 'Web\TodoController@removeTask');
Route::post('/to-do/add', 'Web\TodoController@addTask');

//Library
Route::get('/library', 'Web\BookController@index');
Route::get('/book/{id}', 'Web\BookController@bookSingle');
Route::get('/lib-genre/{id_genre}', 'Web\BookController@bookGenre');

/*===================Admin===========================*/
/*Handbook*/
Route::get('/handbook', 'Web\BookController@indexAdm');
Route::get('/manage-book/category', 'Web\BookController@adminCategory');
Route::get('/manage-book/category/{id}', 'Web\BookController@adminCategoryById');
Route::post('/book-cat-create', 'Web\BookController@adminCategoryCreate');
Route::post('/book-pcat-create', 'Web\BookController@adminPCategoryCreate');
Route::post('/change-active-bcat', 'Web\BookController@changeActive');
Route::post('/remove-bcat', 'Web\BookController@removeCat');
Route::post('/bcat-cancel', 'Web\BookController@cancelEdit');
Route::post('/bcat-save', 'Web\BookController@saveEdit');
Route::get('/manage-book/langs', 'Web\BookController@adminLangs');
Route::post('/book-lang-create', 'Web\BookController@createLangs');
Route::post('/remove-blang', 'Web\BookController@removeLang');
Route::post('/cancel-blang', 'Web\BookController@cancelEditLang');
Route::post('/save-blang', 'Web\BookController@saveEditLang');
Route::get('/manage-book/genre', 'Web\BookController@adminGenre');
Route::post('/book-genre-create', 'Web\BookController@createGenre');
Route::post('/remove-bgenre', 'Web\BookController@removeGenre');
Route::post('/cancel-bgenre', 'Web\BookController@cancelEditGenre');
Route::post('/save-bgenre', 'Web\BookController@saveEditGenre');
Route::get('/manage-book/authors', 'Web\BookController@adminAuthor');
Route::get('/book-author-add', 'Web\BookController@adminAuthorAddPage');
Route::post('/book-author-add', 'Web\BookController@adminAuthorAdd');
Route::post('/remove-bautor', 'Web\BookController@adminAuthorRemove');
Route::get('/book-author/{id}', 'Web\BookController@adminAuthorEditPage');
Route::post('/book-author-edit', 'Web\BookController@adminAuthorEdit');
Route::get('/manage-book/licenses', 'Web\BookController@adminLicense');
Route::get('/book-license-add', 'Web\BookController@adminLicenseAddPage');
Route::post('/book-license-add', 'Web\BookController@adminLicenseAdd');
Route::post('/remove-blicense', 'Web\BookController@adminLicenseRemove');
Route::get('/book-license/{id}', 'Web\BookController@adminLicenseEditPage');
Route::post('/book-license-edit', 'Web\BookController@adminLicenseEdit');
/*==================================================================================*/
/*==============Add Book======================*/
Route::get('/add-book', 'Web\BookController@addBookPage');
Route::get('/edit-book/{id}', 'Web\BookController@editBookPage');
Route::post('/book-upload-file-temp', 'Web\BookController@uploadFileInTemp');
Route::post('/change-section-book', 'Web\BookController@getSectionCategory');
Route::post('/create-new-book', 'Web\BookController@createNewBook');
Route::post('/remove-book-file', 'Web\BookController@removeBookFile');
Route::post('/update-book', 'Web\BookController@updateBook');
Route::post('/remove-book', 'Web\BookController@removeBook');
Route::post('/rate-book', 'Web\BookController@rateBook');
Route::get('/book-category/{id}', 'Web\BookController@categoryBook');
Route::get('/book-sub-category/{id}', 'Web\BookController@subCatBook');
Route::get('/read-book/{id}/{file_name}', 'Web\BookController@readBook');






//VideoCourse
Route::get('/video-course', 'Web\VideoCourseController@index');
Route::get('/my-course', 'Web\VideoCourseController@myCourses');
Route::get('/videocourse/{id}', 'Web\VideoCourseController@singleCourse');
Route::get('/add-course', 'Web\VideoCourseController@addCourse');
Route::post('/add-course', 'Web\VideoCourseController@createCourse');
Route::get('/edit-course/{id}', 'Web\VideoCourseController@editCourse');
Route::get('/course-cat/{id}', 'Web\VideoCourseController@catCourse');
Route::get('/delete-course/{id}', 'Web\VideoCourseController@deleteCourse');
Route::post('/video-play', 'Web\VideoCourseController@playVideo');
Route::post('/video-delete', 'Web\VideoCourseController@deleteVideo');
Route::post('/save-edited-course', 'Web\VideoCourseController@saveEditedCourse');
Route::post('/add-course-video', 'Web\VideoCourseController@addCourseVideo');

//Videocourse Admin
Route::get('/manage-course', 'Web\VideoCourseController@indexAdm');
Route::get('/course-manage/category', 'Web\VideoCourseController@indexAdmCat');
Route::post('/remove-course', 'Web\VideoCourseController@removeCourseAdm');
Route::post('/change-active-course', 'Web\VideoCourseController@changeActiveAdm');
Route::post('/remove-course-cat', 'Web\VideoCourseController@removeCatCourse');
Route::post('/course-cat-create', 'Web\VideoCourseController@createCatCourse');
Route::post('/course-cat-cancel', 'Web\VideoCourseController@cancelCatCourse');
Route::post('/course-cat-save', 'Web\VideoCourseController@saveCatCourse');




//Forum
Route::get('/forum', 'Web\ForumController@index');
Route::get('/forum/category/{id}', 'Web\ForumController@getCategory');
Route::get('/forum/{id}', 'Web\ForumController@single');
Route::get('/forum-search', 'Web\ForumController@search');
Route::post('/search-forum', 'Web\ForumController@searchForum');
Route::post('/edit-forum', 'Web\ForumController@editForum');
Route::post('/edit-forum-save', 'Web\ForumController@editForumSave');
Route::post('/edit-forum-remove', 'Web\ForumController@editForumRemove');
Route::post('/add-new-forum', 'Web\ForumController@addForum');
Route::post('/add-new-forum-like', 'Web\ForumController@addForumLike');
Route::post('/add-new-forum-answer', 'Web\ForumController@addForumAnswer');
Route::post('/add-new-forum-answer-like', 'Web\ForumController@addForumAnswerLike');


//forum admin
Route::get('/forum-manage', 'Web\ForumController@indexAdm');
Route::get('/forum-manage/forums', 'Web\ForumController@forums');
Route::get('/forum-manage/category', 'Web\ForumController@adminCategory');
Route::post('/change-active-forum', 'Web\ForumController@changeActiveForum');
Route::post('/delete-forum', 'Web\ForumController@deleteForum');
Route::post('/forum-cat-cancel', 'Web\ForumController@getForumCategory');
Route::post('/forum-cat-save', 'Web\ForumController@saveForumCategory');
Route::post('/forum-cat-remove', 'Web\ForumController@removeForumCategory');
Route::post('/forum-cat-create', 'Web\ForumController@createForumCategory');
Route::get('/forum-permission-change/{id}', 'Web\ForumController@changePermission');
Route::get('forum-moderable-change/{sts}', 'Web\ForumController@changeModerable');




//Testing
Route::get('/testing', 'Web\TestController@index');
Route::post('/filter-test', 'Web\TestController@filterTest');
Route::get('/test/{id}', 'Web\TestController@test');
Route::get('/my-tests', 'Web\TestController@myTests');
Route::get('/add-test', 'Web\TestController@addTest');
Route::get('/edit-test/{id}', 'Web\TestController@editTest');
Route::get('/test-delete/{id}', 'Web\TestController@deleteTest');
Route::post('/add-test', 'Web\TestController@addTestQuestions');
Route::post('/upload-image-temp', 'Web\TestController@uploadImageTemp');
Route::post('/test-result', 'Web\TestController@resultTest');
Route::post('/save-que-test', 'Web\TestController@saveQuestTest');
Route::post('/remove-que-var', 'Web\TestController@removeVariantTest');
Route::post('/remove-que', 'Web\TestController@removeQuestionTest');
Route::post('/save-new-que-editing-test', 'Web\TestController@saveQuestionNewEditingTest');
Route::post('/save-edited-test', 'Web\TestController@saveEditingTest');
Route::get('/fac-cafedra/{id}', 'Web\TestController@getCafs');


//Commuynity
Route::get('/community', 'Web\CommunityController@index');/*
Route::get('/community-chat', 'Web\CommunityController@chat');*/
Route::get('/community/{id}', 'Web\CommunityController@single');
Route::post('/remove-community', 'Web\CommunityController@communityRemove');
Route::post('/update-community-info', 'Web\CommunityController@updateInfoCommunity');
Route::post('/update-community-img', 'Web\CommunityController@updateImgCommunity');
Route::post('/add-community', 'Web\CommunityController@addNewCommunity');
Route::post('/subscribe-community', 'Web\CommunityController@changeSubscribeCommunity');
Route::post('/like-community', 'Web\CommunityController@changeLikeCommunityPost');
Route::post('/add-community-post', 'Web\CommunityController@addNewPost');
Route::post('/video-upload', 'Web\CommunityController@video');
Route::post('/community-post-comment', 'Web\CommunityController@addComment');
Route::post('/community-post-comment-reply', 'Web\CommunityController@addCommentReply');

Route::get('/community-post-manage/{id}', 'Web\CommunityController@managePosts');
Route::get('/comment/{id}', 'Web\CommunityController@viewComment');
Route::get('/change-active-comment/{id}', 'Web\CommunityController@changeActiveComment');
Route::get('/delete-comment/{id}', 'Web\CommunityController@deleteComment');
/*
Route::get('/post-comments/{id}', 'Web\CommunityController@managePostsComents');
Route::get('/post-coment-replies/{id}', 'Web\CommunityController@managePostsComentsReplies');*/

Route::post('/community-moderableChange', 'Web\CommunityController@changeModerableComments');

//Community Admin
Route::get('/community-manage', 'Web\CommunityController@indexAdm');
Route::post('/change-active-comm', 'Web\CommunityController@changeActiveCommunity');
Route::get('/community-moderator/{id}', 'Web\CommunityController@getModerator');
Route::post('/community-moderator', 'Web\CommunityController@setModerator');


//File Sharing
Route::get('/faylobmennik', 'Web\FileSharingController@index');
Route::get('/file-sharing/{fileName}', 'Web\FileSharingController@downloadPage');
Route::get('/file-sharing-manage', 'Web\FileSharingController@managePage');
Route::post('/file-sharing', 'Web\FileSharingController@uploadFile');
Route::post('/edit-file-share-settings', 'Web\FileSharingController@editFileShareSettings');

//Ads
Route::get('/elon', 'Web\AdController@index');
Route::get('/elon-search', 'Web\AdController@index')->name('elon-search.index');
Route::get('/elon/{id}', 'Web\AdController@single');
Route::get('/my-elon', 'Web\AdController@myElon');
Route::get('/add-elon', 'Web\AdController@addElon');
Route::post('/add-elon', 'Web\AdController@createElon');
Route::post('/update-elon', 'Web\AdController@updateElonPost');
Route::post('/remove-elon', 'Web\AdController@removeElon');
Route::get('/elon_cat/{id}', 'Web\AdController@loadByCatElon');
Route::get('/edit-elon/{id}', 'Web\AdController@editElon');

//Admin Ads
Route::get('/elon-manage', 'Web\AdController@indexAdm');
Route::post('/change-active-elon', 'Web\AdController@changeActiveElon');
Route::post('/remove-elon-adm', 'Web\AdController@removeAdmElon');

Route::get('/elon-manage/category', 'Web\AdController@indexAdmCat');
Route::post('/elon-cat-cancel', 'Web\AdController@cancelEditCat');
Route::post('/elon-cat-save', 'Web\AdController@saveEditCat');
Route::post('/elon-cat-remove', 'Web\AdController@removeCategory');
Route::post('/elon-cat-create', 'Web\AdController@createCategory');



//Faqs
Route::get('/faq', 'Web\FaqController@index');
//Faqs admin
Route::get('/faq-manage', 'Web\FaqController@indexAdm');
Route::get('/faq-manage/add', 'Web\FaqController@addFaqPage');
Route::get('/faq-manage/category', 'Web\FaqController@catFaqPage');
Route::get('/faq-manage/edit/{id}', 'Web\FaqController@editFaqPage');
Route::post('/remove-faq', 'Web\FaqController@removeAdmFaq');
Route::post('/create-faq', 'Web\FaqController@createFaq');
Route::post('/edit-faq', 'Web\FaqController@saveEditedFaq');
Route::post('/faq-cat-create', 'Web\FaqController@createFaqCat');
Route::post('/remove-faq-cat', 'Web\FaqController@removeFaqCat');
Route::post('/faq-cat-cancel', 'Web\FaqController@cancelFaqCat');
Route::post('/faq-cat-save', 'Web\FaqController@saveFaqCat');

//Notice
Route::post('/notice', 'Web\NoticeController@getOne');
Route::post('/delete-notice', 'Web\NoticeController@deleteNotice');
Route::post('/create-notice', 'Web\NoticeController@createNotice');
Route::post('/update-notice', 'Web\NoticeController@updateNotice');
Route::post('/filter-notice', 'Web\NoticeController@filterNotice');
Route::get('/edit-notice/{id}', 'Web\NoticeController@editNotice');
Route::get('/notice-manage', 'Web\NoticeController@index');
Route::get('/notice/{id}', 'Web\NoticeController@single');



//Faculty
Route::get('/faculties-manage', 'Web\FacultController@index');
Route::get('/faculty/{id}', 'Web\FacultController@cafedra');


Route::post('/create-facult', 'Web\FacultController@createFac');
Route::post('/update-facult', 'Web\FacultController@updateFac');
Route::get('/remove-facult/{id}', 'Web\FacultController@removeFac');
Route::post('/create-cafedra', 'Web\FacultController@createCaf');
Route::post('/update-cafedra', 'Web\FacultController@updateCaf');
Route::get('/remove-cafedra/{id}', 'Web\FacultController@removeCaf');
