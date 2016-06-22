<?php

	require_once __DIR__ . '/vendor/autoload.php';

	/**
	* @var \RemoteWebDriver
	*/
	class WP_Inspector extends PHPUnit_Framework_TestCase
	{

		public $TempDirPath = 'screenshots/';

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

	    protected $url = 'https://12southmusic.com';

	    //remove http from our url
	    protected function site_name(){
	     
	     	$site_name = preg_replace('#^https?://#', '', $this->url);

	     	return $site_name;

     	}

	    public function testGitHubHome()
	    {
	        $this->webDriver->get($this->url);
	        // checking that page title contains word 'GitHub'
	        //$this->assertContains('reddit', $this->webDriver->getTitle());

	        $this->TakeScreenshot();
	    }

	    public function test_date(){

	    	//I'm doing it this way to make sure I use the same format everywhere, also so it will be easy to change if I ever decide

	    	return date('m\_d\-_y\_h:i:s');

	    }

	    public function TakeScreenshot($element=null) {

	    		if (!file_exists($this->TempDirPath)) {

	    			//Check for our temp dir
	    			//Maybe timestamp these by month later?
	    			mkdir($this->TempDirPath);
	    		
	    		}

	           // Change the Path to your own settings
	           $screenshot = $this->TempDirPath . $this->test_date() . '_' . $this->site_name() . ".png";

	           // Change the driver instance
	           $this->webDriver->takeScreenshot($screenshot);
	           if(!file_exists($screenshot)) {
	               throw new Exception('Could not save screenshot');
	           }

	           if( ! (bool) $element) {
	               return $screenshot;
	           }

	           $element_width = $element->getSize()->getWidth();
	           $element_height = $element->getSize()->getHeight();

	           $element_src_x = $element->getLocation()->getX();
	           $element_src_y = $element->getLocation()->getY();

	           // Create image instances
	           $src = imagecreatefrompng($screenshot);
	           $dest = imagecreatetruecolor($element_width, $element_height);

	           // Copy
	           imagecopy($dest, $src, 0, 0, $element_src_x, $element_src_y, $element_width, $element_height);

	           imagepng($dest, $screenshot);

	           // unlink($screenshot); // unlink function might be restricted in mac os x.

	           if( ! file_exists($screenshot)) {
	               throw new Exception('Could not save element screenshot');
	           }

	           return $screenshot;
	       }

	}

?>