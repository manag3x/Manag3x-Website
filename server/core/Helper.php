<?php
namespace server\core;
use Exception;
use DateTime;
use server\enum\User;
use server\model\{Client,Admin, Articles, Editor,Writer,Publisher,Guest, Inventory, Message, Order,PublisherInventory};
class Helper{
  
    public static function object(array $array) : object {
        $obj = new \stdClass();
        foreach ($array as $k => $v){
            if(is_array($v)) {
                $obj->{$k} = self::object($v);
                continue;
            }
            $obj->{$k} = $v;
        }
        return $obj;
    }

    public static function GET($key){
        return (array_key_exists($key,$_GET)) ? self::cleanse($_GET[$key]) : "";
    }

	public static function page(){
		$url    = trim($_SERVER['QUERY_STRING']);
		$url    = explode("&",$url);
		$file   = trim($url[0]);
		return $file;
	}

    /**
     * generates n-digit numbers
     *
     * @param int $n
     */
    public static function genRand($n = 5,$pre="",$post="") : string{
        $rand = "";
        for ($i = 0; $i<$n; $i++)
            $rand .= mt_rand(0,9);
        return $pre.$rand.$post;
    }

	public static function treatCtrlAction($ac){
		return strtolower($ac);
	}

    public static function cleanse($data){
        return Core::cleanse($data);;
    }

    public static function permission($user) : string{
        $admin = new Admin();
        return (!$admin->isSuper()) ? $admin->permission->hasPermission($user) : true;
    }

    // public static function nClient($user) : string{
    //     $core = new Core();
    //     $inv = new Inventory();
    //     $task = new \server\model\Order;
    //     $client = (new Client())->guid;
    //      switch ($user){
    //         case "order"         : $table = $task->getbyClient(true); break;
    //          case "article"       : $table = (new Articles)->getByClient(true); break;
    //          case "rejected"      : $table = $inv->getRecommendedByStatus(5,true); break;
    //          case "saved"         : $table = $inv->getSaved(true); break;
    //          case "inventory"     : $table = $inv->getRecommended($client, true); break;
    //          case "a-task"        : $table = $task->getNumClientByStatus(3); break;
    //     };
    //     return $table;
    // }

    public static function nTask($status){
        switch ($status){
            case "pending"      : $table = 0; break;
            case "completed"    : $table = 4; break;
            case "rejected"     : $table = 5; break;
            case "new"          : $table = 0; break;
            case "active"       : $table = 3; break;
        };
        return (new \server\model\Order)->getNumByStatus($table);
    }

    // public static function nClientTask($status){
    //     switch ($status){
    //         case "pending"      : $table = 0; break;
    //         case "completed"    : $table = 4; break;
    //         case "rejected"     : $table = 5; break;
    //         case "new"          : $table = 0; break;
    //         case "active"       : $table = 3; break;
    //     };
    //     return (new \server\model\Order)->getNumClientByStatus($table);
    // }

    public static function specialContent($user){
        $admin = new Admin();
        switch ($user){
            case "btn-export"    : $table = '<button class="btn btn-secondary dataExport" id="dataExport" >
                                <i class="fas fa-file-import mr-2"></i> Export Inventory</button>'; break;
            default         : $table = ""; break;
        };
        return ($admin->isSuper()) ? $table : "";
    }

    /**
     * start and end date of the week - monday/sunday
     */
    public static function startAndEndDateOfTheWeek(){
        $monday = strtotime('next Monday -1 week');
        $monday = date('w', $monday)==date('w') ? strtotime(date("Y-m-d",$monday)." +7 days") : $monday;
        $sunday = strtotime(date("Y-m-d",$monday)." +6 days");

        echo $this_week_sd = date("Y-m-d",$monday)."<br>";
        echo $this_week_ed = date("Y-m-d",$sunday)."<br>";
    }

	public static function treatWebUrl($url){
        $url = trim(strtolower($url));
        $url = str_replace('http://','', $url);
        $url = str_replace('https://','', $url);
        $url = str_replace(' ','', $url);
        return str_replace('www.','', $url);
    }
	public static function ctrlRoute() : array{
		$url = trim($_SERVER['QUERY_STRING']);
		$url = self::crypt($url,false);
		return explode("/",strval($url),3);
	}

	public static function convertToClassCaps($controller){
		return str_replace(' ','', ucwords(str_replace('-', ' ' , $controller)));
	}

    public static function timeElapsedString($datetime, $level = 2){
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		if($diff->w > 1) {return date("d M o [h:ia]",strtotime(str_replace("/","-",$datetime)));}
		else
		{
			foreach ($string as $k => &$v) {
				if ($diff->$k) {
					$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
				}  
				else {
					unset($string[$k]);
				}
			}

			$string = array_slice($string, 0, $level);
			return $string ? implode(', ', $string) . ' ago' : 'just now';
		}
    }

