<?php 
class vSteps extends vCore
{
	private $id;
	private $steps;	
	private $jsfinish;
	
	public function __construct()
	{
		$this->id = $this->id('wizard');
		$this->steps = array();
		$this->jsfinish = '';
	}
	
	public function addStep($content,$title = false)
	{
		if(!$title)
		{
			$title = s('step_'.(count($this->steps)+1));
		}
		
		$this->steps[] = array(
			'title' => $title,
			'content' => $content
		);
	}
	
	/**
	 * give me js code to execute after finish the wizard
	 * can use variables:
	 * - event
	 * - index
	 * @param unknown $jscode
	 */
	public function jsFinish($jscode)
	{
		$this->jsfinish = $jscode;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function render()
	{
		addJs('
			$("#'.$this->id.'").steps({
				transitionEffect: "slideLeft",
				enableAllSteps: true,
				onFinished: function(event, index){
					'.$this->jsfinish.'
				},
				showFinishButtonAlways: true,
				labels: {
					next: \''.s('next').'\',
					previous: \''.s('previous').'\',
					finish: \''.s('finish').'\'
				}
			});
		');
		
		$out = '';
		
		foreach ($this->steps as $step)
		{
			$out .= '
			<h1>'.$step['title'].'</h1>
			<div>
				'.$step['content'].'
			</div>';
		}
		
		return '
		<div id="'.$this->id.'">
			'.$out.'
		</div>';
	}
}