<?php
/*
pSpring - class to draw spring graphs

Version     : 2.1.4
Made by     : Jean-Damien POGOLOTTI
Last Update : 19/01/2014

This file can be distributed under the license you can find at :

http://www.pchart.net/license

You can find the whole class documentation on the pChart web site.
*/
define("NODE_TYPE_FREE", 690001);
define("NODE_TYPE_CENTRAL", 690002);
define("NODE_SHAPE_CIRCLE", 690011);
define("NODE_SHAPE_TRIANGLE", 690012);
define("NODE_SHAPE_SQUARE", 690013);
define("ALGORITHM_RANDOM", 690021);
define("ALGORITHM_WEIGHTED", 690022);
define("ALGORITHM_CIRCULAR", 690023);
define("ALGORITHM_CENTRAL", 690024);
define("LABEL_CLASSIC", 690031);
define("LABEL_LIGHT", 690032);

/* pSpring class definition */
class pSpring
{
	var $History;
	var $pChartObject;
	var $Data;
	var $Links;
	var $X1;
	var $Y1;
	var $X2;
	var $Y2;
	var $AutoComputeFreeZone;
	var $Labels;
	
	/* Class creator */
	function __construct()
	{
		/* Initialise data arrays */
		$this->Data = [];
		$this->Links = [];
		/* Set nodes defaults */
		$this->Default = ["R" => 255, "G" => 255, "B" => 255, "Alpha" => 100, "BorderR" => 0, "BorderG" => 0, "BorderB" => 0, "BorderAlpha" => 100, "Surrounding" => NULL, "BackgroundR" => 255, "BackgroundG" => 255, "BackgroundB" => 255, "BackgroundAlpha" => 0, "Force" => 1, "NodeType" => NODE_TYPE_FREE, "Size" => 5, "Shape" => NODE_SHAPE_CIRCLE, "FreeZone" => 40, "LinkR" => 0, "LinkG" => 0, "LinkB" => 0, "LinkAlpha" => 0];
		$this->Labels = ["Type" => LABEL_CLASSIC, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 100];
		$this->AutoComputeFreeZone = FALSE;
	}

	/* Set default links options */
	function setLinkDefaults(array $Settings = [])
	{
		#$vars = ["R", "G", "B", "Alpha"];
		foreach ($Settings as $key => $value){
			$this->Default["Link".$key] =  $value;
		}
	}

	/* Set default links options */
	function setLabelsSettings(array $Settings = [])
	{
		#$vars = ["Type", "R", "G", "B", "Alpha"];
		foreach ($Settings as $key => $value){
			$this->Labels[$key] =  $value;
		}	
	}

	/* Auto compute the FreeZone size based on the number of connections */
	function autoFreeZone()
	{
		/* Check connections reciprocity */
		foreach($this->Data as $Key => $Settings) {
			$this->Data[$Key]["FreeZone"] = (isset($Settings["Connections"])) ? count($Settings["Connections"]) * 10 + 20 : 20;
		}
	}

	/* Set link properties */
	function linkProperties($FromNode, $ToNode, array $Settings)
	{
		if (!isset($this->Data[$FromNode])) {
			return 0;
		}

		if (!isset($this->Data[$ToNode])) {
			return 0;
		}

		$R = 0;
		$G = 0;
		$B = 0;
		$Alpha = 100;
		$Name = NULL;
		$Ticks = NULL;
		
		extract($Settings);
		
		$this->Links[$FromNode][$ToNode]["R"] = $R;
		$this->Links[$ToNode][$FromNode]["R"] = $R;
		$this->Links[$FromNode][$ToNode]["G"] = $G;
		$this->Links[$ToNode][$FromNode]["G"] = $G;
		$this->Links[$FromNode][$ToNode]["B"] = $B;
		$this->Links[$ToNode][$FromNode]["B"] = $B;
		$this->Links[$FromNode][$ToNode]["Alpha"] = $Alpha;
		$this->Links[$ToNode][$FromNode]["Alpha"] = $Alpha;
		$this->Links[$FromNode][$ToNode]["Name"] = $Name;
		$this->Links[$ToNode][$FromNode]["Name"] = $Name;
		$this->Links[$FromNode][$ToNode]["Ticks"] = $Ticks;
		$this->Links[$ToNode][$FromNode]["Ticks"] = $Ticks;
	}

