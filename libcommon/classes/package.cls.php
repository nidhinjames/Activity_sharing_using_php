<?
class Package {

	var $packageName;
	var $packageLoanDuration;
	var $maxbookAllowed;
	var $packagePrice;
	var $packageFineAmount;
	var $packagePeriod;
	var $packageID;

	function createPackage() {
		
		global $connect;
		$sql = "INSERT INTO Packages
			( packageName, packagePeriod )
			VALUES
			( \"$this->packageName\",  
			 \"$this->packagePeriod\")";
		echo $sql;
		$result = sql_query($sql, $connect);
		return $result;	
	}
	
	function updatePackage() {
	
		global $connect;
		$sql = "UPDATE Packages SET
			packageName=\"$this->packageName\",
			packagePeriod=\"$this->packagePeriod\"
			where packageID=\"$this->packageID\"";
		$result = sql_query($sql, $connect);
		//userUnderPackage($this->packageID);
		return $result; 
	}

	function getPackagePeriod($packageID) {
		
		global $connect;
		$sql = "select packagePeriod FROM Packages WHERE packageID=\"$packageID\"";
		$result = sql_query( $sql, $connect);
		$row = sql_fetch_row($result);
		return $row[0];
	}
	
	function getPackageName($packageID) {
		
		global $connect;
		$sql = "select packageName FROM Packages WHERE packageID=\"$packageID\"";
		$result = sql_query( $sql, $connect);
		$row = sql_fetch_row($result);
		return $row[0];
	}
	function getPackagemaxbookAllowed($packageID) {
		
		global $connect;
		$sql = "select maxbookAllowed FROM Packages WHERE packageID=\"$packageID\"";
		$result = sql_query( $sql, $connect);
		$row = sql_fetch_row($result);
		return $row[0];
	}
	function getPackagePrice($packageID) {
		
		global $connect;
		$sql = "select packagePrice FROM Packages WHERE packageID=\"$packageID\"";
		$result = sql_query( $sql, $connect);
		$row = sql_fetch_row($result);
		return $row[0];
	}
}

function userUnderPackage($packageID) {

	global $connect;

	$pkgperiod = $cPkg->getPackagePeriod($packageID);
        $userCreateTime = date("Y-m-d H:i:s ");
        $timeStamp = strtotime($userCreateTime);
        $timeStamp += 24 * 60 * 60 * $pkgperiod; 
        $userExpire = date("Y-m-d  H:i:s", $timeStamp);

	$sql = "select userID from Useraccount where packageID=\"$packageID\"";
	$result = sql_query( $sql, $connect);
	while( $row = sql_fetch_row($result)) {
	
		$sql = "";
	}
}
?>
