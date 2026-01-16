<?php 
$step1_title = get_field('step_title_1');
$step1_text = get_field('step_text_1');
$step2_title = get_field('step_title_2');
$step2_text = get_field('step_text_2');
$step3_title = get_field('step_title_3');
$step3_text = get_field('step_text_3');
$step4_title = get_field('step_title_4');
$step4_text = get_field('step_text_4');
$step5_title = get_field('step_title_5');
$step5_text = get_field('step_text_5');
?>


<section class="service-process">
    <div class="service-process-div">
        <h3><?php echo esc_html( get_field('process_title') ?: plh_t('With you from start to finish') ); ?></h3>
        <div class="service-process-row">
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>1</p>
                    </div>
                    <div class="process-line"></div>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>2</p>
                    </div>
                    <div class="process-line"></div>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>3</p>
                    </div>
                    <div class="process-line"></div>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>4</p>
                    </div>
                    <div class="process-line"></div>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>5</p>
                    </div>
                   
                </div>
            </div>
        </div>
        <div class="service-process-row">
            <div class="service-process-columns">
                <h4><?php echo $step1_title; ?></h4>
                
            </div>
            <div class="service-process-columns">
                <h4><?php echo $step2_title; ?></h4>
                
            </div>
            <div class="service-process-columns">
                <h4><?php echo $step3_title; ?></h4>
                
            </div>
            <div class="service-process-columns">
                 <h4><?php echo $step4_title; ?></h4>
                
            </div>
            <div class="service-process-columns">
                <h4><?php echo $step5_title; ?></h4>
                
            </div>
        </div>
         <div class="service-process-row">
            <div class="service-process-columns">
                
                <p><?php echo $step1_text; ?></p>
            </div>
            <div class="service-process-columns">
                
                <p><?php echo $step2_text; ?></p>
            </div>
            <div class="service-process-columns">
                
                <p><?php echo $step3_text; ?></p>
            </div>
            <div class="service-process-columns">
                 
                <p><?php echo $step4_text; ?></p>
            </div>
            <div class="service-process-columns">
                
                <p><?php echo $step5_text; ?></p>
            </div>
        </div>
            

        
    </div>

</section>
<section class="mobile-service-process">
    <h3><?php echo esc_html( get_field('process_title') ?: plh_t('With you from start to finish') ); ?></h3>
    <div class="service-process-div">
        
        <div class="service-process-row1">
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>1</p>
                    </div>
                    <div class="process-line"></div>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>2</p>
                    </div>
                    <div class="process-line"></div>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>3</p>
                    </div>
                    <div class="process-line"></div>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>4</p>
                    </div>
                    <div class="process-line"></div>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="process-header">
                    <div class="process-number">
                        <p>5</p>
                    </div>
                   
                </div>
            </div>
        </div>
        <div class="service-process-row">
            <div class="service-process-columns">
                <div class="service-process-columns1">
                    <h4><?php echo $step1_title; ?></h4>
                    <p><?php echo $step1_text; ?></p>
                </div>
                
            </div>
            <div class="service-process-columns">
                <div class="service-process-column1s">
                    <h4><?php echo $step2_title; ?></h4>
                    <p><?php echo $step2_text; ?></p>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="service-process-columns1">
                    <h4><?php echo $step3_title; ?></h4>
                    <p><?php echo $step3_text; ?></p>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="service-process-columns1">
                    <h4><?php echo $step4_title; ?></h4>
                    <p><?php echo $step4_text; ?></p>
                </div>
            </div>
            <div class="service-process-columns">
                <div class="service-process-columns1">
                    <h4><?php echo $step5_title; ?></h4>
                    <p><?php echo $step5_text; ?></p>
                </div>
            </div>


        </div>

    </div>
    

</section>
