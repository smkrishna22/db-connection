<?php 

require_once('php/handle.php');

	if($_POST || file_get_contents("php://input")){
		if($_POST){
			$arr = $_POST;
		}elseif(file_get_contents("php://input")){
			$arr = json_decode(file_get_contents("php://input"),true);
		}
		$handle = new Handle;

		if($arr['typeReq']){
			if($arr['data'] && is_array($arr['data']) && $arr['data'][0]){
				$data = array();
				foreach($arr['data'] as $k=>$v){
					$data[$v['name']] = $v['value'];
				}
				if(!$data['typeReq']){
					$data['typeReq'] = $arr['typeReq'];
				}
				$arr = $data;
			}

			switch($arr['typeReq']){
				case 'zayavka':
					$handle->set_zayavka($arr);
				break;
			}
		}
	}

?>