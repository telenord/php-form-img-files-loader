<?	
//function uploadHandle($max_file_size = 10000, $valid_extensions = array(), $upload_dir = '.', $normal = '', $small_w = '', $small_h = '')
function generateCode($length=6){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
}
$gen_code = generateCode();

function uploadHandle($max_file_size = 10000, $valid_extensions = array(), $upload_dir = '.', $name)   
    {  
        global $gen_code;
      
        $result = 0;
		$error = null;  
        $info  = "загрузка прошла успешно.";  
        $max_file_size *= 1024;  

        if (isset($_FILES[$name]))  
        {              
            // проверяем расширение файла  
            $file_extension = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);  
            if (in_array($file_extension, $valid_extensions))  
            {  
                // проверяем размер файла  
                if ($_FILES[$name]['size'] < $max_file_size)  
                {  	
                     
                	$new_name =	$name . $gen_code .'.' .  $file_extension;  
					$destination = $upload_dir .'/'. $new_name;  
					
					if (move_uploaded_file($_FILES[$name]['tmp_name'], $destination)) {  
                        return $info;
					} else  
                        $error = 'Не удалось загрузить файл - '.$destination.' ';  
                }   
                else  
                    $error = 'Размер файла больше допустимого';  
            }   
            else  
                $error = 'У файла недопустимое расширение';  
        }   
        else  
        {  
            // массив ошибок  
            $error_values = array( 
                UPLOAD_ERR_INI_SIZE   => 'Размер файла больше разрешенного директивой upload_max_filesize в php.ini',
                UPLOAD_ERR_INI_SIZE   => 'Размер файла больше 10 Мб',
                UPLOAD_ERR_FORM_SIZE  => 'Размер файла больше 10 Мб', 
                UPLOAD_ERR_PARTIAL    => 'Файл был загружен только частично',   
                UPLOAD_ERR_NO_FILE    => 'Не был выбран файл для загрузки',   
                UPLOAD_ERR_NO_TMP_DIR => 'Не найдена папка для временных файлов',   
                UPLOAD_ERR_CANT_WRITE => 'Ошибка записи файла на диск'
                                  );  
      
            $error_code = $_FILES[$name]['error'];  
      
            if (!empty($error_values[$error_code]))  
                $error = $error_values[$error_code];  
            else  
                $error = 'Случилось что-то непонятное';  
        }  
      
        return array('info' => $info, 'error' => $error);  
    }     
	
    // Запускаем функцию  
if(isset($_POST)) {   
   
    $valid_extensions = array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');  
    $upload_dir = $_SERVER["DOCUMENT_ROOT"].'/docs_img'; 
    $name = array('pass', 'sts_face' , 'sts_back' );

    $header = "Content-type: text/plain; charset=utf-8";
    $subject = "Содержимое формы 'Документы на лицензию' "\"";
    $msg    = "Содержимое формы 'Документы на лицензию' "\" \r\n\r\n";
    
    for($i=0; $i < count($name); $i++){       

        $file_extension = pathinfo($_FILES[$name[$i]]['name'], PATHINFO_EXTENSION);  
        if (in_array($file_extension, $valid_extensions))  {
            $new_name = $name[$i] . $gen_code .'.' . $file_extension; 
            $msg.= "Файл ".($i+1).": http://fox-taxi.ru/docs_img/".$new_name."\n";
        } else {
            header("HTTP/1.0 400");
            echo "Неверный формат файлов.";
        }
            // $ext = explode('.', $_FILES[$name[$i]]['name']);
        $message = uploadHandle(1024, $valid_extensions , $upload_dir, $name[$i]);        
    }    
    foreach ($_POST as $key=>$val)
    {
        $msg .= "$key :  $val \r\n";
    }
    
   $from = "btrst2@ya.ru"; // Кому
   $from2 = "semikin77@mail.ru"; // Кому
    mail($from,$subject,$msg,$header);
   mail($from2,$subject,$msg,$header);
    echo "Загрузка прошла успешно.";
}
else { 
    header("HTTP/1.0 400");
    echo "Ошибка! Попробуйте позже.";
}

?>