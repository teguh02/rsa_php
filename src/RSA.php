<?php

namespace Teguh02\RsaPhp;

class RSA {
    # Key Generation
    // Fungsi untuk menghitung nilai gcd (Greatest Common Divisor)
    static function gcd($a, $b) {
        while ($b != 0) {
            $t = $b;
            $b = $a % $b;
            $a = $t;
        }
        return $a;
    }
    
    // Fungsi untuk menghitung nilai invers modular
    static function modInverse($a, $m) {
        $m0 = $m;
        $y = 0;
        $x = 1;
        if ($m == 1)
            return 0;
        while ($a > 1) {
            $q = intval($a / $m);
            $t = $m;
            $m = $a % $m;
            $a = $t;
            $t = $y;
            $y = $x - $q * $y;
            $x = $t;
        }
        if ($x < 0)
            $x += $m0;
        return $x;
    }
    
    // Fungsi untuk menghasilkan kunci RSA
    static function generateKeys($p, $q) {
        // Hitung nilai n = p * q
        $n = $p * $q;
    
        // Hitung nilai phi = (p-1) * (q-1)
        $phi = ($p - 1) * ($q - 1);
    
        // Pilih nilai e yang relatif prima terhadap phi dan lebih kecil dari phi
        $e = 3;
        while (self::gcd($e, $phi) != 1) {
            $e += 2;
        }
    
        // Hitung nilai d yang merupakan invers modular dari e modulo phi
        $d = self::modInverse($e, $phi);
    
        // Kunci publik (e, n) dan kunci privat (d, n)
        return array("public" => array($e, $n), "private" => array($d, $n));
    }

    # Encryption and Decryption
    // Fungsi untuk enkripsi pesan
    static function encrypt($plaintext, $publicKey) {
        list($e, $n) = $publicKey['public'];
        // Ubah setiap karakter dalam plaintext menjadi nilai ASCII, lalu enkripsi dengan rumus c = m^e mod n
        $encrypted = array();
        for ($i = 0; $i < strlen($plaintext); $i++) {
            $m = ord($plaintext[$i]);
            $c = bcpowmod($m, $e, $n);
            array_push($encrypted, $c);
        }
        return $encrypted;
    }

    // Fungsi untuk dekripsi pesan
    static function decrypt($ciphertext, $privateKey) { 
        // cek apakah $ciphertext adalah text 
        if (is_string($ciphertext)) {
            // cek apakah $ciphertext adalah text yang berisi koma dan spasi
            if (strpos($ciphertext, ', ') !== false) {
                $ciphertext = explode(', ', $ciphertext);
            } else {
                $ciphertext = explode(',', $ciphertext);
            }

            // Konversi nilai dari string ke integer array
            $ciphertext = array_map('intval', $ciphertext);
        }

        list($d, $n) = $privateKey['private'];
        // Dekripsi setiap nilai dalam ciphertext dengan rumus m = c^d mod n, lalu ubah kembali menjadi karakter ASCII
        $decrypted = "";
        foreach ($ciphertext as $c) {
            $m = bcpowmod($c, $d, $n);
            $decrypted .= chr($m);
        }
        return $decrypted;
    }
}