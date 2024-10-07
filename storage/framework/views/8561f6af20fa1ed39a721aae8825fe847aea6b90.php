<?php ($hasClearIcon = !isset($hasClearIcon) ? true : $hasClearIcon); ?>

<?php if(empty($isAjax)): ?>
    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="error-text error-input-text active" style="<?php echo e(isset($positionAbsolute) && !$positionAbsolute ? 'position: unset;' : ''); ?>">
        <?php echo e($message); ?>

    </p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
<?php else: ?>
    <p class="error-text error-input-text" data-field-name="<?php echo e($name); ?>"
       style="<?php echo e(isset($positionAbsolute) && !$positionAbsolute ? 'position: unset;' : ''); ?>"></p>
<?php endif; ?>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/layouts/partials/app/alerts/input-error.blade.php ENDPATH**/ ?>