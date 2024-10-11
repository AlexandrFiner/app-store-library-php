<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * The platform on which the customer consumed the in-app purchase.
 * @link https://developer.apple.com/documentation/appstoreserverapi/platform
 */
enum Platform: int
{
    /** The platform is undeclared. Use this value to avoid providing information for this field. */
    case Undeclared = 0;
    /** An Apple platform. */
    case Apple = 1;
    /** Non-Apple platform. */
    case NonApple = 2;
}
