<?php

namespace App\Tests\Context\Common\Context;

use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;
use DMore\ChromeDriver\ChromeDriver;

trait CommonContextTrait
{
    /**
     * @return Session
     */
    abstract function getSession($name = null);

    /** @throws \Exception */
    protected function spins($closure, $seconds = 5, $fraction = 4)
    {
        $max = $seconds * $fraction;
        $i = 1;
        while ($i++ <= $max) {
            if ($closure($this)) {
                return true;
            }
            $this->getSession()->wait(1000 / $fraction);
        }

        $backtrace = debug_backtrace();
        throw new \Exception(
            sprintf("Timeout thrown by %s::%s()\n%s, line %s",
                $backtrace[0]['class'], $backtrace[0]['function'],
                $backtrace[0]['file'], $backtrace[0]['line']
            )
        );
    }

    public function takeAScreenshot($kernelProjectDir, $prefix = 'screenshot')
    {
        if ($this->supportsJavaScript()) {
            $content = $this->getSession()->getScreenshot();
            $extension = '.jpg';
        } else {
            $content = $this->getSession()->getPage()->getOuterHtml();
            $extension = '.html';
        }

        $baseName = sprintf('%s-%s.%s', $prefix, microtime(), $extension);
        $basePath = $this->resolveBasePath();

        file_put_contents(sprintf('%s/%s', $basePath, $baseName), $content);
    }

    private function supportsJavaScript()
    {
        return
            $this->getSession()->getDriver() instanceof Selenium2Driver ||
            $this->getSession()->getDriver() instanceof ChromeDriver;
    }

    private function resolveBasePath()
    {
        $basePath = sprintf('%s/var/log/test/screenshots', $this->kernelProjectDir);
        if (!is_dir($basePath)) {
            mkdir($basePath, 0700, true);
        }
        return $basePath;
    }
}