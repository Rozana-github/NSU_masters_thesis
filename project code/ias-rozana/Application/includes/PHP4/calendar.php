<?PHP
include "Library/SessionValidate.php";
include "Library/dbconnect.php";
//include "Library/Library.php";

/*      CSTruter PHP Calendar Control version 1.0
      Author: Christoff Truter

      Date Created: 3 November 2006
      Last Update: 12 November 2006

      e-Mail: christoff@cstruter.com
      Website: www.cstruter.com
      Copyright 2006 CSTruter                        */


include_once("controls.php");

class Calendar extends Controls
{
      /*private*/ var $year;            // Current Selected Year
      /*private*/ var $month;            // Current Selected Month
      /*private*/ var $day;            // Current Selected Day
      /*private*/ var $output;      // Contains the Rendered Calendar
      /*private*/ var $date;            // Contains the date preset via Constructor
      /*public*/  var $redirect;        // Page to redirect to when a specific date is selected
      /*public*/  var $inForm;          // Use Object in a form

      // Styles used - referenced from CSS - with their default values assigned

      /*public*/ var $currentDateStyle = "currentDate";            // Style for current date
      /*public*/ var $selectedDateStyle = "selectedDate";            // Style for selected dates
      /*public*/ var $normalDateStyle = "normalDate";                  // Style for unselected dates
      /*public*/ var $navigateStyle = "navigateYear";                  // Style used in navigation "buttons"
      /*public*/ var $monthStyle = "month";                        // Style used to display month
      /*public*/ var $daysOfTheWeekStyle = "daysOfTheWeek";           // Styles used to display sun-mon

      

      // Constructor - Assign an unique ID to your instantiated object, if needed. Date Format = YYYY-MM-DD

