<?php
$prev = $this->data['view']->pg - 1;
$next = $this->data['view']->pg + 1;

?>

<div class="container">
	<div class="row">

		<ul class="pagination rightsided">
			<?php if ($this->data['view']->pg == 1) {
				echo '<li class="disabled"><span>&laquo;</span></li>';
			} else {
				echo '<li><a href="'.BASE_URL.DS.'list'.DS.$this->action.'?pg='.$prev.'&sort='.$this->data['view']->sort;
				$this->keepSearchParam();
				echo '">&laquo;</a>';
			}

			for ($pg = 1; $pg <= $this->data['view']->totalPages; $pg++) {
				if ($this->data['view']->pg == $pg) {
					echo '<li class="active"><span>'.$pg.'</span></li>';
				} else {
					echo '<li><a href="'.BASE_URL.DS.'list'.DS.$this->action.'?pg='.$pg.'&sort='.$this->data['view']->sort;
					$this->keepSearchParam();
					echo '">'.$pg.'</a>';
				}
			}

			if ($this->data['view']->pg == $this->data['view']->totalPages) {
				echo '<li class="disabled"><span>&raquo;</span></li>';
			} else {
				echo '<li><a href="'.BASE_URL.DS.'list'.DS.$this->action.'?pg='.$next.'&sort='.$this->data['view']->sort;
				$this->keepSearchParam();
				echo '">&raquo;</a>';
			} ?>
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