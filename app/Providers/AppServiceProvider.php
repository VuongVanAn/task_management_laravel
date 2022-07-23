<?php

namespace App\Providers;

use App\Repositories\Attachment\AttachmentRepository;
use App\Repositories\Attachment\IAttachmentRepository;
use App\Repositories\Board\BoardRepository;
use App\Repositories\Board\IBoardRepository;
use App\Repositories\CheckList\CheckListRepository;
use App\Repositories\CheckList\ICheckListRepository;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\ICommentRepository;
use App\Repositories\Lists\IListsRepository;
use App\Repositories\Lists\ListsRepository;
use App\Repositories\ShareData\IShareDataRepository;
use App\Repositories\ShareData\ShareDataRepository;
use App\Repositories\Task\ITaskRepository;
use App\Repositories\Task\TaskRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            IAttachmentRepository::class,
            AttachmentRepository::class
        );

        $this->app->singleton(
            IBoardRepository::class,
            BoardRepository::class
        );

        $this->app->singleton(
            ICheckListRepository::class,
            CheckListRepository::class
        );

        $this->app->singleton(
            ICommentRepository::class,
            CommentRepository::class
        );

        $this->app->singleton(
            IListsRepository::class,
            ListsRepository::class
        );

        $this->app->singleton(
            ITaskRepository::class,
            TaskRepository::class
        );

        $this->app->singleton(
            IUserRepository::class,
            UserRepository::class
        );

        $this->app->singleton(
            IShareDataRepository::class,
            ShareDataRepository::class
        );
    }
}
