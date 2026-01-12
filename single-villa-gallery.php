<?php
/** Template for /villas/{slug}/gallery */
get_header('bare');

if (have_posts()) : the_post(); ?>


<article <?php post_class('villa-gallery-page'); ?>>
  <header class="villa-gallery-header">
    <a href="<?php echo esc_url( get_permalink() ); ?>">← Back to villa</a>
    <h1><?php the_title(); ?></h1>
  </header>

  <?php
  // Renders all sections using your ACF fields
  if (function_exists('plh_render_villa_gallery_sections')) {
    plh_render_villa_gallery_sections(get_the_ID(), 10); // 10 = number of sections you set
  } else {
    echo '<p>Gallery renderer not found.</p>';
  }
  ?>

  <!-- Keep your existing lightbox shell (IDs/class names unchanged) -->
  <div id="lightbox">
    <span class="close">&times;</span>
    <img id="lightbox-img" src="" alt="" />
    <div class="controls">
      <span class="prev">&#10094;</span>
      <span class="next">&#10095;</span>
    </div>
  </div>
</article>



        
        
    


        <div id="lightbox">
            <span class="close">&times;</span>
            <img id="lightbox-img" src="" alt="" />
            <div class="controls">
            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>
            </div>
        </div>
    </div>


<style>
   .gallery {
    display: flex !important;
    flex-direction: column !important;
    gap: 10px !important;
    margin: 0 auto !important;
    padding: 0 !important;
    width: 90% !important;
    justify-content: center !important;
    align-items: center !important;
}

.lightbox-trigger {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}

.gallery-container {
    display: flex !important;
    width: 100% !important;
    gap: 10px !important;
    height: 45vw !important;
}

.gallery-container img {
    cursor: pointer !important;
    transition: transform 0.2s ease-in-out !important;
}

.gallery-container img:hover {
    transform: scale(1.02); /* Removed !important to allow JavaScript interactions */
}

.gallery-container-2 img {
    cursor: pointer !important;
    transition: transform 0.2s ease-in-out !important;
}

.gallery-container-2 img:hover {
    transform: scale(1.02); /* Removed !important to allow JavaScript interactions */
}

.gallery-column-1, .gallery-column-2 {
    display: flex !important;
    flex-direction: column !important;
    width: calc(50% - 5px) !important;
    height: 100% !important;
    gap: 10px !important;
}

.container-photo-11 {
    display: flex !important;
    width: 100% !important;
    height: calc(55% - 5px) !important;
}

.container-photo-12 {
    display: flex !important;
    width: 100% !important;
    height: calc(45% - 5px) !important;
    gap: 10px !important;
}

.container-photo-121 {
    display: flex !important;
    width: calc(50% - 5px) !important;
    height: 100% !important;
}

.gallery-container-2 {
    display: flex !important;
    flex-direction: column !important;
    width: 100% !important;
    height: 70vw !important;
    gap: 10px !important;
}

.gallery2-row1 {
    display: flex !important;
    height: calc(25% - 5px) !important;
    width: 100% !important;
}

.gallery2-row2 {
    display: flex !important;
    gap: 10px !important;
    height: calc(75% - 5px) !important;
}

.row2-col1 {
    display: flex !important;
    width: calc(50% - 5px) !important;
    height: 100% !important;
}

.row2-col2 {
    display: flex !important;
    flex-direction: column !important;
    width: calc(50% - 5px) !important;
    height: 100% !important;
    gap: 10px !important;
}

.row2-col2-row1, .row2-col2-row2 {
    display: flex !important;
    width: 100% !important;
    height: calc(50% - 5px) !important;
}

/* ✅ FIXED: Lightbox now works properly */
#lightbox {
    display: none; /* Removed !important so JavaScript can control visibility */
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    background-color: rgba(0, 0, 0, 0.8) !important;
    justify-content: center !important;
    align-items: center !important;
    z-index: 1000 !important;
}

#lightbox img {
    max-width: 90% !important;
    max-height: 90% !important;
}