	function setNodeDefaults(array $Settings = [])
	{
		#$vars = ["R", "G", "B", "Alpha", "BorderR", "BorderG", "BorderB", "BorderAlpha", "Surrounding", "BackgroundR", "BackgroundG", "BackgroundB", "BackgroundAlpha", "NodeType", "Size", "Shape", "FreeZone"];
		foreach ($Settings as $key => $value){
			$this->Default[$key] =  $value;
		}
	}

	/* Add a node */
	function addNode($NodeID, array $Settings = [])
	{
		/* if the node already exists, ignore */
		if (isset($this->Data[$NodeID])) {
			return 0;
		}

		$Name = "Node " . $NodeID;
		$Connections = NULL;
		$R = $this->Default["R"];
		$G = $this->Default["G"];
		$B = $this->Default["B"];
		$Alpha = $this->Default["Alpha"];
		$BorderR = $this->Default["BorderR"];
		$BorderG = $this->Default["BorderG"];
		$BorderB = $this->Default["BorderB"];
		$BorderAlpha = $this->Default["BorderAlpha"];
		$Surrounding = $this->Default["Surrounding"];
		$BackgroundR = $this->Default["BackgroundR"];
		$BackgroundG = $this->Default["BackgroundG"];
		$BackgroundB = $this->Default["BackgroundB"];
		$BackgroundAlpha = $this->Default["BackgroundAlpha"];
		$Force = $this->Default["Force"];
		$NodeType = $this->Default["NodeType"];
		$Size = $this->Default["Size"];
		$Shape = $this->Default["Shape"];
		$FreeZone = $this->Default["FreeZone"];
		
		/* Override defaults */
		extract($Settings);
		
		if ($Surrounding != NULL) {
			$BorderR = $R + $Surrounding;
			$BorderG = $G + $Surrounding;
			$BorderB = $B + $Surrounding;
		}

		$this->Data[$NodeID] = [
			"R" => $R,
			"G" => $G,
			"B" => $B,
			"Alpha" => $Alpha,
			"BorderR" => $BorderR,
			"BorderG" => $BorderG,
			"BorderB" => $BorderB,
			"BorderAlpha" => $BorderAlpha,
			"BackgroundR" => $BackgroundR,
			"BackgroundG" => $BackgroundG,
			"BackgroundB" => $BackgroundB,
			"BackgroundAlpha" => $BackgroundAlpha,
			"Name" => $Name,
			"Force" => $Force,
			"Type" => $NodeType,
			"Size" => $Size,
			"Shape" => $Shape,
			"FreeZone" => $FreeZone
		];
		
		if ($Connections != NULL) {
			if (is_array($Connections)) {
				foreach($Connections as $Key => $Value){
					$this->Data[$NodeID]["Connections"][] = $Value;
				}
			} else {
				$this->Data[$NodeID]["Connections"][] = $Connections;
			}
		}
	}

	/* Set color attribute for a list of nodes */
	function setNodesColor($Nodes, array $Settings = [])
	{
		if (is_array($Nodes)) {
			foreach($Nodes as $Key => $NodeID) {
				if (isset($this->Data[$NodeID])) {
					
					(isset($Settings["R"])) AND $this->Data[$NodeID]["R"] = $Settings["R"];
					(isset($Settings["G"])) AND $this->Data[$NodeID]["G"] = $Settings["G"];
					(isset($Settings["B"])) AND $this->Data[$NodeID]["B"] = $Settings["B"];
					(isset($Settings["Alpha"])) AND $this->Data[$NodeID]["Alpha"] = $Settings["Alpha"];
					(isset($Settings["BorderR"])) AND $this->Data[$NodeID]["BorderR"] = $Settings["BorderR"];
					(isset($Settings["BorderG"])) AND $this->Data[$NodeID]["BorderG"] = $Settings["BorderG"];
					(isset($Settings["BorderB"])) AND $this->Data[$NodeID]["BorderB"] = $Settings["BorderB"];
					(isset($Settings["BorderAlpha"])) AND $this->Data[$NodeID]["BorderAlpha"] = $Settings["BorderAlpha"];

					if (isset($Settings["Surrounding"])) {
						$this->Data[$NodeID]["BorderR"] = $this->Data[$NodeID]["R"] + $Settings["Surrounding"];
						$this->Data[$NodeID]["BorderG"] = $this->Data[$NodeID]["G"] + $Settings["Surrounding"];
						$this->Data[$NodeID]["BorderB"] = $this->Data[$NodeID]["B"] + $Settings["Surrounding"];
					}
				}
			}
		} else {
			(isset($Settings["R"])) AND $this->Data[$Nodes]["R"] = $Settings["R"];
			(isset($Settings["G"])) AND $this->Data[$Nodes]["G"] = $Settings["G"];
			(isset($Settings["B"])) AND $this->Data[$Nodes]["B"] = $Settings["B"];
			(isset($Settings["Alpha"])) AND $this->Data[$Nodes]["Alpha"] = $Settings["Alpha"];
			(isset($Settings["BorderR"])) AND $this->Data[$Nodes]["BorderR"] = $Settings["BorderR"];
			(isset($Settings["BorderG"])) AND $this->Data[$Nodes]["BorderG"] = $Settings["BorderG"];
			(isset($Settings["BorderB"])) AND $this->Data[$Nodes]["BorderB"] = $Settings["BorderB"];
			(isset($Settings["BorderAlpha"])) AND $this->Data[$Nodes]["BorderAlpha"] = $Settings["BorderAlpha"];

			if (isset($Settings["Surrounding"])) {
				$this->Data[$Nodes]["BorderR"] = $this->Data[$NodeID]["R"] + $Settings["Surrounding"];
				$this->Data[$NodeID]["BorderG"] = $this->Data[$NodeID]["G"] + $Settings["Surrounding"];
				$this->Data[$NodeID]["BorderB"] = $this->Data[$NodeID]["B"] + $Settings["Surrounding"];
			}
		}
	}

