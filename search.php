<?php include('includes/header.html'); ?>
<?php include('includes/headerHome.html'); ?>

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/result.css">

<style>
	.professors_container
	{
		float: left;
		clear: both;
		text-align: center;
		vertical-align: bottom;
		padding: 0;
		margin: 0;
		width: 100%;
	}
	.course_professor
	{
		display: inline-block;
		text-align: center;
		margin: 0 10px;
		max-height: 95px;
		overflow: hidden;
	}
	.course_professor img
	{
		margin-left: auto;
		margin-right: auto;
		width: 50px;
		height: 50px;
	}
	.course_professor p
	{
		margin-left: auto;
		margin-right: auto;
		font-size: 10pt;
		color: #913A8B;
	}

</style>

<div class="backgroundBanner">
	<section class="backgroundPic">
		<img src="./images_files/banner3.jpg" width="600" alt="" class="background_pic">
	</section>

	<div class="searchBar">
		<form action="search.php" method="post">
			<div class="search_bar">
				<input type="search" placeholder = "what would you like to learn about?" id = "search" />
				<button class="icon"><i class="fa fa-search"></i></button>
			</div>
		</form>
	</div>
</div>

<div id="container">
	<?php
	try
	{
		$con = new PDO("mysql:host=localhost;dbname=moocs160;charset=utf8mb4", "root", "xxxxxxxxx");
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$query = "SELECT * FROM course_data";
		$result = $con->query($query);
		$row = $result->fetch(PDO::FETCH_ASSOC);

		print "<div class='course_page_container'>";

			$data = $con->query($query);
			$data->setFetchMode(PDO::FETCH_ASSOC);

			foreach($data as $row)
			{
				$id = $row["id"];
				$query2 = "SELECT profname, profimage ".
				"FROM coursedetails, course_data ".
				"WHERE coursedetails.course_id = ".$id." ".
				"GROUP BY profname";
				$profData = $con->query($query2);
				$profData->setFetchMode(PDO::FETCH_ASSOC);

				$row["site"] = str_replace(".com", "", $row["site"]);
				$row["site"] = str_replace("/", "", $row["site"]);
				$row["site"] = strtoupper(str_replace("http:www.", "", $row["site"]));
				$row["site"] = str_replace("", "", $row["site"]);

				//FULL CONTAINER
				print "<div class='course_container'>\n";
					//print "<h4><a style='color: #913A8B' href='".$row["course_link"]."'>".$row["title"]."</a></h4>";
					print "<h4><a style='color: #913A8B' href='course_page.php?id=".$row["id"]."'>".$row["title"]."</a></h4>";
					print "<p style='padding: 0; margin: 0; margin-left: 20px; margin-bottom: 10px; font-style: italic'>".$row["category"]."</p>";

					//LEFT CONTENT
					print "<a href='course_page.php?id=".$row["id"]."'><img src='".$row["course_image"]."'/></a>";
					
					//CENTER CONTENT
					print "<div class='course_description'>\n";
						print "<p style='color: #913A8B'>Short Description</p>";
						print "<p>".$row["short_desc"]."</p>";
						//print "<p style='color: #913A8B'>Long Description</p>";
						//print "<p>".$row["long_desc"]."</p>";
					print "</div>\n";

					//RIGHT CONTENT
					print "<div class='course_info'>\n";
						print "<p style='font-weight: bold; vertical-align: top'>".$row["site"]."</p>";
						//print "<p style='overflow: hidden'>".$row["university"]."</p>";
						if($row["certificate"] == "yes")
							print "<p style='font-style: italic; font-size: 10px;'>Eligable for Certificate</p>";
						print "<br/>";
						if($row["start_date"] == 0000-00-00)
						{
							print "<p>Self-Paced</p>";
						}
						else
						{
							print "<p>Begins: ".$row["start_date"]."</p>";
						}
						print "<p>".$row["course_length"]." weeks</p><br/>";
						//$row["language"] = strtoupper($row["language"]);
						//print "<p style='font-style: italic; color: #913A8B'>".$row["language"]."</p>";
						if($row["course_fee"] == 0)
						{
							print "<p style='color: green'>Free</p>\n";
						}
						else
						{
							print "<p style='color: green'>$ ".$row["course_fee"]."</p>\n";
						}
						//if(strlen($row["video_link"]) > 0)
							//print "<br/><a href='".$row["video_link"]."'><p>Video</p></a>";
					print "</div>"; // Closes Right-Side Course Content

					// BOTTOM CONTENT
					/*print "<div class='professors_container'>";
						foreach($profData as $row2)
						{
							$row2["profname"] = str_replace(" ", "<br/>", $row2["profname"]);

							print "<div class='course_professor'>";
								print "<p><img src='".$row2["profimage"]."'></p>";
								print "<p>".$row2["profname"]."</p>";	
							print "</div>";	
						}
					print "</div>"; // Closes professor-container
					*/
				print "</div>\n"; // Close course-container
			}
		print "</div>"; // Close course-page-container
	}
	catch(PDOException $ex)
	{
		echo 'ERROR: '.$ex->getMessage();
	}
	?>
</div>