#lightbox .close {
    position: absolute !important;
    top: 20px !important;
    right: 20px !important;
    font-size: 30px !important;
    color: white !important;
    cursor: pointer !important;
}

#lightbox .controls {
    position: absolute !important;
    width: 100% !important;
    display: flex !important;
    justify-content: space-between !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
}

#lightbox .controls span {
    font-size: 40px !important;
    color: white !important;
    cursor: pointer !important;
    padding: 0 20px !important;
}

@media (max-width: 767px) {
    .gallery {
        width: 90% !important;
        gap: 5px !important;
    }

    .gallery-container {
        gap: 5px !important;
       
    }

    .gallery-container-2 {
        gap: 5px !important;
        
    }

    .gallery-column-1, .gallery-column-2 {
        gap: 5px !important;
        width: calc(50% - 2.5px) !important;
    }

    .container-photo-11 {
        height: calc(55% - 2.5px) !important;
    }

    .container-photo-12 {
        gap: 5px !important;
        height: calc(45% - 2.5px) !important;
    }

    .container-photo-121 {
        width: calc(50% - 2.5px) !important;
        height: 100% !important;
    }

    .gallery2-row1 {
        height: calc(25% - 2.5px) !important;
        width: 100% !important;
    }

    .gallery2-row2 {
        gap: 5px !important;
        height: calc(75% - 2.5px) !important;
    }

    .row2-col1 {
        width: calc(50% - 2.5px) !important;
        height: 100% !important;
    }

    .row2-col2 {
        width: calc(50% - 2.5px) !important;
        height: 100% !important;
        gap: 5px !important;
    }

    .row2-col2-row1, .row2-col2-row2 {
        height: calc(50% - 2.5px) !important;
    }
}







</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightbox-img");
    const images = document.querySelectorAll(".lightbox-trigger");
    const closeBtn = document.querySelector(".close");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");

    let currentIndex = 0;
    let startX = 0;
    let endX = 0;

    const showLightbox = (index) => {
      lightbox.style.display = "flex";
      lightboxImg.src = images[index].src;
      currentIndex = index;
      document.body.style.overflow = "hidden";
    };

    const hideLightbox = () => {
      lightbox.style.display = "none";
      document.body.style.overflow = "";
    };

    const showNextImage = () => {
      currentIndex = (currentIndex + 1) % images.length;
      lightboxImg.src = images[currentIndex].src;
    };

    const showPrevImage = () => {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      lightboxImg.src = images[currentIndex].src;
    };

    images.forEach((img, index) => {
      img.addEventListener("click", () => showLightbox(index));
    });

    closeBtn.addEventListener("click", hideLightbox);
    nextBtn.addEventListener("click", showNextImage);
    prevBtn.addEventListener("click", showPrevImage);

    lightbox.addEventListener("click", (e) => {
      if (e.target === lightbox || e.target === closeBtn) hideLightbox();
    });

    // Add keyboard navigation
    document.addEventListener("keydown", (e) => {
      if (lightbox.style.display === "flex") { // Check if the lightbox is open
        switch (e.key) {
          case "ArrowRight": // Next image
            showNextImage();
            break;
          case "ArrowLeft": // Previous image
            showPrevImage();
            break;
          case "Escape": // Close lightbox
            hideLightbox();
            break;
        }
      }
    });

    // ✅ Add Mobile Swipe Support
    lightbox.addEventListener("touchstart", (e) => {
      startX = e.touches[0].clientX; // Get the starting X position
    });

    lightbox.addEventListener("touchend", (e) => {
      endX = e.changedTouches[0].clientX; // Get the ending X position
      handleSwipe();
    });

    const handleSwipe = () => {
      const swipeThreshold = 50; // Minimum swipe distance in pixels

      if (startX - endX > swipeThreshold) {
        // Swiped left → Next image
        showNextImage();
      } else if (endX - startX > swipeThreshold) {
        // Swiped right → Previous image
        showPrevImage();
      }
    };
  });
</script>


<?php
endif;
get_footer(); ?>