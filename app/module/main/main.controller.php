<?php
class MainController extends Controller
{
	private $db;
	private $view;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->db = new MainDb();
		$this->view = new MainView();
	}
	
	public function actionIndex()
	{
		
		$location = new mLocation();
		$location->setName('Spielplatz');
		$location->setLoc(45.23, 9.42);
		$location->setStreet('Ferdinandstraße');
		$location->setZip('50969');
		$location->setCity('Jerusalem');
		
		//print_r($location->toMongo());
		
		$this->setContent($this->view->index());
	}
}