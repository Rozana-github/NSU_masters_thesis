<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
<script language="JavaScript">
function CreateNewParty()
{
        var popit=window.open('Requisitionlist.php','console','status,scrollbars,width=650,height=350');
}

function EditPartyEntry(val)
{
        var popit=window.open("DebtorPartyUpdate.php?CustomerID="+val+"",'console','status,scrollbars,width=650,height=350');
}
function canceljob(id)
{
      alert(id);
      document.Form1.update.value='1';
      document.Form1.objectid.value=id;
      
      document.Form1.action="Requisitionlist.php";
      document.Form1.submit();
}
function Editjob(id)
{
      window.location="EditMaterialRequisit.php?object_id="+id;
}

</script>


</head>

<body class='body_e'>
<form name='Form1' method='post'  action='OrderCancel.php'>
<table border='0' cellspacing='0' cellpadding='0'  width='100%' align='center'>

      <tr>
            <td class='top_left_curb'></td>
            <td colspan='5' class='header_cell_e' align='center'>Order List</td>
            <input type='hidden' name='update' value=''>
            <input type='hidden' name='objectid' value=''>
            <td class='top_right_curb'></td>
      </tr>



        <?PHP
                //echo "2222".$update;

                $searchAllInfo="select
                                        mas_requisition_id,
                                        requisition_number,
                                        date_format(requisition_date,'%d-%m-%Y') As requisition_date,
                                        requisition_by,
                                        requisition_job,
                                        requisition_item,
                                        required_date,
                                        job_quantity
                                from
                                        mas_material_req
                                WHERE
                                    requision_status =0

                                ";
                $resultAllInfo=mysql_query($searchAllInfo) or die(mysql_error());

            if(mysql_num_rows($resultAllInfo)>0)
            {
                  echo "
                  <tr>
                        <td class='lb'></td>
                        <td class='title_cell_e'>Job No</Td>
                        <td class='title_cell_e'>Requisition No.</Td>
                        <td class='title_cell_e'>Quantity</Td>
                        <td class='title_cell_e'>Date</Td>
                        <td class='title_cell_e'>Edit</Td>

                        <td class='rb'></td>
                  </tr>";
                $i=1;
                while($rowAllInfo=mysql_fetch_array($resultAllInfo))
                {
                        extract($rowAllInfo);
                        if($i%2==0)
                              $clss='even_td_e';
                        else
                              $clss='odd_td_e';
                              
                        echo"
                        <tr  >
                              <td class='lb'></td>
                              <td class='$clss' >$requisition_job</Td>
                              <td class='$clss' >$requisition_number</Td>
                              <td class='$clss' >$job_quantity</Td>
                              <td class='$clss' >$requisition_date</Td>
                              <td class='$clss' onClick='Editjob(\"$mas_requisition_id\")' style=\"cursor: hand;\">Edit</Td>

                              <td class='rb'></td>
                        </tr>
                        ";
                        $i++;
                }
                        echo "
                        <tr>
                              <td class='bottom_l_curb'></td>
                              <td class='bottom_f_cell' colspan='5'></td>
                              <td class='bottom_r_curb'></td>
                        </tr>";
                        
            }
            else
            {
                  echo "Data Not Avilable";
            }
        ?>
</TABLE>
</form>
</body>

</html>

