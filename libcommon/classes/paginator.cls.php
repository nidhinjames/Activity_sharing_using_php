<?
class paginator
{
	var $SQL;

	// Maximum data will be displayed on page
	var $maxDataPerPage;

	// URL for navigation on next and previous page
	var $URL;

	// last index of data on a page
	var $endDataPerPage;

	// max page number link in a page
	var $maxTotalLinkPage;


	function executeQuery()
	{
		global $connect;		// Database Connection ID
		$result	= sql_query($this->SQL,	$connect);
		return $result;
	}


	function errorReporting()
	{
		global $connect;		// Database Connection ID
		$result	= sql_query($this->SQL,	$connect);
		echo sql_error();
	}

	function getQueryResult()
	{
		$row		= sql_fetch_array($this->executeQuery());
		return $row;
	}

	function getTotalRows()
	{
		$total	= sql_num_rows($this->executeQuery());
		return $total;
	}

	function getTotalFields()
	{
		$total	= sql_num_fields($this->executeQuery());
		return $total;
	}

	function getLastTotalData()
	{
		return ($this->getTotalRows() - $this->maxDataPerPage);
	}

	function nextStart($start=0)
	{
		if($start<0 || !$start) $start = 0;
		return ($start + $this->maxDataPerPage);
	}

	function prevStart($start=0)
	{
		if($start<0 || !$start) $start = 0;
		return ($start - $this->maxDataPerPage);
	}

	function validateStartValue($start=0)
	{
		if($start<0 || !$start) $start = 0;
		return $start;
	}

	function dataOnEachPage($start=0)
	{
		if($start<0 || !$start) $start = 0;
		$totalRows 	  = $this->getTotalRows();
		$totalFields  = $this->getTotalFields();		
		$result		  = $this->executeQuery();
		
		
		if($totalRows > ($start+$this->maxDataPerPage)) $this->endDataPerPage = $start+$this->maxDataPerPage;
		else $this->endDataPerPage  = $totalRows;

		for($i=$start; $i<$this->endDataPerPage ; $i++)
		{
			for($j=0; $j<$totalFields; $j++)
			{
				$data[$i][$j]	= sql_result($result, $i, $j);
			}
		}

		return $data;
	}

	function navPage($start=0)
	{
		global $l_general;

		if($start<0 || !$start) $start = 0;

		$totalData = $this->getTotalRows();
		$endData   = $this->getLastTotalData();

		$nextLink  = "<a href='".$this->URL."&start=".$this->nextStart($start)."'>Next >></a>";
		$prevLink  = "<a href='".$this->URL."&start=".$this->prevStart($start)."'><< Prev</a>";

   		if($start==0 && $start<$this->maxDataPerPage && $start<$totalData && $totalData>$this->maxDataPerPage) 
		{
			return "<span style=\"color:#CCC;\"><< Prev</span><span style=\"margin-left:60px;\"></span>$nextLink";
		}
	
   		else if($start>=$this->maxDataPerPage && $start<$endData )
		{	
			return "$prevLink<span style=\"margin-left:60px;\"></span>$nextLink";
		}
   		else if($start>=$endData && $start<$totalData && $totalData>$this->maxDataPerPage)
		{
			return "$prevLink<span style=\"margin-left:60px;\"></span><span style=\"color:#CCC;\">Next >></span>";
		}

	}
	 

