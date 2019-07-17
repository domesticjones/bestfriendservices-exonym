			<?php if(have_rows('affiliates', 'options')): ?>
				<footer id="affiliates">
					<h3><?php the_field('affiliates_heading', 'options'); ?></h3>
					<ul class="footer-affiliates">
						<?php while(have_rows('affiliates', 'options')): the_row(); $logo = get_sub_field('logo'); $link = get_sub_field('link'); ?>
							<li>
								<?php if($link) { echo '<a href="' . $link['url'] . '" target="' . $link['target'] . '" title="' . $link['title'] . '">'; } ?>
									<img src="<?php echo $logo['sizes']['small']; ?>" alt="<?php echo $logo['alt']; ?>" />
								<?php if($link) { echo '</a>'; } ?>
							</li>
						<?php endwhile; ?>
					</ul>
				</footer>
			<?php endif; ?>
			<footer id="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
				<section class="footer-column footer-column-logo">
					<img src="<?php ex_logo('primary', 'light'); ?>" alt="Logo for <?php ex_brand(); ?>" class="footer-logo" />
					<p class="copyright">&copy;<?php echo date('Y') . ' '; ex_brand('legal'); ?></p>
				</section>
				<section class="footer-column">
					<h3 class="footer-heading">Contact</h3>
					<p class="footer-address">
						<?php ex_brand(); echo '<br /><span>'; ex_contact('address'); echo '</span>'; ?>
					</p>
				</section>
				<section class="footer-column">
					<h3 class="footer-heading">Services</h3>
					<nav class="nav-footer" role="navigation">
						<?php
							wp_nav_menu(array(
								'container' => false,
								'theme_location' => 'menu-services',
								'depth' => 1,
							));
						?>
					</nav>
				</section>
				<section class="footer-column">
					<h3 class="footer-heading">Information</h3>
					<nav class="nav-footer" role="navigation">
						<?php
							wp_nav_menu(array(
								'container' => false,
								'theme_location' => 'menu-info',
								'depth' => 1,
							));
						?>
					</nav>
				</section>
				<section class="footer-column">
					<?php ex_social(); ?>
				</section>
			</footer>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>
