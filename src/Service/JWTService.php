<?php

namespace App\Service;

use DateTimeImmutable;

class JWTService
{
    /**
     * On génère le token vie le site "jwt.io"
     *
     * @param array $header
     * @param array $payload
     * @param string $secret
     * @param integer $validity = 10800 (10800 secondes = 3heures, le temps de validité du token)
     * @return string
     */
    public function generate(array $header, array $payload, string $secret, int $validity = 10800): string
    {
        // On met tt cela dans la condition, pour éviter d'écraser les token
        if ($validity > 0) {
            // maintenant
            $now = new DateTimeImmutable();

            //expiration de la validité
            $exp = $now->getTimestamp() + $validity;

            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $exp;
        }

        // On encode en base64 car "JSON TOKEN" encodage en base64
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        // On "nettoie" les valeurs encodées (retrait des +, /, et =)
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        // On génère la signature et pour cela il faut un secret
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);

        $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        // On créé le token 
        $jwt = $base64Header . '.' . $base64Payload . '.' . $base64Signature;

        return $jwt;
    }

    // On vérifie que le token soit valide (correctement formé) mais donc pas valide en terme de contenu
    public function isValid(string $token): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }

    // On récupère pour cela le "Payload" (méthode "get" ici car on récupère ou on lit les données sans les modifier)
    public function getPayload(string $token): array
    {
        // On démonte le token 
        $array = explode('.', $token);

        // On décode le Payload
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }

    // On récupère pour cela le "header" 
    public function getHeader(string $token): array
    {
        // On démonte le token 
        $array = explode('.', $token);

        // On décode le Header (et non le Payload)
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    // On vérifie si le token a expiré (si on renvoie "true" => expiré)
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $now = new DateTimeImmutable();

        return $payload['exp'] < $now->getTimestamp();
    }

    // On vérifie la signature du token
    public function check(string $token, string $secret)
    {
        // On récupère le header et le payload
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // On va régénérer un token de la même façon mais on vérifie la signature
        // On va donc régénérer un nouveau "token" sans ajouter la validité
        $verifToken = $this->generate($header, $payload, $secret, 0);

        // On compare uniquement les deux premières parties du token et la signature
        $parts = explode('.', $token);
        $verifParts = explode('.', $verifToken);

        // si mon token a la même signature et le même contenu ==> pas corrompu
        return $parts[2] === $verifParts[2];
    }
}
