$search_value = $this->request->getVar("search_value");
			$search_column = $this->request->getVar("search_column");
			$order_by_column_name = $this->request->getVar("order_by_column_name");
			if(empty($order_by_column_name)){
				$order_by_column_name = 1;
			}
			$sort_by = $this->request->getVar("sort_by");
			if(empty($sort_by)){
				$sort_by = " DESC ";
			}
			$page_no = $this->request->getVar("page_no");
			if(empty($page_no)){
				$page_no = 1;
			}
			$data_limit = $this->request->getVar("data_limit");
			if(empty($data_limit)){
				$data_limit = 10;
			}


			$sql = "";
			// $sql = " SELECT * FROM ( ";

			$sql = $sql." SELECT '.$_column_names.' FROM '.strtoupper($tableName).'  ";    
			
			// filter or search by column or search in all columns
			// order by required

			$where = " ";
			// if(!(empty($search_value))){
			// $where = " WHERE ";
			// 	if(empty($search_column)){
			// 		// full column search

			// 	}else{
			// 		//particular column search
			// 		$where = $where ." ";
			// 	}
			// }



			$order_by = " ORDER BY $order_by_column_name $sort_by ";

			$sql = $where.$order_by;
			

			// if($page_no == 1){
			// 	if($where == ""){
			// 		$sql = $sql." ROWNUM<=$data_limit ";
			// 	}else{
			// 		$sql = $sql." AND ROWNUM<=$data_limit ";
			// 	}
				
			// }else{
				$startRecord = ($page_no * $data_limit) - $data_limit;
				$endRecord = ($page_no * $data_limit);
				// $sql = $sql." ) OFFSET $startRecord ROWS FETCH NEXT $data_limit ROWS ONLY ";
				$sql = $sql."  OFFSET $startRecord ROWS FETCH NEXT $data_limit ROWS ONLY ";
			//}

			$query = $this->db->query($sql)->getResult("array");
			// $data_to_send = [];
			// foreach ($query as $key => $value) {
			// 	$data_to_send[] = [

			// 						];
			// }
			$data = [
				"results" => $query
				];
			return $this->respond($data);