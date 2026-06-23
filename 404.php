<?php
status_header(404);
nocache_headers();

$lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'en';

$strings = [
    'en' => [
        'hero'    => '404',
        'title'   => 'Page Not Found',
        'sub'     => 'The page you\'re looking for doesn\'t exist or has been moved.',
        'home'    => 'Back to Home',
        'villas'  => 'Browse Our Villas',
        'villas_url' => '/villas/',
    ],
    'fr' => [
        'hero'    => '404',
        'title'   => 'Page Introuvable',
        'sub'     => 'La page que vous cherchez n\'existe pas ou a été déplacée.',
        'home'    => 'Retour à l\'accueil',
        'villas'  => 'Découvrir nos villas',
        'villas_url' => '/villas/',
    ],
    'it' => [
        'hero'    => '404',
        'title'   => 'Pagina Non Trovata',
        'sub'     => 'La pagina che stai cercando non esiste o è stata spostata.',
        'home'    => 'Torna alla home',
        'villas'  => 'Scopri le nostre ville',
        'villas_url' => '/ville/',
    ],
];

$s = $strings[$lang] ?? $strings['en'];

get_header();
?>

<div class="small-hero">
    <img
        src="https://www.puglialuxuryhomes.com/wp-content/uploads/2023/06/puglia-hero.jpg"
        alt=""
        aria-hidden="true"
    >
    <div class="small-hero-title">
        <h2><?php echo esc_html($s['hero']); ?></h2>
    </div>
</div>

<div class="homepage">
    <section style="display:flex;flex-direction:column;align-items:center;text-align:center;padding:80px 5vw 100px;">
        <h1 class="section-title" style="font-family:'Didot';font-size:2.4rem;font-weight:300;margin-bottom:20px;">
            <?php echo esc_html($s['title']); ?>
        </h1>
        <p style="font-family:'Raleway';font-size:1rem;color:#555;max-width:520px;line-height:1.7;margin-bottom:40px;">
            <?php echo esc_html($s['sub']); ?>
        </p>
        <div style="display:flex;gap:16px;flex-wrap:wrap;justify-content:center;">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="discover-services-btn">
                <?php echo esc_html($s['home']); ?>
            </a>
            <a href="<?php echo esc_url(home_url($s['villas_url'])); ?>" class="discover-services-btn" style="background:transparent;color:#6c9ba3;border:2px solid #6c9ba3;">
                <?php echo esc_html($s['villas']); ?>
            </a>
        </div>
    </section>
</div>

<?php get_footer(); ?>
