<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Facades\App\Services\Notifications;
use Facades\App\Services\HMessage;
use Auth;
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('layouts.coordinator.include.navigation', function ($view) {
            $notifications = Notifications::UnreadForCoordinator(Auth::user()->id);
            $messages = HMessage::All();
            // $unreadNotifications = Notifications::Unread(Auth::user()->id);
            // $allNotifications = Notifications::All(Auth::user()->id);
            $view->with('notifications', $notifications)->with('messages', $messages["messages"])->with('unseen', $messages["unseen"]);
            //$view->with('unreadNotifications', $unreadNotifications)->with('allNotifications', $allNotifications);
        });
        view()->composer('layouts.client.include.navigation', function ($view) {
            $notifications = Notifications::Unread(Auth::user()->id);
            $messages = HMessage::All();
            // $unreadNotifications = Notifications::Unread(Auth::user()->id);
            // $allNotifications = Notifications::All(Auth::user()->id);
            $view->with('notifications', $notifications)->with('messages', $messages["messages"])->with('unseen', $messages["unseen"]);
            //$view->with('unreadNotifications', $unreadNotifications)->with('allNotifications', $allNotifications);
        });
        view()->composer('layouts.worker.include.navigation', function ($view) {
            $notifications = Notifications::Unread(Auth::user()->id);
            $messages = HMessage::All();
            // $unreadNotifications = Notifications::Unread(Auth::user()->id);
            // $allNotifications = Notifications::All(Auth::user()->id);
            $view->with('notifications', $notifications)->with('messages', $messages["messages"])->with('unseen', $messages["unseen"]);
            //$view->with('unreadNotifications', $unreadNotifications)->with('allNotifications', $allNotifications);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
