<!DOCTYPE HTML>
<html>
  <head>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <style>
      body {
        margin: 0px;
        padding: 0px;
      }
    </style>
  </head>
  <body>
	<?php include('config/config.php'); ?>
    <canvas id="myCanvas" width="500" height="300" style="border: 1px solid black; background-color: #f13130;"></canvas>
	
	<script>
		 function uploadtofb(id){
	 
				 var headline_id = id;
				 var data = $('#myCanvas')[0].toDataURL("image/*");
				 $.ajax({
					type: "POST",
					url: "script.php?id="+headline_id,
					data: { 
						 data: data
					},
					success: function(result){
						console.log(result)
						img_id = result;
						
					},
					error: function(result){
						
					}
					
				
				});
		}
		
		
	</script>
    <script>
      function wrapText(context, text, x, y, maxWidth, lineHeight) {
        var words = text.split(' ');
        var line = '';
		
		
        for(var n = 0; n < words.length; n++) {
          var testLine = line + words[n] + ' ';
          var metrics = context.measureText(testLine);
          var testWidth = metrics.width;
          if (testWidth > maxWidth && n > 0) {
            context.fillText(line, x, y);
            line = words[n] + ' ';
            y += lineHeight;
          }
          else {
            line = testLine;
          }
        }
        context.fillText(line, x, y);
      }
      
      var canvas = document.getElementById('myCanvas');
	  
	  <?php
			$today = date('Y-m-d');
			$stmt = "SELECT * FROM rss_content
						WHERE category_id = 1 AND DATE(fetch_date) = CURDATE() AND image = 'http://120.28.24.39/abaka/uploads/pinas.png'";
			$url = $con->query($stmt); 
	  ?>
	  
	  <?php foreach($url as $row){ ?>
		  var context = canvas.getContext('2d');
		  var maxWidth = 500;
		  var lineHeight = 45;
		  var x = canvas.width / 2;
		  var y = canvas.height / 2.5;
		  var text = '<?php echo $row['headline']; ?>';
		  var id = <?php echo $row['id']; ?>;
		  var size = 0;
		  if(text.length < 50){
			  size = '40pt';
			  lineHeight = 55;
		  }else{
			  size = '25pt';
			  lineHeight = 35;
		  }
		  
		   
		  convert(context, text, x, y, maxWidth, lineHeight, id, size);
		  
	  <?php } ?>
	  
	  function convert(context, text, x, y, maxWidth, lineHeight, id, size){
		  var background = new Image();
		  background.src = "bg.png";

		  background.onload = function(){
				context.drawImage(background,0,0);
				context.font = 'bold '+size+' Times';
				context.fillStyle = '#000000';
				context.textAlign="center";
				wrapText(context, text, x, y, maxWidth, lineHeight);
				uploadtofb(id);
			
		  }
	  }
    </script>
	
	
  </body>
</html>  