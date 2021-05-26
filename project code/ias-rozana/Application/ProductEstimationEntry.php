<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html xmlns:ycode>

<style>
        yCode\:combobox {behavior: url(combobox.htc); }
</style>

<head>

<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>

function CreateNewParty()
{
        var popit=window.open('IOEDetailEntry.php','console','status,scrollbars,width=620,height=200');
}

function EditPartyEntry(val)
{
        var popit=window.open("IOEDetailUpdate.php?Serialno="+val+"",'console','status,scrollbars,width=620,height=200');
}


function calculate()
{

        var micron=0;
        var gsmrate=0;
        var gsm=0;
        var gsmkg=0
        
        var totalmicron=0;
        var totalgsm=0;

        var totalgsmkg=0;
        var layer=0;
        for(i=0;i<11;i++)
        {
        
        status= parseInt(document.frmProdEntry.elements["txtlayerstatus["+i+"]"].value);
        //alert(status+" "+i);
        micron=parseFloat(document.frmProdEntry.elements["txtmicron["+i+"]"].value);
        //alert(micron+" "+i);
        gsmrate=parseFloat(document.frmProdEntry.elements["txtgsmrate["+i+"]"].value);
        //alert(gsmrate+" "+i);
        

        if(status==1)
        {
                gsm=micron*gsmrate;

                if(micron!=0)
                        layer++;
        }
        else
        {
                gsm=gsmrate;
        }
        


        
        totalmicron=totalmicron+micron;
        totalgsm=totalgsm+gsm;


        document.frmProdEntry.elements["txtgsm["+i+"]"].value= gsm;
        document.frmProdEntry.txttotalmicron.value=totalmicron;
        document.frmProdEntry.txttotalgsm.value=totalgsm;
        document.frmProdEntry.txtlayer.value=layer;
        //



        }
        for(j=0;j<11;j++)
        {

                        gsmkg=parseFloat(document.frmProdEntry.elements["txtgsm["+j+"]"].value)*1000/totalgsm;



                totalgsmkg=totalgsmkg+gsmkg;
                document.frmProdEntry.elements["txtgsmkg["+j+"]"].value=Math.round(gsmkg);
               //alert(gsmkg+" "+totalgsmkg);
                 document.frmProdEntry.txttotalgsmkg.value=Math.round(totalgsmkg);
        }
}

function calsalfe()
{
        document.frmProdEntry.action='ProductEstimationEntry.php';
        document.frmProdEntry.submit();
}
function calculatesp()
{
        var rowcount=parseInt(document.frmProdEntry.sptotal.value);
        var totalkgqty=parseFloat(document.frmProdEntry.txtprodquantity.value);
        var wastagerate=parseFloat(document.frmProdEntry.txtwastagerate.value);
        //alert(rowcount);
        for(i=0;i<9;i++)
        {
                document.frmProdEntry.elements["txtspmicron["+i+"]"].value=parseFloat(document.frmProdEntry.elements["txtmicron["+i+"]"].value);
                document.frmProdEntry.elements["txtrqqty["+i+"]"].value=parseFloat(document.frmProdEntry.elements["txtgsmkg["+i+"]"].value);
                amt=totalkgqty*parseFloat(document.frmProdEntry.elements["txtrqqty["+i+"]"].value)/1000*(1+wastagerate/100);
                document.frmProdEntry.elements["txtamount["+i+"]"].value= amt;
        }

        calculateinksp();
        inkamt=totalkgqty*parseFloat(document.frmProdEntry.txtinkrqqty.value)/1000*(1+wastagerate/100);
        document.frmProdEntry.txtinkamount.value= inkamt;
        
        //calculation of bopp adhesive
        calculateboppadhasive();
        boppadamount=totalkgqty*parseFloat(document.frmProdEntry.txtbopprqqty.value)/1000*(1+wastagerate/100);
        document.frmProdEntry.txtboppamount.value= boppadamount;
        
        //calculation of adhesive per pair
        calculatepairadhesive();
        adhesiveamt=totalkgqty*parseFloat(document.frmProdEntry.txtadhesiverqqty.value)/1000*(1+wastagerate/100);
        document.frmProdEntry.txtadhesiveamount.value=adhesiveamt;
        
        //calculation of ink solvent
        calculateinksolvent();
        inksolventamt=totalkgqty*parseFloat(document.frmProdEntry.txtinksolventrqqty.value)/1000*(1+wastagerate/100);
        document.frmProdEntry.txtinksolventamount.value=inksolventamt;
        
        // calculation of adhesive solvent
        calculateadhesivesolvent();
        adhesivesolventamt=totalkgqty*parseFloat(document.frmProdEntry.txtadhesivesolventrqqty.value)/1000*(1+wastagerate/100);
        document.frmProdEntry.txtadhesivesolventamount.value=adhesivesolventamt;
        
}



