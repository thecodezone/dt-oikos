<div class="wrap">
    <h2><?php $this->esc_html_e( 'DT Oikos Map', 'dt_oikos' ) ?></h2>

    <h2 class="nav-tab-wrapper">
        <a href="admin.php?page=dt_oikos&tab=general"
           class="nav-tab <?php echo $this->esc_html( ( $tab == 'general' || ! isset( $tab ) ) ? 'nav-tab-active' : '' ); ?>">
			<?php $this->esc_html_e( 'General', 'dt_oikos' ) ?>
        </a>
    </h2>

    <div class="wrap">
        <div id="poststuff">


            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">

					<?php if ( $error ?? '' ): ?>
                        <div class="notice notice-error is-dismissible">
                            <p>
								<?php $this->e( $error ) ?>
                            </p>
                        </div>
					<?php endif; ?>


					<?php echo $this->section( 'content' ) ?>

                    <!-- End Main Column -->
                </div><!-- end post-body-content -->
                <div id="postbox-container-1" class="postbox-container">
                    <!-- Right Column -->

					<?php echo $this->section( 'right' ) ?>
                    <!-- End Right Column -->
                </div><!-- postbox-container 1 -->
                <div id="postbox-container-2" class="postbox-container">
                </div><!-- postbox-container 2 -->
            </div><!-- post-body meta box container -->
        </div><!--poststuff end -->
    </div><!-- wrap end -->
</div>