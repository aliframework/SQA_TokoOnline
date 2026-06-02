<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

class SystemTest extends TestCase
{
    private $driver;
    private $baseUrl = 'http://localhost:8000';

    protected function setUp(): void
    {
        $host = 'http://localhost:9515';

        $capabilities = DesiredCapabilities::microsoftEdge();

        $this->driver = RemoteWebDriver::create(
            $host,
            $capabilities
        );
    }

    public function testHomepageAndSearchFeature()
    {
        // Buka aplikasi
        $this->driver->get($this->baseUrl);

        // Validasi halaman memuat teks toko
        $bodyText = $this->driver
            ->findElement(WebDriverBy::tagName('body'))
            ->getText();

        $this->assertStringContainsString(
            'Toko Online',
            $bodyText
        );

        // Cari produk
        $searchBox = $this->driver
            ->findElement(WebDriverBy::name('cari'));

        $searchBox->clear();
        $searchBox->sendKeys('Kemeja');
        $searchBox->submit();

        // Validasi hasil pencarian
        $updatedBodyText = $this->driver
            ->findElement(WebDriverBy::tagName('body'))
            ->getText();

        $this->assertStringContainsString(
            'Kemeja Flanel',
            $updatedBodyText
        );
    }

    protected function tearDown(): void
    {
        if ($this->driver) {
            $this->driver->quit();
        }
    }
}