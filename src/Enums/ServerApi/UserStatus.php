<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * The status of a customer’s account within your app.
 * @link https://developer.apple.com/documentation/appstoreserverapi/userstatus
 */
enum UserStatus: int
{
    /** Account status is undeclared. Use this value to avoid providing information for this field. */
    case Undeclared = 0;
    /** The customer’s account is active. */
    case Active = 1;
    /** The customer’s account is suspended. */
    case Suspended = 2;
    /** The customer’s account is terminated. */
    case Terminated = 3;
    /** The customer’s account has limited access. */
    case LimitedAccess = 4;
}
