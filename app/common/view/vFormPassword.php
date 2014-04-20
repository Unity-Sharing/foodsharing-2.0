<?php
class vFormPassword
{
	public $attributes;
	private $passwordfield;
	private $retypefield;
	
	public function __construct($id, $value = '', $option = array())
	{
		$this->passwordfield = new vFormText($id,$value,$option);
		$this->retypefield = new vFormText($id.'-retype');
		
		$this->passwordfield->setPassword();
		$this->retypefield->setPassword();
		
		$this->retypefield->addChecker(s('passwords_not_equal'), 'equal:#'.$this->passwordfield->getId());
		$this->retypefield->addChecker(sv('password_must_between',array('from'=>5,'to'=>10)),'between:5:10','#'.$this->retypefield->getId().',#'.$this->passwordfield->getId());
		addJs('
					
		');
		
	}
	
	public function getChecker()
	{
		return $this->retypefield->getChecker();
	}
	
	public function render()
	{		
		$out = '';
		
		$out .= $this->passwordfield->render();
		$out .= $this->retypefield->render();
		
		return $out;
	}
}