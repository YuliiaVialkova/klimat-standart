<footer id="contacts" class="footer">
    <div class="footer__container container container--middle">
        <div class="footer__content">

            <div class="footer__contacts footer-contacts">
                <div class="footer-contacts__address">
                    <?php echo apply_filters('the_content', carbon_get_theme_option('footer_address')); ?>
                </div>

                <?php $phone = carbon_get_theme_option('footer_phone'); ?>
                <?php if ($phone): ?>
                    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="footer-contacts__link footer-contacts__phone">
                        <?php echo $phone; ?>
                    </a>
                <?php endif; ?>

                <?php $email = carbon_get_theme_option('footer_email'); ?>
                <?php if ($email): ?>
                    <a href="mailto:<?php echo $email; ?>" class="footer-contacts__link footer-contacts__email">
                        <?php echo $email; ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="footer__logo">
                <?php
                $logo_id = carbon_get_theme_option('footer_logo');
                $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
                ?>
                <a href="<?php echo home_url(); ?>" class="footer__logo-link">
                    <?php if ($logo_url): ?>
                        <img src="<?php echo $logo_url; ?>" alt="<?php bloginfo('name'); ?>">
                    <?php else: ?>
                        <span><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <div class="footer__map">
                <?php echo carbon_get_theme_option('footer_map'); ?>
            </div>

        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>