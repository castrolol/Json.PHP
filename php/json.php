<?php

	require "prototype.object.php";

	class Json extends Object {

		public function send(){
			$jHelper = new JsonHelper;
			$jHelper->send($this);
		}

		public function has($prop){
			return isset($this->{$prop});
		}

	}


	class JsonHelper {

		private function makeObject($obj){
			$jsonObj = new Json;

			foreach((array)$obj as $k => $v){
				if(gettype($v) == "object"){
					$jsonObj->{$k} =  $this->makeObject($v);
				}else{
					$jsonObj->{$k} = $v;
				}
			}

			return $jsonObj;
		}

		public function receive(){
			try{
				$body = file_get_contents("php://input");
				 
				$jsonDecode = $this->makeObject(json_decode($body));
				return $jsonDecode;
			}catch(Exception $e){
				 
				return new Json;
			}
		}

		public function send($obj){
			ob_clean();
			if( !isset($obj) ) $obj = $json;
			die(json_encode($obj));
		}

	}

	$jsonHelper = new JsonHelper;
	$json = $jsonHelper->receive();

?>