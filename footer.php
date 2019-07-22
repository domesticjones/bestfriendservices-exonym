			</main>
			<?php if(have_rows('affiliates', 'options') && get_post_type() == 'page' && !is_account_page() && !is_cart()): ?>
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
					<?php get_template_part('modules/copyright'); ?>
				</section>
				<section class="footer-column footer-column-contact">
					<h3 class="footer-heading">Contact</h3>
					<p class="footer-address">
						<?php ex_brand(); echo '<br /><span>'; ex_contact('address'); echo '</span>'; ?>
					</p>
				</section>
				<section class="footer-column footer-column-services">
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
				<section class="footer-column footer-column-info">
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
				<section class="footer-column footer-column-social">
					<?php ex_social(); ?>
				</section>
			</footer>
		</div>
		<?php
			get_template_part('modules/navigation');
			wp_footer();
		?>
	</body>
</html>