	/* Returns all the nodes details */
	function dumpNodes()
	{
		return $this->Data;
	}

	/* Check if a connection exists and create it if required */
	function checkConnection($SourceID, $TargetID)
	{
		if (isset($this->Data[$SourceID]["Connections"])) {
			foreach($this->Data[$SourceID]["Connections"] as $Key => $ConnectionID) {
				if ($TargetID == $ConnectionID) {
					return TRUE;
				}
			}
		}

		$this->Data[$SourceID]["Connections"][] = $TargetID;
	}

	/* Get the median linked nodes position */
	function getMedianOffset($Key, $X, $Y)
	{
		$Cpt = 1;
		if (isset($this->Data[$Key]["Connections"])) {
			foreach($this->Data[$Key]["Connections"] as $ID => $NodeID) {
				if (isset($this->Data[$NodeID]["X"]) && isset($this->Data[$NodeID]["Y"])) {
					$X = $X + $this->Data[$NodeID]["X"];
					$Y = $Y + $this->Data[$NodeID]["Y"];
					$Cpt++;
				}
			}
		}

		return ["X" => $X / $Cpt,"Y" => $Y / $Cpt];
	}

	/* Return the ID of the attached partner with the biggest weight */
	function getBiggestPartner($Key)
	{
		if (!isset($this->Data[$Key]["Connections"])) {
			return "";
		}

		$MaxWeight = 0;
		$Result = "";
		foreach($this->Data[$Key]["Connections"] as $Key => $PeerID) {
			if ($this->Data[$PeerID]["Weight"] > $MaxWeight) {
				$MaxWeight = $this->Data[$PeerID]["Weight"];
				$Result = $PeerID;
			}
		}

		return $Result;
	}

