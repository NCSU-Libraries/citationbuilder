<?php
/*****Form functionality******/
	
	//Creates a page heading and links for style choice
	function heading($heading, $source, $style) {
		$html = '<div>';
		$html .= '<table width="100%"><tr><td width="8%" nowrap="nowrap">';
		$html .= '<div id="mainheading" style="mainheading"><h2>' . $heading;
		/*$html .= '<select id="sourcechoice" name="sourcechoice">' . "\n";
		if ($source=="book") {
			$html .= '<option value="book" selected="selected">book</option>' . "\n";
		}else{
			$html .= '<option value="book">book</option>' . "\n";
		}
		if ($source=="bookchapter") {
			$html .= '<option value="bookchapter" selected="selected">chapter or essay</option>' . "\n";
		}else{
			$html .= '<option value="bookchapter">chapter or essay</option>' . "\n";
		}
		if ($source=="newspaper") {
			$html .= '<option value="newspaper" selected="selected">newspaper</option>' . "\n";
		}else{
			$html .= '<option value="newspaper">newspaper</option>' . "\n";
		}
		if ($source=="magazine") {
			$html .= '<option value="magazine" selected="selected">magazine</option>' . "\n";
		}else{
			$html .= '<option value="magazine">magazine</option>' . "\n";
		}
		if ($source=="scholar") {
			$html .= '<option value="scholar" selected="selected">scholarly article</option>' . "\n";
		}else{
			$html .= '<option value="scholar">scholarly article</option>' . "\n";
		}
		if ($source=="website") {
			$html .= '<option value="website" selected="selected">website</option>'. "\n";
		}else{
			$html .= '<option value="website">website</option>'. "\n";
		}
		$html .= '</select>';*/
		$html .= '</h2></div></td><td><div id="change" class="change"><a href="">change</a>';
		$html .= '<input type="hidden" id="sourceholder" name="sourceholder" value="' . $source . '" /></div></td>';
		$html .= '<td align="right"><div id="stylechoice" class="stylechoice"><input type="hidden" id="styleholder" name="styleholder" value="' . $style . '" />';
		$html .= 'Citation style: ';
		if ($style=="apa6") {
			$html .= ' <span class="styleselected">APA 6</span> ';
		}else{
			$html .= ' <a href="cite.php?source=' . $source . '&amp;style=apa6" id="apa6">APA 6</a> ';
		}
		if ($style=="mla7") {
			$html .= '| <span class="styleselected">MLA 7</span> ';
		}else{
			$html .= '| <a href="cite.php?source=' . $source . '&amp;style=mla7" id="mla7">MLA 7</a> ';
		}
		$html .= '</div></td></tr></table></div>' . "\n";
		echo $html;
	}

/********************************/
/*    Form Inputs               */
/********************************/
	
	//Creates a checkbox and label div
	function checkbox($id, $css) {
		$html = '<input type="checkbox" id="' . $id . '" name="' . $id . '"';
		$html .= ' class="' . $css . '" value="1" />';
		return $html;
	}
	
	//Creates a month drop down list
	function monthdropdown($id, $css) {
		$html = '<div class="' . $css . '">';
		$html .= '<select id="' . $id . '" name="' . $id . '">';
		$html .= '<option></option>';
		$html .= '<option value="January">January</option>'; 
		$html .= '<option value="February">February</option>'; 
		$html .= '<option value="March">March</option>'; 
		$html .= '<option value="April">April</option>'; 
		$html .= '<option value="May">May</option>'; 
		$html .= '<option value="June">June</option>'; 
		$html .= '<option value="July">July</option>'; 
		$html .= '<option value="August">August</option>'; 
		$html .= '<option value="September">September</option>'; 
		$html .= '<option value="October">October</option>'; 
		$html .= '<option value="November">November</option>'; 
		$html .= '<option value="December">December</option>'; 
		$html .= '<option value="Jan. &amp; Feb.">Jan. &amp; Feb.</option>'; 
		$html .= '<option value="Feb. &amp; March">Feb. &amp; March</option>'; 
		$html .= '<option value="March &amp; April">March &amp; April</option>'; 
		$html .= '<option value="April &amp; May">April &amp; May</option>'; 
		$html .= '<option value="May &amp; June">May &amp; June</option>'; 
		$html .= '<option value="June &amp; July">June &amp; July</option>'; 
		$html .= '<option value="July &amp; Aug.">July &amp; Aug.</option>'; 
		$html .= '<option value="Aug. &amp; Sept.">Aug. &amp; Sept.</option>'; 
		$html .= '<option value="Sept. &amp; Oct.">Sept. &amp; Oct.</option>'; 
		$html .= '<option value="Oct. &amp; Nov.">Oct. &amp; Nov.</option>'; 
		$html .= '<option value="Nov. &amp; Dec.">Nov. &amp; Dec.</option>'; 
		$html .= '<option value="Dec. &amp; Jan.">Dec. &amp; Jan.</option>'; 
		$html .= '<option value="Spring">Spring</option>'; 
		$html .= '<option value="Summer">Summer</option>';
		$html .= '<option value="Fall">Fall</option>'; 
		$html .= '<option value="Winter">Winter</option>';
		$html .= '</select>';
		$html .= '</div>';
		return $html;	
	}
	
	//Creates the submit button
	function submitbutton($css) {
		$html = '<input type="submit" class="' . $css . '" value="Submit" />';
		echo $html;
	}
	
	//Creates a textbox and label div
	function textbox($id, $css, $size, $maxlength, $value) {
		$html = '<input type="text" id="' . $id . '"';
		$html .= ' name="' . $id . '"';
		$html .= ' class="' . $css . '"';
		$html .= ' size="' . $size . '"';
		if ($value!="novalue") {
			$html .= ' value="' . $value . '"';
		}
		$html .= ' maxlength="' . $maxlength . '" />';
		return $html;
	}

/********************************/
/*    Form Sections             */
/********************************/
	
	//Creates the Advanced Info section
	function advancedinfo($id) {
		$html = '<table id="' . $id . '">';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= textbox($id . 'volume', textbox, 4, none, novalue);
		$html .= '<br /><span class="small">Volume</span></td><td>';
		$html .= textbox($id . 'issue', textbox, 4, none, novalue);
		$html .= '<br /><span class="small">Issue</span></td><td>';
		//$html .= textbox(series, textbox, 4, none, novalue);
		//$html .= '<br /><span class="small">Series</span></td>';
		$html .= '</tr></table>';
		echo $html;
	}
	
	//Creates a section and label div
	function beginsection($sectionid, $label, $top) {
		$html = '<div id="' . $sectionid . '" ';
		$html .= 'class="sectionchild">' . "\n";
		$html .= '<table>' . "\n" . '<tr>' . "\n\t" . '<td class="sectionlabel">';
		$html .= $label;
		$html .= '</td>' . "\n\t" . '<td>';
		echo $html;
	}
	
	//Creates the Contributor section
	function contributor($id) {
		$html = '<table id="' . $id . 'table0">';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= '<select id="' . $id . 'select0" name="' . $id . 'select0">' . "\n";
		$html .= '<option value="author">Author</option>' . "\n";
		//$html .= '<option value="editor">Editor</option>' . "\n";
		//$html .= '<option value="translator">Translator</option>' . "\n";
		$html .= '</select>' . "\n";
		$html .= '</td><td>';
		$html .= textbox(contributorfname0, textbox, 10, none, novalue);
		$html .= '<br /><span class="small">First</span></td><td>';
		$html .= textbox(contributormi0, textbox, 1, 1, novalue);
		$html .= '<br /><span class="small">MI</span></td><td>';
		$html .= textbox(contributorlname0, textbox, 12, none, Anonymous);
		$html .= '<br /><span class="small">Last / Corporation</span></td>';
		$html .= '<td width="48px"></td>';
		$html .= '</tr>';
		$html .= '<tr><td colspan="5"><div id="adddiv"><input type="hidden" id="addidvalue" name="addidvalue" value="1" /></div></td></tr>';
		$html .= '<tr><td colspan="5" class="addcontributor"><a href="" class="contribaddlink" id="contribaddlink">+ Add another contributor</a></td>';
		$html .= '</tr></table>';
		echo $html;
	}
		
	//Creates a date input
	function dateinput($id) {
		$html = '<table id="' . $id . '">';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= textbox($id . 'day', textbox, 2, 2, novalue);
		$html .= '<br /><span class="small">Day</span></td><td>';
		$html .= monthdropdown($id . 'month', monthdropdown);
		$html .= '<span class="small">Month</span></td><td>';
		$html .= textbox($id . 'year', textbox, 4, 4, novalue);
		$html .= '<br /><span class="small">Year</span></td>';
		$html .= '</tr></table>';
		echo $html;
	}
	
	//Closes a section and label div
	function endsection () {
		$html = "</td>\n</tr>\n</table>\n</div>\n";
		echo $html;
	}
	
	//Creates a footer for the form
	function footercreate() {
		$html = '<div id="footer" class="footer"></div>';
		echo $html;
	}
		
	//Creates a header for the form
	function headercreate() {
		$html = '<div id="header" class="header">Fill in everything you know about your source:</div>';
		echo $html;
	}
	
	//Creates the Medium input
	function mediuminput() {
		$html = textbox(mediuminput, textbox, 45, none, novalue);
		$html .= '<br/>';
		$html .= 'Ex: PDF, Microsoft Word, MP3, etc.';
		echo $html;
	}
		
	//Creates the Newspaper city input
	function newspapercityinput($id) {
		$html = textbox($id, textbox, 45, none, novalue);
		$html .= '<br/>';
		$html .= 'Only include if city is not in newspaper name';
		echo $html;
	}
	
	//Creates the Pages section
	function pages($id) {
		$html = '<table id="' . $id . '"><tr><td><div id="pagesstart">';
		$html .= textbox($id . startinput, textbox, 4, none, novalue);
		$html .= '<br /><span class="small">Start</span></div></td><td><div id="pagesend">';
		$html .= textbox($id . endinput, textbox, 4, none, novalue);
		$html .= '<br /><span class="small">End</span></div></td>';
		$html .= '<td><div id="nonconsecutivepagenums" style="display: none;">';
		$html .= textbox($id . nonconsecutivepagenumsinput, textbox, 27, none, novalue);
		$html .= '<br /><span class="small">Separate the numbers with commas</span></div></td>';
		$html .= '<td><div id="pagenccheck">';
		$html .= checkbox($id . nonconsecutiveinput, checkbox);
		$html .= '<span class="small">Pages are non-consecutive</span></div></td></tr></table>';
		echo $html;
	}
		
	//Creates the Publication Info section
	function publicationinfo($id) {
		$html = '<table id="' . $id . '"><tr><td>';
		$html .= textbox(publisherinput, textbox, 15, none, novalue);
		$html .= '<br /><span class="small">Publisher</span></td><td>';
		$html .= textbox(publisherlocationinput, textbox, 15, none, novalue);
		$html .= '<br /><span class="small">Location</span></td><td>';
		$html .= textbox(publicationyearinput, textbox, 4, 4, novalue);
		$html .= '<br /><span class="small">Year</span></td></tr></table>';
		echo $html;
	}
		
	//Creates a URL input
	function urlinput($id, $style, $source, $showor){
		$html = textbox($id, textbox, 45, none, novalue);
		if ($style=="apa6") {
			if ($showor=="yes") {
				$html .= '<br /> OR';
			}
		}
		if ($style=="mla7") {
			$html .= '<br />MLA 7 says to omit the URL unless the source cannot be located without it, or if your instructor requires it.';
		}
		echo $html;
	}
		
