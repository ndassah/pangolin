<?php if (isset($component)) { $__componentOriginalaa758e6a82983efcbf593f765e026bd9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa758e6a82983efcbf593f765e026bd9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::message'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('mail::message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<p>Bonjour <?php echo e($user->nom); ?>,</p>

<?php if($otp->type=='verification'): ?>
Nous avons recus votre demande de verification de votre compte pangolin par votre adresse e-mail.
Votre code de verification Pangolin est le :
<?php endif; ?>

<?php if($otp->type=='password-reset'): ?>
Nous avons reçu votre demande de réinitialisation de votre mot de passe.
Vous pouvez utiliser ce code pour réinitialiser votre mot de passe :
<?php endif; ?> 
<p>
    <strong><?php echo e($otp->code); ?></strong>
</p>
<h4>
    veuillez ne pas partager ce code avec quiconque.
</h4>
Merci,<br>

<p style="color: #1fc5e2; font-size: 30px; font-weight: bold"> <?php echo e(config('app.name')); ?></p>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $attributes = $__attributesOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $component = $__componentOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__componentOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\php\www\Stago\resources\views/mail/auth/otp.blade.php ENDPATH**/ ?>