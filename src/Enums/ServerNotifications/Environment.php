<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * The server environment, either sandbox or production.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/environment
 */
enum Environment: string
{
    /** Indicates that the notification applies to testing in the sandbox environment. */
    case Sandbox = 'Sandbox';
    /** Indicates that the notification applies to the production environment. */
    case Production = 'Production';
}