      /*public*/ function Calendar($ID, $Date = NULL)
      {
             $this->ID = $ID."_";
            $this->date = isset($Date) ? $Date : NULL;

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

      /*private*/ function SetDate()
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


      /*public*/ function Value()
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

      //Fetch Data from Database
      function LoadDataInCalender($qDay,$qMonth,$qYear)
      {
            $qDate=$qYear."-".$qMonth."-".$qDay;
            
            $query="SELECT
                        mas_order_planed.order_object_id,
                        if( mas_order_planed.status =0, 'Planed', 'Cnceled' ) AS STATUS ,
                        mas_order.job_no,
                        a.qty,mas_order.order_unit
                  FROM
                        mas_order_planed
                        LEFT JOIN mas_order ON mas_order.order_object_id = mas_order_planed.order_object_id
                        left join (select order_object_id, sum(trn_order_description.order_quntity) as qty from trn_order_description group by trn_order_description.order_object_id  ) as a on a.order_object_id=mas_order.order_object_id
                  where
                       mas_order_planed.planed_date  ='".$qDate."'
                  ";
             //echo $query."<br>";
            $rset = mysql_query($query) or die(mysql_error());
            
            if(mysql_num_rows($rset) > 0)
            {
                  return $rset;
            }
            else 
                  return false;
      }
      
      // Render the calendar, and add it to a variable - needed for placing the object in a specific area in our output buffer

      /*public*/
      function Output()
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
            else{ $this->output = ''; }

            $NavUrls = $this->UrlParams($this->UID('year').','.$this->UID('month').','.$this->UID('Day'));

            $this->output.= '
                              <table width="100%" class="calendar">
                              <tr>
                                    <td class="'.$this->navigateStyle.'">
                                          <a id="'.$this->UID('navigateback').'" class="'.$this->navigateStyle.'" href="'.$_SERVER['PHP_SELF'].
                                                '?'.$this->UID('month').'='.($this->month-1).'&'.$this->UID('year').'='.$this->year.$NavUrls.'">
                                          <</a>
                                    </td>
                                    <td id="'.$this->UID('Month').'" colspan="5" class="'.$this->monthStyle.'">
                                                <font color="#fcfcfc"><b>'.date("F", mktime(0, 0, 0, $this->month, 1, $this->year)).'&nbsp;'.$this->year.'</b></font>
                                    </td>
                                    <td class="'.$this->navigateStyle.'">
                                          <a id="'.$this->UID('navigatenext').'" class="'.$this->navigateStyle.'" href="'.$_SERVER['PHP_SELF'].'?'.$this->UID('month').'='.($this->month+1).'&'.$this->UID('year').'='.$this->year.$NavUrls.'">></a>
                                    </td>
                              </tr>
                              <tr class="'.$this->daysOfTheWeekStyle.'">
                                    <td align="center" width="15%">Sun</td>
                                    <td align="center" width="14%">Mon</td>
                                    <td align="center" width="14%">Tue</td>
                                    <td align="center" width="14%">Wen</td>
                                    <td align="center" width="14%">Thu</td>
                                    <td align="center" width="14%">Fri</td>
                                    <td align="center" width="15%">Sat</td>
                              </tr>';
      
                  for ($Week=0; $Week<6; $Week++)
                  {
                  $this->output.= '<tr valign="top">';
                    
                  for ($Day=0; $Day<7; $Day++)
                  {
                              $days++;
                              $dDay = $days - $first_spaces;
                        
                              $CellID = $this->UID('item['.$days.']');
                              $qday=explode("-",$qDate);
                              
                              
                              
                              if ($days > $first_spaces && ($dDay) < $total_days  + 1) 
                              {
                                    $LinkID = $this->UID('hlink['.$days.']');
                                    $currentSelectedDay = '
                                          <td align="center" height="100%" valign="top">
                                          <table width="100%" border="1" height="100%" valign="top">
                                          <tr valign="top">
                                                <td valign="top" bgcolor="#F1F1F1" align="center" id="'.$CellID.'" class="'.$this->selectedDateStyle.'" height="20">
                                                <a id="'.$LinkID.'" class="'.$this->selectedDateStyle.'"';
                                    
                                    $CurrentDate = isset($_REQUEST[$currentday]) ? $_REQUEST[$currentday]: '';
                              
                                    if ($CurrentDate == $dDay)      
                                    {
                                          $this->output.= $currentSelectedDay;
                                    }

                                    else
                                    {
                                          $this->output.='
                                          <td align="center" height="100%" valign="top">
                                          <table width="100%" border="1" align="center" valign="top" height="100%">
                                          <tr valign="top">
                                          <td valign="top" bgcolor="#F1F1F1" height="20" align="center" id="'.$CellID.'" class='; 
                                          $this->output.= ($dDay==date("j") && $this->year==date("Y") && $this->month==date("n")) ? 
                                                '"'.$this->currentDateStyle.'" >
                                                <a id="'.$LinkID.'" class="'.$this->currentDateStyle.'"' : '"'.$this->normalDateStyle.'">
                                                <a id="'.$LinkID.'" class="'.$this->normalDateStyle.'"';                                    
                                    }

                                    //------------- Calling the Load Data Function and Drawing a table with the fetched data into the cells of Calender----------
                                    
                                    if($dDay > 0)
                                    {
                                          $this_day=$dDay;
                                          $tempTable = '';
                                          if($outStr = $this->LoadDataInCalender($this_day,$this->month,$this->year))
                                          {
                                                
                                                $tempTable.='<table border="0" width="100%" height="" valign="top" bgcolor="#99CCFF">';

                                                while($row=mysql_fetch_array($outStr))
                                                {
                                                     $n="";
                                                      extract($row);
                                                     // $orderunit=pick("mas_unit","unitdesc","unitid=$order_unit");

                                                      $n=$n.$job_no." ".$qty." $orderunit<br>".$STATUS."<br>";
                                                      $tempTable.='
                                                                        <tr>
                                                                              <td valign="top" onClick="printorder('.$order_object_id.')" style="cursor: hand;" ><font size="3">'.$n.'</font></td>

                                                                        </tr>
                                                      ';

                                                }


                                                $tempTable.='</table>';
                                          }
                                    }
                                    //-----------------------------------------------------------------------------------------------------------------------------------------------------

                                    $this->output.= 'href="rptactionplanBottom.php?cboDay='.$dDay.'&cboMonth='.$this->month.'&cboYear='.$this->year.$this->UrlParams($currentday).'">'.$dDay.'</a>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td align="center" valign="top">&nbsp;'.$tempTable.'
                                                </td>
                                          </tr>
                                          </table>
                                          </td>';
                              }
                              else
                              {
                                    //------------- Calling the Load Data Function and Drawing a table with the fetched data into the cells of Calender ----------
                                    
                                    if($dDay > 0)
                                    {
                                          $this_day=$dDay;
                                          $tempTable = '';
                                          if($outStr = $this->LoadDataInCalender($this_day,$this->month,$this->year) != false)
                                          {
                                                
                                                $tempTable.='<table border="0" width="100%" height="" valign="top">';
                                                
                                                while($row=mysql_fetch_array($outStr))
                                                {
                                                extract($row);
                                                $tempTable.='
                                                                        <tr valign="top">
                                                                              <td valign="top"><font size="1">'.$n.'</font></td>
                                                                              <td valign="top"><font size="1">'.$d.'</font></td>
                                                                        </tr>
                                                      ';
                                                }
                                                $tempTable.='</table>';
                                          }
                                    }
                                    //------------------------------------------------------------------------------------------------------------------------------------------------------
                                    $this->output.='
                                          <td align="center">
                                          <table width="100%" border="1" align="center" valign="top">
                                          <tr>
                                                <td align="center" id="'.$CellID.'" class="'.$this->normalDateStyle.'">
                                                &nbsp;
                                                </td height="30%">
                                          </tr>
                                          <tr valign="top">
                                                <td align="center" valign="top">
                                                &nbsp;
                                                '.$tempTable.'
                                                </td>
                                          </tr>
                                          </table>
                                          </td>
                                          '."\n";
                              }
                        }

                        $this->output.="</tr>";
              }

            $this->output.= '</table>';

            return $this->output;
      }
}

?>


