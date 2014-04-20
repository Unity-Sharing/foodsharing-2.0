<?php
class vFormTimetable extends vFormElement
{	
	public function __construct($id,$value = array(),$options = array())
	{
		if(empty($value))
		{
			$value = array();
		}
		
		parent::__construct($id,$value,$options);
		
		addJsFunc('
			function addtime'.$this->id.'(daystr,dow,start,end)
			{
				length = $("#'.$this->id.'-times .dow-" + dow).length;
				hidden = \'<input type="hidden" name="'.$this->id.'[\'+dow+\'][\'+length+\'][0]" value="\'+start+\'">\';
				hidden += \'<input type="hidden" name="'.$this->id.'[\'+dow+\'][\'+length+\'][1]" value="\'+end+\'">\';		
				$("#'.$this->id.'-times").append(\'<tr class="dow-\'+dow+\'"><td>\'+hidden+daystr+\'</td><td>\'+start+\'</td><td>\'+end+\'</td><td style="text-align:right;"><button onclick="$(this).parent().parent().remove();" class="btn btn-default btn-table" type="button"><span class="glyphicon glyphicon-remove btn-xs"></span></button></td></tr>\');
			}
		');
		
		addJs('
			$("#'.$this->id.'-table").css("width",$("#'.$this->id.'-ingroup").width()+"px");
			$("#'.$this->id.'-add").click(function(){
				if($("#'.$this->id.'-dow").val() == -1)
				{
					error("'.T::jsSafe(s('please_choose_day')).'");
					return false;
				}
				else
				{
					addtime'.$this->id.'($("#'.$this->id.'-dow option:selected").text(),$("#'.$this->id.'-dow").val(),$("#'.$this->id.'-time-from").val(),$("#'.$this->id.'-time-to").val());
				}
			});
		');
		
	}
	
	public function render()
	{

		if(!empty($this->value) && is_array($this->value))
		{

			foreach ($this->value as $dow => $times)
			{
				foreach ($times as $t)
				{
					$from = T::preZero($t['from'][0]).':'.T::preZero($t['from'][1]);
					$to = T::preZero($t['to'][0]).':'.T::preZero($t['to'][1]);
	
					
					addJs('
					addtime'.$this->id.'(\''.T::jsSafe(s('dow_'.(int)$dow)).'\','.(int)$dow.',"'.$from.'","'.$to.'")
				');
				}
			}
		}
		
		$out = '
			<div id="'.$this->id.'-ingroup" class="input-group">
			  <select id="'.$this->id.'-dow" style="width:150px" class="form-control">
				<option value="-1">'.s('choose_day').'</option>
			  	<option value="1">'.s('dow_1').'</option>
			  	<option value="2">'.s('dow_2').'</option>
			  	<option value="3">'.s('dow_3').'</option>
			  	<option value="4">'.s('dow_4').'</option>
			  	<option value="5">'.s('dow_5').'</option>
			  	<option value="6">'.s('dow_6').'</option>
			  	<option value="0">'.s('dow_0').'</option>
			  </select>
			  <select id="'.$this->id.'-time-from" style="width:85px" class="form-control"><option value="0">'.s('time_from').'</option><option>00:00</option><option>00:15</option><option>00:30</option><option>00:45</option><option>01:00</option><option>01:15</option><option>01:30</option><option>01:45</option><option>02:00</option><option>02:15</option><option>02:30</option><option>02:45</option><option>03:00</option><option>03:15</option><option>03:30</option><option>03:45</option><option>04:00</option><option>04:15</option><option>04:30</option><option>04:45</option><option>05:00</option><option>05:15</option><option>05:30</option><option>05:45</option><option>06:00</option><option>06:15</option><option>06:30</option><option>06:45</option><option>07:00</option><option>07:15</option><option>07:30</option><option>07:45</option><option>08:00</option><option>08:15</option><option>08:30</option><option>08:45</option><option selected="selected">09:00</option><option>09:15</option><option>09:30</option><option>09:45</option><option>10:00</option><option>10:15</option><option>10:30</option><option>10:45</option><option>11:00</option><option>11:15</option><option>11:30</option><option>11:45</option><option>12:00</option><option>12:15</option><option>12:30</option><option>12:45</option><option>13:00</option><option>13:15</option><option>13:30</option><option>13:45</option><option>14:00</option><option>14:15</option><option>14:30</option><option>14:45</option><option>15:00</option><option>15:15</option><option>15:30</option><option>15:45</option><option>16:00</option><option>16:15</option><option>16:30</option><option>16:45</option><option>17:00</option><option>17:15</option><option>17:30</option><option>17:45</option><option>18:00</option><option>18:15</option><option>18:30</option><option>18:45</option><option>19:00</option><option>19:15</option><option>19:30</option><option>19:45</option><option>20:00</option><option>20:15</option><option>20:30</option><option>20:45</option><option>21:00</option><option>21:15</option><option>21:30</option><option>21:45</option><option>22:00</option><option>22:15</option><option>22:30</option><option>22:45</option><option>23:00</option><option>23:15</option><option>23:30</option><option>23:45</option></select>
			  <select id="'.$this->id.'-time-to" style="width:85px" class="form-control"><option value="0">'.s('time_to').'</option><option>00:00</option><option>00:15</option><option>00:30</option><option>00:45</option><option>01:00</option><option>01:15</option><option>01:30</option><option>01:45</option><option>02:00</option><option>02:15</option><option>02:30</option><option>02:45</option><option>03:00</option><option>03:15</option><option>03:30</option><option>03:45</option><option>04:00</option><option>04:15</option><option>04:30</option><option>04:45</option><option>05:00</option><option>05:15</option><option>05:30</option><option>05:45</option><option>06:00</option><option>06:15</option><option>06:30</option><option>06:45</option><option>07:00</option><option>07:15</option><option>07:30</option><option>07:45</option><option>08:00</option><option>08:15</option><option>08:30</option><option>08:45</option><option>09:00</option><option>09:15</option><option>09:30</option><option>09:45</option><option>10:00</option><option>10:15</option><option>10:30</option><option>10:45</option><option>11:00</option><option>11:15</option><option>11:30</option><option>11:45</option><option>12:00</option><option>12:15</option><option>12:30</option><option>12:45</option><option>13:00</option><option>13:15</option><option>13:30</option><option>13:45</option><option selected="selected">14:00</option><option>14:15</option><option>14:30</option><option>14:45</option><option>15:00</option><option>15:15</option><option>15:30</option><option>15:45</option><option>16:00</option><option>16:15</option><option>16:30</option><option>16:45</option><option>17:00</option><option>17:15</option><option>17:30</option><option>17:45</option><option>18:00</option><option>18:15</option><option>18:30</option><option>18:45</option><option>19:00</option><option>19:15</option><option>19:30</option><option>19:45</option><option>20:00</option><option>20:15</option><option>20:30</option><option>20:45</option><option>21:00</option><option>21:15</option><option>21:30</option><option>21:45</option><option>22:00</option><option>22:15</option><option>22:30</option><option>22:45</option><option>23:00</option><option>23:15</option><option>23:30</option><option>23:45</option></select>
			  <span class="input-group-btn pull-left">
		        <button id="'.$this->id.'-add" class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus-sign"></span></button>
		      </span>
			</div>
		<table class="table" id="'.$this->id.'-table">
			<thead>
	          <tr>
	            <th>'.s('day_of_week').'</th>
	            <th>'.s('start').'</th>
	            <th>'.s('end').'</th>
	            <th style="text-align:right;width:30px;">#</th>
	          </tr>
	        </thead>
	        <tbody id="'.$this->id.'-times">
	        	
	        </tbody>
		</table>';
		
		
		return $this->wrapper($out);
	}
}