/*****Citation functionality******/

/********************************/
/*    String manipulation       */
/********************************/

	//Converts a passed style variable into the appropriate text
	function styleconvert($style) {
		switch($style) {
			case "apa6":
				$html = "APA 6";
				break;
			case "mla7":
				$html = "MLA 7";
				break;
		} 
		return $html;
	}
	
	//Clean variables of slashes and leading/trailing spaces
	function cleanvars($variable) {
		$cleanvariable = stripslashes($variable);
		$cleanvariable = trim($cleanvariable);
		return $cleanvariable;
	}
	
	//Uppercase all words in string
	function uppercasewords($string) {
		$uppercasestring = ucwords($string);
		return $uppercasestring;
	}
	
	//Uppercase first word in a string
	function uppercasefirstword($string) {
		$lowercasestring = strtolower($string);
		$uppercasestring = ucfirst($lowercasestring);
		return $uppercasestring;
	}
	
	//Lowercase all words in a string
	function lowercasewords($string) {
		$lowercasestring = strtolower($string);
		return $lowercasestring;
	}
	
	//Uppercase the first word of a subtitle
	function subtitleucfirst($string, $regs) {  
		$ucaftercolon = strtoupper($regs[0]);
		$subtitleucfirst = ereg_replace(":[ ]+[a-z]", "$ucaftercolon", $string);
		return $subtitleucfirst;
}

	//Remove articles (A, An, The) before a string
	function removearticle($string) {
		$patterns = array ('/A /', '/An /', '/The /');
			$replacements = array ('');
			$removearticle = preg_replace($patterns, $replacements, $string);
			return $removearticle;
	}
	
	//Force articles, prepositions, and conjuctions to lowercase
	function forcearticlelower($forcearticlelower) {
			$forcearticlelower = str_replace(" A ", " a ", $forcearticlelower);
			$forcearticlelower = str_replace(" An ", " an ", $forcearticlelower);
			$forcearticlelower = str_replace(" And ", " and ", $forcearticlelower);
			$forcearticlelower = str_replace(" About ", " about ", $forcearticlelower);
			$forcearticlelower = str_replace(" As ", " as ", $forcearticlelower);
			$forcearticlelower = str_replace(" At ", " at ", $forcearticlelower);
			$forcearticlelower = str_replace(" Away ", " away ", $forcearticlelower);
			$forcearticlelower = str_replace(" But ", " but ", $forcearticlelower);
			$forcearticlelower = str_replace(" By ", " by ", $forcearticlelower);
			$forcearticlelower = str_replace(" Due ", " due ", $forcearticlelower);
			$forcearticlelower = str_replace(" For ", " for ", $forcearticlelower);
			$forcearticlelower = str_replace(" From ", " from ", $forcearticlelower);
			$forcearticlelower = str_replace(" In ", " in ", $forcearticlelower);
			$forcearticlelower = str_replace(" Into ", " into ", $forcearticlelower);
			$forcearticlelower = str_replace(" Like ", " like ", $forcearticlelower);
			$forcearticlelower = str_replace(" Of ", " of ", $forcearticlelower);
			$forcearticlelower = str_replace(" Off ", " off ", $forcearticlelower);
			$forcearticlelower = str_replace(" On ", " on ", $forcearticlelower);
			$forcearticlelower = str_replace(" Onto ", " onto ", $forcearticlelower);
			$forcearticlelower = str_replace(" Or ", " or ", $forcearticlelower);
			$forcearticlelower = str_replace(" Over ", " over ", $forcearticlelower);
			$forcearticlelower = str_replace(" Per ", " per ", $forcearticlelower);
			$forcearticlelower = str_replace(" Than ", " than ", $forcearticlelower);
			$forcearticlelower = str_replace(" The ", " the ", $forcearticlelower);
			$forcearticlelower = str_replace(" Till ", " till ", $forcearticlelower);
			$forcearticlelower = str_replace(" To ", " to ", $forcearticlelower);
			$forcearticlelower = str_replace(" Until ", " until ", $forcearticlelower);
			$forcearticlelower = str_replace(" Up ", " up ", $forcearticlelower);
			$forcearticlelower = str_replace(" Upon ", " upon ", $forcearticlelower);
			$forcearticlelower = str_replace(" Via ", " via ", $forcearticlelower);
			$forcearticlelower = str_replace(" With ", " with ", $forcearticlelower);
			$forcearticlelower = str_replace(" Within ", " within ", $forcearticlelower);
			$forcearticlelower = str_replace(" Without ", " without ", $forcearticlelower);
			$forcearticlelower = str_replace(" Within ", " within ", $forcearticlelower);
			$forcearticlelower = str_replace(" Within ", " within ", $forcearticlelower);
			return $forcearticlelower;
	}
	
	//Add a period to the end of an article title unless it is a ".", "?", or "!"
	function articleperiod($articletitle) {
			$articletitlelength = strlen($articletitle);
			$lastarticletitlechar = substr($articletitle, $articletitlelength-1, 1);
			if (($lastarticletitlechar != ".") && ($lastarticletitlechar != "?") && ($lastarticletitlechar != "!")) {
				$articletitle = $articletitle . ".";
			}else{
				$articletitle = $articletitle;
			}
			return $articletitle;
		}
		
	//Check if a day should be displayed based on a month selection
	function dayshow($month) {
		$noshow = 1;
		switch($month) {
			case "January":
				$noshow = 0;
				break;
			case "February":
				$noshow = 0;
				break;
			case "March":
				$noshow = 0;
				break;
			case "April":
				$noshow = 0;
				break;
			case "May":
				$noshow = 0;
				break;
			case "June":
				$noshow = 0;
				break;
				case "July":
				$noshow = 0;
				break;
			case "August":
				$noshow = 0;
				break;
			case "September":
				$noshow = 0;
				break;
				case "October":
				$noshow = 0;
				break;
			case "November":
				$noshow = 0;
				break;
			case "December":
				$noshow = 0;
				break;
			}
		return $noshow;
	}
	
	//Check that a URL begins with "http://", "ftp://", "telnet://", or "gopher://" (case-insensitive).  If not, assume http and prepend "http://".
	function checkurlprepend($urlwebsiteinput) {
			$httpprefix = ereg("http://", $urlwebsiteinput);
			$httpsprefix = ereg("https://", $urlwebsiteinput);
			$ftpprefix = ereg("ftp://", $urlwebsiteinput);
			$telnetprefix = ereg("telnet://", $urlwebsiteinput);
			$gopherprefix = ereg("gopher://", $urlwebsiteinput);
			if (($httpprefix != 1) && ($ftpprefix != 1) && ($telnetprefix != 1) && ($gopherprefix != 1) && ($httpsprefix != 1)) {
			   $urlwebsiteinput = "http://" . $urlwebsiteinput;
			}
			return $urlwebsiteinput;
		}
	
	//Format a name and pull the first initial
	function firstinitial($name) {
		$initial = substr($name , 0, 1);
		$initial = strtoupper($initial);
		return $initial;
	}

	/********************************/
	/*     APA only                 */
	/********************************/
	
	//Format a date published (APA)
	function apamagnewsdate($datepublishedday, $datepublishedmonth, $datepublishedyear) {
	if (!$datepublishedday && !$datepublishedmonth && !$datepublishedyear) {
		$apamagnewsdate = '(n.d.)';
	}else{
			$apamagnewsdate = '(' . $datepublishedyear . ', ' . $datepublishedmonth;
			if ($datepublishedday) {
				$apamagnewsdate .= ' ' . $datepublishedday;
			}
			$apamagnewsdate .= ')';
		}
	return $apamagnewsdate;
}

	//Format page numbers for a newspaper citing (APA)
	function apanewspaperpages($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput) {
		if (($pagesstartinput==$pagesendinput || $pagesstartinput && !$pagesendinput) && ($pagesstartinput && !$pagesnonconsecutiveinput)) {
			//if start page equals end page or there is a start page, but no end page
			$html = 'p. ' . uppercasewords($pagesstartinput);
			return $html;
		}
		if ($pagesstartinput<$pagesendinput && !$pagesnonconsecutiveinput) {
			//if start page is less than end page and the pages are consecutive
			$html = 'pp. ' . uppercasewords($pagesstartinput) . "-" . uppercasewords($pagesendinput);
			return $html;
		}
		if ($pagesnonconsecutiveinput && $pagesnonconsecutivepagenumsinput) {
			//if the pages are not consecutive and there are page numbers to display
			$html = 'pp. ' . $pagesnonconsecutivepagenumsinput;
			return $html;
		}
	}
	
	//Format page numbers for a scholarly journal citing (APA)
	function apascholarjournalpages($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput) {
		if (($pagesstartinput==$pagesendinput || $pagesstartinput && !$pagesendinput) && ($pagesstartinput && !$pagesnonconsecutiveinput)) {
			//if start page equals end page or there is a start page, but no end page
			$html = uppercasewords($pagesstartinput);
			return $html;
		}
		if ($pagesstartinput<$pagesendinput && !$pagesnonconsecutiveinput) {
			//if start page is less than end page and the pages are consecutive
			$html = uppercasewords($pagesstartinput) . "-" . uppercasewords($pagesendinput);
			return $html;
		}
		if ($pagesnonconsecutiveinput && $pagesnonconsecutivepagenumsinput) {
			//if the pages are not consecutive and there are page numbers to display
			$html = $pagesnonconsecutivepagenumsinput;
			return $html;
		}
	}
	
	//Format the author names (APA)
	function apaauthorformat($contributors) {
		//Count the number of contributors in the array
		$countcontributors = count($contributors);
		//Count the number of authors in the array
		$countauthors = 0;
		foreach ($contributors as $contributor) {
			if ($contributor['cselect']=='author') {
				$countauthors++;
			}
		}
		$html = '';
		for ($i=0; $i<$countcontributors; $i++) {
			//If this contributor is an author
			if ($contributors[$i]['cselect']=='author') {
				if ($i==0) {
					//First time through the loop
					if ($countauthors>1) {
						//There is more than one author
						$html .= uppercasewords($contributors[$i]['lname']);
						if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
						//The author is a person and not a corporation
							//Check for a hyphen in the first name
							$hyphentest = stripos($contributors[$i]['fname'], '-');
							if ($hyphentest!=false) {
								$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.-';
							}else{
								$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.';
							}
							if ($contributors[$i]['mi']) {
								$html .= ' ' . uppercasewords($contributors[$i]['mi']) . '., ';
							}else{
								$html .= ', ';
							}
						}else{
							//The author is a corporation and not a person
							$html .= ', ';
						}
					}else{
						//There is only one author
						if (($contributors[$i]['lname']!='Anonymous') || (!$contributors[$i]['lname'] && !$contributors[$i]['fname'] && !$contributors[$i]['mi'])) {
							//The author is not Anonymous or blank
							$html .= uppercasewords($contributors[$i]['lname']);
							if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
							//The author is a person and not a corporation
								//Check for a hyphen in the first name
								$hyphentest = stripos($contributors[$i]['fname'], '-');
								if ($hyphentest!=false) {
									$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.-';
								}else{
									$html .= ', ' . firstinitial($contributors[$i]['fname']) . '. ';
								}
								if ($contributors[$i]['mi']) {
									$html .= uppercasewords($contributors[$i]['mi']) . '. ';
								}
							}else{
								//The author is a corporation and not a person
								$html .= '. ';
							}
						}
					}
				}elseif ($i>=5) {
					//Sixth or more time through the loop
					if ($countauthors>7 && $i==5) {
						//There are more than 7 authors and this is the sixth time through the loop
						$html .= ' ' . uppercasewords($contributors[$i]['lname']) . ', ';
						if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
							//The author is a person and not a corporation
							//Check for a hyphen in the first name
							$hyphentest = stripos($contributors[$i]['fname'], '-');
							if ($hyphentest!=false) {
								$html .= firstinitial($contributors[$i]['fname']) . '.-';
							}else{
								$html .= firstinitial($contributors[$i]['fname']) . '. ';
							}
							$html .= uppercasewords($contributors[$i]['mi']) . '., . . . ';
						}else{
							//The author is a corporation and not a person
							$html .= ', . . . ';
						}
					}elseif ($countauthors==7 && $i==5) {
						//There are 7 authors and this is the sixth time through the loop
						$html .= ' ' . uppercasewords($contributors[$i]['lname']);
						if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
							//The author is a person and not a corporation
							//Check for a hyphen in the first name
							$hyphentest = stripos($contributors[$i]['fname'], '-');
							if ($hyphentest!=false) {
								$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.-';
							}else{
								$html .= ', ' . firstinitial($contributors[$i]['fname']) . '. ';
							}
							if ($contributors[$i]['mi']) {
								$html .= uppercasewords($contributors[$i]['mi']) . '., & ';	
							}else{
								$html .= uppercasewords($contributors[$i]['mi']) . ', & ';	
							}
						}else{
							//The author is a corporation and not a person
							$html .= ', & ';
						}
					}elseif (($i+1)==$countcontributors) {
						//This is the last time through the loop
						//If there are 6 authors add an ampersand before the name, otherwise do not
						if ($countauthors==6) {
							$html .= ' & ' . uppercasewords($contributors[$i]['lname']);
							if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
								//The author is a person and not a corporation
								//Check for a hyphen in the first name
								$hyphentest = stripos($contributors[$i]['fname'], '-');
								if ($hyphentest!=false) {
									$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.-';
								}else{
									$html .= ', ' . firstinitial($contributors[$i]['fname']) . '. ';
								}
								if ($contributors[$i]['mi']) {
									$html .= uppercasewords($contributors[$i]['mi']) . '. ';
								}
							}else{
								//The author is a corporation and not a person
								$html .= '. ';
							}
						}else{
							$html .= ' ' . uppercasewords($contributors[$i]['lname']);
							if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
								//The author is a person and not a corporation
								//Check for a hyphen in the first name
								$hyphentest = stripos($contributors[$i]['fname'], '-');
								if ($hyphentest!=false) {
									$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.-';
								}else{
									$html .= ', ' . firstinitial($contributors[$i]['fname']) . '. ';
								}
								if ($contributors[$i]['mi']) {
									$html .= uppercasewords($contributors[$i]['mi']) . '. ';
								}
							}else{
								//The author is a corporation and not a person
								$html .= '. ';
							}
						}
					}
				}else{
					if (($i+1)==$countcontributors) {
						//This is the last time through the loop
						if ($countauthors>1) {
							//There is more than one author
							$html .= ' & ' . uppercasewords($contributors[$i]['lname']);
							if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
								//The author is a person and not a corporation
								//Check for a hyphen in the first name
								$hyphentest = stripos($contributors[$i]['fname'], '-');
								if ($hyphentest!=false) {
									$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.-';
								}else{
									$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.';
								}
								if ($contributors[$i]['mi']) {
										$html .= ' ' . uppercasewords($contributors[$i]['mi']) . '. ';
								}
								$html .= ' ';
							}else{
								//The author is a corporation and not a person
								$html .= '. ';
							}
						}else{
							//There is only one author
							if (($contributors[$i]['lname']!='Anonymous') || (!$contributors[$i]['lname'] && !$contributors[$i]['fname'] && !$contributors[$i]['mi'])) {
								//The author is not Anonymous or blank
								$html .= uppercasewords($contributors[$i]['lname']);
								if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
									//The author is a person and not a corporation
									//Check for a hyphen in the first name
									$hyphentest = stripos($contributors[$i]['fname'], '-');
									if ($hyphentest!=false) {
										$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.-';
									}else{
										$html .= ', ' . firstinitial($contributors[$i]['fname']) . '. ';
									}
									if ($contributors[$i]['mi']) {
										$html .= uppercasewords($contributors[$i]['mi']) . '. ';
									}
								}else{
									//The author is a corporation and not a person
									$html .= '. ';
								}
							}
						}
					}else{
						$html .= ' ' . uppercasewords($contributors[$i]['lname']);
						if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
							//The author is a person and not a corporation
							//Check for a hyphen in the first name
							$hyphentest = stripos($contributors[$i]['fname'], '-');
							if ($hyphentest!=false) {
								$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.-';
							}else{
								$html .= ', ' . firstinitial($contributors[$i]['fname']) . '.';
							}
							if ($contributors[$i]['mi']) {
								$html .= ' ' . uppercasewords($contributors[$i]['mi']) . '.,';
							}else{
								$html .= ', ';
							}
						}else{
							//The author is a corporation and not a person
							$html .= ', ';
						}
					}
				}
			}	
		}
		return $html;
	}
	
	//Format an article title (APA)
	function articletitleapaformat($articletitleinput) {
		//Uppercase the first word in article title
		$articletitleinput = uppercasefirstword($articletitleinput);
		//If the article title contains a subtitle, capitalize the first word after the colon
		if (ereg(":[ ]+[a-z]", $articletitleinput, $regs)) {
			$articletitleinput = subtitleucfirst($articletitleinput, $regs);
		}
		//Punctuate after the article title
		$articletitleinput = articleperiod($articletitleinput);
		return $articletitleinput;
	}
	
	//Format a book title (APA)
	function booktitleapaformat($booktitleinput, $addpunctuation) {
		//Uppercase the first word in article title
		$html = uppercasefirstword($booktitleinput);
		//If the article title contains a subtitle, capitalize the first word after the colon
		if (ereg(":[ ]+[a-z]", $html, $regs)) {
			$html = subtitleucfirst($html, $regs);
		}
		if ($addpunctuation=="yes") {
			//Punctuate after the book title, if necessary
			$html = articleperiod($html);
		}
		$html = '<i>' . $html . '</i>';
		return $html;
	}
	
	/********************************/
	/*     MLA only                 */
	/********************************/

	//Format a date published (MLA)
	function mlanewspublishdate($datepublishedday, $datepublishedmonth, $datepublishedyear) {
		if (!$datepublishedday && !$datepublishedmonth && !$datepublishedyear) {
			$mlanewspublishdate .= 'n.d';
		}else{
				if (dayshow($datepublishedmonth)==0) {
					$mlanewspublishdate = $datepublishedday . " ";
				}
				$mlanewspublishdate .= shortenmonth($datepublishedmonth) . " ";
				$mlanewspublishdate .= $datepublishedyear;
		}
		return $mlanewspublishdate;
	}
	
	//Format an access date for website or database (MLA)
	function mlaaccessdate($dateaccessedday, $dateaccessedmonth, $dateaccessedyear) {
			if (dayshow($dateaccessedmonth)==0) {
				$mlaaccessdate = $dateaccessedday . " ";
			}
			$mlaaccessdate .= shortenmonth($dateaccessedmonth) . " ";
			$mlaaccessdate .= $dateaccessedyear;
		return $mlaaccessdate;
	}
	
	//Shorten a full month name into an abbreviation (MLA)
	function shortenmonth($month) {
		switch($month) {
			case "January":
				$month = "Jan.";
				break;
			case "February":
				$month = "Feb.";
				break;
			case "March":
				$month = "Mar.";
				break;
			case "April":
				$month = "Apr.";
				break;
			case "May":
				$month = "May";
				break;
			case "June":
				$month = "June";
				break;
				case "July":
				$month = "July";
				break;
			case "August":
				$month = "Aug.";
				break;
			case "September":
				$month = "Sept.";
				break;
				case "October":
				$month = "Oct.";
				break;
			case "November":
				$month = "Nov.";
				break;
			case "December":
				$month = "Dec.";
				break;
			}
			return $month;
	}
	
	//Ensure that ed. is at the end of edition (MLA)
	function editionabbrev($editioninput) { 
		$mlaedition = preg_replace("/edition/", "ed.", $editioninput);
		$mlaedition = preg_replace("/ed/", "ed.", $mlaedition);
		$mlaedition = preg_replace("/ed../", "ed.", $mlaedition);
		if (preg_match("/ed./", $mlaedition)) {
			$mlaedition = $mlaedition;
		}
		elseif ($mlaedition != "") {
			$mlaedition = $mlaedition . " ed.";
		}
		return $mlaedition;
	}
	
	//Creates the page number output (MLA)
	function mlapagenumbers($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput) {
		if (!$pagesstartinput && !$pagesendinput && !$pagesnonconsecutiveinput) {
			//There are no page numbers
			$html = "N. pag. ";
			return $html;
		}elseif (($pagesstartinput==$pagesendinput) || ($pagesstartinput && !$pagesendinput)) {
			//The article is only on one page
			$html = uppercasewords($pagesstartinput) . ". ";
			return $html;
		}
		if ($pagesstartinput<$pagesendinput && !$pagesnonconsecutiveinput) {
			//There is a consecutive range of pages
			$html = uppercasewords($pagesstartinput) . "-" . uppercasewords($pagesendinput) . ". ";
			return $html;
		}
		if ($pagesnonconsecutiveinput) {
			//There are nonconsecutive pages
			$html = uppercasewords($pagesstartinput) . "+. ";
			return $html;
		}
	}
	
	//Format section number for a newspaper citing (MLA)
	function mlanewspapersection($sectioninput) {
		if (ctype_alpha($sectioninput)) {
			$html = $sectioninput . ' sec.';
		}else{
			$html = 'sec. ' . $sectioninput;
		}
		return $html;
	}
	
	//Format the author names (MLA)
	function mlaauthorformat($contributors) {
		$countcontributors = count($contributors);
		//Count the number of authors in the array
		$countauthors = 0;
		foreach ($contributors as $contributor) {
			if ($contributor['cselect']=='author') {
				$countauthors++;
			}
		}
		$html = '';
		for ($i=0; $i<$countcontributors; $i++) {
			//If this contributor is an author
			if ($contributors[$i]['cselect']=='author') {
				if ($i==0) {
					//First time through the loop
					if ($countauthors>1) {
						//There is more than one author
						$html .= uppercasewords($contributors[$i]['lname']);
						if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
							//The author is a person and not a corporation
							$html .= ', ' . uppercasewords($contributors[$i]['fname']);
							if ($contributors[$i]['mi']) {
								$html .= ' ' . uppercasewords($contributors[$i]['mi']) . '.';
							}
						}
						$html .= ',';
					}else{
						//There is only one author
						if (($contributors[$i]['lname']!='Anonymous') || (!$contributors[$i]['lname'] && !$contributors[$i]['fname'] && !$contributors[$i]['mi'])) {
							//The author is not Anonymous or blank
							$html .= uppercasewords($contributors[$i]['lname']);
							if (($contributors[$i]['fname'] || $contributors[$i]['mi'])) {
								//The author is a person and not a corporation
								$html .= ', ' . uppercasewords($contributors[$i]['fname']);
								if ($contributors[$i]['mi']) {
									$html .= ' ' . uppercasewords($contributors[$i]['mi']);
								}
							}
							$html .= '. ';
						}
					}
				}elseif (($i+1)==$countcontributors) {
					//Last time through the loop
					if ($countauthors>1) {
						//There is more than one author
						$html .= ' and ' . uppercasewords($contributors[$i]['fname']) . ' ';
						if ($contributors[$i]['mi']) {
							$html .= uppercasewords($contributors[$i]['mi']) . '. ';
						}
						$html .= uppercasewords($contributors[$i]['lname']) . '. ';
					}else{
						//There is only one author
						if (($contributors[$i]['lname']!='Anonymous') || (!$contributors[$i]['lname'] && !$contributors[$i]['fname'] && !$contributors[$i]['mi'])) {
							//The author is not Anonymous or blank
							$html .= uppercasewords($contributors[$i]['lname']) . ', ';
							$html .= uppercasewords($contributors[$i]['fname']);
							if ($contributors[$i]['mi']) {
								$html .= ' ' . uppercasewords($contributors[$i]['mi']);
							}
							$html .= '. ';
						}
					}
				}else{
					$html .= ' ' . uppercasewords($contributors[$i]['fname']) . ' ';
					if ($contributors[$i]['mi']) {
						$html .= uppercasewords($contributors[$i]['mi']) . '. ';
					}
					$html .= uppercasewords($contributors[$i]['lname']) . ',';				
				}
			}
		}
		return $html;
	}
	
	//Format a scholarly journal year published (MLA)
	function mlasjyearpublished($yearpublishedinput) {
		$html = '(' . $yearpublishedinput . '): ';
		return $html;
	}
	
	//Format a book title (MLA)
	function mlabooktitleformat($booktitleinput, $addpunctuation) {
		//Uppercase the words in book title
		$html = uppercasewords($booktitleinput);
		//Lowercase all articles, prepositions, & conjunctions
		$html = forcearticlelower($html);
		//If the article title contains a subtitle, capitalize the first word after the colon
		if (ereg(":[ ]+[a-z]", $html, $regs)) {
			$html = subtitleucfirst($html, $regs);
		}
		if ($addpunctuation=="yes") {
			//Punctuate after the book title, if necessary
			$html = articleperiod($html);
		}
		$html = '<i>' . $html . '</i>';
		return $html;
	}
	
	//Format an eBook medium (MLA)
	function mlaebookmediumformat($mediuminput) {
		if (ereg("[ ]+file", $mediuminput, $regs)) {
			//has the word "file" at the end of the string 
			$html = $mediuminput;
		}elseif(!$mediuminput) {
			//the Medium field is blank
			$html = '<i>Digital file</i>';
		}else{
			//does not have the word "file" at the end of the string
			$html = $mediuminput . ' file';
		}
		return $html;
	}

