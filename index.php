<?php

	require_once __DIR__ . '/vendor/autoload.php';

	class GitHubTest extends PHPUnit_Framework_TestCase {

	    /**
	     * @var \RemoteWebDriver
	     */
	    protected $webDriver;

		public function setUp()
	    {



	        $capabilities = array(\Facebook\WebDriver\Remote\WebDriverCapabilityType::BROWSER_NAME => 'chrome');
	        $this->webDriver = Facebook\WebDriver\Remote\RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
	    }

	    protected $url = 'https://github.com';

	    public function testGitHubHome()
	    {
	        $this->webDriver->get($this->url);
	        // checking that page title contains word 'GitHub'
	        $this->assertContains('GitHub', $this->webDriver->getTitle());
	    }    

	}

?>