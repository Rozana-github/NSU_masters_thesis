<?PHP

function InWords($tamount,$currency)
{

/* Method Developer Name: Faisal Ahmed
   Date of Development: 27th August 2005*/

 //echo $tamount."<br>";
 //echo $currency."<br>";

 $cur = $currency;

 $ar = array(
              0 => "",
              1 => "One",
              2 => "Two",
              3 => "Three",
              4 => "Four",
              5 => "Five",
              6 => "Six",
              7 => "Seven",
              8 => "Eight",
              9 => "Nine",
              10 => "Ten",
              11 => "Eleven",
              12 => "Twelve",
              13 => "Thirteen",
              14 => "Fourteen",
              15 => "Fifteen",
              16 => "Sixteen",
              17 => "Seventeen",
              18 => "Eighteen",
              19 => "Nineteen",
              20 => "Twenty",
              30 => "Thirty",
              40 => "Forty",
              50 => "Fifty",
              60 => "Sixty",
              70 => "Seventy",
              80 => "Eighty",
              90 => "Ninety"
            );


   settype($tamount,"string");

   $tamount = strtok($tamount,'.');

   $damount = strtok('.');

   //echo $tamount."<br>";
   //echo $damount."<br>";


   if(strlen($tamount)>7)
   {
     $amount  = substr($tamount,strlen($amount)-7,7);
     $lamount = substr($tamount,0,strlen($tamount)-strlen($amount));
   }
   else
     $amount = $tamount;


   $n = array();

   $zcount=0;

   for($i=0;$i<strlen($amount);$i++)
   {
     if(substr($amount,$i,1)=="0")
           $zcount++;
     else break;
   }

   //echo strval($zcount);

   if($zcount!=0)
    $amount = substr($amount,$zcount,strlen($amount)-$zcount);

   for($i=0;$i<strlen($amount);$i++)
   {
     $n[$i] = substr($amount,$i,1);
   }

   $num = $amount;

   if(strlen($amount)==1)
    {
      settype($num,"integer");

      $res = $ar[$num];

    }
   else if(strlen($amount)==2)
   {
      settype($num,"integer");

      if($num <= 20)
       {
       $res = $ar[$num];
       }
      else
      {
       settype($n[1],"integer");
       settype($n[0],"integer");

      if($n[1]==0)
       $res = $ar[$n[0]*10];
      else
        $res = $ar[$n[0]*10]." ".$ar[$n[1]];
       }
   }
   else if(strlen($amount)==3)
   {

    $part = substr($amount,1,2);
    settype($part,"integer");

    for($i=0;$i<3;$i++)
       settype($n[$i],"integer");

    if($n[2]==0 && $n[1]==0)
       $res = $ar[$n[0]]." Hundred";
    else if($n[1]==0 && $n[2]!=0)
       $res = $ar[$n[0]]." Hundred and ".$ar[$n[2]];
    else if($part<20)
       $res = $ar[$n[0]]." Hundred and ".$ar[$n[1]*10+$n[2]];
    else
       $res = $ar[$n[0]]." Hundred and ".$ar[$n[1]*10]." ".$ar[$n[2]];

   }
  else if(strlen($amount)==4 || strlen($amount)==5)
   {
     for($i=0;$i<strlen($amount);$i++)
         settype($n[$i],"integer");

     if(strlen($amount)==4)
      {
       $part = substr($amount,2,2);
       settype($part,"integer");


       if($n[3]==0 && $n[2]==0 && $n[1]==0)
            $res = $ar[$n[0]]." Thousand";
       else if($n[3]==0 && $n[2]==0)
             $res = $ar[$n[0]]." Thousand ".$ar[$n[1]]." Hundred";
       else if($part<20)
             if($n[1]==0)
               $res = $ar[$n[0]]." Thousand and ".$ar[$n[2]*10+$n[3]];
            else
               $ar[$n[0]]." Thousand ".$ar[$n[1]]." Hundred and ".$ar[$n[2]*10+$n[3]];

       else if($part>=20)
           if($n[1]==0)
                $res = $ar[$n[0]]." Thousand and ".$ar[$n[2]*10]." ".$ar[$n[3]];
           else
                $res = $ar[$n[0]]." Thousand ".$ar[$n[1]]." Hundred and ".$ar[$n[2]*10]." ".$ar[$n[3]];
      }

     else
       {
         $lpart = substr($amount,3,2);
         settype($lpart,"integer");

         $mpart = substr($amount,0,2);
         settype($mpart,"integer");


         if($n[4]==0 && $n[3]==0 && $n[2]==0 && $n[1]==0)
            $res = $ar[$n[0]*10]." Thousand";
         else if($n[4]==0 && $n[3]==0 && $n[2]==0)
           if($mpart<20)
                $res = $ar[$n[0]*10+$n[1]]." Thousand";
            else
                $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Thousand";
         else if($n[4]==0 && $n[3]==0)
              if($mpart<20)
                  $res = $ar[$n[0]*10+$n[1]]." Thousand and ".$ar[$n[2]]." Hundred";
              else
                  $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Thousand and ".$ar[$n[2]]." Hundred";

         else if($lpart < 20)
             {
               if($mpart<20)
                  if($n[2]==0)
                     $res = $ar[$n[0]*10+$n[1]]." Thousand and ".$ar[$n[3]*10+$n[4]];
                  else
                     $res = $ar[$n[0]*10+$n[1]]." Thousand ".$ar[$n[2]]." Hundred and ".$ar[$n[3]*10+$n[4]];
               else
                 if($n[2]==0)
                      $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Thousand and ".$ar[$n[3]*10+$n[4]];
                 else
                      $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Thousand ".$ar[$n[2]]." Hundred and ".$ar[$n[3]*10+$n[4]];
               }
         else
            {
              if($mpart<20)
                  if($n[2]==0)
                     $res = $ar[$n[0]*10+$n[1]]." Thousand and ".$ar[$n[3]*10]." ".$ar[$n[4]];
                  else
                     $res = $ar[$n[0]*10+$n[1]]." Thousand ".$ar[$n[2]]." Hundred and ".$ar[$n[3]*10]." ".$ar[$n[4]];
               else
                 if($n[2]==0)
                      $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Thousand and ".$ar[$n[3]*10]." ".$ar[$n[4]];
                 else
                      $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Thousand ".$ar[$n[2]]." Hundred and ".$ar[$n[3]*10]." ".$ar[$n[4]];
            }

        }

     }
   else if(strlen($amount)==6 || strlen($amount)==7)
      {

        for($i=0;$i<strlen($amount);$i++)
        {
           settype($n[$i],"integer");
           //echo $n[$i].",";
        }



        if(strlen($amount)==6)
        {
           $lpart = substr($amount,4,2);
           settype($lpart,"integer");

           $mpart = substr($amount,1,2);
           settype($mpart,"integer");

           //echo "mpart: ".$mpart;
           //echo "lpart: ".$lpart;
           if($n[5]==0 && $n[4]==0 && $n[3]==0 && $n[2]==0 && $n[1]==0)
              $res = $ar[$n[0]]." Lakh";
           else if($n[5]==0 && $n[4]==0 && $n[3]==0 && $n[2]==0)
              $res = $ar[$n[0]]." Lakh and ".$ar[$n[1]*10]." Thousand";
           else if($n[5]==0 && $n[4]==0 && $n[3]==0)
               if($mpart < 20)
                 $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10+$n[2]]." Thousand";
               else
                 $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10]." ".$ar[$n[2]]." Thousand";
           else if($n[5]==0 && $n[4]==0)
               if($mpart < 20)
                   $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10+$n[2]]." Thousand and ".$ar[$n[3]]." Hundred";
               else
                   $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10]." ".$ar[$n[2]]." Thousand and ".$ar[$n[3]]." Hundred";
           else if($n[5]==0)
               if($mpart==0)
                        $res = $ar[$n[0]]." Lakh ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10];
               else if($mpart < 20)
                      $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10+$n[2]]." Thousand ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10];

               else
               {
                   $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10]." ".$ar[$n[2]]." Thousand ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10];
                   //echo $res."n5=0 and mpart" ;
               }
           else
               if($mpart < 20)
                  if($lpart <20)
                      if($n[3]==0)
                         if($n[2]==0 && $n[1]==0)
                           $res = $ar[$n[0]]." Lakh and ".$ar[$n[4]*10+$n[5]];
                         else
                           $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10+$n[2]]." Thousand and ".$ar[$n[4]*10+$n[5]];
                      else
                         if($n[2]==0 && $n[1]==0)
                           $res = $ar[$n[0]]." Lakh ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10+$n[5]];
                         else
                           $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10+$n[2]]." Thousand ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10+$n[5]];
                  else
                      if($n[3]==0)
                        if($n[2]==0 && $n[1]==0)
                          $res = $ar[$n[0]]." Lakh and ".$ar[$n[4]*10]." ".$ar[$n[5]];
                        else
                          $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10+$n[2]]." Thousand and ".$ar[$n[4]*10]." ".$ar[$n[5]];
                      else
                        if($n[2]==0 && $n[1]==0)
                          $res = $ar[$n[0]]." Lakh ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10]." ".$ar[$n[5]];
                        else
                          $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10+$n[2]]." Thousand ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10]." ".$ar[$n[5]];
               else
                  if($lpart < 20)
                     if($n[3]==0)
                        if($n[2]==0 && $n[1]==0)
                           $res = $ar[$n[0]]." Lakh and ".$ar[$n[4]*10+$n[5]];
                        else
                           $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10]." ".$ar[$n[2]]." Thousand and ".$ar[$n[4]*10+$n[5]];
                     else
                        if($n[2]==0 && $n[1]==0)
                          $res = $ar[$n[0]]." Lakh ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10+$n[5]];
                        else
                          $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10]." ".$ar[$n[2]]." Thousand ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10+$n[5]];
                 else
                     if($n[3]==0)
                        if($n[2]==0 && $n[1]==0)
                           $res = $ar[$n[0]]." Lakh and ".$ar[$n[4]*10]." ".$ar[$n[5]];
                        else
                           $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10]." ".$ar[$n[2]]." Thousand and ".$ar[$n[4]*10]." ".$ar[$n[5]];
                     else
                        if($n[2]==0 && $n[1]==0)
                           $res = $ar[$n[0]]." Lakh ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10]." ".$ar[$n[5]];
                        else
                           $res = $ar[$n[0]]." Lakh ".$ar[$n[1]*10]." ".$ar[$n[2]]." Thousand ".$ar[$n[3]]." Hundred and ".$ar[$n[4]*10]." ".$ar[$n[5]];


        }
      else  //len 7
        {
          $lpart = substr($amount,5,2);
          settype($lpart,"integer");

          $mpart1 = substr($amount,0,2);
          settype($mpart1,"integer");

          $mpart2 = substr($amount,2,2);
          settype($mpart2,"integer");


          if($n[6]==0 && $n[5]==0 && $n[4]==0 && $n[3]==0 && $n[2]==0 && $n[1]==0)
            $res = $ar[$n[0]*10]." Lakh";
          else if($n[6]==0 && $n[5]==0 && $n[4]==0 && $n[3]==0 && $n[2]==0)
            if($mpart1 < 20)
              $res = $ar[$n[0]*10+$n[1]]." Lakh";
            else
              $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh";
          else if($n[6]==0 && $n[5]==0 && $n[4]==0 && $n[3]==0)
             if($mpart1 < 20)
                $res = $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[2]*10]." Thousand";
             else
                 $res = $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh and ".$ar[$n[2]*10]." Thousand";
          else if($n[6]==0 && $n[5]==0 && $n[4]==0)
              if($mpart1 < 20)
                 if($mpart2 < 20)
                   $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[2]*10+$n[3]]." Thousand";
                 else
                   $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand";
              else
                 if($mpart2 < 20)
                   $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh and ".$ar[$n[2]*10+$n[3]]." Thousand";
                 else
                   $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh and ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand";
          else if($n[6]==0 && $n[5]==0)
              if($mpart1 < 20)
                 if($mpart2 < 20)
                   if($n[3]==0 && $n[2]==0)
                     $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand and ".$ar[$n[4]]." Hundred";
                   else
                     $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[4]]." Hundred";
                 else
                   if($n[3]==0 && $n[2]==0)
                     $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[4]]." Hundred";
                   else
                      $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand and ".$ar[$n[4]]." Hundred";
              else
                 if($mpart2 < 20)
                   if($n[3]==0 && $n[2]==0)
                     $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh and ".$ar[$n[4]]." Hundred";
                   else
                     $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand and ".$ar[$n[4]]." Hundred";
                 else
                   if($n[3]==0 && $n[2]==0)
                      $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh and ".$ar[$n[4]]." Hundred";
                   else
                      $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand and ".$ar[$n[4]]." Hundred";

           else
             if($mpart1 < 20)
                 if($mpart2 < 20)
                   if($lpart < 20)
                     if($n[4]==0)
                       if($n[3]==0 && $n[2]==0)
                          $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[5]*10+$n[6]];
                       else
                         $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand and ".$ar[$n[5]*10+$n[6]];
                     else
                        if($n[3]==0 && $n[2]==0)
                         $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10+$n[6]];
                       else
                         $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10+$n[6]];
                   else
                     if($n[4]==0)
                       if($n[3]==0 && $n[2]==0)
                         $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                       else
                         $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                     else
                        if($n[3]==0 && $n[2]==0)
                           $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                        else
                          $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                else
                    if($lpart < 20)
                      if($n[4]==0)
                         if($n[3]==0 && $n[2]==0)
                            $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[5]*10+$n[6]];
                         else
                           $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand and ".$ar[$n[5]*10+$n[6]];
                      else
                         if($n[3]==0 && $n[2]==0)
                           $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10+$n[6]];
                         else
                           $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10+$n[6]];
                    else
                      if($n[4]==0)
                         if($n[3]==0 && $n[2]==0)
                           $res = $ar[$n[0]*10+$n[1]]." Lakh and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                         else
                           $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                      else
                         if($n[3]==0 && $n[2]==0)
                            $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                         else
                           $res = $ar[$n[0]*10+$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10]." ".$ar[$n[6]];
              else
                 if($mpart2 < 20)
                   if($lpart < 20)
                      if($n[4]==0)
                         if($n[3]==0 && $n[2]==0)
                           $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh and ".$ar[$n[5]*10+$n[6]];
                         else
                           $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand and ".$ar[$n[5]*10+$n[6]];
                      else
                         if($n[3]==0 && $n[2]==0)
                            $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10+$n[6]];
                         else
                           $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10+$n[6]];
                   else
                       if($n[4]==0)
                         if($n[3]==0 && $n[2]==0)
                            $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                         else
                            $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                       else
                          if($n[3]==0 && $n[2]==0)
                            $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                          else
                            $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10+$n[3]]." Thousand ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                 else
                   if($lpart < 20)
                      if($n[4]==0)
                        if($n[3]==0 && $n[2]==0)
                          $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh and ".$ar[$n[5]*10+$n[6]];
                        else
                          $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand and ".$ar[$n[5]*10+$n[6]];
                      else
                        if($n[3]==0 && $n[2]==0)
                           $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10+$n[6]];
                        else
                           $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10+$n[6]];
                   else
                       if($n[4]==0)
                          if($n[3]==0 && $n[2]==0)
                             $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                          else
                             $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                       else
                          if($n[3]==0 && $n[2]==0)
                            $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10]." ".$ar[$n[6]];
                          else
                            $res = $ar[$n[0]*10]." ".$ar[$n[1]]." Lakh ".$ar[$n[2]*10]." ".$ar[$n[3]]." Thousand ".$ar[$n[4]]." Hundred and ".$ar[$n[5]*10]." ".$ar[$n[6]];

         }


      }

    settype($lamount,"integer");

    if($lamount!='')
    {
      $res1 = InWords($lamount,"");
      $res1 = $res1." Crore ";
    }

    if($damount!='')
    {
      $d = array();

      for($i=0;$i<strlen($damount);$i++)
       $d[$i] = substr($damount,$i,1);

      for($i=0;$i<strlen($damount);$i++)
           settype($d[$i],"integer");


     if($damount>0)
     {
        if(strlen($damount)==1)
        {
                $res2 = $ar[$d[0]*10];
        }
        else if(strlen($damount)==2)
        {
                if(intval($damount)<20)
                        $res2 = $ar[$d[0]*10+$d[1]];
                else
                        $res2 = $ar[$d[0]*10]." ".$ar[$d[1]];
        }

         $res2 = $res2." Paisa ";
     }

    }

    $res = $res1." ".$res." ".$cur." ".$res2." only";

    //echo $res1."1"."<br>";
    //echo $res."2"."<br>";
    //echo $res;
    return $res;


   //echo "<b>".$res."</b> Taka Only";

}

?>

