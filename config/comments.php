<?php

return [

    /*
    |==========================================================================
    | GENERAL
    |==========================================================================
    */

    /*
    |--------------------------------------------------------------------------
    | Guest Users
    |--------------------------------------------------------------------------
    |
    | Specify if guest users can leave comments.
    |
    */

    'guest' => true,


    /*
    |--------------------------------------------------------------------------
    | Votes
    |--------------------------------------------------------------------------
    |
    | Specify if authenticated users can vote.
    |
    */

    'votes' => true,

    /*
    |--------------------------------------------------------------------------
    | Replies
    |--------------------------------------------------------------------------
    |
    | Specify if comment replies are allowed.
    |
    */

    'replies' => true,

    /*
    |--------------------------------------------------------------------------
    | Real Time
    |--------------------------------------------------------------------------
    |
    | Specify if you want real time updating comments.
    | Make sure have a broadcast driver configured.
    |
    */

    'real_time' => false,

    /*
    |--------------------------------------------------------------------------
    | Editing
    |--------------------------------------------------------------------------
    |
    | Specify if authenticated users can edit their comments.
    |
    | false   - Users can't edit comments.
    | true    - Users cant edit comments anytime.
    | numeric - Users can edit comments for the sepecified number of seconds.
    |
    */

    'edit' => 120,

    /*
    |--------------------------------------------------------------------------
    | Maximum Comment Length
    |--------------------------------------------------------------------------
    |
    | Specify the maximum comment length. To disable set null.
    |
    */

    'max_length' => 500,

    /*
    |--------------------------------------------------------------------------
    | Comments Per Page
    |--------------------------------------------------------------------------
    |
    | Specify the number of comments to be displayed per page.
    |
    */

    'per_page' => 15,

    /*
    |--------------------------------------------------------------------------
    | Default Comment Sort
    |--------------------------------------------------------------------------
    |
    | 1 - Newest first
    | 2 - Oldest first
    | 3 - Best first
    |
    */

    'default_sort' => 1,

    /*
    |--------------------------------------------------------------------------
    | Default Avatar Imageset
    |--------------------------------------------------------------------------
    |
    | Specify the default imageset to use for avatars.
    | Supported: "404", "mm", "identicon", "monsterid", "wavatar"
    |
    */

    'default_gravatar' => 'wavatar',

    /*
    |==========================================================================
    | FORMATTING
    |==========================================================================
    |
    | http://docs.hazzardweb.com/ajax-comment-system-laravel/master/formatting
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Emoticons
    |--------------------------------------------------------------------------
    |
    | Specify if you want to enable emoticons.
    |
    */

    'emoticons' => true,

    /*
    |--------------------------------------------------------------------------
    | BBCodes
    |--------------------------------------------------------------------------
    |
    | Specify if comments should be parsed as BBCode tags.
    | https://en.wikipedia.org/wiki/BBCode
    |
    */

    'bbcodes' => true,

    /*
    |--------------------------------------------------------------------------
    | Markdown (Litedown)
    |--------------------------------------------------------------------------
    |
    | Specify if comments should be parsed as Markdown.
    |
    */

    'markdown' => false,

    /*
    |--------------------------------------------------------------------------
    | Auto Link
    |--------------------------------------------------------------------------
    |
    | Specify if plain-text URLs should be converted into clickable links.
    |
    */

    'auto_link' => true,

    /*
    |--------------------------------------------------------------------------
    | Auto Email
    |--------------------------------------------------------------------------
    |
    | Specify if plain-text emails should be converted into clickable links.
    |
    */

    'auto_email' => true,

    /*
    |--------------------------------------------------------------------------
    | Auto Image
    |--------------------------------------------------------------------------
    |
    | Specify if plain-text image URLs should be converted into actual images.
    |
    */

    'auto_image' => true,

    /*
    |--------------------------------------------------------------------------
    | Media Embed
    |--------------------------------------------------------------------------
    |
    | Specify if content from media sites should be embedded.
    | http://s9etextformatter.readthedocs.org/Plugins/MediaEmbed/Sites/
    |
    */

    'media_embed' => true,

    /*
    |==========================================================================
    | Moderation
    |==========================================================================
    */

    /*
    |--------------------------------------------------------------------------
    | Moderation
    |--------------------------------------------------------------------------
    |
    | Here you may specify if all comments should be approved.
    |
    */

    'moderation' => false,

    /*
    |--------------------------------------------------------------------------
    | Akismet Spam Detection
    |--------------------------------------------------------------------------
    |
    | Here you may enable Akismet for spam detection.
    | Make sure to set the akismet_key in config/services.php.
    | https://akismet.com/account
    |
    */

    'akismet' => false,

    /*
    |--------------------------------------------------------------------------
    | Moderation Keys
    |--------------------------------------------------------------------------
    |
    | When a comment contains any of these words in its content, name, URL,
    | e-mail, or IP, it will be held in the moderation queue.
    |
    */

    'moderation_keys' => [],

    /*
    |--------------------------------------------------------------------------
    | Blacklist Keys
    |--------------------------------------------------------------------------
    |
    | When a comment contains any of these words in its content, name, URL,
    | e-mail, or IP, it will be marked as spam.
    |
    */

    'blacklist_keys' => [],

    /*
    |--------------------------------------------------------------------------
    | Duplicate Detection
    |--------------------------------------------------------------------------
    |
    | If enabled, duplicate comments on the same page and user are not allowed.
    |
    */

    'duplicate' => true,

    /*
    |--------------------------------------------------------------------------
    | Maximum Pending
    |--------------------------------------------------------------------------
    |
    | Block comments form users that have to many unapproved comments.
    | To disable set null.
    |
    */

    'max_pending' => null,

    /*
    |--------------------------------------------------------------------------
    | Maximum Links
    |--------------------------------------------------------------------------
    |
    | Here you may specify if comments that contains too many links should be
    | hold in the moderation queue. To disable set null.
    |
    */

    'max_links' => null,

    /*
    |--------------------------------------------------------------------------
    | Censored Words
    |--------------------------------------------------------------------------
    |
    | Specify if and what words should be censored.
    |
    */

    'censor' => false,

    'censored_words' => [],

    /*
    |==========================================================================
    | Protection
    |==========================================================================
    */

    /*
    |--------------------------------------------------------------------------
    | Captcha
    |--------------------------------------------------------------------------
    |
    | Specify for which users captcha is enabled.
    |
    | 1 - Guest users | 2 - Logged in users | 3 - All users | false - None
    |
    | Make sure reCAPTCHA is configured!
    | http://docs.hazzardweb.com/ajax-comment-system-laravel/master/configuration
    |
    */

    'captcha' => false,

    /*
    |--------------------------------------------------------------------------
    | Throttle Comment Posts
    |--------------------------------------------------------------------------
    |
    | Specify if you want to throttle for comment posts,
    | the maximum number of comment post attempts for delaying further attempts
    | and the number of seconds to delay further comment post attempts.
    |
    */

    'throttle' => false,
    'throttle_max_attempts' => 5,
    'throttle_lockout_time' => 60,

    /*
    |==========================================================================
    | Notifications
    |==========================================================================
    */

    /*
    |--------------------------------------------------------------------------
    | Admin Email
    |--------------------------------------------------------------------------
    |
    | An email address to which notifications will be sent
    | when a new comment is posted. Spam won't be reported.
    |
    */

    'admin_email' => null,

    /*
    |--------------------------------------------------------------------------
    | Reply Email
    |--------------------------------------------------------------------------
    |
    | Specify if users should be notified when their comments receive replies.
    |
    */

    'reply_email' => false,

];