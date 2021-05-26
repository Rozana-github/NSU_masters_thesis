<?PHPPHP

/*	CSTruter PHP Calendar Control version 1.0
	Author: Christoff Truter

	Date Created: 3 November 2006
	Last Update: 12 November 2006

	e-Mail: christoff@cstruter.com
	Website: www.cstruter.com
	Copyright 2006 CSTruter				*/


include_once("controls.php");

class Calendar extends Controls
{
	private $year;		// Current Selected Year
	private $month;		// Current Selected Month
	private $day;		// Current Selected Day
	private $output;	// Contains the Rendered Calendar
	private $date;		// Contains the date preset via Constructor
	public  $redirect;  	// Page to redirect to when a specific date is selected
	public  $inForm;    	// Use Object in a form

	// Styles used - referenced from CSS - with their default values assigned

	public $currentDateStyle = "currentDate";		// Style for current date
	public $selectedDateStyle = "selectedDate";		// Style for selected dates
	public $normalDateStyle = "normalDate";			// Style for unselected dates
	public $navigateStyle = "navigateYear";			// Style used in navigation "buttons"
	public $monthStyle = "month";				// Style used to display month
	public $daysOfTheWeekStyle = "daysOfTheWeek";		// Styles used to display sun-mon
	

	// Constructor - Assign an unique ID to your instantiated object, if needed. Date Format = YYYY-MM-DD

	public function Calendar($ID, $Date = NULL)
	{
 		$this->ID = $ID."_";
		$this->date = isset($Date) ? $Date: NULL;

		if (isset($_REQUEST[$this->UID('year')]))
		{
			$this->year = $_REQUEST[$this->UID('year')];
			$this->month = $_REQUEST[$this->UID('month')];
			$this->day = $_REQUEST[$this->UID('Day')];
		}
		else
		{
			if (isset($Date))
			{
				$DateComponents = explode("-",$Date);
				$this->year = $DateComponents[0];
				$this->month = $DateComponents[1];
				$this->day = isset($_REQUEST[$this->UID('Day')]) ? $_REQUEST[$this->UID('Day')] : $DateComponents[2];
			}
			else
			{
				$this->year = date("Y");
				$this->month = date("n");
				$this->day = date("j");
			}
		}
	}

	// Sets the current Month and Year for the instantiated object

	private function SetDate()
	{		
		if ($this->month > 12) 
		{
			$this->month=1;
			$this->year++;
		}

		if ($this->month < 1) 
		{
			$this->month=12;
			$this->year--;
		}

		if ($this->year > 2037) $this->year = 2037;
		if ($this->year < 1971) $this->year = 1971;
	}


	public function Value()
	{
		$returnValue="";

		if (isset($_REQUEST[$this->UID('Day')]))
		{
			$returnValue = isset($this->day) ? $this->year.'-'.$this->month.'-'.$_REQUEST[$this->UID('Day')]: '';
		}
		else if (isset($_REQUEST[$this->UID('calendar')]))
		{
			$returnValue = $_REQUEST[$this->UID('calendar')];
		}
		else if (isset($this->date))
		{
			$returnValue = isset($this->day) ? $this->year.'-'.$this->month.'-'.$this->day: '';
		}
	
		return $returnValue;
	}

	// Render the calendar, and add it to a variable - needed for placing the object in a specific area in our output buffer

	public function Output()
	{
		$days = 0;
		$this->redirect = isset($this->redirect) ? $this->redirect: $_SERVER['PHP_SELF'] ;
		$this->SetDate();
		$total_days = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
		$first_spaces = date("w", mktime(0, 0, 0, $this->month, 1, $this->year));
		$currentday = $this->UID('Day');

		if (isset($this->inForm))
		{
			$CObjID = $this->UID('calendar');
			$DateString = ($this->Value()) ? '","'.$this->Value() : '';
			$this->output = '<script language="javascript">'."\n".'var '.$CObjID.' = new Calendar("'.$this->ID.$DateString.'");'."\n"
			.$CObjID.'.currentDateStyle = "'.$this->currentDateStyle.'";'."\n"
			.$CObjID.'.selectedDateStyle = "'.$this->selectedDateStyle.'";'."\n"
			.$CObjID.'.normalDateStyle = "'.$this->normalDateStyle.'";'."\n"
			.$CObjID.'.setStyles();'."\n"
			.'</script>'."\n"
			.'<input type="hidden" id="'.$CObjID.'" name="'.$CObjID.'" value="'.$this->Value().'"/>'."\n";
		}
		else $this->output = '';		

		$NavUrls = $this->UrlParams($this->UID('year').','.$this->UID('month').','.$this->UID('Day'));

		$this->output.= '<table class="calendar"><tr><td class="'.$this->navigateStyle.'"><a id="'.$this->UID('navigateback').'" class="'.$this->navigateStyle.'" href="'.$_SERVER['PHP_SELF'].
			'?'.$this->UID('month').'='.($this->month-1).'&'.$this->UID('year').'='.$this->year.$NavUrls.'"><</a>
		    </td><td id="'.$this->UID('Month').'" colspan="5" class="'.$this->monthStyle.'">'.date("F", mktime(0, 0, 0, $this->month, 1, $this->year)).'&nbsp;'.$this->year.'
		    </td><td class="'.$this->navigateStyle.'"><a id="'.$this->UID('navigatenext').'" class="'.$this->navigateStyle.'" href="'.$_SERVER['PHP_SELF'].'?'.$this->UID('month').'='.($this->month+1).'&'.$this->UID('year').'='.$this->year.$NavUrls.'">></a>
		    </td></tr><tr class="'.$this->daysOfTheWeekStyle.'"><td>S</td><td>M</td><td>T</td><td>W</td><td>T</td><td>F</td><td>S</td></tr>';
	
        	for ($Week=0;$Week<6;$Week++)
        	{
            	$this->output.= '<tr>';
		        
				for ($Day=0;$Day<7;$Day++)
            	{      
					$days++;
					$dDay = $days - $first_spaces;

					$CellID = $this->UID('item['.$days.']');

					if ($days > $first_spaces && ($dDay) < $total_days  + 1) 
					{
						$LinkID = $this->UID('hlink['.$days.']');
						$currentSelectedDay = '<td id="'.$CellID.'" class="'.$this->selectedDateStyle.'"><a id="'.$LinkID.'" class="'.$this->selectedDateStyle.'"';
						$CurrentDate = isset($_REQUEST[$currentday]) ? $_REQUEST[$currentday]: '';

						if ($CurrentDate == $dDay)	$this->output.= $currentSelectedDay;
						else
						{
							$this->output.='<td id="'.$CellID.'" class=';
							$this->output.= ($dDay==date("j") && $this->year==date("Y") && $this->month==date("n")) ? 
								'"'.$this->currentDateStyle.'"><a id="'.$LinkID.'" class="'.$this->currentDateStyle.'"' : 
								'"'.$this->normalDateStyle.'"><a id="'.$LinkID.'" class="'.$this->normalDateStyle.'"';						
						}

						$this->output.= 'href="'.$this->redirect.'?'.$currentday.'='.$dDay.$this->UrlParams($currentday).'">'.$dDay.'</a></td>';

					}
					else
					{
						$this->output.='<td id="'.$CellID.'" class="'.$this->normalDateStyle.'"></td>'."\n";
					}
				}

				$this->output.="</tr>";
        	}

		$this->output.= '</table>';

		return $this->output;
	}
}

?>