function calculateinksp()
{
        var petgsmkg=parseFloat(document.frmProdEntry.elements["txtgsmkg[0]"].value);
        var inkrate=parseFloat(document.frmProdEntry.txtinkrate.value);
        if(petgsmkg==0)
        {
                boppgsmkg=parseFloat(document.frmProdEntry.elements["txtgsmkg[1]"].value);
                boppgsm=parseFloat(document.frmProdEntry.elements["txtgsm[1]"].value)

                inkqtygm=boppgsmkg/boppgsm*7*inkrate/100;
        }
        else
        {
                petgsmkg=parseFloat(document.frmProdEntry.elements["txtgsmkg[0]"].value);
                petgsm=parseFloat(document.frmProdEntry.elements["txtgsm[0]"].value)

                inkqtygm=petgsmkg/petgsm*7*inkrate/100;
        }
        document.frmProdEntry.txtinkrqqty.value=inkqtygm;

}


function calculateboppadhasive()
{
        var bopp=parseFloat(document.frmProdEntry.elements["txtmicron[1]"].value);
        var bopprate=parseFloat(document.frmProdEntry.txtboppadrate.value);
        if(bopp!=0)
        {
                inkqtygm=parseFloat(document.frmProdEntry.txtinkrqqty.value);
                boppqtygm=inkqtygm*bopprate/100;
        }
        else
        {
                boppqtygm=0;
        }
        document.frmProdEntry.txtbopprqqty.value=boppqtygm;

}

function calculatepairadhesive()
{
        var layer=document.frmProdEntry.txtlayer.value;

        var petgsmkg=parseFloat(document.frmProdEntry.elements["txtgsmkg[0]"].value);
        var petgsm=parseFloat(document.frmProdEntry.elements["txtgsm[0]"].value);

        var boppgsmkg=parseFloat(document.frmProdEntry.elements["txtgsmkg[1]"].value);
        var boppgsm=parseFloat(document.frmProdEntry.elements["txtgsm[1]"].value);
        
        var adhesiverate=document.frmProdEntry.txtadhesiverate.value;
        
        if(layer <= 2)
        {
                if(petgsmkg==0)
                {
                        adhesiveqtygm=boppgsmkg/boppgsm*3.5*adhesiverate/100;
                }
                else
                {
                        adhesiveqtygm=petgsmkg/petgsm*3.5*adhesiverate/100;
                }
        }
        else
        {
                if(layer==3)
                {
                        if(petgsmkg==0)
                        {
                                adhesiveqtygm=boppgsmkg/boppgsm*3.5*2*adhesiverate/100;
                        }
                        else
                        {
                                adhesiveqtygm=petgsmkg/petgsm*3.5*2*adhesiverate/100;
                        }
                }
                else
                {
                        if(petgsmkg==0)
                        {
                                adhesiveqtygm=boppgsmkg/boppgsm*3.5*3*adhesiverate/100;
                        }
                        else
                        {
                                adhesiveqtygm=petgsmkg/petgsm*3.5*3*adhesiverate/100;
                        }
                }
                
        }
        document.frmProdEntry.txtadhesiverqqty.value=adhesiveqtygm;
}

function calculateinksolvent()
{
        var inksolventrate=parseFloat(document.frmProdEntry.txtinksolventrate.value);

        var petgsmkg=parseFloat(document.frmProdEntry.elements["txtgsmkg[0]"].value);
        var petgsm=parseFloat(document.frmProdEntry.elements["txtgsm[0]"].value);

        var boppgsmkg=parseFloat(document.frmProdEntry.elements["txtgsmkg[1]"].value);
        var boppgsm=parseFloat(document.frmProdEntry.elements["txtgsm[1]"].value);
        
        if(petgsmkg==0)
        {
                inksolventqtygm=boppgsmkg/boppgsm*6.5*inksolventrate/100;
        }
        else
        {
                inksolventqtygm=petgsmkg/petgsm*6.5*inksolventrate/100;
        }
        document.frmProdEntry.txtinksolventrqqty.value=inksolventqtygm;
}

