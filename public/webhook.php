<?php

/**
 * This is the main file you can put on LNPay web hook
 *
 * So your name will be update each time people send some sats to your address.
 */

// required connection
require_once 'config/app.php';

// load module
use App\Library\TwitterUpdater;
use App\Library\WalletChecker;
use App\Library\BannerCreator;


/**
 * Get Balance
 */
$checker = new WalletChecker();
$balance = $checker->getFormattedBalance();

/**
 * Generate Banner
 */
$bannerCreator = new BannerCreator();
$banner = $bannerCreator->generateBanner($balance);

/**
 * Update the Profile name & Banner
 */
$updater = new TwitterUpdater();
$updater->updateProfileName($balance);
$updater->updateProfileBannerBlob($banner);
