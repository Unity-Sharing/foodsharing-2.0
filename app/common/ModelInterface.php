<?php
/**
 * Interface that we will ever privide methods to get the 
 * Mondo Document of an Object
 * 
 * @author Raphael Wintrich
 *
 */
interface ModelInterface
{
	/**
	 * each Model needs a way to transform all Data in Mongo specific array
	 * therefore is the toMongo Function
	 */
	public function toMongo();
	
	/**
	 * Give the model an Document and map it to an Object
	 * 
	 * @param MongoDocument $document
	 */
	public function loadMongo($document);
}