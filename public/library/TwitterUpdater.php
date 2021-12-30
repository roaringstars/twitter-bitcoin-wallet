<?php

namespace App\Library;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterUpdater
{
    private TwitterOAuth $twitter;

    public function __construct()
    {
        $this->twitter = new TwitterOAuth(
            $_ENV['TWITTER_OAUTH_CONSUMER_API_KEY'],
            $_ENV['TWITTER_OAUTH_CONSUMER_API_SECRET_KEY'],
            $_ENV['BOT_OAUTH_TOKEN'],
            $_ENV['BOT_OAUTH_TOKEN_SECRET']
        );
    }

    /**
     * Update Profile Full Name
     */
    public function updateProfileName(string $newProfileName): bool
    {
        $changeName = $this->twitter->post('account/update_profile', [
            'name' => $newProfileName,
        ]);
        return (is_object($changeName) && property_exists($changeName, 'errors') === false);
    }

    /**
     * Update Profile Banner
     */
    public function updateProfileBannerBlob(string $blob): bool
    {
        $imageBase64 = base64_encode($blob);
        $changeBanner = $this->twitter->post('account/update_profile_banner', [
            'banner' => $imageBase64,
        ]);
        return (is_object($changeBanner) && property_exists($changeBanner, 'errors') === false);
    }
}