    public static function getNumDays($start,$end){
        $date1 = new DateTime(date('Y-m-d',strtotime($start)));
        $date2 = new DateTime(date('Y-m-d',strtotime($end)));
        $days  = $date2->diff($date1)->format('%a');
        return $days;
    }

    /**
    * Encrypts and Decrypts
    *
    * @param string $string value to encrypt
    * @param string $action Specify true for encryption and false for decryption
    * @return string
    */
    public static function crypt($string, $action = true) {
        $active = Config::$CRYPT;
        // you may change these values to your own
        $secret_key = 'yospecialistDamireX';
        $secret_iv = '0654335678+-436574892';
    
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    
        if($action) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else{
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
    
        return ($active) ? $output : $string;
    }

    /**
     * mime Type
     * document => doc, img => image
     * @param string $type
     */
    public static function mimeType(string $type){
        switch (strtolower($type)) {
            case "csv" : 
                $table =  array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'); break;
            case "img" : 
                $table =  array('image/jpg', 'image/jpeg', 'image/png'); 
            break;
            case "doc" : 
                $table = array('application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/pdf', 'application/msword','application/doc','application/rtf','application/x-rtf','text/richtext','text/rtf','application/zip','application/vnd.oasis.opendocument.text ', 'application/vnd.sun.xml.writer'); 
            break;
            default : $table =  null; break;
        };
        return $table;
    }

    public static function fileUpload($data,$dir,$fileType = "doc"){
        $fileFolder = Config::$res->uploads->root;
        $db_file  = "/".date('dmYHis').str_replace(" ", "_", basename($data->doc));
        $data->doc      = empty($data->doc) ? "" : $dir.$db_file;

        //validate for file type, file must be an image
        if(!in_array($_FILES['file']['type'],Helper::mimeType($fileType))){
            echo json_encode(array("message" => "Invalid File Type: Only doc and pdf File Format is Required ", "valid" => 0));
            exit();
        }
        //validate for image file size, must not exceed 2megabyte
        if($_FILES["file"]["size"]/2000000 > 1){
            echo json_encode(array("message" => "Image size is too large, Maximum is 2mb", "valid" => 0));exit();
        }
        if(!file_exists($fileFolder.$dir)){
            mkdir($fileFolder.$dir,"0755");
        }
        $target = $fileFolder.$data->doc;
        return (move_uploaded_file($_FILES['file']['tmp_name'],$target)) ? true : false;
    }

    /**
        * Convert amount to words
        *
        * @param int $number
        * @return string
        */
    public static function convert_number($number) {
		if (($number < 0) || ($number > 999999999)) 
		{ 
		throw new Exception("Number is out of range");
		} 
	
		$Gn = floor($number / 1000000);  /* Millions (giga) */ 
		$number -= $Gn * 1000000; 
		$kn = floor($number / 1000);     /* Thousands (kilo) */ 
		$number -= $kn * 1000; 
		$Hn = floor($number / 100);      /* Hundreds (hecto) */ 
		$number -= $Hn * 100; 
		$Dn = floor($number / 10);       /* Tens (deca) */ 
		$n = $number % 10;               /* Ones */ 
	
		$res = ""; 
	
		if ($Gn) 
		{ 
			$res .= self::convert_number($Gn) . " Million"; 
		} 
	
		if ($kn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
         self::convert_number($kn) . " Thousand"; 
		} 
		if ($Hn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
         self::convert_number($Hn) . " Hundred"; 
		} 
		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen"); 
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty","Seventy", "Eigthy", "Ninety"); 
	
		if ($Dn || $n){
          
			if (!empty($res)) 
			{ 
				$res .= " and "; 
			} 
	
			if ($Dn < 2) 
			{ 
				$res .= $ones[$Dn * 10 + $n]; 
			} 
			else 
			{ 
				$res .= $tens[$Dn]; 
	
				if ($n) 
				{ 
					$res .= "-" . $ones[$n]; 
				} 
			} 
		} 
		if (empty($res)) 
		{ 
			$res = "zero"; 
		} 
	
		return $res; 
	}

   /**
    * Formats amount
    * 
    * @param double $number
    * @param boolean $fractional
    * formatMoney(1050 , true) => # 1,050.
    * @return void
    */
	public static function formatMoney($number, $fractional=true) { 
		if ($fractional) { 
			$number = sprintf('%.2f', $number); 
		} 
		while (true) { 
			$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
			if ($replaced != $number) { 
				$number = $replaced; 
			} else { 
				break; 
			} 
		} 
		return $number; 
	} 

    /**
        * Generates password with specified lenght
        *
        * @param int $lenght
        * @return void
        */
    function passwordGen($lenght){
		$chars = "nownowtechnologiesbcdfjlmpquvwxyz0123456789";
		return substr(str_shuffle($chars),0, $lenght);
	}
}