function calculateadhesivesolvent()
{
        var adhesivesolventrate=parseFloat(document.frmProdEntry.txtadhesivesolventrate.value);
        var adhesivepair=parseFloat(document.frmProdEntry.txtadhesiverqqty.value);
        adhesivesolventgm=adhesivepair*1.67*adhesivesolventrate/100;
        document.frmProdEntry.txtadhesivesolventrqqty.value=adhesivesolventgm;
}

function submitform()
{
         document.frmProdEntry.submit();
}

</script>

</head>

<body class='body_e'>




<form name='frmProdEntry' method='post' action='AddToEstimationEntry.php'>

 <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='5' class='header_cell_e' align='center'>Production Estimation</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e' colspan='2'>Job No.</td>
                        <td class='td_e' colspan='3'>
                                <select name='cbojobno' class='select_e' onchange='calsalfe()'>
                                <?PHP
                                        createCombo("Job No","mas_order","order_object_id","job_no","order by job_no","$cbojobno");
                                ?>
                                </select>
                        </td>
                        <td class='rb' ></td>
                </tr>
                <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='5'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
 </table><br>




<?PHP

      $employeequery=" SELECT
                                prod_item_object_id ,
                                description ,
                                gsm_rate ,
                                layer_type
                        FROM
                                prod_item_setup
                        where
                               layer_type !='2'
                        order by
                                prod_item_object_id

                  ";
      $rsemployee=mysql_query($employeequery) or die();
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {
           echo " <table border='0' width='98%' align='center'  cellspacing='0' cellpadding='0'>
                    <tr>
                        <td width='50%'>
                        <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <td class='lb' ></td>
                                    <Td class='title_cell_e'>Item</Td>
                                    <Td class='title_cell_e'>Micron</Td>
                                    <Td class='title_cell_e'>Rate</Td>
                                    <Td class='title_cell_e'>GSM</Td>
                                    <Td class='title_cell_e'>GSM/Kg</Td>
                                    <td class='rb' ></td>

                              </TR>


                  ";
            $i=0;
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  $desc[$i]=$description;
                  $state[$i]=$layer_type;
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';
                  echo"
                              <TR >

                                    <td class='lb' ><input type='hidden' name='txtlayerstatus[$i]' value='".$layer_type."'></td>
                                    <TD class='$cls' >$description<input type='hidden' name='txtprodobjectid[$i]' value='".$prod_item_object_id."'></TD>
                                    <TD class='$cls' ><input type='text' name='txtmicron[$i]' value='0' class='input_e' style='text-align:right' size='5' onchange='calculate()'></TD>
                                    <TD class='$cls' class='right'>$gsm_rate<input type='hidden' name='txtgsmrate[$i]' value='".$gsm_rate."'></TD>
                                    <TD class='$cls' ><input type='text' name='txtgsm[$i]' value='0' class='input_e' style='text-align:right' size='5' readonly></TD>
                                    <TD class='$cls' ><input type='text' name='txtgsmkg[$i]' value='0' class='input_e' style='text-align:right' size='6' readonly></TD>

                                    <td class='rb' ></td>
                              </TR>
                        ";
                  $i++;
            }
                 $total=$i;
                 echo"
                              <TR >
                                    <td class='lb' ></td>
                                    <TD class='$cls' >Total</TD>
                                    <TD class='$cls' ><input type='text' name='txttotalmicron' value='0' class='input_e' style='text-align:right' size='5' readonly></TD>
                                    <TD class='$cls' class='right'>&nbsp;</TD>
                                    <TD class='$cls' ><input type='text' name='txttotalgsm' value='0' class='input_e' style='text-align:right' size='5' readonly></TD>
                                    <TD class='$cls' ><input type='text' name='txttotalgsmkg' value='0' class='input_e' style='text-align:right' size='6' readonly></TD>

                                    <td class='rb' ></td>
                              </TR>
                              <TR >
                                    <td class='lb' ></td>
                                    <TD class='$cls' >Layer</TD>
                                    <TD class='$cls' colspan='4'><input type='text' name='txtlayer' value='0' class='input_e' style='text-align:right' size='6' readonly></TD>

                                    <td class='rb' ></td>
                              </TR>
                        ";
            echo  "
            <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='5'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
                  </TABLE>
                </td>";
                if(isset($cbojobno))
                {
                $queryorder="SELECT
                                    trn_order_description.order_desc_object_id,
                                    mas_order.order_object_id,
                                    mas_order.job_no,
                                    trn_order_description.order_description,
                                    mas_customer.customer_id,
                                    Company_Name,
                                    office_address,
                                    date_format(mas_order.order_date,'%d-%m-%Y') as order_date,
                                    trn_order_description.order_quntity,
                                    trn_order_description.order_unit ,
                                    trn_order_description.order_rate,
                                    trn_order_description.order_amount,
                                    trn_order_description.order_unit as mas_order_unit,
                                    total_amount,
                                    vat_status,
                                    date_format(first_proof_date,'%d-%m-%Y') as first_proof_date,
                                    date_format(final_proof_date,'%d-%m-%Y') final_proof_date,
                                    date_format(printing_order_date,'%d-%m-%Y') printing_order_date,
                                    date_format(delivery_date,'%d-%m-%Y') delivery_date,
                                    size,
                                    order_status,
                                    product_status,
                                    paid_on_order_amount,
                                    due_on_delivery_amount,
                                    remarks
                              FROM
                                    mas_order
                                    LEFT JOIN mas_customer ON mas_customer.customer_id = mas_order.customer_id
                                    left join trn_order_description on trn_order_description.order_object_id=mas_order.order_object_id
                              where
                                    mas_order.order_object_id='$cbojobno'
                              order by
                                     trn_order_description.order_desc_object_id";

                        $rsorderinfo=mysql_query($queryorder)or die(mysql_error());
                        $quantity=0;
                        while($roworder=mysql_fetch_array($rsorderinfo))
                        {
                                extract($roworder);
                                $quantity=$quantity+$order_quntity;
                        }
                        $querytrn="SELECT
                                        mas_item ,
                                        sub_item
                                   FROM
                                        trn_order
                                   WHERE
                                        order_object_id='$cbojobno' ";
                        $rstrn=mysql_query($querytrn)or die(mysql_error());
                        while($rowtrn=mysql_fetch_array($rstrn))
                        {
                                extract($rowtrn);
                                $mainitem=pick("mas_item","itemdescription","itemcode=$mas_item");
                                $subitem=pick("mas_item","itemdescription","itemcode=$sub_item");
                                $stracture=$stracture.$mainitem.'-'.$subitem.'<br>';
                        }
                        $unit=pick("mas_unit","unitdesc","unitid='$mas_order_unit'");
                        echo "<td width='50%'>
                        <table border='0' width='100%'  cellspacing='2' cellpadding='0'>
                                <tr>
                                        <td width='25%'><b>Job No</b></td><td width='75%'>:$job_no</td>
                                </tr>
                                <tr>
                                        <td width='25%'><b>Job Name</b></td><td width='75%'>:$order_description</td>
                                </tr>
                                <tr>
                                        <td width='25%'><b>Structure</b></td><td width='75%'>:$stracture</td>
                                </tr>

                                 <tr>
                                        <td width='25%'><b>Order Date</b></td><td width='75%'>:$order_date</td>
                                </tr>

                                <tr>
                                        <td width='25%'><b>Quantity</b></td><td width='75%'>:$quantity $unit</td>
                                </tr>
                        </table>";
                }
                else
                {
                        echo "<td width='50%'>";
                }
                echo "</td>
                </tr>
                </table><br>";

      }