/********************************/
/*     Citation parsing         */
/********************************/

	//Creates a book citation
	function bookcite($style, $medium, $contributors, $publicationyearinput, $booktitleinput, $publisherlocationinput, $publisherinput, $websitetitleinput, $webaccessdateday, $webaccessdatemonth, $webaccessdateyear, $urlwebsiteinput, $doiwebsiteinput, $databaseinput, $dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear, $urldbinput, $doidbinput, $yearpublishedinput, $mediuminput, $urlebookinput, $doiebookinput) {
		//If the style is APA 6
		if ($style=="apa6") {
			//Add the contributors
			$html = apaauthorformat($contributors);
			//Add the publishing date (if provided)
			if ($publicationyearinput) {
				$html .= ' (' . $publicationyearinput . '). ';
			}
			//Add the book title (if provided)
			if ($booktitleinput) {
				$html .= booktitleapaformat($booktitleinput, "yes") . ' ';
			}
			//in print
				if ($medium=="print") {
					//Add the publisher location (if provided)
					if ($publisherlocationinput) {
						$html .= uppercasewords($publisherlocationinput) . ': ';
					}
					//Add the publisher (if provided)
					if ($publisherinput) {
						$html .= uppercasewords($publisherinput) . '.';
					}
				}
			//on a website
				if ($medium=="website") {
					//Add the URL (if provided)
					if ($urlwebsiteinput) {
						$html .= 'Retrieved from ' . checkurlprepend($urlwebsiteinput);
					}elseif($doiwebsiteinput) {
						//Add the DOI (if provided)
						$html .= 'doi:' . $doiwebsiteinput;
					}
				}
			//in a database
				if ($medium=="db") {
					//Add the URL (if provided)
					if ($urldbinput) {
						$html .= 'Retrieved from ' . checkurlprepend($urldbinput);
					}elseif($doidbinput) {
						//Add the DOI (if provided)
						$html .= 'doi:' . $doidbinput;
					}
				}
			//as an ebook
				if ($medium=="ebook") {
					//Add the URL (if provided)
					if ($urlebookinput) {
						$html .= 'Retrieved from ' . checkurlprepend($urlebookinput);
					}elseif($doiebookinput) {
						//Add the DOI (if provided)
						$html .= 'doi:' . $doiebookinput;
					}
				}
		}
		
		//If the style is MLA 7
		if ($style=="mla7") {
			//Add the contributors
			$html = mlaauthorformat($contributors);
			//Add the book title (if provided)
			if ($booktitleinput) {
				$html .= mlabooktitleformat($booktitleinput, "yes") . ' ';
			}
			//Add the publisher location (if provided)
			if ($publisherlocationinput) {
				$html .= uppercasewords($publisherlocationinput) . ': ';
			}
			//Add the publisher (if provided)
			if ($publisherinput) {
				$html .= uppercasewords($publisherinput) . ', ';
			}
			//Add the publication year (if provided)
			if ($publicationyearinput) {
				$html .= $publicationyearinput . '. ';
			}
			//in print
				if ($medium=="print") {
					//Add the medium
					$html .= 'Print.';
				}
			//on a website
				if ($medium=="website") {
					//Add the title of the website (if provided)
					if ($websitetitleinput) {
						$html .= '<i>' . uppercasewords($websitetitleinput) . '</i>' . '. ';
					}
					//Add the medium
					$html .= 'Web. ';
					//Add the access date (if provided)
					if ($webaccessdateday || $webaccessdatemonth || $webaccessdateyear) {
						$html .= mlaaccessdate($webaccessdateday, $webaccessdatemonth, $webaccessdateyear) . '. ';
					}
					//Add the URL (if provided)
					if ($urlwebsiteinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urlwebsiteinput);
						$html .= '&#62;';
						$html .= '. ';
					}
					
				}
			//in a database
				if ($medium=="db") {
					//Add the database title (if provided)
					if ($databaseinput) {
						$html .= '<i>' . uppercasewords($databaseinput) . '</i>' . '. ';
					}
					//Add the medium
					$html .= 'Web. ';
					//Add the access date (if provided)
					if ($dbaccessdateday || $dbaccessdatemonth || $dbaccessdateyear) {
						$html .= mlaaccessdate($dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear) . '. ';
					}
					//Add the URL (if provided)
					if ($urldbinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urldbinput);
						$html .= '&#62;';
						$html .= '. ';
					}
				}
			//as a digital file
				if ($medium=="ebook") {
					//Add the Medium
					$html .= mlaebookmediumformat($mediuminput) . '. ';
					//Add the URL (if provided)
					if ($urlebookinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urlebookinput);
						$html .= '&#62;';
						$html .= '. ';
					}
				}
		}
		echo $html;
	}
	
	//Creates a chapter or essay from a book citation
	function chapteressaycite($style, $medium, $contributors, $publicationyearinput, $chapteressayinput, $booktitleinput, $pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput, $publisherlocationinput, $publisherinput, $websitetitleinput, $webaccessdateday, $webaccessdatemonth, $webaccessdateyear, $urlwebsiteinput, $doiwebsiteinput, $databaseinput, $dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear, $urldbinput, $doidbinput) {
		//If the style is APA 6
		if ($style=="apa6") {
			//Add the contributors
			$html = apaauthorformat($contributors);
			//Add the publishing date (if provided)
			if ($publicationyearinput) {
				$html .= ' (' . $publicationyearinput . '). ';
			}
			//Add the chapter/essay title (if provided)
			if ($chapteressayinput) {
				$html .= articletitleapaformat($chapteressayinput) . ' ';
			}
			//Add the book title and page numbers (if provided)
			$pageholder = apanewspaperpages($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput);
			if ($pageholder) {
				//There are page numbers to display
				if ($booktitleinput) {
					//There is a book title to display
					$html .= booktitleapaformat($booktitleinput, "no") . ' ';
				}
				$html .= '(' . $pageholder . '). ';
			}else{
				//There are no page numbers to display
				if ($booktitleinput) {
					//There is a book title to display
					$html .= booktitleapaformat($booktitleinput, "yes") . ' ';
				}
			}
			//Add the publisher location (if provided)
			if ($publisherlocationinput) {
				$html .= uppercasewords($publisherlocationinput) . ': ';
			}
			//Add the publisher (if provided)
			if ($publisherinput) {
				$html .= uppercasewords($publisherinput) . '. ';
			}
			//on a website
				if ($medium=="website") {
					//Add the URL (if provided)
					if ($urlwebsiteinput) {
						$html .= 'Retrieved from ' . checkurlprepend($urlwebsiteinput);
					}elseif($doiwebsiteinput) {
						//Add the DOI (if provided)
						$html .= 'doi:' . $doiwebsiteinput;
					}
				}
			//in a database
				if ($medium=="db") {
					//Add the URL (if provided)
					if ($urldbinput) {
						$html .= 'Retrieved from ' . checkurlprepend($urldbinput);
					}elseif($doidbinput) {
						//Add the DOI (if provided)
						$html .= 'doi:' . $doidbinput;
					}
				}
		}
		
		//If the style is MLA 7
		if ($style=="mla7") {
			//Add the contributors
			$html = mlaauthorformat($contributors);
			//Add the chapter/essay title (if provided)
			if ($chapteressayinput) {
				//Uppercase all words in chapter/essay title, lowercase all articles, prepositions, & conjunctions, append a period, and encapsulate in double quotes
				$chapteressayinput = uppercasewords($chapteressayinput);
				$chapteressayinput = forcearticlelower($chapteressayinput);
				$chapteressayinput = articleperiod($chapteressayinput);
				$html .= '"' . $chapteressayinput . '" ';
			}
			//Add the book title (if provided)
			if ($booktitleinput) {
				$html .= mlabooktitleformat($booktitleinput, "yes") . ' ';
			}
			//Add the publisher location (if provided)
			if ($publisherlocationinput) {
				$html .= uppercasewords($publisherlocationinput) . ': ';
			}
			//Add the publisher (if provided)
			if ($publisherinput) {
				$html .= uppercasewords($publisherinput) . ', ';
			}
			//Add the publication year (if provided)
			if ($publicationyearinput) {
				$html .= $publicationyearinput . '. ';
			}
			//Add the page numbers
			$html .= mlapagenumbers($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput);
			//in print
				if ($medium=="print") {
					//Add the medium
					$html .= 'Print.';
				}
			//on a website
				if ($medium=="website") {
					//Add the title of the website (if provided)
					if ($websitetitleinput) {
						$html .= '<i>' . uppercasewords($websitetitleinput) . '</i>' . '. ';
					}
					//Add the medium
					$html .= 'Web. ';
					//Add the access date (if provided)
					if ($webaccessdateday || $webaccessdatemonth || $webaccessdateyear) {
						$html .= mlaaccessdate($webaccessdateday, $webaccessdatemonth, $webaccessdateyear) . '. ';
					}
					//Add the URL (if provided)
					if ($urlwebsiteinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urlwebsiteinput);
						$html .= '&#62;';
						$html .= '. ';
					}
					
				}
			//in a database
				if ($medium=="db") {
					//Add the database title (if provided)
					if ($databaseinput) {
						$html .= '<i>' . uppercasewords($databaseinput) . '</i>' . '. ';
					}
					//Add the medium
					$html .= 'Web. ';
					//Add the access date (if provided)
					if ($dbaccessdateday || $dbaccessdatemonth || $dbaccessdateyear) {
						$html .= mlaaccessdate($dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear) . '. ';
					}
					//Add the URL (if provided)
					if ($urldbinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urldbinput);
						$html .= '&#62;';
						$html .= '. ';
					}
				}
		}		
		echo $html;
	}
	
	//Creates a magazine article citation
	function magazinecite($style, $medium, $contributors, $articletitleinput, $magazinetitleinput, $datepublishedday, $datepublishedmonth, $datepublishedyear, $pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput, $printadvancedinfovolume, $printadvancedinfoissue, $websitetitleinput, $webpagesstartinput, $webpagesendinput, $webpagesnonconsecutiveinput, $webpagesnonconsecutivepagenumsinput, $websiteadvancedinfovolume, $websiteadvancedinfoissue, $webaccessdateday, $webaccessdatemonth, $webaccessdateyear, $urlwebsiteinput, $dbpagesstartinput, $dbpagesendinput, $dbpagesnonconsecutiveinput, $dbadvancedinfovolume, $dbadvancedinfoissue, $databaseinput, $dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear, $urldbinput) {
		//Prep any variables that apply to all styles
		
		//If the style is APA 6
		if ($style=="apa6") {
			//Add the contributors
			$html = apaauthorformat($contributors);
			//Add the publishing date
			$html .= apamagnewsdate($datepublishedday, $datepublishedmonth, $datepublishedyear) . '. ';
			//Add the article title (if provided)
			if ($articletitleinput) {
				$html .= articletitleapaformat($articletitleinput) . ' ';
			}
			//Add the magazine title (if provided)
			if ($magazinetitleinput) {
				$magtitleholder = uppercasewords($magazinetitleinput);
				$html .= '<i>' . forcearticlelower($magtitleholder) . '</i>';
			}
			if ($medium=="print") {
				//Add the volume and issue numbers (if provided)
				if ($printadvancedinfovolume || $printadvancedinfoissue) {
					//Add a comma after the magazine title (if provided)
					if ($magazinetitleinput) {
						$html .= ', ';
					}
					$html .= '<i>' . $printadvancedinfovolume . '</i>';
					if ($printadvancedinfoissue) {
						//Add the issue number (if provided)
						$html .= '(' . $printadvancedinfoissue . ')';
					}
				}
				//Add the page numbers (if provided)
				$pageholder = apascholarjournalpages($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput);
				if ($pageholder) {
					//There are page numbers
					if ($printadvancedinfovolume || $printadvancedinfoissue) {
						//There is a volume & issue number preceeding
						$html .= ', ' . $pageholder;
					}else{
						//There is no volume & issue number preceeding
						if ($magazinetitleinput) {
							//There is a magazine title preceeding
							$html .= ', ' . $pageholder;
						}else{
							//There is no magazine title preceeding
							$html .= $pageholder;
						}
					}
				}
				//Add a period
				$html .= '. ';
			}
			if ($medium=="website") {
				//Add the volume and issue numbers (if provided)
				if ($websiteadvancedinfovolume || $websiteadvancedinfoissue) {
					//Add a comma after the magazine title (if provided)
					if ($magazinetitleinput) {
						$html .= ', ';
					}
					$html .= '<i>' . $websiteadvancedinfovolume . '</i>';
					if ($websiteadvancedinfoissue) {
						//Add the issue number (if provided)
						$html .= '(' . $websiteadvancedinfoissue . ')';
					}
				}
				//Add the page numbers (if provided)
				$pageholder = apascholarjournalpages($webpagesstartinput, $webpagesendinput, $webpagesnonconsecutiveinput, $webpagesnonconsecutivepagenumsinput);
				if ($pageholder) {
					//There are page numbers
					if ($printadvancedinfovolume || $printadvancedinfoissue) {
						//There is a volume & issue number preceeding
						$html .= ', ' . $pageholder;
					}else{
						//There is no volume & issue number preceeding
						if ($magazinetitleinput) {
							//There is a magazine title preceeding
							$html .= ', ' . $pageholder;
						}else{
							//There is no magazine title preceeding
							$html .= $pageholder;
						}
					}
				}
				//Add a period
				$html .= '. ';
				//Add the URL (if provided)
				if ($urlwebsiteinput) {
					$html .= 'Retrieved from ' . checkurlprepend($urlwebsiteinput);
				}
			}
			if ($medium=="db") {
				//Add the volume and issue numbers (if provided)
				if ($dbadvancedinfovolume || $dbadvancedinfoissue) {
					//Add a comma after the magazine title (if provided)
					if ($magazinetitleinput) {
						$html .= ', ';
					}
					$html .= '<i>' . $dbadvancedinfovolume . '</i>';
					if ($dbadvancedinfoissue) {
						//Add the issue number (if provided)
						$html .= '(' . $dbadvancedinfoissue . ')';
					}
				}
				//Add the page numbers (if provided)
				$pageholder = apascholarjournalpages($dbpagesstartinput, $dbpagesendinput, $dbpagesnonconsecutiveinput, $dbpagesnonconsecutivepagenumsinput);
				if ($pageholder) {
					//There are page numbers
					if ($dbadvancedinfovolume || $dbadvancedinfoissue) {
						//There is a volume & issue number preceeding
						$html .= ', ' . $pageholder;
					}else{
						//There is no volume & issue number preceeding
						if ($magazinetitleinput) {
							//There is a magazine title preceeding
							$html .= ', ' . $pageholder;
						}else{
							//There is no magazine title preceeding
							$html .= $pageholder;
						}
					}
				}
				//Add a period
				$html .= '. ';
				//Add the URL (if provided)
				if ($urldbinput) {
					$html .= 'Retrieved from ' . checkurlprepend($urldbinput);
				}
			}
		}
		
		//If the style is MLA 7
		if ($style=="mla7") {
			//Add the contributors
			$html = mlaauthorformat($contributors);
			//Add the article title (if provided)
			if ($articletitleinput) {
				//Uppercase all words in article title, lowercase all art., prep., & conj., append a period, and encapsulate in double quotes
				$articletitle = uppercasewords($articletitleinput);
				$articletitle = forcearticlelower($articletitle);
				$articletitle = articleperiod($articletitle);
				$html .= '"' . $articletitle . '" ';
			}
			//in print
				if ($medium=="print") {
					//Add the magazine title (if provided)
					if ($magazinetitleinput) {
						$magtitleholder = uppercasewords($magazinetitleinput);
						$html .= '<i>' . forcearticlelower($magtitleholder) . '</i>' . ' ';
					}
					//Add the date published (if provided)
					if ($datepublishedday || $datepublishedmonth || $datepublishedyear) {
						$html .= mlanewspublishdate($datepublishedday, $datepublishedmonth, $datepublishedyear);
						//Add a colon
						$html .= ': ';
					}
					//Add the page numbers
					$html .= mlapagenumbers($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput);
					//Add the medium
					$html .= 'Print.';
				}
			//on website
				if ($medium=="website") {
					//Add the website publisher/sponsor (if provided)
					if ($magazinetitleinput) {
						$html .= '<i>' . uppercasewords($magazinetitleinput) . '</i>' . '. ';
					}else{
						$html .= 'N.p., ';
					}
					//Add the website title (if provided)
					if ($websitetitleinput) {
						$html .= uppercasewords($websitetitleinput) . ', ';
					}
					//Add the date published (if provided)
					$html .= mlanewspublishdate($datepublishedday, $datepublishedmonth, $datepublishedyear);
					//Add a period
					$html .= '. ';
					//Add the medium
					$html .= 'Web. ';
					//Add the access date (if provided)
					if ($webaccessdateday || $webaccessdatemonth || $webaccessdateyear) {
						$html .= mlaaccessdate($webaccessdateday, $webaccessdatemonth, $webaccessdateyear) . '. ';
					}
					//Add the URL (if provided)
					if ($urlwebsiteinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urlwebsiteinput);
						$html .= '&#62;';
						$html .= '. ';
					}
				}
			//in a database
				if ($medium=="db") {
					//Add the magazine title (if provided)
					if ($magazinetitleinput) {
						$magtitleholder = uppercasewords($magazinetitleinput);
						$html .= '<i>' . forcearticlelower($magtitleholder) . '</i>' . ' ';
					}
					//Add the date published (if provided)
					$html .= mlanewspublishdate($datepublishedday, $datepublishedmonth, $datepublishedyear);
					//Add a period
					$html .= '. ';
					//Add the page numbers
					$html .= mlapagenumbers($dbpagesstartinput, $dbpagesendinput, $dbpagesnonconsecutiveinput);
					//Add the database title (if provided)
					if ($databaseinput) {
						$html .= '<i>' . uppercasewords($databaseinput) . '</i>' . '. ';
					}
					//Add the medium
					$html .= 'Web. ';
					//Add the access date (if provided)
					if ($dbaccessdateday || $dbaccessdatemonth || $dbaccessdateyear) {
						$html .= mlaaccessdate($dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear) . '. ';
					}
					//Add the URL (if provided)
					if ($urldbinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urldbinput);
						$html .= '&#62;';
						$html .= '. ';
					}
				}
		}
		echo $html;
	}	
	
	//Creates a newspaper article citation
	function newspapercite($style, $medium, $contributors, $articletitleinput, $newspapertitleinput, $newspapercityinput, $datepublishedday, $datepublishedmonth, $datepublishedyear, $editioninput, $sectioninput, $pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput, $websitetitleinput, $urlwebsiteinput, $electronicpublishday, $electronicpublishmonth, $electronicpublishyear, $webaccessdateday, $webaccessdatemonth, $webaccessdateyear, $dbnewspapercityinput, $dbdatepublisheddateday, $dbdatepublisheddatemonth, $dbdatepublisheddateyear, $dbeditioninput, $dbpagesstartinput, $dbpagesendinput, $dbpagesnonconsecutiveinput, $databaseinput, $dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear, $urldbinput) {

		//If the style is APA 6
		if ($style=="apa6") {
			//Add the contributors
			$html = apaauthorformat($contributors);
			//Add the publishing date
			if ($medium=="print") {
				$html .= apamagnewsdate($datepublishedday, $datepublishedmonth, $datepublishedyear) . '. ';
			}
			if ($medium=="website") {
				$html .= apamagnewsdate($electronicpublishday, $electronicpublishmonth, $electronicpublishyear) . '. ';
			}
			if ($medium=="db") {
				$html .= apamagnewsdate($dbdatepublisheddateday, $dbdatepublisheddatemonth, $dbdatepublisheddateyear) . '. ';
			}
			//Add the article title (if provided)
			if ($articletitleinput) {
				$html .= articletitleapaformat($articletitleinput) . ' ';
			}
			//in print
				if ($medium=="print") {
					//Add the newspaper title
					$html .= '<i>' . uppercasewords($newspapertitleinput) . '</i>';
					//Add a comma after the newspaper title
					$html .= ', ';
					//Add the page numbers
					$html .= apanewspaperpages($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput) . '.';
				}
			//on a website
				if ($medium=="website") {
					//Add the newspaper title
					$html .= '<i>' . uppercasewords($newspapertitleinput) . '</i>';
					//Add a period after the newspaper title
					$html .= '. ';
					//Add the Home page URL (if provided)
					if ($urlwebsiteinput) {
						//Add the URL
						$html .= 'Retrieved from ' . $urlwebsiteinput;
					}
				}
			//in a database
				if ($medium=="db") {
					//Add the newspaper title
					$html .= '<i>' . uppercasewords($newspapertitleinput) . '</i>';
					//Add a period after the newspaper title
					$html .= '. ';
					//Add the Home page URL (if provided)
					if ($urldbinput) {
						//Add the URL
						$html .= 'Retrieved from ' . $urldbinput;
					}
				}
		}
		
		//If the style is MLA 7
		if ($style=="mla7") {
			//Add the contributors
			$html = mlaauthorformat($contributors);
			//Add the article title (if provided)
			if ($articletitleinput) {
				//Uppercase all words in article title, lowercase all art., prep., & conj., append a period, and encapsulate in double quotes
				$articletitle = uppercasewords($articletitleinput);
				$articletitle = forcearticlelower($articletitle);
				$articletitle = articleperiod($articletitle);
				$html .= '"' . $articletitle . '" ';
			}
			//in print
				if ($medium=="print") {
					//Add the newspaper title (if provided)
					if ($newspapertitleinput) {
						//Uppercase all words in a newspaper's title
						$newspapertitleinput = uppercasewords($newspapertitleinput);
						//Remove articles (A, An, The) before the newspaper title 
						$newspapertitleinput = removearticle($newspapertitleinput);
						$html .= '<i>' . $newspapertitleinput . '</i>' . ' ';
					}
					//Add the newspaper city (if provided)
					if ($newspapercityinput) {
						$html .= '[' . uppercasewords($newspapercityinput) . ']' . ' ';
					}
					//Add the date published (if provided)
					if ($datepublishedday || $datepublishedmonth || $datepublishedyear) {
						$html .= mlanewspublishdate($datepublishedday, $datepublishedmonth, $datepublishedyear);
					}
					//Add the edition (if provided)
					if ($editioninput) {
						$editioninput = lowercasewords($editioninput);
						$html .= ', ' . editionabbrev($editioninput);
					}
					//Add the section (if provided)
					if ($sectioninput) {
						$html .= ', ' . mlanewspapersection($sectioninput);
					}
					//Add a colon
					$html .= ': ';
					//Add the page numbers
					$html .= mlapagenumbers($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput);
					//Add the medium
					$html .= 'Print.';
				}
			//on a website
				if ($medium=="website") {
					//Add the web site title (if provided)
					if ($websitetitleinput) {
						$html .= '<i>' . uppercasewords($websitetitleinput) . '</i>' . '. ';
					}
					//Add the newspaper title (if provided)
					if ($newspapertitleinput) {
						//Uppercase all words in a newspaper's title
						$newspapertitleinput = uppercasewords($newspapertitleinput);
						//Remove articles (A, An, The) before the newspaper title 
						$newspapertitleinput = removearticle($newspapertitleinput);
						$html .= '<i>' . $newspapertitleinput . '</i>' . ', ';
					}
					//Add the electronically published date (if provided)
					if ($electronicpublishday || $electronicpublishmonth || $electronicpublishyear) {
						$html .= mlanewspublishdate($electronicpublishday, $electronicpublishmonth, $electronicpublishyear) . '. ';
					}
					//Add the medium
					$html .= 'Web. ';
					//Add the access date (if provided) 
					if ($webaccessdateday || $webaccessdatemonth || $webaccessdateyear) {
						$html .= mlaaccessdate($webaccessdateday, $webaccessdatemonth, $webaccessdateyear) . '. ';
					}
					//Add the URL (if provided)
					if ($urlwebsiteinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urlwebsiteinput);
						$html .= '&#62;';
						$html .= '. ';
					}
				}
			//in a database
				if ($medium=="db") {
					//Add the newspaper title (if provided)
					if ($newspapertitleinput) {
						//Uppercase all words in a newspaper's title
						$newspapertitleinput = uppercasewords($newspapertitleinput);
						//Remove articles (A, An, The) before the newspaper title 
						$newspapertitleinput = removearticle($newspapertitleinput);
						$html .= '<i>' . $newspapertitleinput . '</i>' . ' ';
					}
					//Add the newspaper city (if provided)
					if ($dbnewspapercityinput) {
						$html .= '[' . uppercasewords($dbnewspapercityinput) . ']' . ' ';
					}
					//Add the date published (if provided)
					if ($dbdatepublisheddateday || $dbdatepublisheddatemonth || $dbdatepublisheddateyear) {
						$html .= mlanewspublishdate($dbdatepublisheddateday, $dbdatepublisheddatemonth, $dbdatepublisheddateyear);
					}
					//Add the edition (if provided)
					if ($dbeditioninput) {
						$dbeditioninput = lowercasewords($dbeditioninput);
						$html .= ', ' . editionabbrev($dbeditioninput);
					}			
					//Add a colon
					$html .= ': ';
					//Add the page numbers
					$html .= mlapagenumbers($dbpagesstartinput, $dbpagesendinput, $dbpagesnonconsecutiveinput);
					//Add the database title (if provided)
					if ($databaseinput) {
						$html .= '<i>' . uppercasewords($databaseinput) . '</i>' . '. ';
					}
					//Add the medium
					$html .= 'Web. ';
					//Add the access date
					$html .= mlaaccessdate($dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear) . '. ';
					//Add the URL (if provided)
					if ($urldbinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urldbinput);
						$html .= '&#62;';
						$html .= '. ';
					}
				}
		}
		
		echo $html;
	}
	
	//Creates a scholarly journal article citation
	function scholarjournalcite($style, $medium, $contributors, $yearpublishedinput, $articletitleinput, $journaltitleinput, $volume, $issue, $pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput, $urlwebsiteinput, $doiwebsiteinput, $webaccessdateday, $webaccessdatemonth, $webaccessdateyear, $databaseinput, $dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear, $urldbinput, $doidbinput) {
		//If the style is APA 6
		if ($style=="apa6") {
			//Add the contributors
			$html = apaauthorformat($contributors);
			//Add the publishing date (if provided)
			if ($yearpublishedinput) {
				$html .= ' (' . $yearpublishedinput . '). ';
			}
			//Add the article title (if provided)
			if ($articletitleinput) {
				$html .= articletitleapaformat($articletitleinput) . ' ';
			}
			//Add the journal title (if provided)
			if ($journaltitleinput) {
				$journaltitleholder = uppercasewords($journaltitleinput);
				$html .= '<i>' . forcearticlelower($journaltitleholder) . '</i>';
			}
			//Add the volume and issue numbers (if provided)
			if ($volume || $issue) {
				//Add a comma after the journal title (if provided)
				if ($journaltitleinput) {
					$html .= ', ';
				}
				$html .= '<i>' . $volume . '</i>';
				if ($issue) {
					//Add the issue number (if provided)
					$html .= '(' . $issue . ')';
				}
			}
			//Add the page numbers (if provided)
			$pageholder = apascholarjournalpages($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput, $pagesnonconsecutivepagenumsinput);
			if ($pageholder) {
				//There are page numbers
				if ($volume || $issue) {
					//There is a volume & issue number preceeding
					$html .= ', ' . $pageholder;
				}else{
					//There is no volume & issue number preceeding
					if ($journaltitleinput) {
						//There is a magazine title preceeding
						$html .= ', ' . $pageholder;
					}else{
						//There is no journal title preceeding
						$html .= $pageholder;
					}
				}
			}
			//Add a period
			$html .= '. ';
			//on a website
				if ($medium=="website") {
					//Add the URL (if provided)
					if ($urlwebsiteinput) {
						$html .= 'Retrieved from ' . checkurlprepend($urlwebsiteinput);
					}elseif($doiwebsiteinput) {
						//Add the DOI (if provided)
						$html .= 'doi:' . $doiwebsiteinput;
					}
				}
			//in a database
				if ($medium=="db") {
					//Add the URL (if provided)
					if ($urldbinput) {
						$html .= 'Retrieved from ' . checkurlprepend($urldbinput);
					}elseif($doidbinput) {
						//Add the DOI (if provided)
						$html .= 'doi:' . $doidbinput;
					}
				}
		}
		
		//If the style is MLA 7
		if ($style=="mla7") {
			//Add the contributors
			$html = mlaauthorformat($contributors);
			//Add the article title (if provided)
			if ($articletitleinput) {
				//Uppercase all words in article title, lowercase all art., prep., & conj., append a period, and encapsulate in double quotes
				$articletitle = uppercasewords($articletitleinput);
				$articletitle = forcearticlelower($articletitle);
				$articletitle = articleperiod($articletitle);
				$html .= '"' . $articletitle . '" ';
			}
			//Add the journal title (if provided)
			if ($journaltitleinput) {
				$journaltitleholder = uppercasewords($journaltitleinput);
				$html .= '<i>' . forcearticlelower($journaltitleholder) . ' </i>';
			}
			//Add the volume number (if provided)
			if ($volume) {
				$html .= $volume;
			}
			//Add the issue number (if provided)
			if ($issue) {
				$html .= '.' . $issue . ' ';
			}
			//Add the date published (if provided)
			if ($yearpublishedinput) {
				$html .= mlasjyearpublished($yearpublishedinput);
			}
			//Add the page numbers
			$html .= mlapagenumbers($pagesstartinput, $pagesendinput, $pagesnonconsecutiveinput);
			//in print
				if ($medium=="print") {
					//Add the medium
					$html .= 'Print.';
				}
			//on a website
				if ($medium=="website") {
					//Add the medium
					$html .= 'Web. ';
					//Add the access date (if provided)
					if ($webaccessdateday || $webaccessdatemonth || $webaccessdateyear) {
						$html .= mlaaccessdate($webaccessdateday, $webaccessdatemonth, $webaccessdateyear) . '. ';
					}
					//Add the URL (if provided)
					if ($urlwebsiteinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urlwebsiteinput);
						$html .= '&#62;';
						$html .= '. ';
					}
				}
			//in a database
				if ($medium=="db") {
					//Add the database title (if provided)
					if ($databaseinput) {
						$html .= '<i>' . uppercasewords($databaseinput) . '</i>' . '. ';
					}
					//Add the medium
					$html .= 'Web. ';
					//Add the access date (if provided)
					if ($dbaccessdateday || $dbaccessdatemonth || $dbaccessdateyear) {
						$html .= mlaaccessdate($dbaccessdateday, $dbaccessdatemonth, $dbaccessdateyear) . '. ';
					}
					//Add the URL (if provided)
					if ($urldbinput) {
						$html .= '&#60;';
						$html .= checkurlprepend($urldbinput);
						$html .= '&#62;';
						$html .= '. ';
					}
				}
		}
		echo $html;
	}
	
	//Creates a web site citation
	function websitecite($style, $medium, $contributors, $articletitleinput, $websitetitleinput, $publishersponsorinput, $urlwebsiteinput, $electronicpublishday, $electronicpublishmonth, $electronicpublishyear, $webaccessdateday, $webaccessdatemonth, $webaccessdateyear) {
		
		//If the style is APA 6
		if ($style=="apa6") {
			//Add the contributors
			$html = apaauthorformat($contributors);
			//Add the publishing date
			$html .= apamagnewsdate($electronicpublishday, $electronicpublishmonth, $electronicpublishyear) . '. ';
			//Add the article title (if provided)
			if ($articletitleinput) {
				$html .= articletitleapaformat($articletitleinput) . ' ';
			}
			//Add the website title (if provided)
			if ($websitetitleinput) {
				$html .= 'Retrieved from ' . $websitetitleinput . ' ';
			}
			//Add the URL (if provided)
			if ($urlwebsiteinput) {
				$html .= 'website: ' . checkurlprepend($urlwebsiteinput);
			}
		}
		
		//If the style is MLA 7
		if ($style=="mla7") {
			//Add the contributors
			$html = mlaauthorformat($contributors);
			//Add the article title (if provided)
			if ($articletitleinput) {
				//Uppercase all words in article title, lowercase all art., prep., & conj., append a period, and encapsulate in double quotes
				$articletitle = uppercasewords($articletitleinput);
				$articletitle = forcearticlelower($articletitle);
				$articletitle = articleperiod($articletitle);
				$html .= '"' . $articletitle . '" ';
			}
			//Add the web site title (if provided)
			if ($websitetitleinput) {
				$html .= '<i>' . uppercasewords($websitetitleinput) . '</i>' . '. ';
			}
			//Add the web site publisher/sponsor (if provided)
			if ($publishersponsorinput) {
				$html .= uppercasewords($publishersponsorinput) . ', ';
			}else{
				$html .= 'N.p., ';
			}
			//Add the electronically published date (if provided)
			$html .= mlanewspublishdate($electronicpublishday, $electronicpublishmonth, $electronicpublishyear);
			//Add a period
			$html .= '. ';
			//Add the medium
			$html .= 'Web. ';
			//Add the access date (if provided)
			if ($webaccessdateday || $webaccessdatemonth || $webaccessdateyear) {
				$html .= mlaaccessdate($webaccessdateday, $webaccessdatemonth, $webaccessdateyear) . '. ';
			}
			//Add the URL (if provided)
			if ($urlwebsiteinput) {
				$html .= '&#60;';
				$html .= checkurlprepend($urlwebsiteinput);
				$html .= '&#62;';
				$html .= '. ';
			}
		}
		echo $html;
	}
	
/********************************/
/*     Citation layout          */
/********************************/

	//Creates an overall container for citations
	function citationhold() {
		$html = '<div id="placeholder" class="placeholder"></div>';
		echo $html;
	}
	
	//Creates a single citation container
	function citationcontainstart($style) {
		$html = '<div id="overallcitationholder"><table width="100%"><tr><td align="center">Copy and paste the citation below into your work.</td></tr></table>';
		$html .= '<div id="citationholder" class="citationholder"><span class="styleheading">' . styleconvert($style) . '</span><br />';
		echo $html;
	}
	
	//Closes a single citation container
	function citationcontainend() {
		$html = '</div>';
		echo $html;
	}
?>