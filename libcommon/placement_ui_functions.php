<?

function mark_filter_ui($markSystem, $frameWork, $courseTypeID, $courseTypeName, $courseTypeDesc, $markString)
{
	//echo $markSystem.$frameWork.$courseTypeID.$courseTypeName.$courseTypeDesc;
	// mark = "BETWEEN:5,6";
			if($markString)
			{
				$first = explode(":", $markString);
				//print_r($first);
				if($first[0] == "ALL")
					$checked = "ALL";
				else if($first[0] == "BETWEEN")
				{
					$checked = "BETWEEN";
					$second = explode(",", $first[1]);
					//print_r($second);
					$start = $second[0];
					$end = $second[1];
				}
				else if($first[0] == "ABOVE")
				{
					$checked = "ABOVE";
					$above = $first[1];
				}
				else if($first[0] == "BELOW")
				{
					$checked = "BELOW";
					$below = $first[1];
				}
			}
			else
			{
				$checked = "ALL";
			}
	
	if($frameWork == "BOOTSTRAP")
	{
		
		if($markSystem == 0)
		{
			echo "<div class=\"form-group\" style='display:none' >";
				echo "<label for=\"selectPriv\" class=\"col-sm-6 col-md-6 col-lg-6 control-label\" style=\"text-align:left;\" >$courseTypeDesc : </label>";
				echo "<div class=\"col-sm-6 col-md-6 col-lg-6\">";
					echo "<input type='checkbox' id='panelCheck$courseTypeID' onclick='panel_show($courseTypeID)' >";
				echo "</div>";
				//echo "<div class=\"col-sm-4 col-md-4 col-lg-4\" id=\"title_msg$courseTypeID\"></div>";
			echo "</div>";
			
			echo "<div class=\"panel panel-default cls$courseTypeID courses\" id='$courseTypeID' style='display:none' >";
				echo "<div class=\"panel-body\" ><label class=\"col-md-12\">Set marks: $courseTypeDesc</label></div>";
				echo "<div class=\"panel-body\" >";
					echo "<div class=\"row fields\" style=\"margin:0;\" >";
					
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"  >";
							echo "All : <div class=\"make-switch switch-small\" id=\"dimension-switch1$courseTypeID\" ><input type=\"radio\" id=\"allRad$courseTypeID\" name=\"$courseTypeID\"  onchange=\"changeField('$courseTypeID')\" checked></div>";
						echo "</div>";
						
					echo "</div>";
					
				echo "</div>";
			echo "</div>";
		}
		else if($markSystem == 1)
		{
			echo "<div class=\"form-group\">";
				echo "<label for=\"selectPriv\" class=\"col-sm-6 col-md-6 col-lg-6 control-label\" style=\"text-align:left;\" >$courseTypeDesc : </label>";
				echo "<div class=\"col-sm-6 col-md-6 col-lg-6\">";
					echo "<input type='checkbox' id='panelCheck$courseTypeID' onclick='panel_show($courseTypeID)' >";
				echo "</div>";
				//echo "<div class=\"col-sm-4 col-md-4 col-lg-4\" id=\"title_msg$courseTypeID\"></div>";
			echo "</div>";
		
			echo "<input type='hidden' id='limit_mark$courseTypeID' value='100' >";
			
			echo "<div class=\"panel panel-default cls$courseTypeID courses\" id='$courseTypeID' >";
				echo "<div class=\"panel-body\" ><label class=\"col-md-12\">Set marks: $courseTypeDesc</label></div>";
				echo "<div class=\"panel-body\" >";
					echo "<div class=\"row fields\" style=\"margin:0;\" >";
					
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"  >";
						if($checked == "ALL")
						{
							echo "All : <div class=\"make-switch switch-small\" id=\"dimension-switch1$courseTypeID\" ><input type=\"radio\" id=\"allRad$courseTypeID\" name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\" checked></div>";
						}
						else
						{
							echo "All : <div class=\"make-switch switch-small\" id=\"dimension-switch1$courseTypeID\" ><input type=\"radio\" id=\"allRad$courseTypeID\" name=\"$courseTypeID\"  onchange=\"changeField('$courseTypeID')\" ></div>";
						}
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"  >";
						if($checked == "BETWEEN")
						{
							echo "Between: <div class=\"make-switch switch-small\" id=\"dimension-switch2$courseTypeID\" ><input type=\"radio\" id=\"fromRad$courseTypeID\" name=\"$courseTypeID\"  onchange=\"changeField('$courseTypeID')\" checked></div>";
						}
						else
						{
							echo "Between: <div class=\"make-switch switch-small\" id=\"dimension-switch2$courseTypeID\" ><input type=\"radio\" id=\"fromRad$courseTypeID\" name=\"$courseTypeID\"  onchange=\"changeField('$courseTypeID')\" ></div>";
						}
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\" >";
						if($checked == "ABOVE")
						{
							echo "Above: <div class=\"make-switch switch-small\" id=\"dimension-switch3$courseTypeID\" ><input type=\"radio\" id=\"aboveRad$courseTypeID\"  name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\"  checked></div>";
						}
						else
						{
							echo "Above: <div class=\"make-switch switch-small\" id=\"dimension-switch3$courseTypeID\" ><input type=\"radio\" id=\"aboveRad$courseTypeID\"  name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\"  ></div>";
						}
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\" >";
						if($checked == "BELOW")
						{
							echo "Below: <div class=\"make-switch switch-small\" id=\"dimension-switch4$courseTypeID\" ><input type=\"radio\" id=\"belowRad$courseTypeID\" name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\"  checked></div>";
						}
						else
						{
							echo "Below: <div class=\"make-switch switch-small\" id=\"dimension-switch4$courseTypeID\" ><input type=\"radio\" id=\"belowRad$courseTypeID\" name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\"  ></div>";
						}
						echo "</div>";
						
					echo "</div>";
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\"  id=\"addField\" >";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\" >";
							echo "<div id=\"all_msg$courseTypeID\"></div>";
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">";
						if($checked == "BETWEEN")
						{
							echo "<div id=\"addField1$courseTypeID\">";
								echo "<div>";
									echo "From: <input type=\"text\" id=\"from$courseTypeID\" style=\"width:18%;\" value='".$start."' >% To: <input type=\"text\" id=\"to$courseTypeID\" style=\"width:18%;\" value='".$end."' >%";
								echo "</div>";
								echo "<div id=\"between_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						else
						{
							echo "<div id=\"addField1$courseTypeID\" style='display:none;' >";
								echo "<div>";
									echo "From: <input type=\"text\" id=\"from$courseTypeID\" style=\"width:18%;\" value='".$start."' >% To: <input type=\"text\" id=\"to$courseTypeID\" style=\"width:18%;\" value='".$end."' >%";
								echo "</div>";
								echo "<div id=\"between_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">";
						if($checked == "ABOVE")
						{
							echo "<div id=\"addField2$courseTypeID\">";
								echo "<div>";
									echo "Percentage : <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='".$above."' >";
								echo "</div>";
								echo "<div id=\"above_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						else
						{
							echo "<div id=\"addField2$courseTypeID\" style='display:none;' >";
								echo "<div>";
									echo "Percentage : <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='".$above."' >";
								echo "</div>";
								echo "<div id=\"above_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">";
						if($checked == "BELOW")
						{
							echo "<div id=\"addField3$courseTypeID\">";
								echo "<div>";
									echo "Percentage : <input type=\"text\" id=\"below$courseTypeID\" style=\"width:18%;\" value='".$below."' >";
								echo "</div>";
								echo "<div id=\"below_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						else
						{
							echo "<div id=\"addField3$courseTypeID\" style='display:none;' >";
								echo "<div>";
									echo "Percentage : <input type=\"text\" id=\"below$courseTypeID\" style=\"width:18%;\" value='".$below."' >";
								echo "</div>";
								echo "<div id=\"below_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						echo "</div>";
						
					echo "</div>";
					
				echo "</div>";
			echo "</div>";
			//echo "</div>"; // ADDED DIV
		}
		else if($markSystem == 2)
		{
			echo "<div class=\"form-group\">";
				echo "<label for=\"selectPriv\" class=\"col-sm-6 col-md-6 col-lg-6 control-label\" style=\"text-align:left;\" >$courseTypeDesc : </label>";
				echo "<div class=\"col-sm-6 col-md-6 col-lg-6\">";
					echo "<input type='checkbox' id='panelCheck$courseTypeID' onclick='panel_show($courseTypeID)' >";
				echo "</div>";
				//echo "<div class=\"col-sm-4 col-md-4 col-lg-4\" id=\"title_msg$courseTypeID\"></div>";
			echo "</div>";
		
			echo "<input type='hidden' id='limit_mark$courseTypeID' value='10' >";
		
			echo "<div class=\"panel panel-default cls$courseTypeID courses \" id='$courseTypeID' >";
				echo "<div class=\"panel-body\" ><label class=\"col-md-12\">Set marks: $courseTypeDesc</label></div>";
				echo "<div class=\"panel-body\" >";
					echo "<div class=\"row fields\" style=\"margin:0;\" >";
					
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"  >";
						if($checked == "ALL")
						{
							echo "All : <div class=\"make-switch switch-small\" id=\"dimension-switch1$courseTypeID\" ><input type=\"radio\" id=\"allRad$courseTypeID\" name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\" checked></div>";
						}
						else
						{
							echo "All : <div class=\"make-switch switch-small\" id=\"dimension-switch1$courseTypeID\" ><input type=\"radio\" id=\"allRad$courseTypeID\" name=\"$courseTypeID\"  onchange=\"changeField('$courseTypeID')\" ></div>";
						}
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"  >";
						if($checked == "BETWEEN")
						{
							echo "Between: <div class=\"make-switch switch-small\" id=\"dimension-switch2$courseTypeID\" ><input type=\"radio\" id=\"fromRad$courseTypeID\" name=\"$courseTypeID\"  onchange=\"changeField('$courseTypeID')\" checked></div>";
						}
						else
						{
							echo "Between: <div class=\"make-switch switch-small\" id=\"dimension-switch2$courseTypeID\" ><input type=\"radio\" id=\"fromRad$courseTypeID\" name=\"$courseTypeID\"  onchange=\"changeField('$courseTypeID')\" ></div>";
						}
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\" >";
						if($checked == "ABOVE")
						{
							echo "Above: <div class=\"make-switch switch-small\" id=\"dimension-switch3$courseTypeID\" ><input type=\"radio\" id=\"aboveRad$courseTypeID\"  name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\"  checked></div>";
						}
						else
						{
							echo "Above: <div class=\"make-switch switch-small\" id=\"dimension-switch3$courseTypeID\" ><input type=\"radio\" id=\"aboveRad$courseTypeID\"  name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\"  ></div>";
						}
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\" >";
						if($checked == "BELOW")
						{
							echo "Below: <div class=\"make-switch switch-small\" id=\"dimension-switch4$courseTypeID\" ><input type=\"radio\" id=\"belowRad$courseTypeID\" name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\"  checked></div>";
						}
						else
						{
							echo "Below: <div class=\"make-switch switch-small\" id=\"dimension-switch4$courseTypeID\" ><input type=\"radio\" id=\"belowRad$courseTypeID\" name=\"$courseTypeID\" onchange=\"changeField('$courseTypeID')\"  ></div>";
						}
						echo "</div>";
						
					echo "</div>";
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\"  id=\"addField\" >";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\" >";
							echo "<div id=\"all_msg$courseTypeID\"></div>";
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">";
						if($checked == "BETWEEN")
						{
							echo "<div id=\"addField1$courseTypeID\">";
								echo "<div>";
									echo "From: <input type=\"text\" id=\"from$courseTypeID\" style=\"width:18%;\" value='".$start."' > To: <input type=\"text\" id=\"to$courseTypeID\" style=\"width:18%;\" value='".$end."' >(in CGPA)";
								echo "</div>";
								echo "<div id=\"between_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						else
						{
							echo "<div id=\"addField1$courseTypeID\" style='display:none;' >";
								echo "<div>";
									echo "From: <input type=\"text\" id=\"from$courseTypeID\" style=\"width:18%;\" value='".$start."' > To: <input type=\"text\" id=\"to$courseTypeID\" style=\"width:18%;\" value='".$end."' >(in CGPA)";
								echo "</div>";
								echo "<div id=\"between_msg$courseTypeID\"></div>";
							echo "</div>";
						}
							
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">";
						if($checked == "ABOVE")
						{
							echo "<div id=\"addField2$courseTypeID\">";
								echo "<div>";
									echo "CGPA : <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='".$above."' >";
								echo "</div>";
								echo "<div id=\"above_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						else
						{
							echo "<div id=\"addField2$courseTypeID\" style='display:none;' >";
								echo "<div>";
									echo "CGPA : <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='".$above."' >";
								echo "</div>";
								echo "<div id=\"above_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						echo "</div>";
						
						echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">";
						if($checked == "BELOW")
						{
							echo "<div id=\"addField3$courseTypeID\">";
								echo "<div>";
									echo "CGPA : <input type=\"text\" id=\"below$courseTypeID\" style=\"width:18%;\" value='".$below."' >";
								echo "</div>";
								echo "<div id=\"below_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						else
						{
							echo "<div id=\"addField3$courseTypeID\" style='display:none;' >";
								echo "<div>";
									echo "CGPA : <input type=\"text\" id=\"below$courseTypeID\" style=\"width:18%;\" value='".$below."' >";
								echo "</div>";
								echo "<div id=\"below_msg$courseTypeID\"></div>";
							echo "</div>";
						}
						echo "</div>";
						
					echo "</div>";
				echo "</div>";
			echo "</div>";
			//echo "</div>"; // ADDED DIV
		}
		
		
	}
	
}

function round_ui($markSystem, $frameWork, $courseTypeID, $courseTypeName, $courseTypeDesc, $markString)
{
			if($markString)
			{
				$first = explode(":", $markString);
				//print_r($first);
				if($first[0] == "ALL")
					$checked = "ALL";
				else if($first[0] == "BETWEEN")
				{
					$checked = "BETWEEN";
					$second = explode(",", $first[1]);
					//print_r($second);
					$start = $second[0];
					$end = $second[1];
				}
				else if($first[0] == "ABOVE")
				{
					$checked = "ABOVE";
					$above = $first[1];
				}
				else if($first[0] == "BELOW")
				{
					$checked = "BELOW";
					$below = $first[1];
				}
			}
			else
			{
				$checked = "ALL";
			}
	
	if($frameWork == "BOOTSTRAP")
	{
		
		if($markSystem == 0)
		{
			echo "
					<div class=\"panel panel-default cls$courseTypeID courses \" style='display:none;' id='$courseTypeID' >
					<div class=\"panel-body\" ><label class=\"col-md-12\">$courseTypeDesc</label></div>
					<div class=\"panel-body\" >
					";
						echo "<input type='hidden' id='type$courseTypeID' value='ALL'>";
				echo "</div></div>";
		}
		else if($markSystem == 1)
		{
			echo "
					<div class=\"panel panel-default cls$courseTypeID courses \" style='height:175px;' id='$courseTypeID' >
					<div class=\"panel-body\" ><label class=\"col-md-12\">$courseTypeDesc</label></div>
					<div class=\"panel-body\" >
					";
						echo "<input type='hidden' id='courselimit$courseTypeID' value='100' >";
				//echo $firstPg[0]."HAI";	
				if($first[0] == "ALL")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Above: <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='0' >(in %)
								<br> (Previous CGPA limit $above)
								<input type='hidden' id='limit$courseTypeID' value='$above'>
								<input type='hidden' id='type$courseTypeID' value='ABOVE'>
								</div>
								<div id=\"above_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "BETWEEN")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								From: <input type=\"text\" id=\"from$courseTypeID\" style=\"width:18%;\" value='$start' > To: <input type=\"text\" id=\"to$courseTypeID\" style=\"width:18%;\" value='$end' readonly>(in %)
								<br> (Previous From CGPA limit $start)
								<input type='hidden' id='limit$courseTypeID' value='$start'>
								<input type='hidden' id='type$courseTypeID' value='BETWEEN'>
								</div>
								<div id=\"between_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "ABOVE")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Above: <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='$above' >(in %)
								<br> (Previous CGPA limit $above)
								<input type='hidden' id='type$courseTypeID' value='ABOVE'>
								<input type='hidden' id='limit$courseTypeID' value='$above'>
								</div>
								<div id=\"above_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "BELOW")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Below: <input type=\"text\" id=\"below$courseTypeID\" style=\"width:18%;\" >(in %)
								<br> (Previous CGPA limit $below)
								<input type='hidden' id='type$courseTypeID' value='BELOW'>
								<input type='hidden' id='limit$courseTypeID' value='$below'>
								</div>
								<div id=\"below_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
					
					
				echo "</div></div>";
		}
		else if($markSystem == 2)
		{
			echo "
					<div class=\"panel panel-default cls$courseTypeID courses \" id='$courseTypeID' style='height:175px;' >
					<div class=\"panel-body\" ><label class=\"col-md-12\">".$courseTypeDesc."</label></div>
					<div class=\"panel-body\" >
					";
						echo "<input type='hidden' id='courselimit$courseTypeID' value='100' >";
				//echo $firstPg[0]."HAI";	
				if($first[0] == "ALL")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Above: <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='0' >(in CGPA)
								<br> (Previous CGPA limit $above)
								<input type='hidden' id='limit$courseTypeID' value='$above'>
								<input type='hidden' id='type$courseTypeID' value='ABOVE'>
								</div>
								<div id=\"above_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "BETWEEN")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								From: <input type=\"text\" id=\"from$courseTypeID\" style=\"width:18%;\" value='$start' > To: <input type=\"text\" id=\"to$courseTypeID\" style=\"width:18%;\" value='$end' readonly>(in CGPA)
								<br> (Previous From CGPA limit $start)
								<input type='hidden' id='limit$courseTypeID' value='$start'>
								<input type='hidden' id='type$courseTypeID' value='BETWEEN'>
								</div>
								<div id=\"between_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "ABOVE")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Above: <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='$above' >(in CGPA)
								<br> (Previous CGPA limit $above)
								<input type='hidden' id='type$courseTypeID' value='ABOVE'>
								<input type='hidden' id='limit$courseTypeID' value='$above'>
								</div>
								<div id=\"above_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "BELOW")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Below: <input type=\"text\" id=\"below$courseTypeID\" style=\"width:18%;\" >(in CGPA)
								<br> (Previous CGPA limit $below)
								<input type='hidden' id='type$courseTypeID' value='BELOW'>
								<input type='hidden' id='limit$courseTypeID' value='$below'>
								</div>
								<div id=\"below_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
					
					
				echo "</div></div>";
		}
		
	}
}


function round_ui_limit($markSystem, $frameWork, $courseTypeID, $courseTypeName, $courseTypeDesc, $markString, $limitMarkString)
{
			if($markString)
			{
				$first = explode(":", $markString);
				//print_r($first);
				if($first[0] == "ALL")
				{
					$checked = "ALL";
				}
				else if($first[0] == "BETWEEN")
				{
					$checked = "BETWEEN";
					$second = explode(",", $first[1]);
					//print_r($second);
					$start = $second[0];
					$end = $second[1];
				}
				else if($first[0] == "ABOVE")
				{
					$checked = "ABOVE";
					$above = $first[1];
					
				}
				else if($first[0] == "BELOW")
				{
					$checked = "BELOW";
					$below = $first[1];
				}
			}
			else
			{
				$checked = "ALL";
			}
			
			if($limitMarkString)
			{
				$first1 = explode(":", $limitMarkString);
				//print_r($first);
				if($first1[0] == "ALL")
				{
					$checked = "ALL";
					$abovelimit = 0;
				}
				else if($first1[0] == "BETWEEN")
				{
					$checked = "BETWEEN";
					$second = explode(",", $first1[1]);
					//print_r($second);
					$startlimit = $second[0];
					$endlimit = $second[1];
				}
				else if($first1[0] == "ABOVE")
				{
					$checked = "ABOVE";
					$abovelimit = $first1[1];
				}
				else if($first1[0] == "BELOW")
				{
					$checked = "BELOW";
					$belowlimit = $first1[1];
				}
			}
			else
			{
				$checked = "ALL";
			}
			
			
	
	if($frameWork == "BOOTSTRAP")
	{
		
		if($markSystem == 0)
		{
			echo "
					<div class=\"panel panel-default cls$courseTypeID courses \" style='display:none;' id='$courseTypeID' >
					<div class=\"panel-body\" ><label class=\"col-md-12\">$courseTypeDesc</label></div>
					<div class=\"panel-body\" >
					";
						echo "<input type='hidden' id='type$courseTypeID' value='ALL'>";
				echo "</div></div>";
		}
		else if($markSystem == 1)
		{
			echo "
					<div class=\"panel panel-default cls$courseTypeID courses \" style='height:175px;' id='$courseTypeID' >
					<div class=\"panel-body\" ><label class=\"col-md-12\">$courseTypeDesc</label></div>
					<div class=\"panel-body\" >
					";
						echo "<input type='hidden' id='courselimit$courseTypeID' value='100' >";
				//echo $firstPg[0]."HAI";	
				if($first[0] == "ALL")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Above: <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='0' >(in %)
								<br> (Previous CGPA limit $abovelimit)
								<input type='hidden' id='limit$courseTypeID' value='$abovelimit'>
								<input type='hidden' id='type$courseTypeID' value='ABOVE'>
								</div>
								<div id=\"above_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "BETWEEN")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								From: <input type=\"text\" id=\"from$courseTypeID\" style=\"width:18%;\" value='$start' > To: <input type=\"text\" id=\"to$courseTypeID\" style=\"width:18%;\" value='$end' readonly>(in %)
								<br> (Previous From CGPA limit $startlimit)
								<input type='hidden' id='limit$courseTypeID' value='$startlimit'>
								<input type='hidden' id='type$courseTypeID' value='BETWEEN'>
								</div>
								<div id=\"between_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "ABOVE")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Above: <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='$above' >(in %)
								<br> (Previous CGPA limit $abovelimit)
								<input type='hidden' id='type$courseTypeID' value='ABOVE'>
								<input type='hidden' id='limit$courseTypeID' value='$abovelimit'>
								</div>
								<div id=\"above_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "BELOW")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Below: <input type=\"text\" id=\"below$courseTypeID\" style=\"width:18%;\" >(in %)
								<br> (Previous CGPA limit $belowlimit)
								<input type='hidden' id='type$courseTypeID' value='BELOW'>
								<input type='hidden' id='limit$courseTypeID' value='$belowlimit'>
								</div>
								<div id=\"below_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
					
					
				echo "</div></div>";
		}
		else if($markSystem == 2)
		{
			
			
			echo "
					<div class=\"panel panel-default cls$courseTypeID courses \" id='$courseTypeID' style='height:175px;' >
					<div class=\"panel-body\" ><label class=\"col-md-12\">".$courseTypeDesc."</label></div>
					<div class=\"panel-body\" >
					";
						echo "<input type='hidden' id='courselimit$courseTypeID' value='100' >";
				//echo $firstPg[0]."HAI";	
				if($first[0] == "ALL")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Above: <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='0' >(in CGPA)
								<br> (Previous CGPA limit $abovelimit)
								<input type='hidden' id='limit$courseTypeID' value='$abovelimit'>
								<input type='hidden' id='type$courseTypeID' value='ABOVE'>
								</div>
								<div id=\"above_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "BETWEEN")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								From: <input type=\"text\" id=\"from$courseTypeID\" style=\"width:18%;\" value='$start' > To: <input type=\"text\" id=\"to$courseTypeID\" style=\"width:18%;\" value='$end' readonly>(in CGPA)
								<br> (Previous From CGPA limit $startlimit)
								<input type='hidden' id='limit$courseTypeID' value='$startlimit'>
								<input type='hidden' id='type$courseTypeID' value='BETWEEN'>
								</div>
								<div id=\"between_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "ABOVE")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Above: <input type=\"text\" id=\"above$courseTypeID\" style=\"width:18%;\" value='$above' >(in CGPA)
								<br> (Previous CGPA limit $abovelimit)
								<input type='hidden' id='type$courseTypeID' value='ABOVE'>
								<input type='hidden' id='limit$courseTypeID' value='$abovelimit'>
								</div>
								<div id=\"above_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
				else if($first[0] == "BELOW")
				{
					
					echo "<div class=\"row fields\" style=\"margin:3% 0 0 0;\" >";
						echo "<div>
								<div>
								Below: <input type=\"text\" id=\"below$courseTypeID\" style=\"width:18%;\" >(in CGPA)
								<br> (Previous CGPA limit $belowlimit)
								<input type='hidden' id='type$courseTypeID' value='BELOW'>
								<input type='hidden' id='limit$courseTypeID' value='$belowlimit'>
								</div>
								<div id=\"below_msg$courseTypeID\"></div>
								</div>";
					echo "</div>";
				}
					
					
				echo "</div></div>";
		}
		
	}
}




?>