?>
         <table border='0' width='98%' align='center' cellspacing='0' cellpadding='0'>
                <tr>
                        <td  class='button_cell_e' align='right'>Quantity</td>
                        <td  class='button_cell_e'><input type='text' name='txtprodquantity' value='0' class='input_e' style='text-align:right' size='6'  onchange='calculatesp()'> Kg</td>
                        <td class='button_cell_e' colspan='2'><input type='button' name='btnsve' value='Save' class='forms_button_e' onclick='submitform()'></td>
                </tr>
        </table><br>
        <table border='0' width='98%' align='center' cellspacing='0' cellpadding='0'>
                <TR>
                        <td class='lb' ></td>
                        <Td class='title_cell_e' colspan='2'>Materials Specification</Td>
                        <Td class='title_cell_e'>Required Quantity, gm</Td>
                        <Td class='title_cell_e'>Amount, Kg</Td>
                        <td class='rb' ></td>

                </TR>
                <?PHP
                        for($i=0;$i<$total;$i++)
                        {
                                if($i%2==0)
                                        $cls='even_td_e';
                                else
                                        $cls='odd_td_e';
                                if($state[$i]!=0)
                                {

                                        echo "<tr>
                                                <td class='lb' ></td>
                                                <td class='$cls'><input type='text' name='txtspmicron[$i]' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                                <td class='$cls'>micron ".$desc[$i]."</td>
                                                <td class='$cls' align='center'><input type='text' name='txtrqqty[$i]' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                                <td class='$cls' align='center'><input type='text' name='txtamount[$i]' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                                <td class='rb' ></td>
                                                </tr>";
                                }
                        }
                        $queryadhesive="SELECT
                                prod_item_object_id ,
                                description ,
                                gsm_rate ,
                                layer_type
                        FROM
                                prod_item_setup
                        where
                               layer_type ='2'
                        order by
                                prod_item_object_id";
                        $rsadhesive=mysql_query($queryadhesive)or die(mysql_error());
                        $j=0;
                        while($rowadhesive=mysql_fetch_array($rsadhesive))
                        {
                                extract($rowadhesive);
                                $prod_object[$j]=$prod_item_object_id ;
                                $j++ ;
                        }
                         echo "<tr>
                                        <td class='lb' ></td>
                                        <td class='odd_td_e'>Ink,#clrs 5<input type='hidden' name='txtadhesive1' value='".$prod_object[0]."'></td>
                                        <td class='odd_td_e' ><input type='text' name='txtinkrate' value='100' class='input_e' style='text-align:right' size='6' >%</td>
                                        <td class='odd_td_e' align='center'><input type='text' name='txtinkrqqty' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='odd_td_e' align='center'><input type='text' name='txtinkamount' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='rb' ></td>

                                </tr>
                                <tr>
                                        <td class='lb' ></td>
                                        <td class='even_td_e'>BOPP Additives<input type='hidden' name='txtadhesive2' value='".$prod_object[1]."'></td>
                                        <td class='even_td_e' ><input type='text' name='txtboppadrate' value='15' class='input_e' style='text-align:right' size='6' >%</td>
                                        <td class='even_td_e' align='center'><input type='text' name='txtbopprqqty' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='even_td_e' align='center'><input type='text' name='txtboppamount' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='rb' ></td>
                                </tr>
                                <tr>
                                        <td class='lb' ></td>
                                        <td class='odd_td_e'>Adhesive, Per Pair<input type='hidden' name='txtadhesive3' value='".$prod_object[2]."'></td>
                                        <td class='odd_td_e' ><input type='text' name='txtadhesiverate' value='100' class='input_e' style='text-align:right' size='6' >%</td>
                                        <td class='odd_td_e' align='center'><input type='text' name='txtadhesiverqqty' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='odd_td_e' align='center'><input type='text' name='txtadhesiveamount' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='rb' ></td>
                                </tr>
                                <tr>
                                        <td class='lb' ></td>
                                        <td class='even_td_e'>Solvent, Ink <input type='hidden' name='txtadhesive4' value='".$prod_object[3]."'></td>
                                        <td class='even_td_e' ><input type='text' name='txtinksolventrate' value='100' class='input_e' style='text-align:right' size='6' >%</td>
                                        <td class='even_td_e' align='center'><input type='text' name='txtinksolventrqqty' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='even_td_e' align='center'><input type='text' name='txtinksolventamount' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='rb' ></td>
                                </tr>

                                <tr>
                                        <td class='lb' ></td>
                                        <td class='odd_td_e'>Solvent, Adhesive <input type='hidden' name='txtadhesive5' value='".$prod_object[4]."'></td>
                                        <td class='odd_td_e' ><input type='text' name='txtadhesivesolventrate' value='100' class='input_e' style='text-align:right' size='6' >%</td>
                                        <td class='odd_td_e' align='center'><input type='text' name='txtadhesivesolventrqqty' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='odd_td_e' align='center'><input type='text' name='txtadhesivesolventamount' value='0' class='input_e' style='text-align:right' size='6' ></td>
                                        <td class='rb' ></td>
                                </tr>
                                <tr>
                                        <td class='lb' ></td>
                                        <td class='even_td_e'>Wastage <input type='hidden' name='txtadhesive6' value='".$prod_object[5]."'></td>
                                        <td colspan='3' class='even_td_e'><input type='text' name='txtwastagerate' value='7.0' class='input_e' style='text-align:right' size='6' >%</td>
                                        <td class='rb' ></td>
                                </tr>
                                <tr>
                                        <td class='bottom_l_curb'></td>
                                        <td class='bottom_f_cell' colspan='4'></td>
                                        <td class='bottom_r_curb'></td>
                                </tr>
                                <input type='hidden' name='sptotal' value='$total'>
                        </table>";

                ?>
         </table>




</form>



</body>

</html>
