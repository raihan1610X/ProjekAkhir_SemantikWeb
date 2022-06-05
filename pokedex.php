<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Regional Pokedex</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/c3c1353c4c.js" crossorigin="anonymous"></script>
</head>

<?php
  require_once("sparqllib.php");
  $test = "";
  if(isset($_POST['search'])){
	  $test = $_POST['search'];
	  $data = sparql_get(
	  "http://localhost:3030/pokemon_region",
	  "
	  	PREFIX id: <https://pokemon.com/> 
		PREFIX item: <https://pokemon.com/entry#> 
		PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

		SELECT ?Name ?Type ?Region ?Game ?Generation
		WHERE 
		{
			?items
				item:Name	?Name ;
				item:Type	?Type ;
				item:Region ?Region ;
				item:Game	?Game ;
				item:Generation ?Generation ;
				FILTER
				(regex	(?Name, '$test', 'i')
				|| regex	(?Type, '$test', 'i')
				|| regex	(?Region, '$test', 'i')
				|| regex	(?Game, '$test', 'i')
				|| regex	(?Generation, '$test', 'i'))
		}"
	);
  }
  else{
	$data = sparql_get(
		"http://localhost:3030/pokemon_region",
		"
		  PREFIX id: <https://pokemon.com/> 
		  PREFIX item: <https://pokemon.com/entry#> 
		  PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

		  SELECT ?Name ?Type ?Region ?Game ?Generation
		  WHERE
		  { 
			?items
				item:Name	?Name ;
				item:Type	?Type ;
				item:Region ?Region ;
				item:Game	?Game ;
				item:Generation ?Generation ;
		  }
		"
	);

  }

  if (!isset($data)){
	  print "<p>Error: " . sparql_errno() . ": " . sparql_error(). "</p>";
  }
?>

<nav style= "background-color: #EC7063" class="navbar navbar-expand-lg">
  <div class="container container-fluid">
	<a class="navbar-brand" href="pokedex.php"><img src="src/img/poke.png" style="width:100px;;" alt="Logo"></a>
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item px-2">
          <a class="nav-link active text-yellow" aria-current="page" href="pokedex.php">Welcome to the World of Pokemon</a>
        </li>
	  </ul>
	  <form class="d-flex" role="search" action="" method="post" id="namefrom">
		  <input class="form-control me-2" type="search" placeholder="Who's That Pokemon?" aria-label="Search" name="search">
		  <button class="btn btn-outline-info" type="submit">Search</button>
	  </form>
	</div>
   	</div>
</nav>

	<div class="container container-fluid mt-3 ">
		<?php
			if ($test != NULL){
				?> <i class="fa-solid fa-magnifying-glass"></i><span>Results <b>"<?php echo $test; ?>"</b> <br><br></span><?php
			}
		?>
		<table class="table table-bordered table-striped table-hover text-centre">
			<thead class="table-secondary">
				<tr>
					<th>Entry.</th>
					<th>Name</th>
					<th>Type</th>
					<th>Region</th>
					<th>Game</th>
					<th>Generation</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($data as $dat) : ?>
				<tr>
					<td><?= ++$i ?></td>
					<td><?= $dat['Name'] ?></td>
					<td><?= $dat['Type'] ?></td>
					<td><?= $dat['Region'] ?></td>
					<td><?= $dat['Game'] ?></td>
					<td><?= $dat['Generation'] ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</body>
</html>