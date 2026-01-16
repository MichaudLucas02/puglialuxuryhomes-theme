<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
  <link rel="preload"
      href="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/fonts/vogue/vogue-regular.woff2' ); ?>"
      as="font" type="font/woff2" crossorigin>

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="mega-backdrop" class="mega-backdrop" aria-hidden="true"></div>
<header class='header'>
    <div class="top-header">
        <div class='top-header-left'>

        </div>
        <div class='top-header-center'>
          <h3 class='website-title'>
            <a href="<?php echo esc_url( home_url('/') ); ?>" aria-label="<?php echo esc_attr( get_bloginfo('name') ); ?>">
              PUGLIA LUXURY HOMES
            </a>
          </h3>
        </div>
        <div class='top-header-right'>
          <div class="header-phone">
            <a href="tel:+393279379067" aria-label="Call +39 327 93 79 067">
              <i class="fa fa-phone" aria-hidden="true"></i>
            </a>
          </div>
            <div class="language-switcher">
                <?php
                if (function_exists('pll_current_language')) {
                    $current_lang = strtoupper(pll_current_language('slug'));
                    $languages = pll_the_languages(array('raw' => 1));
                    ?>
                    <div class="lang-dropdown">
                        <button class="lang-current" aria-expanded="false">
                            <?php echo $current_lang; ?>
                            <span class="lang-arrow">▼</span>
                        </button>
                        <ul class="lang-options">
                            <?php foreach ($languages as $lang): ?>
                                <li class="<?php echo $lang['current_lang'] ? 'active' : ''; ?>">
                                    <a href="<?php echo $lang['url']; ?>" lang="<?php echo $lang['slug']; ?>">
                                        <?php echo strtoupper($lang['slug']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="mobile-header-menu">
                <button id="mobile-menu-toggle"
                        class="mobile-menu-toggle"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        aria-label="<?php esc_attr_e( 'Toggle menu', 'thinktech' ); ?>">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'thinktech' ); ?></span>
                </button>
                <nav id="mobile-menu" class="mobile-menu" aria-hidden="true">
                  <?php
                  // Choose language-aware mobile menu location if available; fallback to base 'mobile'
                  $mobile_location = 'mobile';
                  if ( function_exists('pll_current_language') ) {
                    $lang = pll_current_language('slug');
                    if ( $lang === 'fr' && has_nav_menu('mobile_fr') ) {
                      $mobile_location = 'mobile_fr';
                    } elseif ( $lang === 'it' && has_nav_menu('mobile_it') ) {
                      $mobile_location = 'mobile_it';
                    }
                  }
                  wp_nav_menu( array(
                    'theme_location' => $mobile_location,
                    'container'      => false,
                    'menu_class'     => 'mobile-menu__list',
                    'fallback_cb'    => false,
                  ) );
                  ?>
                </nav>
                
            </div>

        </div>
    </div>
    <div class="bottom-header">
      <nav class="main-nav">
          <?php
          wp_nav_menu( array(
              'theme_location'  => 'primary',
              'container'       => false,
              'items_wrap'      => '<ul>%3$s</ul>'
          ) );
          ?>
      </nav>
      
      <div id="mega-panel-extra" class="mega-panel-extra" aria-hidden="true" style="display:none;">
        <div class="panel-contact">
          <h4>Contact Us</h4>
          <p><a href="mailto:info@example.com">reservation@puglialuxuryhomes.com</a></p>
          <p><a href="tel:+39123456789">+(39) 327 93 79 067</a></p>
        </div>
      </div>
    </div>
    

</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
  try {
    const toggle = document.getElementById('mobile-menu-toggle');
    const menu   = document.getElementById('mobile-menu');
    const header = document.querySelector('.header');
    const closeBtn = menu && menu.querySelector('.mobile-menu-close');

    if (!toggle) return console.warn('mobile-menu-toggle not found');
    if (!menu)   return console.warn('mobile-menu not found');

    // compute header height and apply layout to menu
    function layoutMenu() {
      const headerHeight = header ? header.getBoundingClientRect().height : 0;
      // position menu under header and fill remaining viewport
      menu.style.position = 'fixed';
      menu.style.top = headerHeight + 'px';
      menu.style.left = '0';
      menu.style.right = '0';
      menu.style.height = `calc(100vh - ${headerHeight}px)`;
      menu.style.overflowY = 'auto';
      menu.style.zIndex = 9999;
    }

    function openMenu() {
      layoutMenu();
      toggle.setAttribute('aria-expanded', 'true');
      menu.setAttribute('aria-hidden', 'false');
      menu.classList.add('is-open', 'is-fullscreen');
      document.body.classList.add('mobile-menu-open');
      // lock background scroll
      document.documentElement.style.overflow = 'hidden';
      document.body.style.overflow = 'hidden';
      // move focus into the menu (first focusable element)
      const firstLink = menu.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
      if (firstLink) firstLink.focus();
    }

    function closeMenu() {
      toggle.setAttribute('aria-expanded', 'false');
      menu.setAttribute('aria-hidden', 'true');
      menu.classList.remove('is-open', 'is-fullscreen');
      document.body.classList.remove('mobile-menu-open');
      // restore scrolling
      document.documentElement.style.overflow = '';
      document.body.style.overflow = '';
      toggle.focus();
    }

    // attach toggle
    toggle.addEventListener('click', function (e) {
      e.stopPropagation();
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      expanded ? closeMenu() : openMenu();
    });

    // optional close button inside the menu
    if (closeBtn) {
      closeBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        closeMenu();
      });
    }

    // Close on Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && menu.classList.contains('is-open')) {
        closeMenu();
      }
    });

    // Click outside to close (only when open)
    document.addEventListener('click', function (e) {
      if (menu.classList.contains('is-open') && !menu.contains(e.target) && !toggle.contains(e.target)) {
        closeMenu();
      }
    });

    // recompute on resize/orientation change if open
    window.addEventListener('resize', function () {
      if (menu.classList.contains('is-open')) layoutMenu();
    });

  } catch (err) {
    console.error('Mobile menu script error:', err);
  }
});
</script>
  


