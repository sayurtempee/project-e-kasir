<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center space-x-2 mt-4">
        
        <?php if($paginator->onFirstPage()): ?>
            <span class="px-3 py-1 text-sm text-gray-400 rounded border"
                style="background:#fff; border-color:#fff;">&lt;</span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>"
                class="px-3 py-1 text-sm text-blue-700 hover:bg-blue-100 rounded border"
                style="background:#fff; border-color:#fff;">&lt;</a>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <span class="px-3 py-1 text-sm text-gray-400 rounded border"
                    style="background:#fff; border-color:#fff;"><?php echo e($element); ?></span>
            <?php endif; ?>

            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span class="px-3 py-1 text-sm text-white bg-blue-800 rounded border"
                            style="border-color:#fff;"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>"
                            class="px-3 py-1 text-sm text-blue-800 hover:bg-blue-100 rounded border"
                            style="background:#fff; border-color:#fff;"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>"
                class="px-3 py-1 text-sm text-blue-800 hover:bg-blue-100 rounded border"
                style="background:#fff; border-color:#fff;">&gt;</a>
        <?php else: ?>
            <span class="px-3 py-1 text-sm text-gray-400 rounded border"
                style="background:#fff; border-color:#fff;">&gt;</span>
        <?php endif; ?>
    </nav>
<?php endif; ?>
<?php /**PATH /var/www/html/e-kasir/resources/views/vendor/pagination/simple-numbers.blade.php ENDPATH**/ ?>