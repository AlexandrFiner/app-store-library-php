<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * The success or error information the App Store server records when it attempts
 * to send an App Store server notification to your server.
 * @link https://developer.apple.com/documentation/appstoreserverapi/sendattemptresult
 */
enum SendAttemptResult: string
{
    /** The App Store server received a success response when it sent the notification to your server. */
    case Success = 'SUCCESS';
    /** The App Store server detected a continual redirect. Check your server’s redirects for a circular redirect loop. */
    case CircularRedirect = 'CIRCULAR_REDIRECT';
    /** The App Store server received an invalid response from your server. */
    case InvalidResponse = 'INVALID_RESPONSE';
    /** The App Store server didn’t receive a valid HTTP response from your server. */
    case NoResponse = 'NO_RESPONSE';
    /** Another error occurred that prevented your server from receiving the notification. */
    case Other = 'OTHER';
    /** The App Store server’s connection to your server was closed while the send was in progress. */
    case PrematureClose = 'PREMATURE_CLOSE';
    /** A network error caused the notification attempt to fail. */
    case SocketIssue = 'SOCKET_ISSUE';
    /** The App Store server didn’t get a response from your server and timed out. Check that your server isn’t processing messages in line. */
    case TimedOut = 'TIMED_OUT';
    /** The App Store server couldn’t establish a TLS session or validate your certificate. Check that your server has a valid certificate and supports Transport Layer Security (TLS) protocol 1.2 or later. */
    case TlsIssue = 'TLS_ISSUE';
    /** The App Store server didn’t receive an HTTP 200 response from your server. */
    case UnsuccessfulHttpResponseCode = 'UNSUCCESSFUL_HTTP_RESPONSE_CODE';
    /** The App Store server doesn’t support the supplied charset. */
    case UnsupportedCharset = 'UNSUPPORTED_CHARSET';
}
