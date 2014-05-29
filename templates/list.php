<?php
// $length of preview
$length = 350;
?>

<div class="container">
	<?php for ($i=$this->start; $i<=$this->end; $i++) {
		if ($i % $this->data['postsPerRow'] == 0) echo '<div class="row">' ?>

			<div class="col-md-<?php echo($this->colWidth); ?>">
				<h3 class="text-center"><?php echo($this->data[$i]['title']); ?></h3>

				<p>
					<?php
					$cleanBody = str_replace(array('<div>', '</div>'), '', $this->data[$i]['body']);
					echo substr($cleanBody, 0, $length) . '...';
					?>
				</p>

				<a href="<?php echo(BASE_URL.'/post/view?id='.$this->data[$i]['id']);?>" class="label label-success">Read More</a> <br>
				<p>
					<?php switch ($this->data['sort']) {
						case ('date'):
							$date = strtotime($this->data[$i]['created']);
							echo '<span class="label label-info">Created:  ' . date('M j Y &\nb\sp; g:ia',$date) . '</span>';
							break;
						case ('popularity'):
							echo '<a class="label label-info" href="'.BASE_URL.'/post/view?id='.$this->data[$i]['id'].'#comments"> Comments: ' . $this->data[$i]['count'] . '</a>';
							break;
					} ?>
				</p>
			</div>

		<?php if ($i % $this->data['postsPerRow'] == $this->data['postsPerRow']-1
		|| $i == $this->end) echo '</div><br>';
	} ?>
</div>