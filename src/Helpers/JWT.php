<?php

namespace AppStoreLibrary\Helpers;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class JWT
{
    private static bool $unsafeMode = false;

    /**
     * Turn on/off check sign verification
     *
     * @param  bool  $isEnabled
     * @return void
     */
    public static function unsafeMode(bool $isEnabled = true): void
    {
        self::$unsafeMode = $isEnabled;
    }

    /**
     * @return array Decoded payload
     * @throws \Exception
     */
    public static function parse(string $jwt): array
    {
        $parts = explode('.', $jwt);

        [$headersJson, $payloadJson, $signature] = array_map(fn($part) => FirebaseJWT::urlsafeB64Decode($part), $parts);
        if (!$headersJson || !$payloadJson || !$signature) {
            throw new \Exception('JWT could not be decoded');
        }

        $payload = json_decode($payloadJson, associative: true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Payload JSON could not be decoded');
        }

        if (self::$unsafeMode) {
            return $payload;
        }

        $header = FirebaseJWT::jsonDecode($headersJson);
        $publicKey = join("\n", [
            '-----BEGIN CERTIFICATE-----',
            trim(chunk_split($header->x5c[0], 64)),
            '-----END CERTIFICATE-----',
        ]);
        FirebaseJWT::decode($jwt, new Key($publicKey, $header->alg));
        return $payload;
    }
}
