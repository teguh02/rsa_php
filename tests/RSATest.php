<?php

// import autoload
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

// Import the RSA module
use Teguh02\RsaPhp\RSA;

class RSATest extends TestCase
{
    // Define p and q for testing
    private const P = 61;
    private const Q = 53;
    private const MESSAGE = "I LOVE YOU";
    private const ENCRYPTED = '286,2774,83,913,1781,155,2774,206,913,2509';

    /**
     * Test RSA key generation.
     */
    public function testKeyGeneration()
    {
        $keys = RSA::generateKeys(self::P, self::Q);

        // Assert that both public and private keys are generated
        $this->assertArrayHasKey('public', $keys);
        $this->assertArrayHasKey('private', $keys);
        $this->assertCount(2, $keys['public']);
        $this->assertCount(2, $keys['private']);
    }

    /**
     * Test RSA encryption process.
     */
    public function testEncryption()
    {
        $keys = RSA::generateKeys(self::P, self::Q);

        // Encrypt the message using the public key
        $encrypted = RSA::encrypt(self::MESSAGE, $keys);
        $encryptedString = join(",", $encrypted);

        // Assert that the encrypted message is not empty
        $this->assertNotEmpty($encryptedString);

        // Assert that the encrypted message is equal to the expected value
        $this->assertEquals(self::ENCRYPTED, $encryptedString);
    }

    /**
     * Test RSA decryption process.
     */
    public function testDecryption()
    {
        $keys = RSA::generateKeys(self::P, self::Q);

        // Decrypt the message using the private key
        $decrypted = RSA::decrypt(self::ENCRYPTED, $keys);

        // Assert that the decrypted message is not empty
        $this->assertNotEmpty($decrypted);

        // Assert that the decrypted message is equal to the original message
        $this->assertEquals(self::MESSAGE, $decrypted);
    }
}
?>
