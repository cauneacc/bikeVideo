<?php
$videoCategories = VideoCategories::getCategoriesForDisplay();
?>
<ul class="categories">
	<?php
	foreach ($videoCategories['categories'] as $parentCategory) {
		?>
		<li>
			<a href="<?php echo $parentCategory['url'] ?>" title="<?php echo ucfirst($parentCategory['category']->name) ?>">
				<h2><?php echo ucfirst($parentCategory['category']->name) ?></h2>
			</a>
		</li>
		<?php
		if ($parentCategory['child']) {
			foreach ($parentCategory['child'] as $childCategory) {
				?>
				<li>
					<a href="<?php echo $childCategory['url'] ?>"  title="<?php echo ucfirst($childCategory['category']->description) ?>">
						<?php echo ucfirst($childCategory['category']->name) ?>
					</a>
				</li>
				<?php
			}
		}
	}
	?>

</ul>

