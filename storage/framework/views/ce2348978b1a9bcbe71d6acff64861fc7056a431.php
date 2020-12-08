<ul class="devsite-breadcrumb-list">
    <li class="devsite-breadcrumb-item">
        <a href="/" class="devsite-breadcrumb-link gc-analytics-event"
           data-category="Site-Wide Custom Events"
           data-label="Breadcrumbs"
           data-value="1">Главная</a>
    </li>
    <li class="devsite-breadcrumb-item">
        <div class="devsite-breadcrumb-guillemet material-icons" aria-hidden="true"></div>
        <a href="<?php echo e(route('api_doc')); ?>" class="devsite-breadcrumb-link gc-analytics-event"
           data-category="Site-Wide Custom Events"
           data-label="Breadcrumbs"
           data-value="2">API</a>
    </li>
    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="devsite-breadcrumb-item">
        <div class="devsite-breadcrumb-guillemet material-icons" aria-hidden="true"></div>
        <a href="<?php echo e($m['url']); ?>" class="devsite-breadcrumb-link gc-analytics-event"
           data-category="Site-Wide Custom Events"
           data-label="Breadcrumbs"
           data-value="3"><?php echo e($m['name']); ?></a>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>