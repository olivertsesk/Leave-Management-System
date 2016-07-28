<?php


include("../mpdf/mpdf.php");
 
//$mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); 
 
//$mpdf->SetDisplayMode('fullpage');
 
//$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
 
//$mpdf->WriteHTML(file_get_contents('../Home/action_employee_table.php'));
         
//$mpdf->Output();



ob_start();  // start output buffering
include "../Home/action_employee_table.php"; 
$content = ob_get_clean(); // get content of the buffer and clean the buffer
$mpdf = new mPDF(); 
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($content);
$mpdf->Output(); // output as inline content

?>