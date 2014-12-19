<html>
<head>
	<title></title>
	<script src="js/json.ajax.js" ></script>
</head>
<body>

	<input type="text" />
	<ul>
	</ul>

	<script>

	window.addEventListener("load", function(){


		//arquivo pessoa.js

		var ul = document.querySelector("ul");
		var input = document.querySelector("input");
		input.addEventListener("blur", function(){

			var text = input.value;

			Server
				.post()
				.inUrl("ajax.php")
				.send({ name: text })
				.done(function(response){

					var sugestoes = response.sugestoes || [];

					ul.innerHTML = "";

					for(var i = 0; i < sugestoes.length; i++){
						var sug = sugestoes[i];
						var li = document.createElement("li");
						li.textContent = sug;
						ul.appendChild(li);
					}

				})
				.fail(function(){

				})
				.always(function(){

				});

		});


	});

	</script>

</body>
</html>