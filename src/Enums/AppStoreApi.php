<?php

namespace AppStoreLibrary\Enums;

use AppStoreLibrary\Enums\ServerNotifications\Environment;

enum AppStoreApi: string
{
    /**
     * Docs: https://developer.apple.com/documentation/appstoreserverapi
     * Manage customers’ App Store transactions
     */
    case AppStoreServer = 'appstoreserverapi';
    /**
     * Docs: https://developer.apple.com/documentation/appstoreconnectapi
     * Automate the tasks you perform on the Apple Developer website and in App Store Connect.
     */
    case AppStoreConnect = 'appstoreconnectapi';

    /**
     * @throws \Exception
     */
    public function getHost(Environment $environment): string
    {
        return match ($this) {
            self::AppStoreServer => $environment === Environment::Production
                ? 'https://api.storekit.itunes.apple.com'
                : 'https://api.storekit-sandbox.itunes.apple.com',
            self::AppStoreConnect => 'https://api.appstoreconnect.apple.com',
        };
    }
}
