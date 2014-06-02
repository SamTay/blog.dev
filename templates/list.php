<?php
// $length of preview
$length = 350;
?>

<div class="container">
	<?php if ($this->section == 'search') { ?>
		<div class="row">
			<div class="text-center well">
				<h4>Your search for "<?php echo $this->data['view']->needle ?>" returned <?php echo $this->data['view']->totalPosts; ?> results.</h4>
			</div>
		</div>
	<?php } ?>

	<?php for ($i=$this->start; $i<=$this->end; $i++) {

		if ($i % $this->data['view']->postsPerRow == 0) echo '<div class="row">' ?>
			<div class="col-md-<?php echo($this->colWidth); ?>">
				<?php $cleanTitle = str_replace($this->data['view']->needle,
						'<span class="found">'.$this->data['view']->needle.'</span>', $this->data[$i]->title);
				$cleanTitle = str_replace(ucwords($this->data['view']->needle),
					'<span class="found">'.ucwords($this->data['view']->needle).'</span>', $this->data[$i]->title);?>
				<h3 class="text-center"><?php echo($cleanTitle); ?></h3>

				<p>
					<?php
					$cleanBody = str_replace(array('<div>', '</div>'), '', $this->data[$i]->body);
					$cleanBody = substr($cleanBody, 0, $length) . '...';
					$cleanBody = str_replace($this->data['view']->needle,
						'<span class="found">'.$this->data['view']->needle.'</span>', $cleanBody);
					$cleanBody = str_replace(ucwords($this->data['view']->needle),
						'<span class="found">'.ucwords($this->data['view']->needle).'</span>', $cleanBody);
					echo $cleanBody;
					?>
				</p>

				<a href="<?php echo(BASE_URL.'/post/view?id='.$this->data[$i]->id);?>" class="label label-success">Read More</a> <br>
				<p>
					<?php switch ($this->data['view']->sort) {
						case ('date'):
							$date = strtotime($this->data[$i]->created);
							echo '<span class="label label-info">Created:  ' . date('M j Y &\nb\sp; g:ia',$date) . '</span>';
							break;
						case ('popularity'):
							echo '<a class="label label-info" href="'.BASE_URL.'/post/view?id='.$this->data[$i]->id.'#comments"> Comments: ' . $this->data[$i]->count . '</a>';
							break;
					} ?>
				</p>
			</div>

		<?php if ($i % $this->data['view']->postsPerRow == $this->data['view']->postsPerRow-1
		|| $i == $this->end) echo '</div><br>';
	} ?>
</div>