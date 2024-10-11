<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * A value that indicates the amount of time that the customer used the app.
 * @link https://developer.apple.com/documentation/appstoreserverapi/playtime
 */
enum PlayTime: int
{
    /** The engagement time is undeclared. Use this value to avoid providing information for this field. */
    case Undeclared = 0;
    /** The engagement time is between 0–5 minutes. */
    case UptoFiveMinutes = 1;
    /** The engagement time is between 5–60 minutes. */
    case UptoHour = 2;
    /** The engagement time is between 1–6 hours. */
    case UptoSixHours = 3;
    /** The engagement time is between 6–24 hours. */
    case UptoDay = 4;
    /** The engagement time is between 1–4 days. */
    case UptoFourDays = 5;
    /** The engagement time is between 4–16 days. */
    case UptoSixteenDays = 6;
    /** The engagement time is over 16 days. */
    case MoreSixteenDays = 7;
}