<script>
document.addEventListener('DOMContentLoaded', function () {
  // Language dropdown toggle (desktop)
  (function(){
    const dropdown = document.querySelector('.lang-dropdown');
    if (!dropdown) return;
    const toggle = dropdown.querySelector('.lang-current');
    const menu = dropdown.querySelector('.lang-options');
    if (!toggle || !menu) return;

    function closeDropdown(){
      toggle.setAttribute('aria-expanded', 'false');
      dropdown.classList.remove('is-open');
    }

    function openDropdown(){
      toggle.setAttribute('aria-expanded', 'true');
      dropdown.classList.add('is-open');
    }

    toggle.addEventListener('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      const isOpen = toggle.getAttribute('aria-expanded') === 'true';
      isOpen ? closeDropdown() : openDropdown();
    });

    menu.addEventListener('click', function(e){
      e.stopPropagation();
    });

    document.addEventListener('click', function(e){
      if (!dropdown.contains(e.target)) closeDropdown();
    });

    document.addEventListener('keydown', function(e){
      if (e.key === 'Escape') closeDropdown();
    });
  })();

  const DESKTOP_BREAKPOINT = 720;
  const nav = document.querySelector('.main-nav');
  const backdrop = document.getElementById('mega-backdrop');
  const extraTpl = document.getElementById('mega-panel-extra'); // hidden template in header

  if (!nav) return;

  function removeAllClones() {
    nav.querySelectorAll('.mega-panel-extra').forEach(c => c.remove());
  }

  function closeAll() {
    nav.querySelectorAll('.menu-item-has-children.mega-open').forEach(li => {
      li.classList.remove('mega-open');
      const sub = li.querySelector('ul');
      if (sub) sub.classList.remove('is-open');
      const t = li.querySelector(':scope > a, :scope > button');
      if (t) t.setAttribute('aria-expanded', 'false');
    });
    if (backdrop) backdrop.classList.remove('is-visible');
    removeAllClones();
    document.removeEventListener('keydown', escHandler);
  }

  function escHandler(e) {
    if (e.key === 'Escape') closeAll();
  }

  // Delegate clicks inside the nav: toggle panel on click of a parent top-level trigger
  nav.addEventListener('click', function (e) {
    if (window.innerWidth <= DESKTOP_BREAKPOINT) return; // desktop only

    const parentLi = e.target.closest('.menu-item-has-children');
    if (!parentLi) return;

    const trigger = e.target.closest('a, button');
    if (!trigger || !parentLi.contains(trigger)) return;

    // Only treat clicks on the top-level trigger element as toggles.
    const topTrigger = parentLi.querySelector(':scope > a, :scope > button');
    if (!topTrigger || trigger !== topTrigger) {
      // click is inside the panel (child link) — allow default behavior
      return;
    }

    // toggle panel
    e.preventDefault();
    const isOpen = parentLi.classList.contains('mega-open');

    // close others
    nav.querySelectorAll('.menu-item-has-children.mega-open').forEach(li => {
      if (li !== parentLi) {
        li.classList.remove('mega-open');
        const s = li.querySelector('ul');
        if (s) s.classList.remove('is-open');
        const t = li.querySelector(':scope > a, :scope > button');
        if (t) t.setAttribute('aria-expanded', 'false');
      }
    });
    removeAllClones();

    if (!isOpen) {
      parentLi.classList.add('mega-open');
      const submenu = parentLi.querySelector('ul');
      if (submenu) submenu.classList.add('is-open');

      // clone & append the extra panel into the opened submenu (if template exists)
      if (extraTpl && submenu && !submenu.querySelector('.mega-panel-extra')) {
        const clone = extraTpl.cloneNode(true);
        clone.id = ''; // avoid duplicate IDs
        clone.style.display = ''; // show it
        clone.classList.add('mega-panel-extra');
        submenu.appendChild(clone);
      }

      if (backdrop) backdrop.classList.add('is-visible');
      topTrigger.setAttribute('aria-expanded', 'true');
      document.addEventListener('keydown', escHandler);
    } else {
      parentLi.classList.remove('mega-open');
      const submenu = parentLi.querySelector('ul');
      if (submenu) submenu.classList.remove('is-open');
      if (backdrop) backdrop.classList.remove('is-visible');
      topTrigger.setAttribute('aria-expanded', 'false');
      removeAllClones();
      document.removeEventListener('keydown', escHandler);
    }
  });

  // Clicking backdrop closes panels
  if (backdrop) {
    backdrop.addEventListener('click', closeAll);
  }

  // Click outside nav closes panels
  document.addEventListener('click', function (e) {
    if (window.innerWidth <= DESKTOP_BREAKPOINT) return;
    if (!nav.contains(e.target) && !(backdrop && backdrop.contains(e.target))) {
      closeAll();
    }
  });

  // Close on resize to mobile
  window.addEventListener('resize', function () {
    if (window.innerWidth <= DESKTOP_BREAKPOINT) closeAll();
  });

  // Language Switcher Dropdown
  const langButton = document.querySelector('.lang-current');
  const langDropdown = document.querySelector('.lang-dropdown');

  if (langButton && langDropdown) {
    langButton.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      const isExpanded = langButton.getAttribute('aria-expanded') === 'true';
      langButton.setAttribute('aria-expanded', !isExpanded);
      
      // Toggle class for additional control
      langDropdown.classList.toggle('is-open', !isExpanded);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!langDropdown.contains(e.target)) {
        langButton.setAttribute('aria-expanded', 'false');
        langDropdown.classList.remove('is-open');
      }
    });
    
    // Prevent dropdown from closing when clicking inside
    langDropdown.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  }
});
</script>

