<?PHP
include "dbconnect.php" ;
?>
<?PHP

    $FootData="select
                    _nisl_system_paramiter.template_id,
                    _nisl_system_paramiter.project_name AS project_name,
                    _nisl_system_paramiter.font_size AS font_size,
                    _nisl_system_paramiter.font_name AS font_name,
                    _nisl_system_paramiter.title_f_color_id AS TFCID,
                    _nisl_mas_template.template_name AS TName,
                    _nisl_mas_template.template_path AS Path,
                    _nisl_mas_template.footer_backrepet AS FBackRepet,
                    _nisl_mas_template.footer_logo AS FLogo,
                    A.title_font_color AS Fontcolor,
                    B.title_font_color AS FontShcolor
                    
                from
                    _nisl_system_paramiter
                    LEFT JOIN _nisl_mas_template ON _nisl_mas_template.template_id=_nisl_system_paramiter.template_id
                    LEFT JOIN _nisl_font_color AS A ON A.title_f_color_id=_nisl_system_paramiter.title_f_color_id
                    LEFT JOIN _nisl_font_color AS B ON B.title_f_color_id=_nisl_system_paramiter.title_f_shade_id
               ";
    $ExFootData=mysql_query($FootData) or die(mysql_error());
    while($Row=mysql_fetch_array($ExFootData))
    {
        extract($Row);
    }
        // Set the content-type
        header("Content-type: image/png");

       /*---------------------------Create the image--------------------------*/
        $ImPath='../'.$Path.'TopBacground_8.png';
        $im     = imagecreatefrompng($ImPath);
       /*---------------------- Convert Color ------------------------------*/
              $A1=substr($Fontcolor, 0, 2);
              $Fc1=base_convert($A1, 16, 10);

              $A2=substr($Fontcolor, 2, 2);
              $Fc2=base_convert($A2, 16, 10);//convert hexadacimal to dacimal

              $A3=substr($Fontcolor, 4, 2);
              $Fc3=base_convert($A3, 16, 10);

              $B1=substr($FontShcolor, 0, 2);
              $Fsc1=base_convert($B1, 16, 10);

              $B2=substr($FontShcolor, 2, 2);
              $Fsc2=base_convert($B2, 16, 10);
              
              $B3=substr($FontShcolor, 4, 2);
              $Fsc3=base_convert($B3, 16, 10);
        
        /*---------------------- END ----------------------------------------*/
        /*----------------- Allocate a color for an image ---------------------*/
        $white = imagecolorallocate($im,$Fc1,$Fc2,$Fc3);
        $grey = imagecolorallocate($im,$Fsc1,$Fsc2,$Fsc3);
        /*------------------- END ---------------------------------------------*/

        /*---------------------The text to draw--------------------------------*/
        $text = $project_name;
        /*---------------------Replace path by your own font path--------------*/
        $font = "../Font/$font_name";

        // Add some shadow to the text
        imagettftext($im, $font_size, 0, 11, 39, $grey, $font, $text);

        // Add the text
        imagettftext($im, $font_size, 0, 10, 38, $white, $font, $text);

        // Using imagepng() results in clearer text compared with imagejpeg()
        imagepng($im,'../'.$Path.'TopBanner.png');
        /* $PA=imagepng($im);
        echo "<font color='ff0000' size='3'>$im</font>"; */
        imagedestroy($im);

?>

