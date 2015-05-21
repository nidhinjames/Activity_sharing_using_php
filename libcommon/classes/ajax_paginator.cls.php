<?
class ajaxPaginator
{
	var $SQL;
        
        var $SQLTOTAlROW;

	// Maximum data will be displayed on page
	var $maxDataPerPage;

	// URL for navigation on next and previous page
	var $URL;

	// last index of data on a page
	var $endDataPerPage;

	// max page number link in a page
	var $maxTotalLinkPage;

	function getTotalRows()
        {
		global $connect;                // Database Connection ID
		$result = sql_query($this->SQLTOTAlROW, $connect);
		$row = sql_fetch_row($result);
		$total = $row[0];
                return $total;
        }
        
	function executeQuery($start=0)
        {
                global $connect;                // Database Connection ID
		$this->SQL = $this->SQL." LIMIT $start ,".($this->maxDataPerPage);
		//echo $this->SQL;
                $result = sql_query($this->SQL, $connect);
		$i = 0;
		while( $row = sql_fetch_row($result)) {
			$datas[] = $row;
			$i++;
		}
		$this->endDataPerPage = $i;
                return $datas;
        }
				
	function ajaxQuickJump($start=0, $div, $url)
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
				if($startVal == $start) $nav .= "<span>$i</span>&nbsp;";
				else $nav .= "<a href=\"#\" onClick=\"jumpPage('".($i-1)."', '$url','$div'); return false;\">$i </a>&nbsp;";
			}

			if($totalPage > $this->maxTotalLinkPage)
			{ 
				$startVal = ($totalPage - 1) * $this->maxDataPerPage;
				$nav .= "... <a href='".$this->URL."&start=$startVal'>>>".$l_lang['last']."</a>&nbsp;";
			}
			return $nav;			
		}
				
	}
}
?>