<script>
// Failsafe language dropdown toggle
document.addEventListener('DOMContentLoaded', function(){
  try {
    const dropdown = document.querySelector('.lang-dropdown');
    if (!dropdown) return;
    const toggle = dropdown.querySelector('.lang-current');
    const menu = dropdown.querySelector('.lang-options');
    if (!toggle || !menu) return;

    const open = () => {
      toggle.setAttribute('aria-expanded', 'true');
      dropdown.classList.add('is-open');
      menu.style.opacity = '1';
      menu.style.visibility = 'visible';
      menu.style.transform = 'translateY(0)';
    };
    const close = () => {
      toggle.setAttribute('aria-expanded', 'false');
      dropdown.classList.remove('is-open');
      menu.style.opacity = '0';
      menu.style.visibility = 'hidden';
      menu.style.transform = 'translateY(-8px)';
    };

    toggle.addEventListener('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      const isOpen = toggle.getAttribute('aria-expanded') === 'true';
      isOpen ? close() : open();
    });

    menu.addEventListener('click', function(e){ e.stopPropagation(); });

    document.addEventListener('click', function(e){
      if (!dropdown.contains(e.target)) close();
    });

    document.addEventListener('keydown', function(e){
      if (e.key === 'Escape') close();
    });
  } catch (err) {
    console.error('Language dropdown error', err);
  }
});
</script>


<main class="site-main">


 