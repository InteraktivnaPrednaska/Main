<?php
$_SESSION["add"] = isset($_POST['add_button']);
$title = "Interactive lecture";
include("functions.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta ln="sk"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title; ?></title>
	<link href="style.css" rel="stylesheet">
	<link href="features.css" rel="stylesheet">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="script.js"></script>

</head>

<body>
	<?php
	if(is_active()){
		?>

		<div id="switch">
			<input id="sw" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" checked>
			<label data-checked="1" class="toggle_act" id="lsw" for="sw" style="float:left"></label>
			<p style="position:absolute; top:5px; left:80px;">vypnúť/zapnúť zobrazenie prednášky</p>
			<div style="position:absolute; top:20px; left:300px;"><a href="admin.php">Administrácia</a></div>
		</div>

		<div id="lecture">
			<object id ="pdf"data=<?php echo "sources/".$_SESSION['slide']['name']?> type="application/pdf" width="100%" height="100%"></object>
		</div>

		<div id="chat">	
		<div id="timeline">
			<?php echo select_questions(); ?>
			
		</div>
		<form method="post" class="question">
			<input type="textarea"  class="textarea" placeholder="Otázka..." id="otazka">
			<div class="submit" name="add_button" id="add_question">Pridaj otázku</div>
			<?php
				if(is_admin()) {
			?>
					<div class="submit" name="add_in" id="add_inquiry">Pridaj anketu</div>
			<?php
				}
			?>
			
		</form>
		</div>
		<?php 
	}
	?>
	<script type="text/javascript">
		setInterval(function(){ $("#timeline").load(document.URL+" #timeline>*","");}, 500);
		$( document ).ready(function() {
			$("#add_question").click(function(){
				var text = $('#otazka').val();
				$('#otazka').val("");
				var sessName = "<?php echo $_SESSION['slide']['id']?>";

				$(".questions").html($(".questions").html()+"<li><p>"+text+"</p></li>");
   			$.post("add_question.php", { // Send the retrieved data to a script that pushes it to database (SQL UPDATE)
   				type: sessName,
   				val1: text
   			});

   		});
		});

		$( document ).ready(function() {
			$("#add_inquiry").click(function(){
				var text = $('#otazka').val();
				$('#otazka').val("");
				var sessName = "<?php echo $_SESSION['slide']['id']?>";
				//$(".questions").html($(".questions").html()+"<li><p>"+text+"</p></li>");
   			$.post("add_in.php", { // Send the retrieved data to a script that pushes it to database (SQL UPDATE)
   				type: sessName,
   				val1: text
   			});

   		});
		});

		$( document ).ready(function() {
            $("#sw").click(function(){
                $( "#lecture" ).toggle( "slow", function() {
    			// Animation complete.
				});
				var toggleWidth = $("#chat").width() == 1100 ? "400px" : "1100px";
				var pad = $("#otazka").width() == 829 ? "320px" : "829px";
        		$('#chat').animate({ width: toggleWidth });
        		$('#otazka').animate({ width: pad });
   });
        });

		function mark_as_solved(id){
			var admin = "<?php if(isset($_SESSION['admin']) && $_SESSION['admin']) echo true;?>";
			if(admin){
			$.post("mark_question.php", { // Send the retrieved data to a script that pushes it to database (SQL UPDATE)
   				i: id
   			});
   			$("#d"+id.toString()).addClass("solved");}
   			
		}
		function plus(id){
			$.ajax({
				url:"answer_p.php", 
				type:"POST",
				data: {// Send the retrieved data to a script that pushes it to database (SQL UPDATE)
	   				i: id,
	   				type: 1
	   			},
	   			success:function(data) {
	   				//alert(data);
	   			}
   			});
   		}
   			
		

		function minus(id){
			$.post("answer_p.php", { // Send the retrieved data to a script that pushes it to database (SQL UPDATE)
   				i: id,
   				type: 0
   			});
   		}
   			
		
		function show(id){
			/*var admin = "<?php if(isset($_SESSION['admin']) && $_SESSION['admin']) echo true;?>";
			if(admin){
				alert("áno: 1\nnie: 0");
			}*/

		};
   			
   			
					
   			
		

		


	</script>

</body>
</html>
