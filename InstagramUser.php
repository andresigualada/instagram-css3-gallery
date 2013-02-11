<?php
	
	class InstagramUser
	{
		public $name;
		public $images;
		public $pics;
		public $ppr;
		
		private $id;
		
		public function __construct($name = 'instagram', $pics = 12, $ppr = 4) {
			$this->name = $name;
			$this->id = $this->getUserFromId($this->name);
			$this->pics = $pics;
			$this->ppr = $ppr;
			
			if(!empty($this->id))
				$this->images = json_decode($this->getImagesFromUser($this->id, $this->pics));
			else
				return false;
		}
		
		private function getUserFromId($name, $max_users = 1) {
			$raw_data = fetchData("https://api.instagram.com/v1/users/search?q=".$name."&access_token=32752386.040dedc.ee2dc5ee468946138cc3e86dc0053dc3&count=".$max_users);
			$data = json_decode($raw_data);

			if(!empty($data->data[0]))
				return $data->data[0]->id;
			else
				return false;
		}
		
		private function getImagesFromUser($id = 25025320, $count) {
			$raw_data = fetchData("https://api.instagram.com/v1/users/".$id."/media/recent/?access_token=32752386.040dedc.ee2dc5ee468946138cc3e86dc0053dc3&count=".$count);
		
			$data = json_decode($raw_data);	
			$images = fetchImg($data);
			return json_encode($images);
		}
	}