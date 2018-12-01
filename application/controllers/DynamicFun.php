
	function fetchItemId(){
		header("Content-Type: application/json");
		$itemCode = $_POST["itemCode"];
		$result = $this->SaleMod->fetchItemId($itemCode);
		echo json_encode($result);
	}
