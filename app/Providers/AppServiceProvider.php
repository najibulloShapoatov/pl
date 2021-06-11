<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Model\User;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Model\Notice;
use App\Model\NoticeResult;
use App\Model\SiteCustomization;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Schema::defaultStringLength(191); //NEW: Increase StringLength

        // frontend
        View::composer('*', function ($view) {


            // user info
            $userData = [];
			// user info
            $user = new User();




            if(!empty(Auth::user())) {
                 $userData = $user->getByID(Auth::user()->id);

            }



            $S_Customize = new SiteCustomization();
            $Infodata = $S_Customize->getListAdm();


            $notice = new Notice();
            $notices = [];
            $notice_res_user = [];
            $n_count = 0;
            if (Auth::check()){
                $notices = $notice->getByRole(Auth::user()->role_id);

                $n_count = count($notices);

                $notice_Res = new NoticeResult();
                $notice_res_user = $notice_Res->getByUserID(Auth::user()->id);
                foreach ($notices as $item){
                    $n_count -= $notice_Res->checkNotice(Auth::user()->id, $item->id);
                }

            }


//{{ $userInfo->email }}

            $view->with([
                'userInfo' => $userData,
                'sts' => 0,
                'Infodata'=>$Infodata,
                'notices'=>$notices,
                'n_count'=>$n_count,
                'notice_res_user'=>$notice_res_user,
            ]);

        });
    }
}
