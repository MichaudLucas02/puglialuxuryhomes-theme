<?php
/**
 * Template Name: Acceuil
 */ 
get_header(); ?>

<div class='homepage'>
    
    <section class='hero-section'>
        <img 
            src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/7-Vue-1-scaled.webp"
            class='hero-background'
        ></img>

        <div class='hero-content'>
            <h1>UNE FENÊTRE SUR L’ADRIATIQUE</h1>
            <p>Ici, la pierre sèche du Salento se fond dans le bleu intense de la Méditerranée. Bordée de falaises, de criques et de longues plages blanches, entourée de garrigue et de forêts de pins, cette terre sauvage est une ode à l’art de vivre et à la douceur du bord de mer.</p>
        </div>

    </section>

    <section class='our-collection'>
        <h2>Nos Collections</h2>
        <p class="p-title">Découvrez nos collections de villas exclusives</p>

        <div class="sea-collection">
            <img 
                src="http://puglialuxuryhomes.com/wp-content/uploads/2025/04/6-Salotto-2-scaled.jpg"
                class='sea-collection-cover'
            ></img>
            <div class='sea-overlay'>
                <h1>Collection Mer</h1>
                <p>Découvrez l’essence même du luxe – Plongez dans un monde d’exclusivité inégalée grâce à notre collection soigneusement sélectionnée des plus belles villas de vacances de luxe au monde, chacune une œuvre d’art au design primé, un havre de paix et d’intimité, avec un personnel dédié à chacun de vos besoins.</p>
                <a href="">DÉCOUVRIR LA COLLECTION</a>
            </div>
        </div>
    
        <div class="collection-wrapper">
            <div class='city-collection'>
                <img
                    src="http://puglialuxuryhomes.com/wp-content/uploads/2024/08/luca-dimola-bIUIhzGo8_U-unsplash-scaled.jpg"
                    class='sea-collection-cover'
                ></img>
                <div class='city-overlay'>
                    <h1>Collection Ville</h1>
                    <p>Découvrez l’essence même du luxe – Plongez dans un monde d’exclusivité inégalée grâce à notre collection soigneusement sélectionnée des plus belles villas de vacances de luxe au monde, chacune une œuvre d’art au design primé, un havre de paix et d’intimité, avec un personnel dédié à chacun de vos besoins.</p>
                    <a href="">DÉCOUVRIR LA COLLECTION</a>
                </div>
            </div>

            <div class='land-collection'>
                <img 
                    src="/wp-content/uploads/2025/08/kalina-o-5BhEr7SKhvE-unsplash-scaled.jpg"
                    class='sea-collection-cover'
                ></img>
                <div class='land-overlay'>
                    <h1>Collection Terre</h1>
                    <p>Découvrez l’essence même du luxe – Plongez dans un monde d’exclusivité inégalée grâce à notre collection soigneusement sélectionnée des plus belles villas de vacances de luxe au monde, chacune une œuvre d’art au design primé, un havre de paix et d’intimité, avec un personnel dédié à chacun de vos besoins.</p>
                    <a href="<?php echo get_permalink( get_page_by_path('land-collection') ); ?>">DÉCOUVRIR LA COLLECTION</a>
                </div>
            </div>

        </div>
    </section>

    <section class='villa-section'>
        <h2>Villas</h2>
        <p class="p-title">Élégance et tranquillité dans des lieux d’exception</p>
    </section>
    
    <section class="main-content villa-slider">
        <div class="swiper">
            <div class="swiper-wrapper">
            <?php
            // Exemple : requête des villas
            $q = new WP_Query([
                'post_type'      => 'villa',
                'posts_per_page' => 12,
            ]);
            if ($q->have_posts()):
                while ($q->have_posts()): $q->the_post(); ?>
                <article class="swiper-slide">
                    <?php
                    get_template_part('partials/villa-card', null, ['post_id' => get_the_ID()]);
                    ?>
                </article>
                <?php endwhile; wp_reset_postdata();
            endif; ?>
            </div>
        </div>

        <button class="villa-arrow prev" type="button" aria-label="Diapositive précédente">
            <img src="/wp-content/uploads/2025/09/right-arrow.png" alt="" />
        </button>
        <button class="villa-arrow next" type="button" aria-label="Diapositive suivante">
            <img src="/wp-content/uploads/2025/09/right-arrow.png" alt="" />
        </button>

        <div class="swiper-pagination"></div>
    </section>

    <section class="central-title-section grey">
        <div class="central-title grey">
            <h2>Take a glance <br>at the region</h2>
            <p class="p-title">As a short-term rental management specialists in Salento, we assist our property owners with the management
                of their assets. From creating listings to revenue management and concierge services, our team takes care of your rental
                from the outset to completion.</p>
        </div>
    </section>

    <?php get_template_part('partials/discover-section', null, ['bg_color' => '#F5F5F5']); ?>

    <?php get_template_part('partials/discover-slider'); ?>
    
    <section class="why-us">
        <div class="why-us-container">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/7-Vue-1-scaled.webp">
            <div class="why-us-absolute">
                
                <div class="why-us-text col1">
                    <h2>Pourquoi nous choisir ?</h2>
                    <p>Nous nous occupons de tout, pour que vous puissiez vous détendre et profiter pleinement.</p>
                    <a href="" class="border-button">
                        En savoir plus
                    </a>
                </div>
                <div class="why-us-text col1">
                    <h2>Service exceptionnel</h2>
                    <p>Nous nous occupons de tout, pour que vous puissiez vous détendre et profiter pleinement.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="central-title">
        <h2>GESTION LOCATIVE</h2>
        <p class="p-title">En tant que spécialistes de la gestion locative à court terme dans le Salento, nous accompagnons nos propriétaires dans la gestion de leurs biens. De la création des annonces à la gestion des revenus et des services de conciergerie, notre équipe s’occupe de tout, du début à la fin.</p>
    </section>
    
    <section class="management">
        <div class="management-div">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/1-Vue-generale-1.webp">
            <div class="management-title"><h3>Commercialisation de votre propriété</h3></div>
        </div>
        
        <div class="management-div">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/4.1-Diner-1.webp">
            <div class="management-title"><h3>Gestion annuelle de votre propriété</h3></div>
        </div>

        <div class="management-div">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/2-CH-1.2-scaled.webp">
            <div class="management-title"><h3>Gestion locative</h3></div>
        </div>

        <div class="management-div">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/Lifestyle-24-scaled.webp">
            <div class="management-title"><h3>Conciergerie dédiée</h3></div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