	/* Do the initial node positions computing pass */
	function firstPass($Algorithm)
	{
		$CenterX = ($this->X2 - $this->X1) / 2 + $this->X1;
		$CenterY = ($this->Y2 - $this->Y1) / 2 + $this->Y1;
		/* Check connections reciprocity */
		foreach($this->Data as $Key => $Settings) {
			if (isset($Settings["Connections"])) {
				foreach($Settings["Connections"] as $ID => $ConnectionID) {
					$this->checkConnection($ConnectionID, $Key);
				}
			}
		}

		if ($this->AutoComputeFreeZone) {
			$this->autoFreeZone();
		}

		/* Get the max number of connections */
		$MaxConnections = 0;
		foreach($this->Data as $Key => $Settings) {
			if (isset($Settings["Connections"])) {
				if ($MaxConnections < count($Settings["Connections"])) {
					$MaxConnections = count($Settings["Connections"]);
				}
			}
		}

		if ($Algorithm == ALGORITHM_WEIGHTED) {
			foreach($this->Data as $Key => $Settings) {
				if ($Settings["Type"] == NODE_TYPE_CENTRAL) {
					$this->Data[$Key]["X"] = $CenterX;
					$this->Data[$Key]["Y"] = $CenterY;
				}

				if ($Settings["Type"] == NODE_TYPE_FREE) {
					$Connections = (isset($Settings["Connections"])) ? count($Settings["Connections"]) : 0;
					$Ring = $MaxConnections - $Connections;
					$Angle = rand(0, 360);
					$this->Data[$Key]["X"] = cos(deg2rad($Angle)) * ($Ring * $this->RingSize) + $CenterX;
					$this->Data[$Key]["Y"] = sin(deg2rad($Angle)) * ($Ring * $this->RingSize) + $CenterY;
				}
			}
		} elseif ($Algorithm == ALGORITHM_CENTRAL) {
			/* Put a weight on each nodes */
			foreach($this->Data as $Key => $Settings) {
				$this->Data[$Key]["Weight"] = (isset($Settings["Connections"])) ? count($Settings["Connections"]) : 0;
			}

			$MaxConnections = $MaxConnections + 1;
			for ($i = $MaxConnections; $i >= 0; $i--) {
				foreach($this->Data as $Key => $Settings) {
					if ($Settings["Type"] == NODE_TYPE_CENTRAL) {
						$this->Data[$Key]["X"] = $CenterX;
						$this->Data[$Key]["Y"] = $CenterY;
					}

					if ($Settings["Type"] == NODE_TYPE_FREE) {
						$Connections = (isset($Settings["Connections"])) ? count($Settings["Connections"]) : 0;
						if ($Connections == $i) {
							$BiggestPartner = $this->getBiggestPartner($Key);
							if ($BiggestPartner != "") {
								$Ring = $this->Data[$BiggestPartner]["FreeZone"];
								$Weight = $this->Data[$BiggestPartner]["Weight"];
								$AngleDivision = 360 / $this->Data[$BiggestPartner]["Weight"];
								$Done = FALSE;
								$Tries = 0;
								while (!$Done && $Tries <= $Weight * 2) {
									$Tries++;
									$Angle = floor(rand(0, $Weight) * $AngleDivision);
									if (!isset($this->Data[$BiggestPartner]["Angular"][$Angle]) || !isset($this->Data[$BiggestPartner]["Angular"])) {
										$this->Data[$BiggestPartner]["Angular"][$Angle] = $Angle;
										$Done = TRUE;
									}
								}

								if (!$Done) {
									$Angle = rand(0, 360);
									$this->Data[$BiggestPartner]["Angular"][$Angle] = $Angle;
								}

								$X = cos(deg2rad($Angle)) * ($Ring) + $this->Data[$BiggestPartner]["X"];
								$Y = sin(deg2rad($Angle)) * ($Ring) + $this->Data[$BiggestPartner]["Y"];
								$this->Data[$Key]["X"] = $X;
								$this->Data[$Key]["Y"] = $Y;
							}
						}
					}
				}
			}
		} elseif ($Algorithm == ALGORITHM_CIRCULAR) {
			$MaxConnections = $MaxConnections + 1;
			for ($i = $MaxConnections; $i >= 0; $i--) {
				foreach($this->Data as $Key => $Settings) {
					if ($Settings["Type"] == NODE_TYPE_CENTRAL) {
						$this->Data[$Key]["X"] = $CenterX;
						$this->Data[$Key]["Y"] = $CenterY;
					}

					if ($Settings["Type"] == NODE_TYPE_FREE) {
						$Connections = (isset($Settings["Connections"])) ? count($Settings["Connections"]) : 0;
						if ($Connections == $i) {
							$Ring = $MaxConnections - $Connections;
							$Angle = rand(0, 360);
							$X = cos(deg2rad($Angle)) * ($Ring * $this->RingSize) + $CenterX;
							$Y = sin(deg2rad($Angle)) * ($Ring * $this->RingSize) + $CenterY;
							$MedianOffset = $this->getMedianOffset($Key, $X, $Y);
							$this->Data[$Key]["X"] = $MedianOffset["X"];
							$this->Data[$Key]["Y"] = $MedianOffset["Y"];
						}
					}
				}
			}
		} elseif ($Algorithm == ALGORITHM_RANDOM) {
			foreach($this->Data as $Key => $Settings) {
				if ($Settings["Type"] == NODE_TYPE_FREE) {
					$this->Data[$Key]["X"] = $CenterX + rand(-20, 20);
					$this->Data[$Key]["Y"] = $CenterY + rand(-20, 20);
				}

				if ($Settings["Type"] == NODE_TYPE_CENTRAL) {
					$this->Data[$Key]["X"] = $CenterX;
					$this->Data[$Key]["Y"] = $CenterY;
				}
			}
		}
	}

