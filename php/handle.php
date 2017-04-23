<?php
require_once('db_connection.php');

class Handle extends  Db_connection{
	protected $website_domain = '';
	protected $list_form_zayavki = array(
		"id",
		"utm",
		"source",
		"name",
		"phone",
		"date"
	);

	function __construct($type='ajax'){
		$this->type = $type;;
	} 

	protected function clearData($data,$type='s'){
		switch($type){
			case 's':
				$data = strip_tags(trim($data));
			break;
			case 'i':
				$data = $data*1;
			break;
			case "email":
				$email =  addslashes(strip_tags(trim($data)));
				if( filter_var($email, FILTER_VALIDATE_EMAIL) ){
					return $email;
				}else{
					return false;
				}
			break;
		}
		return $data;
	}

	protected $msgs = array(
		"default" => array(
			"suc" 		=> "Спасибо!<br />Мы с Вами свяжемся в ближайшее время.",
			"err" 		=> "Извините произошла ошибка.<br />Пожалуйста повторите!",
			"err_email"	=> "Извините Ваш email не корректный.<br />Пожалуйста введите правильный email"
		)
	);

	public function set_zayavka($data){
		//var_dump($data);
		$arr = array();
		foreach($this->list_form_zayavki as $v){
			if($v == "date"){
				$arr[$v] = date('d-m-Y H:i:s');
			}elseif($v == 'name'){
				$arr[$v] = (isset($data[$v]) && !empty($data[$v])  ? addslashes($this->clearData($data[$v])) : '');
			}elseif($v == 'id'){
				$arr[$v] = $this->get_id('zayavka');
			}elseif($v == "email"){

				$arr[$v] = (isset($data[$v]) && !empty($data[$v])  ? $this->clearData($data[$v],'email') : '');
				if(!$arr[$v]){
					echo json_encode(array("error"=>"1","data"=>$this->msgCtrl('err_email','default')) );
					return;
				}
			}else{
				$arr[$v] = (isset($data[$v]) && !empty($data[$v])  ? $this->clearData($data[$v]) : '');
			}
		}
		
		$result = $this->set_data('zayavka',implode(', ',$this->list_form_zayavki),implode("','",$arr));
		
		if($result){
			
			if($this->type == 'ajax'){
				echo json_encode(array("error"=>"0","data"=>$this->msgCtrl('suc','default','',$liqpay_btn)) );
			}else{
				return array("error"=>"0","data"=>$this->msgCtrl('suc','default','',$liqpay_btn));
			}	
		}else{
			if($this->type == 'ajax'){
				echo json_encode( array("error"=>"1",$this->msgCtrl('err','default')) );
			}else{
				return array("error"=>"1","data"=>$this->msgCtrl('err','default'));
			}	
		}
	}

	private function msgCtrl($type_msg,$type,$args=''){
		$msg = '';
		if($type && $this->msgs[$type] && $this->msgs[$type][$type_msg]){
			if( is_array($this->msgs[$type][$type_msg]) ){
				$msg = $this->msgs[$type][$type_msg][$args];
			}else{
				$msg = $this->msgs[$type][$type_msg];
			}
		}else{
			$msg = $this->msgs['default'][$type_msg];
		}
		
		return $msg;
	}

}

?>