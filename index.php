<?php

	require_once __DIR__ . '/vendor/autoload.php';

	/**
	* @var \RemoteWebDriver
	*/
	class WP_Inspector extends PHPUnit_Framework_TestCase
	{

		protected $webDriver;
		
		public function __construct()
		{
			echo "Building our Inspector";
		}

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

	        $this->TakeScreenshot();
	    }

	    public function TakeScreenshot($element=null) {
	           // Change the Path to your own settings
	           $screenshot = "screenshot.png";

	           // Change the driver instance
	           $this->webDriver->takeScreenshot($screenshot);
	           if(!file_exists($screenshot)) {
	               throw new Exception('Could not save screenshot');
	           }

	           if( ! (bool) $element) {
	               return $screenshot;
	           }

	           $element_screenshot = "screenshot.png"; // Change the path here as well

	           $element_width = $element->getSize()->getWidth();
	           $element_height = $element->getSize()->getHeight();

	           $element_src_x = $element->getLocation()->getX();
	           $element_src_y = $element->getLocation()->getY();

	           // Create image instances
	           $src = imagecreatefrompng($screenshot);
	           $dest = imagecreatetruecolor($element_width, $element_height);

	           // Copy
	           imagecopy($dest, $src, 0, 0, $element_src_x, $element_src_y, $element_width, $element_height);

	           imagepng($dest, $element_screenshot);

	           // unlink($screenshot); // unlink function might be restricted in mac os x.

	           if( ! file_exists($element_screenshot)) {
	               throw new Exception('Could not save element screenshot');
	           }

	           return $element_screenshot;
	       }

	}

?>