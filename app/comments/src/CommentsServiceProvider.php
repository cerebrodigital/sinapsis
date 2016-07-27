<?php



namespace Hazzard\Comments;

use Hazzard\Comments\Author\Author;
use Hazzard\Comments\Support\Akismet;
use Hazzard\Comments\Comments\Comment;
use Illuminate\Support\ServiceProvider;
use Hazzard\Comments\Comments\Moderator;
use Hazzard\Comments\Formatter\Formatter;
use Hazzard\Comments\Events\CommentWasPosted;
use Hazzard\Comments\Settings\Repository as Settings;
use Hazzard\Comments\Events\BroadcastCommentWasPosted;
use Hazzard\Comments\Listeners\SendCommentNotification;

class CommentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'comments');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'comments');

        $this->publishes([
            __DIR__.'/../config/comments.php' => config_path('comments.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
           __DIR__.'/../public/css' => public_path('vendor/comments/css'),
           __DIR__.'/../public/js'  => public_path('vendor/comments/js'),
           __DIR__.'/../public/img' => public_path('vendor/comments/img'),
       ], 'public');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/comments.php', 'comments');

        $this->registerComments();

        $this->registerFormatter();

        $this->registerSettings();

        $this->registerModerator();

        $this->registerAuthor();
    }

    /**
     * Register the comments.
     *
     * @return void
     */
    protected function registerComments()
    {
        $this->app->singleton('comments', function ($app) {
            $config = $app['comments.settings']->config();

            if (! isset($config['comments.user_model'])) {
               $app['config']['comments.user_model'] = $this->getUserModel();
            }

            $app['config']['comments.captcha_required'] = $this->captchaRequired();

            $this->setUid();

            $this->registerListeners();

            Comment::setFormatter($app['comments.formatter']);

            return $app['config']['comments'];
        });
    }

    /**
     * Register the comment author.
     *
     * @return void
     */
    protected function registerAuthor()
    {
        $this->app->singleton(Author::class, function ($app) {
            $attributes = [];

            if ($app['auth']->check()) {
                $attributes = $app['auth']->user()->getAuthor();
                $attributes['guest'] = false;
            }

            return new Author($attributes);
        });

        $this->app->alias(Author::class, 'comments.author');
    }

    /**
     * Register the comment moderator.
     *
     * @return void
     */
    protected function registerModerator()
    {
        $this->app->singleton(Moderator::class, function ($app) {
            $config = $app['comments.settings']->config();

            $moderator = new Moderator($config);

            if ($config['akismet']) {
                $moderator->setAkismet($this->getAkismet());
            }

            return $moderator;
        });

        $this->app->alias(Moderator::class, 'comments.moderator');
    }

    /**
     * Register the content formatter.
     *
     * @return void
    */
    protected function registerFormatter()
    {
        $this->app->singleton(Formatter::class, function ($app) {
            return new Formatter($app['config']['comments'], $app['cache.store']);
        });

        $this->app->alias(Formatter::class, 'comments.formatter');
    }

    /**
     * Register the database settings repository.
     *
     * @return void
     */
    protected function registerSettings()
    {
        $this->app->singleton(Settings::class, function ($app) {
            $settings = new Settings(
                $app['db']->connection(), $app['config'], $app['cache.store']
            );

            $settings->load();

            return $settings;
        });

        $this->app->alias(Settings::class, 'comments.settings');
    }

    /**
     * Register the event listeners.
     *
     * @return void
     */
    protected function registerListeners()
    {
        $this->app['events']->listen(CommentWasPosted::class, SendCommentNotification::class);

        if ($this->app['config']['comments.real_time']) {
            $this->app['events']->listen(CommentWasPosted::class, function(CommentWasPosted $event) {
                if ($event->comment->status == Comment::APPROVED) {
                    $this->app['events']->fire(new BroadcastCommentWasPosted($event->comment));
                }
            });
        }
    }

    /**
     * Get a new Akismet instance.
     *
     * @return \Hazzard\Comments\Support\Akismet
     */
    protected function getAkismet()
    {
        $url = $this->app['config']['app.url'];
        $key = $this->app['config']['services.akismet_key'];

        return (new Akismet($key))->setBlogUrl($url);
    }

    /**
     * @param  string $key
     * @return void
     */
    protected function setUid($key = 'comments_uid')
    {
        if (! $this->app['session']->has($key)) {
            $this->app['session']->put($key, str_random());
        }
    }
    /**
     * Check if captcha is required.
     *
     * @return bool
     */
    protected function captchaRequired()
    {
        $level = $this->app['config']['comments.captcha'];

        if ($level === 1 && $this->app['comments.author']->guest()) {
            return true;
        } elseif ($level === 2 && ! $this->app['comments.author']->guest()) {
            return true;
        } elseif ($level === 3) {
            return true;
        }

        return false;
    }

    /**
     * Get user model name.
     *
     * @return string
     */
    protected function getUserModel()
    {
        $provider = $this->app['auth']->getProvider();

        return get_class($provider->createModel());
    }
}
