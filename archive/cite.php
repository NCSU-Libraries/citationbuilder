<?php
	//Save the variable passed in through the URL
	$source = $_GET['source'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- METADATA: insert content from stage/webpub/metadata form below this line -->
		
		
		<!-- MASTER STYLES AND HEAD: do not remove -->
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.3/themes/base/jquery-ui.css" type="text/css" media="all" />
		<!--#include virtual="/websiteclassic/includes/head.html"-->
		<link rel="stylesheet" href="includes/css.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="includes/colorbox.css" type="text/css" media="screen" />
		
		<!-- jQuery -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
		<script type="text/javascript" src="includes/jquery_plugins/jquery.form.js"></script>
		<script type="text/javascript" src="includes/jquery_plugins/jquery.colorboxmin.js"></script>
		<script type="text/javascript">
			$(function() {
				$('#stylechoice a').live('click', function() {
					$.get($(this).attr("href"), function(data) {
						var selectedtab = $('#citeform #tabs').tabs('option', 'selected');
						$('#tabs').tabs('destroy');
						//see if user has filled out form, save old data
							//common variables
								var articletitleinput = $('#articletitleinput').val();	
								var datepublishedday = $('#datepublishedday').val();
								var datepublishedmonth = $('#datepublishedmonth').val();
								var datepublishedyear = $('#datepublishedyear').val();
								var pagesstartinput = $('#pagesstartinput').val();
								var pagesendinput = $('#pagesendinput').val();
								var urlwebsiteinput = $('#urlwebsiteinput').val();
								var electronicpublishday = $('#electronicpublishday').val();
								var electronicpublishmonth = $('#electronicpublishmonth').val();
								var electronicpublishyear = $('#electronicpublishyear').val();
								var webaccessdateday = $('#webaccessdateday').val();
								var webaccessdatemonth = $('#webaccessdatemonth').val();
								var webaccessdateyear = $('#webaccessdateyear').val();
								var dbdatepublisheddateday = $('#dbdatepublisheddateday').val();
								var dbdatepublisheddatemonth = $('#dbdatepublisheddatemonth').val();
								var dbdatepublisheddateyear = $('#dbdatepublisheddateyear').val();
								var dbpagesstartinput = $('#dbpagesstartinput').val();
								var dbpagesendinput = $('#dbpagesendinput').val();
								var dbpagesnonconsecutiveinput = $('#dbpagesnonconsecutiveinput').attr('checked');
								var databaseinput = $('#databaseinput').val();
								var urldbinput = $('#urldbinput').val();
								var dbaccessdateday = $('#dbaccessdateday').val();
								var dbaccessdatemonth = $('#dbaccessdatemonth').val();
								var dbaccessdateyear = $('#dbaccessdateyear').val();
							//source specific variables
								var newspapertitleinput = $('#newspapertitleinput').val();
								var editioninput = $('#editioninput').val();
								var sectioninput = $('#sectioninput').val();
								var dbeditioninput = $('#dbeditioninput').val();
						$('#stylechoice').html($(data).find('#stylechoice').html());
						$('#revolvecontent').html($(data).find('#revolvecontent').html());
						//set saved data into new form
							//common variables
								$('#articletitleinput').val(articletitleinput);
								//Date published
									if (datepublishedday && !dbdatepublisheddateday) {
										$('#datepublishedday').val(datepublishedday);
										$('#dbdatepublisheddateday').val(datepublishedday);
									}
									if (!datepublishedday && dbdatepublisheddateday) {
										$('#datepublishedday').val(dbdatepublisheddateday);
										$('#dbdatepublisheddateday').val(dbdatepublisheddateday);
									}
									if (datepublishedmonth && !dbdatepublisheddatemonth) {
										$('#datepublishedmonth').val(datepublishedmonth);
										$('#dbdatepublisheddatemonth').val(datepublishedmonth);
									}
									if (!datepublishedmonth && dbdatepublisheddatemonth) {
										$('#datepublishedmonth').val(dbdatepublisheddatemonth);
										$('#dbdatepublisheddatemonth').val(dbdatepublisheddatemonth);
									}
									if (datepublishedyear && !dbdatepublisheddateyear) {
										$('#datepublishedyear').val(datepublishedyear);
										$('#dbdatepublisheddateyear').val(datepublishedyear);
									}
									if (!datepublishedyear && dbdatepublisheddateyear) {
										$('#datepublishedyear').val(dbdatepublisheddateyear);
										$('#dbdatepublisheddateyear').val(dbdatepublisheddateyear);
									}
								//Pages
									if (pagesstartinput && !dbpagesstartinput) {
										$('#pagesstartinput').val(pagesstartinput);
										$('#dbpagesstartinput').val(pagesstartinput);
									}
									if (pagesendinput && !dbpagesendinput) {
										$('#pagesendinput').val(pagesendinput);
										$('#dbpagesendinput').val(pagesendinput);
									}
									
									if (!pagesstartinput && dbpagesstartinput) {
										$('#pagesstartinput').val(dbpagesstartinput);
										$('#dbpagesstartinput').val(dbpagesstartinput);
									}
									if (!pagesendinput && dbpagesendinput) {
										$('#pagesendinput').val(dbpagesendinput);
										$('#dbpagesendinput').val(dbpagesendinput);
									}
								//URL
									if (urlwebsiteinput && !urldbinput) {
										$('#urlwebsiteinput').val(urlwebsiteinput);
										$('#urldbinput').val(urlwebsiteinput);
									}
									if (!urlwebsiteinput && urldbinput) {
										$('#urlwebsiteinput').val(urldbinput);
										$('#urldbinput').val(urldbinput);
									}
								$('#electronicpublishday').val(electronicpublishday);
								$('#electronicpublishmonth').val(electronicpublishmonth);
								$('#electronicpublishyear').val(electronicpublishyear);
								//Access date
									if (webaccessdateday && !dbaccessdateday) {
										$('#webaccessdateday').val(webaccessdateday);
										$('#dbaccessdateday').val(webaccessdateday);
									}
									if (webaccessdatemonth && !dbaccessdatemonth) {
										$('#webaccessdatemonth').val(webaccessdatemonth);
										$('#dbaccessdatemonth').val(webaccessdatemonth);
									}
									if (webaccessdateyear && !dbaccessdateyear) {
										$('#webaccessdateyear').val(webaccessdateyear);
										$('#dbaccessdateyear').val(webaccessdateyear);
									}
									if (!webaccessdateday && dbaccessdateday) {
										$('#webaccessdateday').val(dbaccessdateday);
										$('#dbaccessdateday').val(dbaccessdateday);
									}
									if (!webaccessdatemonth && dbaccessdatemonth) {
										$('#webaccessdatemonth').val(dbaccessdatemonth);
										$('#dbaccessdatemonth').val(dbaccessdatemonth);
									}
									if (!webaccessdateyear && dbaccessdateyear) {
										$('#webaccessdateyear').val(dbaccessdateyear);
										$('#dbaccessdateyear').val(dbaccessdateyear);
									}
								$('#databaseinput').val(databaseinput);	
							//source specific variables
								$('#newspapertitleinput').val(newspapertitleinput);
								//Edition
									if (editioninput && !dbeditioninput) {
										$('#editioninput').val(editioninput);
										$('#dbeditioninput').val(editioninput);
									}
									if (!editioninput && dbeditioninput) {
										$('#editioninput').val(dbeditioninput);
										$('#dbeditioninput').val(dbeditioninput);
									}
								$('#sectioninput').val(sectioninput);
						
						//set tabs
						$('#citeform #tabs').tabs({selected: selectedtab});
						$('.print').click(function(){
							$('#mediumholder').attr('value','print');
						});
						$('.website').click(function(){
							$("#mediumholder").attr('value','website');
						});
						$('.db').click(function(){
							$('#mediumholder').attr('value','db');
						});
						$('.ebook').click(function(){
							$('#mediumholder').attr('value','ebook');
						});
						//prevent entering both fields on an OR choice
						$('#urlwebsiteinput').blur(function(){
							if($('#urlwebsiteinput').val() != '') {
								$('#doiwebsiteinput').attr('disabled','disabled');
							}else{
								$('#doiwebsiteinput').removeAttr('disabled');
							}
						});
						$('#doiwebsiteinput').blur(function(){
							if($('#doiwebsiteinput').val() != '') {
								$('#urlwebsiteinput').attr('disabled','disabled');
							}else{
								$('#urlwebsiteinput').removeAttr('disabled');
							}
						});
						$('#urldbinput').blur(function(){
							if($('#urldbinput').val() != '') {
								$('#doidbinput').attr('disabled','disabled');
							}else{
								$('#doidbinput').removeAttr('disabled');
							}
						});
						$('#doidbinput').blur(function(){
							if($('#doidbinput').val() != '') {
								$('#urldbinput').attr('disabled','disabled');
							}else{
								$('#urldbinput').removeAttr('disabled');
							}
						});
						$('#urlebookinput').blur(function(){
							if($('#urlebookinput').val() != '') {
								$('#doiebookinput').attr('disabled','disabled');
							}else{
								$('#doiebookinput').removeAttr('disabled');
							}
						});
						$('#doiebookinput').blur(function(){
							if($('#doiebookinput').val() != '') {
								$('#urlebookinput').attr('disabled','disabled');
							}else{
								$('#urlebookinput').removeAttr('disabled');
							}
						});
					});
					return false;
				});
				$('#citeform').ajaxForm({ 
					//target identifies the element(s) to update with the server response 
					target: '#placeholder', 
			 
					//success identifies the function to invoke when the server response 
					//has been received; here we apply a fade-in effect to the new content 
					success: function() { 
						$.colorbox({
							overlayClose: false,
							speed: 500,
							inline:true,
							opacity: 0.65,
							close: "x Close",
							href:"#overallcitationholder",
							width: "900px"
						}); 
					}
				});
				$('#change').click(function(){
					$('#sourcechangeholder').show(700);
					return false;
				})
				$('#close').click(function(){
					$('#sourcechangeholder').hide(700);
					return false;
				})
				$('#tabs').tabs({selected : 1});
				$('.print').click(function(){
					$('#mediumholder').attr('value','print');
				});
				$('.website').click(function(){
					$('#mediumholder').attr('value','website');
				});
				$('.db').click(function(){
					$('#mediumholder').attr('value','db');
				});
				$('.ebook').click(function(){
					$('#mediumholder').attr('value','ebook');
				});
				$('#contribaddlink').live('click', function(){
					var id =$('#addidvalue').val();
					$('#adddiv').append('<table id="contributor' + id + '"><tr><td><select id="contributorselect' + id + '" name="contributorselect' + id + '"><option value="author">Author</option></select></td><td><input type="text" id="contributorfname' + id + '" name="contributorfname' + id + '" class="textbox" size="10" maxlength="none" /><br /><span class="small">First</span></td><td><input type="text" id="contributormi' + id + '" name="contributormi' + id + '" class="textbox" size="1" maxlength="1" /><br /><span class="small">MI</span></td><td><input type="text" id="contributorlname' + id + '" name="contributorlname' + id + '" class="textbox" size="12" maxlength="none" /><br /><span class="small">Last / Corporation</span></td><td><div class="remove"><a href="" id="removecontrib' + id + '">Remove</a></div></td></tr></table>');
					
					$("#removecontrib" + id + "").click(function(){	
						id = --id;
						$("#contributor" + id + "").remove();
						return false;
					});					
					
					id = ++id;
					$('#addidvalue').val(id);
					return false;
				});
				$('#pagesnonconsecutiveinput').live('click', function(){
					var styleholder = $('#styleholder').val();
					if($(this).is(":checked")) {
						if (styleholder=='apa6'){
							$('#pagesstart').hide();
							$('#pagesend').hide();
							$('#nonconsecutivepagenums').show();
						}
					}else{
						if (styleholder=='apa6'){
							$('#pagesstart').show();
							$('#pagesend').show();
							$('#nonconsecutivepagenums').hide();
						}
					}
				}); 
			});
		</script>
	</head>
	<body>
		<!--#include virtual="/websiteclassic/includes/header.html"-->
		<noscript><div class="noscript">Javascript is disabled in your browser. Citation Builder will not function correctly without it.</div></noscript>
		<h1><a href="index.php">Citation Builder</a></h1>		
		<div style="position: relative;">
			<form id="citeform" action="citationbuild.php" method="post">
				<div><input type="hidden" id="mediumholder" name="mediumholder" value="website" /></div>
				<?php
				//Load the appropriate form template based on the source passed in through the URL
					switch ($source) {
						case "book":
							include ('templates/booktemplate.php');
							break;
						case "scholar":
							include ('templates/scholarjournaltemplate.php');
							break;
						case "bookchapter":
							include ('templates/bookchaptertemplate.php');
							break;
						case "website":
							include ('templates/websitetemplate.php');
							break;
						case "magazine":
							include ('templates/magazinetemplate.php');
							break;
						case "newspaper":
							include ('templates/newspapertemplate.php');
							break;
					}
				?>
			</form>
			<div id="sourcechangeholder" class="sourcechangeholder">
				Cite a...
				<table width="200px">
					<tr>
						<td>
							<ul>
								<li><a href="cite.php?source=book">book (in entirety)</a></li>
								<li><a href="cite.php?source=bookchapter">chapter or essay from a book</a></li>
								<li><a href="cite.php?source=magazine">magazine article</a></li>
								<li><a href="cite.php?source=newspaper">newspaper article</a></li>
								<li><a href="cite.php?source=scholar">scholarly journal article</a></li>
								<li><a href="cite.php?source=website">web site</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="right">
							<a href="" id="close" name="close">x Close</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php
			//Footer includes will go here	
		?>
		<!-- END OF CONTENT -->
		<!-- FOOTER: do not remove -->
		<!--#include virtual="/websiteclassic/includes/footer.html"-->
	</body>
</html>