	/* Compute one pass */
	function doPass()
	{
		/* Compute vectors */
		foreach($this->Data as $Key => $Settings) {
			if ($Settings["Type"] != NODE_TYPE_CENTRAL) {
				unset($this->Data[$Key]["Vectors"]);
				$X1 = $Settings["X"];
				$Y1 = $Settings["Y"];
				/* Repulsion vectors */
				foreach($this->Data as $Key2 => $Settings2) {
					if ($Key != $Key2) {
						$X2 = $this->Data[$Key2]["X"];
						$Y2 = $this->Data[$Key2]["Y"];
						$FreeZone = $this->Data[$Key2]["FreeZone"];
						$Distance = $this->getDistance($X1, $Y1, $X2, $Y2);
						$Angle = $this->getAngle($X1, $Y1, $X2, $Y2) + 180;
						/* Nodes too close, repulsion occurs */
						if ($Distance < $FreeZone) {
							$Force = log(pow(2, $FreeZone - $Distance));
							if ($Force > 1) {
								$this->Data[$Key]["Vectors"][] = ["Type" => "R","Angle" => $Angle % 360,"Force" => $Force];
							}
						}
					}
				}

				/* Attraction vectors */
				if (isset($Settings["Connections"])) {
					foreach($Settings["Connections"] as $ID => $NodeID) {
						if (isset($this->Data[$NodeID])) {
							$X2 = $this->Data[$NodeID]["X"];
							$Y2 = $this->Data[$NodeID]["Y"];
							$FreeZone = $this->Data[$Key2]["FreeZone"];
							$Distance = $this->getDistance($X1, $Y1, $X2, $Y2);
							$Angle = $this->getAngle($X1, $Y1, $X2, $Y2);
							if ($Distance > $FreeZone) {
								$Force = log(($Distance - $FreeZone) + 1);
							} else {
								$Force = log(($FreeZone - $Distance) + 1);
								($Angle = $Angle + 180);
							}

							if ($Force > 1) {
								$this->Data[$Key]["Vectors"][] = ["Type" => "A","Angle" => $Angle % 360,"Force" => $Force];
							}
						}
					}
				}
			}
		}

		/* Move the nodes accoding to the vectors */
		foreach($this->Data as $Key => $Settings) {
			$X = $Settings["X"];
			$Y = $Settings["Y"];
			if (isset($Settings["Vectors"]) && $Settings["Type"] != NODE_TYPE_CENTRAL) {
				foreach($Settings["Vectors"] as $ID => $Vector) {
					$Type = $Vector["Type"];
					$Force = $Vector["Force"];
					$Angle = $Vector["Angle"];
					$Factor = $Type == "A" ? $this->MagneticForceA : $this->MagneticForceR;
					$X = cos(deg2rad($Angle)) * $Force * $Factor + $X;
					$Y = sin(deg2rad($Angle)) * $Force * $Factor + $Y;
				}
			}

			$this->Data[$Key]["X"] = $X;
			$this->Data[$Key]["Y"] = $Y;
		}
	}

	function lastPass()
	{
		/* Put everything inside the graph area */
		foreach($this->Data as $Key => $Settings) {
			$X = $Settings["X"];
			$Y = $Settings["Y"];
			($X < $this->X1) AND $X = $this->X1;
			($X > $this->X2) AND $X = $this->X2;
			($Y < $this->Y1) AND $Y = $this->Y1;
			($Y > $this->Y2) AND $Y = $this->Y2;
			$this->Data[$Key]["X"] = $X;
			$this->Data[$Key]["Y"] = $Y;
		}

		/* Dump all links */
		$Links = [];
		foreach($this->Data as $Key => $Settings) {
			$X1 = $Settings["X"];
			$Y1 = $Settings["Y"];
			if (isset($Settings["Connections"])) {
				foreach($Settings["Connections"] as $ID => $NodeID) {
					if (isset($this->Data[$NodeID])) {
						$X2 = $this->Data[$NodeID]["X"];
						$Y2 = $this->Data[$NodeID]["Y"];
						$Links[] = ["X1" => $X1,"Y1" => $Y1,"X2" => $X2,"Y2" => $Y2,"Source" => $Settings["Name"],"Destination" => $this->Data[$NodeID]["Name"]];
					}
				}
			}
		}

		/* Check collisions */
		$Conflicts = 0;
		foreach($this->Data as $Key => $Settings) {
			$X1 = $Settings["X"];
			$Y1 = $Settings["Y"];
			if (isset($Settings["Connections"])) {
				foreach($Settings["Connections"] as $ID => $NodeID) {
					if (isset($this->Data[$NodeID])) {
						$X2 = $this->Data[$NodeID]["X"];
						$Y2 = $this->Data[$NodeID]["Y"];
						foreach($Links as $IDLinks => $Link) {
							$X3 = $Link["X1"];
							$Y3 = $Link["Y1"];
							$X4 = $Link["X2"];
							$Y4 = $Link["Y2"];
							if (!($X1 == $X3 && $X2 == $X4 && $Y1 == $Y3 && $Y2 == $Y4)) {
								if ($this->intersect($X1, $Y1, $X2, $Y2, $X3, $Y3, $X4, $Y4)) {
									if ($Link["Source"] != $Settings["Name"] && $Link["Source"] != $this->Data[$NodeID]["Name"] && $Link["Destination"] != $Settings["Name"] && $Link["Destination"] != $this->Data[$NodeID]["Name"]) {
										$Conflicts++;
									}
								}
							}
						}
					}
				}
			}
		}

		return ($Conflicts / 2);
	}

