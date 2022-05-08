<?php

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}


/* 
 * php delete function that deals with directories recursively
 */
function delete_files($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
        
        foreach( $files as $file ){
            delete_files( $file );      
        }
      
        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );  
    }
}


#$target_dir = "E:/bank_info/uploads/";
$target_dir = "./uploads/";
$fname = basename($_FILES["fileToUpload"]["name"]);
echo 'Назва файлу '.$fname.'<br/>';
$target_file=$target_dir.$fname;


if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
    echo "Файл перевірено за успішно завантажено.<br/>";
	
	$source_pdf=$target_file;

	$output_folder="converted_pdf";
	
	//delete_files($output_folder);
	
    if (!file_exists($output_folder)) { mkdir($output_folder, 0777, true);}
	$output_folder=$output_folder.'/'.time();
	if (!file_exists($output_folder)) { mkdir($output_folder, 0777, true);}
	
	
	$ret_var;
	exec("pdftohtml $source_pdf $output_folder/$fname");
	# $a= passthru("pdftohtml -c -noframes $source_pdf $output_folder/new_file_name", $ret_var);
	# var_dump($a);
	unlink($target_file);
	
	#var_dump($ret_var);
	
	echo '<a href="./'.$output_folder.'" >Відкрити завантажений html</a>';
	
	
	
} else {
    echo "Можлива \"file upload\" атака!\n";
}





?>