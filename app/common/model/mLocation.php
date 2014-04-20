<?php
/**
 * Class to Structure each Location Object in Foodsharing Application
 * at the Moment the first Testing Class how we handle Mongo Models
 * 
 * @author Raphael Wintrich
 *
 */
class mLocation extends Model implements ModelInterface
{
	private $name;
	private $loc;
	private $zip;
	private $city;
	private $street;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function toMongo()
	{
		return array(
			'name' => $this->getName(),
			'loc' => $this->getLoc(),
			'zip' => $this->getLoc(),
			'city' => $this->getCity(),
			'street' => $this->getStreet()
		);
	}
	
	public function loadMongo($document)
	{
		$this->setName($document['name']);
		$this->setLoc($document['loc'][0], $document['loc'][1]);
		$this->setZip($document['zip']);
		$this->setCity($document['city']);
		$this->setStreet($document['street']);
	}

    /**
     * name
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * name
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * loc
     * @return Array
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * loc
     * @param Double $loc
     */
    public function setLoc($lat,$lng)
    {
        $this->loc = array($lat,$lng);
    }

    /**
     * zip
     * @return String
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * zip
     * @param String $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * city
     * @return String
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * city
     * @param String $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * street
     * @return String
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * street
     * @param String $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

}