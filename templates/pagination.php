<?php
$prev = $this->data['pg'] - 1;
$next = $this->data['pg'] + 1;

$action = $this->action;
?>

<div class="container">
	<div class="row">

		<ul class="pagination rightsided">
			<?php if ($this->data['pg'] == 1)
				echo '<li class="disabled"><span>&laquo;</span></li>';
			else
				echo '<li><a href="'.BASE_URL.DS.'list'.DS.$action.'?pg='.$prev.'&sort='.$this->data['sort'].'">&laquo;</a>';

			for ($pg = 1; $pg <= $this->data['totalPages']; $pg++) {
				if ($this->data['pg'] == $pg)
					echo '<li class="active"><span>'.$pg.'</span></li>';
				else
					echo '<li><a href="'.BASE_URL.DS.'list'.DS.$action.'?pg='.$pg.'&sort='.$this->data['sort'].'">'.$pg.'</a>';
			}

			if ($this->data['pg'] == $this->data['totalPages'])
				echo '<li class="disabled"><span>&raquo;</span></li>';
			else
				echo '<li><a href="'.BASE_URL.DS.'list'.DS.$action.'?pg='.$next.'&sort='.$this->data['sort'].'">&raquo;</a>';
			?>
		</ul>

		<?php if ($action == 'view') { ?>
		<ul class="pagination">
			<li class="dropdown">
				<a href="" class="dropdown-toggle dropdown-menu-left" data-toggle="dropdown"><span class="glyphicon glyphicon-sort"></span><b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo(BASE_URL.DS.'list?sort=date');?>">Date Created</a></li>
					<li><a href="<?php echo(BASE_URL.DS.'list?sort=popularity');?>">Popularity</a></li>
				</ul>
			</li>
		</ul>
		<?php } ?>

	</div>
</div>