	/* Center the graph */
	function center()
	{
		/* Determine the real center */
		$TargetCenterX = ($this->X2 - $this->X1) / 2 + $this->X1;
		$TargetCenterY = ($this->Y2 - $this->Y1) / 2 + $this->Y1;
		/* Get current boundaries */
		$XMin = $this->X2;
		$XMax = $this->X1;
		$YMin = $this->Y2;
		$YMax = $this->Y1;
		foreach($this->Data as $Key => $Settings) {
			$X = $Settings["X"];
			$Y = $Settings["Y"];
			($X < $XMin) AND $XMin = $X;
			($X > $XMax) AND $XMax = $X;
			($Y < $YMin) AND $YMin = $Y;
			($Y > $YMax) AND $YMax = $Y;
		}

		$CurrentCenterX = ($XMax - $XMin) / 2 + $XMin;
		$CurrentCenterY = ($YMax - $YMin) / 2 + $YMin;
		/* Compute the offset to apply */
		$XOffset = $TargetCenterX - $CurrentCenterX;
		$YOffset = $TargetCenterY - $CurrentCenterY;
		/* Correct the points position */
		foreach($this->Data as $Key => $Settings) {
			$this->Data[$Key]["X"] = $Settings["X"] + $XOffset;
			$this->Data[$Key]["Y"] = $Settings["Y"] + $YOffset;
		}
	}