	function quickJump($start=0)
	{
		global $l_lang;

		$totalData = $this->getTotalRows();
		$totalPage = ceil($totalData / $this->maxDataPerPage);

		if($totalPage > 1)
		{
			// Specify page index.
			$iPage = ($start / $this->maxDataPerPage)+1; 

			// Specify start and stop index of page will be displayed as link
			if(($iPage + $this->maxTotalLinkPage - 1) > $totalPage)
			{ 
				$startPage = $totalPage - $this->maxTotalLinkPage;
				$endPage = $totalPage;
			}
			else 
			{
				$startPage = $iPage - 1;
				$endPage = $startPage + $this->maxTotalLinkPage;
			}
			if($startPage <= 0) $startPage = 1;

			if($totalPage > $this->maxTotalLinkPage)
			{ 
				$nav .= "<a href='".$this->URL."&start=0'>".$l_lang['first']."<<</a>&nbsp;... ";
			}

			for($i=$startPage;$i<=$endPage;$i++)
			{
				$startVal = ($i-1) * $this->maxDataPerPage;
				if($startVal == $start) $nav .= "<span id=\"selpage\">$i</span>&nbsp;";
				else $nav .= "<a href='".$this->URL."&start=$startVal'>$i</a>&nbsp;";
			}

			if($totalPage > $this->maxTotalLinkPage)
			{ 
				$startVal = ($totalPage - 1) * $this->maxDataPerPage;
				$nav .= "... <a href='".$this->URL."&start=$startVal'>>>".$l_lang['last']."</a>&nbsp;";
			}
			return $nav;			
		}
				
	}
	
	
	function navPageLeft($start=0)
	{
		global $l_general;

		if($start<0 || !$start) $start = 0;

		$totalData = $this->getTotalRows();
		$endData   = $this->getLastTotalData();
		
		$prevLink  = "<li><a href='".$this->URL."&start=".$this->prevStart($start)."'>&laquo;</a></li>";
		//$nextLink  = "<li><a href='".$this->URL."&start=".$this->nextStart($start)."'>&raquo;</a></li>";

		if(!($start==0 && $start<$this->maxDataPerPage && $start<$totalData && $totalData>$this->maxDataPerPage))
		{
			return $prevLink;
		}
   		

	}
	
	function navPageRight($start=0)
	{
		global $l_general;

		if($start<0 || !$start) $start = 0;

		$totalData = $this->getTotalRows();
		$endData   = $this->getLastTotalData();
		
		if(!($start>=$endData && $start<$totalData && $totalData>$this->maxDataPerPage))
		{
			$nextLink  = "<li><a href='".$this->URL."&start=".$this->nextStart($start)."'>&raquo;</a></li>";
		}
   		return $nextLink;
	}
	
	function quickJumpBootstrap($start=0)
	{
		global $l_lang;

		$totalData = $this->getTotalRows();
		$totalPage = ceil($totalData / $this->maxDataPerPage);

		if($totalPage > 1)
		{
			// Specify page index.
			$iPage = ($start / $this->maxDataPerPage)+1; 

			// Specify start and stop index of page will be displayed as link
			if(($iPage + $this->maxTotalLinkPage - 1) > $totalPage)
			{ 
				$startPage = $totalPage - $this->maxTotalLinkPage;
				$endPage = $totalPage;
			}
			else 
			{
				$startPage = $iPage - 1;
				$endPage = $startPage + $this->maxTotalLinkPage;
			}
			if($startPage <= 0) $startPage = 1;

			if($totalPage > $this->maxTotalLinkPage)
			{ 
				//$nav .= "<a href='".$this->URL."&start=0'>".$l_lang['first']."<<</a>&nbsp;... ";
			}

			for($i=$startPage;$i<=$endPage;$i++)
			{
				$startVal = ($i-1) * $this->maxDataPerPage;
				if($startVal == $start) 
				{
					$nav .= "<li class='active' ><a href='' >$i</a></li>";
				}
				else 
				{
					$nav .= "<li><a href='".$this->URL."&start=$startVal'>$i</a></li>";
				}
			}

			if($totalPage > $this->maxTotalLinkPage)
			{ 
				$startVal = ($totalPage - 1) * $this->maxDataPerPage;
				//$nav .= "... <a href='".$this->URL."&start=$startVal'>>>".$l_lang['last']."</a>&nbsp;";
			}
			return $nav;			
		}
				
	}
	
	
}
?>
