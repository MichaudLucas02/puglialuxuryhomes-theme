</main>
<footer class="site-footer">
  <div class="footer-inner">
    
    <div class="footer-col col-left">
        <nav class="footer-vertical-nav" aria-label="Footer (left)">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => 'footer-vertical-menu',
                'fallback_cb'    => false,
            ]);
            ?>
        </nav>

    </div>
    
    <div class="footer-col col-middle">
        <img src='https://www.puglialuxuryhomes.com/wp-content/uploads/2023/06/Fichier-16.png'></img>
        <p><?php echo esc_html( function_exists('pll__') ? pll__('Follow us on socials:') : __('Follow us on socials:', 'thinktech') ); ?></p>
        <div class="footer-icons">
          <div class="social-list">
            <a href="https://www.instagram.com/puglia_luxury_homes/"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://www.instagram.com/puglia_luxury_homes/">Instagram</a>
          </div>
          <div class="social-list">
            <a href="https://www.facebook.com/profile.php?id=61553876982558&locale=fr_FR"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://www.facebook.com/profile.php?id=61553876982558&locale=fr_FR">Facebook</a>
          </div>
          
        </div>
    </div>
    
    <div class="footer-col col-right">
      <p><?php echo esc_html( function_exists('pll__') ? pll__('Contact us') : __('Contact us', 'thinktech') ); ?></p>
      <a href="">reservation@puglialuxuryhomes.com</a>
      <a href="">ajaquet@puglialuxuryhomes.com</a>
      <a href="">+(39) 327 93 79 067</a>
    </div>
    

  </div>
  <div class="mobile-footer-inner">
     <div class="footer-col col-middle">
        <img src='https://www.puglialuxuryhomes.com/wp-content/uploads/2023/06/Fichier-16.png'></img>
        <p><?php echo esc_html( function_exists('pll__') ? pll__('Follow us on socials:') : __('Follow us on socials:', 'thinktech') ); ?></p>
        <div class="footer-icons">
          <div class="social-list">
            <a href="https://www.instagram.com/puglia_luxury_homes/"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://www.instagram.com/puglia_luxury_homes/">Instagram</a>
          </div>
          <div class="social-list">
            <a href="https://www.facebook.com/profile.php?id=61553876982558&locale=fr_FR"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://www.facebook.com/profile.php?id=61553876982558&locale=fr_FR">Facebook</a>
          </div>
        </div>
      </div>
      <div class="mobile-footer-menu">
         <div class="footer-col col-left">
            <nav class="footer-vertical-nav" aria-label="Footer (left)">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                ]);
                ?>
            </nav>

          </div>
          <div class="footer-col col-right">
            <p><?php echo esc_html( function_exists('pll__') ? pll__('Contact us') : __('Contact us', 'thinktech') ); ?></p>
            <a href="">reservation@puglialuxuryhomes.com</a>
            <a href="">ajaquet@puglialuxuryhomes.com</a>
            <a href="">+(39) 327 93 79 067</a>
          </div>
      </div>
  </div>
  <div class="bottom-footer-wrapper">
    <div class="bottom-footer">
      <div class="bottom-footer-left">
        <?php
        $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'en';
        $policies_menu = 'Policies EN';
        if ($current_lang === 'fr') {
            $policies_menu = 'Policies FR';
        } elseif ($current_lang === 'it') {
            $policies_menu = 'Policies IT';
        }
        
        wp_nav_menu([
            'menu'           => $policies_menu,
            'container'      => false,
            'menu_class'     => 'bottom-footer-menu',
            'fallback_cb'    => false,
        ]);
        ?>
      </div>
      <div class="bottom-footer-right">
        <p>© Puglia Luxury Homes 2026</p>
      </div>
      

    </div>
  </div>  
   
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<?php wp_footer(); ?>

</body>
</html>
