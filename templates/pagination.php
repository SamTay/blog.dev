<?php

$currentPg = $this->data['view']->pg;
$prev = $currentPg - 1;
$next = $currentPg + 1;
$sort = $this->data['view']->sort;
$totalPages = $this->data['view']->totalPages;

?>

<div class="container">
	<div class="row">

		<ul id="pagination" class="pagination rightsided">

			<?php
			echo '<li class="prev-button';
			if ($currentPg == 1) {
				echo ' disabled';
			}
			echo '"><a href="';
			if ($currentPg == 1) {
				echo '#';
			} else {
				echo BASE_URL.DS.'list'.DS.$this->action.'?pg='.$prev.'&sort='.$sort;
				$this->keepSearchParam();
			}
			echo '">&laquo;</a></li>';

			for ($pg = 1; $pg <= $totalPages; $pg++) {
				echo '<li class="pg-button';
				if ($currentPg == $pg) {
					echo ' active';
				}
				echo '"><a href="';
				if ($currentPg == $pg) {
					echo '#';
				} else {
					echo BASE_URL.DS.'list'.DS.$this->action.'?pg='.$pg.'&sort='.$sort;
					$this->keepSearchParam();
				}
				echo '">'.$pg.'</a></li>';
			}

			echo '<li class="next-button';
			if ($currentPg >= $totalPages) {
				echo ' disabled';
			}
			echo '"><a href="';
			if ($currentPg >= $totalPages) {
				echo '#';
			} else {
				echo BASE_URL.DS.'list'.DS.$this->action.'?pg='.$next.'&sort='.$sort;
				$this->keepSearchParam();
			}
			echo '">&raquo;</a></li>';
			?>
		</ul>

		<ul class="pagination">
			<li class="dropdown">
				<a href="" class="dropdown-toggle dropdown-menu-left" data-toggle="dropdown"><span class="glyphicon glyphicon-sort"></span><b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo(BASE_URL.DS.'list?sort=date'); $this->keepSearchParam(); ?>">Date Created</a>
					</li>
					<li>
						<a href="<?php echo(BASE_URL.DS.'list?sort=popularity'); $this->keepSearchParam(); ?>">Popularity</a>
					</li>
				</ul>
			</li>
		</ul>

	</div>
</div>