	/* Create the encoded string */
	function drawSpring($Object, array $Settings = [])
	{
		$this->pChartObject = $Object;
		$Pass = isset($Settings["Pass"]) ? $Settings["Pass"] : 50;
		$Retries = isset($Settings["Retry"]) ? $Settings["Retry"] : 10;
		$this->MagneticForceA = isset($Settings["MagneticForceA"]) ? $Settings["MagneticForceA"] : 1.5;
		$this->MagneticForceR = isset($Settings["MagneticForceR"]) ? $Settings["MagneticForceR"] : 2;
		$this->RingSize = isset($Settings["RingSize"]) ? $Settings["RingSize"] : 40;
		$DrawVectors = isset($Settings["DrawVectors"]) ? $Settings["DrawVectors"] : FALSE;
		$DrawQuietZone = isset($Settings["DrawQuietZone"]) ? $Settings["DrawQuietZone"] : FALSE;
		$CenterGraph = isset($Settings["CenterGraph"]) ? $Settings["CenterGraph"] : TRUE;
		$TextPadding = isset($Settings["TextPadding"]) ? $Settings["TextPadding"] : 4;
		$Algorithm = isset($Settings["Algorithm"]) ? $Settings["Algorithm"] : ALGORITHM_WEIGHTED;
		$FontSize = $Object->FontSize;
		$this->X1 = $Object->GraphAreaX1;
		$this->Y1 = $Object->GraphAreaY1;
		$this->X2 = $Object->GraphAreaX2;
		$this->Y2 = $Object->GraphAreaY2;
		$Conflicts = 1;
		$Jobs = 0;
		$this->History["MinimumConflicts"] = - 1;
		while ($Conflicts != 0 && $Jobs < $Retries) {
			$Jobs++;
			/* Compute the initial settings */
			$this->firstPass($Algorithm);
			/* Apply the vectors */
			if ($Pass > 0) {
				for ($i = 0; $i <= $Pass; $i++) {
					$this->doPass();
				}
			}

			$Conflicts = $this->lastPass();
			if ($this->History["MinimumConflicts"] == - 1 || $Conflicts < $this->History["MinimumConflicts"]) {
				$this->History["MinimumConflicts"] = $Conflicts;
				$this->History["Result"] = $this->Data;
			}
		}

		$Conflicts = $this->History["MinimumConflicts"];
		$this->Data = $this->History["Result"];
		if ($CenterGraph) {
			$this->center();
		}

		/* Draw the connections */
		$Drawn = [];
		foreach($this->Data as $Key => $Settings) {
			$X = $Settings["X"];
			$Y = $Settings["Y"];
			if (isset($Settings["Connections"])) {
				foreach($Settings["Connections"] as $ID => $NodeID) {
					if (!isset($Drawn[$Key])) {
						$Drawn[$Key] = [];
					}

					if (!isset($Drawn[$NodeID])) {
						$Drawn[$NodeID] = [];
					}

					if (isset($this->Data[$NodeID]) && !isset($Drawn[$Key][$NodeID]) && !isset($Drawn[$NodeID][$Key])) {
						$Color = ["R" => $this->Default["LinkR"],"G" => $this->Default["LinkG"],"B" => $this->Default["LinkB"],"Alpha" => $this->Default["Alpha"]];
						#if ($this->Links != "") {
						if (count($this->Links) > 0) {	
							if (isset($this->Links[$Key][$NodeID]["R"])) {
								$Color = ["R" => $this->Links[$Key][$NodeID]["R"],"G" => $this->Links[$Key][$NodeID]["G"],"B" => $this->Links[$Key][$NodeID]["B"],"Alpha" => $this->Links[$Key][$NodeID]["Alpha"]];
							}

							if (isset($this->Links[$Key][$NodeID]["Ticks"])) {
								$Color["Ticks"] = $this->Links[$Key][$NodeID]["Ticks"];
							}
						}

						$X2 = $this->Data[$NodeID]["X"];
						$Y2 = $this->Data[$NodeID]["Y"];
						$this->pChartObject->drawLine($X, $Y, $X2, $Y2, $Color);
						$Drawn[$Key][$NodeID] = TRUE;
						#if (isset($this->Links) && $this->Links != "") {
						if (count($this->Links) > 0) {
							if (isset($this->Links[$Key][$NodeID]["Name"]) || isset($this->Links[$NodeID][$Key]["Name"])) {
								$Name = isset($this->Links[$Key][$NodeID]["Name"]) ? $this->Links[$Key][$NodeID]["Name"] : $this->Links[$NodeID][$Key]["Name"];
								$TxtX = ($X2 - $X) / 2 + $X;
								$TxtY = ($Y2 - $Y) / 2 + $Y;
								if ($X <= $X2) {
									$Angle = (360 - $this->getAngle($X, $Y, $X2, $Y2)) % 360;
								} else {
									$Angle = (360 - $this->getAngle($X2, $Y2, $X, $Y)) % 360;
								}

								$Settings = $Color;
								$Settings["Angle"] = $Angle;
								$Settings["Align"] = TEXT_ALIGN_BOTTOMMIDDLE;
								$this->pChartObject->drawText($TxtX, $TxtY, $Name, $Settings);
							}
						}
					}
				}
			}
		}

		/* Draw the quiet zones */
		if ($DrawQuietZone) {
			foreach($this->Data as $Key => $Settings) {
				$X = $Settings["X"];
				$Y = $Settings["Y"];
				$FreeZone = $Settings["FreeZone"];
				$this->pChartObject->drawFilledCircle($X, $Y, $FreeZone, ["R" => 0,"G" => 0,"B" => 0,"Alpha" => 2]);
			}
		}

		/* Draw the nodes */
		foreach($this->Data as $Key => $Settings) {
			$X = $Settings["X"];
			$Y = $Settings["Y"];
			$Name = $Settings["Name"];
			$FreeZone = $Settings["FreeZone"];
			$Shape = $Settings["Shape"];
			$Size = $Settings["Size"];
			$Color = [
				"R" => $Settings["R"],
				"G" => $Settings["G"],
				"B" => $Settings["B"],
				"Alpha" => $Settings["Alpha"],
				"BorderR" => $Settings["BorderR"],
				"BorderG" => $Settings["BorderG"],
				"BorderB" => $Settings["BorderB"],
				"BorderApha" => $Settings["BorderAlpha"]
			];
			if ($Shape == NODE_SHAPE_CIRCLE) {
				$this->pChartObject->drawFilledCircle($X, $Y, $Size, $Color);
			} elseif ($Shape == NODE_SHAPE_TRIANGLE) {
				$Points = [cos(deg2rad(270)) * $Size + $X, sin(deg2rad(270)) * $Size + $Y, cos(deg2rad(45)) * $Size + $X, sin(deg2rad(45)) * $Size + $Y, cos(deg2rad(135)) * $Size + $X, sin(deg2rad(135)) * $Size + $Y, ];
				$this->pChartObject->drawPolygon($Points, $Color);
			} elseif ($Shape == NODE_SHAPE_SQUARE) {
				$Offset = $Size / 2;
				$Size = $Size / 2;
				$this->pChartObject->drawFilledRectangle($X - $Offset, $Y - $Offset, $X + $Offset, $Y + $Offset, $Color);
			}

			if ($Name != "") {
				$LabelOptions = ["R" => $this->Labels["R"],"G" => $this->Labels["G"],"B" => $this->Labels["B"],"Alpha" => $this->Labels["Alpha"]];
				if ($this->Labels["Type"] == LABEL_LIGHT) {
					$LabelOptions["Align"] = TEXT_ALIGN_BOTTOMLEFT;
					$this->pChartObject->drawText($X, $Y, $Name, $LabelOptions);
				} elseif ($this->Labels["Type"] == LABEL_CLASSIC) {
					$LabelOptions["Align"] = TEXT_ALIGN_TOPMIDDLE;
					$LabelOptions["DrawBox"] = TRUE;
					$LabelOptions["BoxAlpha"] = 50;
					$LabelOptions["BorderOffset"] = 4;
					$LabelOptions["RoundedRadius"] = 3;
					$LabelOptions["BoxRounded"] = TRUE;
					$LabelOptions["NoShadow"] = TRUE;
					$this->pChartObject->drawText($X, $Y + $Size + $TextPadding, $Name, $LabelOptions);
				}
			}
		}

		/* Draw the vectors */
		if ($DrawVectors) {
			foreach($this->Data as $Key => $Settings) {
				$X1 = $Settings["X"];
				$Y1 = $Settings["Y"];
				if (isset($Settings["Vectors"]) && $Settings["Type"] != NODE_TYPE_CENTRAL) {
					foreach($Settings["Vectors"] as $ID => $Vector) {
						$Type = $Vector["Type"];
						$Force = $Vector["Force"];
						$Angle = $Vector["Angle"];
						$Factor = $Type == "A" ? $this->MagneticForceA : $this->MagneticForceR;
						$Color = $Type == "A" ? ["FillR" => 255,"FillG" => 0,"FillB" => 0] : ["FillR" => 0,"FillG" => 255,"FillB" => 0];
						$X2 = cos(deg2rad($Angle)) * $Force * $Factor + $X1;
						$Y2 = sin(deg2rad($Angle)) * $Force * $Factor + $Y1;
						$this->pChartObject->drawArrow($X1, $Y1, $X2, $Y2, $Color);
					}
				}
			}
		}

		return ["Pass" => $Jobs,"Conflicts" => $Conflicts];
	}

