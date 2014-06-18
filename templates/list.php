<?php
// $length of preview
$length = 350;

$posts = $this->data['posts'];

$needle = $this->data['view']->needle;
$totalPosts = $this->data['view']->totalPosts;
$postsPerRow = $this->data['view']->postsPerRow;
$postsPerPage = $this->data['view']->postsPerPage;
$sort = $this->data['view']->sort;
$pg = $this->data['view']->pg;
?>

<div class="container">
	<?php if ($this->section == 'search') { ?>
		<div class="row">
			<div class="text-center well">
				<h4>Your search for "<?php echo $needle ?>" returned <?php echo $totalPosts; ?> results.</h4>
			</div>
		</div>
	<?php } ?>

	<?php for ($i=0; $i<$totalPosts; $i++) {

		if ($i % $postsPerRow == 0) {
			echo '<div class="row';
			if ( !(($pg -1)*$postsPerPage <= $i && $i < $pg*$postsPerPage) ) {
				echo ' hidden';
			}
			echo '">';
		} ?>
			<div class="col-md-<?php echo($this->colWidth); ?>">
				<?php $cleanTitle = str_replace($needle,
						'<span class="found">'.$needle.'</span>', $posts[$i]->title);
				$cleanTitle = str_replace(ucwords($needle),
					'<span class="found">'.ucwords($needle).'</span>', $posts[$i]->title);?>
				<h3 class="text-center"><?php echo($cleanTitle); ?></h3>

				<p>
					<?php
					$cleanBody = str_replace(array('<div>', '</div>'), '', $posts[$i]->body);
					$cleanBody = substr($cleanBody, 0, $length) . '...';
					$cleanBody = str_replace(' '.$needle.' ',
						' <span class="found">'.$needle.'</span> ', $cleanBody);
					$cleanBody = str_replace(ucwords(' '.$needle.' '),
						' <span class="found">'.ucwords($needle).'</span> ', $cleanBody);
					echo $cleanBody;
					?>
				</p>

				<a href="<?php echo(BASE_URL.'/post/view?id='.$posts[$i]->id);?>" class="label label-success">Read More</a> <br>
				<p>
					<?php switch ($sort) {
						case ('date'):
							$date = strtotime($posts[$i]->created);
							echo '<span class="label label-info">Created:  ' . date('M j Y &\nb\sp; g:ia',$date) . '</span>';
							break;
						case ('popularity'):
							echo '<a class="label label-info" href="'.BASE_URL.'/post/view?id='.$posts[$i]->id.'#comments"> Comments: ' . $posts[$i]->count . '</a>';
							break;
					} ?>
				</p>
			</div>

		<?php if ($i % $postsPerRow == $postsPerRow-1 || $i == $totalPosts) {
			echo '<br></div>';
		}
	} ?>
</div>