	/* Return the distance between two points */
	function getDistance($X1, $Y1, $X2, $Y2)
	{
		return sqrt(($X2 - $X1) * ($X2 - $X1) + ($Y2 - $Y1) * ($Y2 - $Y1));
	}

	/* Return the angle made by a line and the X axis */
	function getAngle($X1, $Y1, $X2, $Y2)
	{
		$Opposite = $Y2 - $Y1;
		$Adjacent = $X2 - $X1;
		$Angle = rad2deg(atan2($Opposite, $Adjacent));

		return ($Angle > 0) ? $Angle : (360 - abs($Angle));

	}

	function intersect($X1, $Y1, $X2, $Y2, $X3, $Y3, $X4, $Y4)
	{
		$A = (($X3 * $Y4 - $X4 * $Y3) * ($X1 - $X2) - ($X1 * $Y2 - $X2 * $Y1) * ($X3 - $X4));
		$B = (($Y1 - $Y2) * ($X3 - $X4) - ($Y3 - $Y4) * ($X1 - $X2));
		if ($B == 0) {
			return FALSE;
		}

		$Xi = $A / $B;
		$C = ($X1 - $X2);
		if ($C == 0) {
			return FALSE;
		}

		$Yi = $Xi * (($Y1 - $Y2) / $C) + (($X1 * $Y2 - $X2 * $Y1) / $C);
		if ($Xi >= min($X1, $X2) && $Xi >= min($X3, $X4) && $Xi <= max($X1, $X2) && $Xi <= max($X3, $X4)) {
			if ($Yi >= min($Y1, $Y2) && $Yi >= min($Y3, $Y4) && $Yi <= max($Y1, $Y2) && $Yi <= max($Y3, $Y4)) {
				return TRUE;
			}
		}

		return FALSE;
	}
}

?>