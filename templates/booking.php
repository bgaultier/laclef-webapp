<?php $title = _('Réservation de la salle de réunion - laclef.cc'); ?>

<?php ob_start() ?>
  <section>
    <div class="box">
        <form id="bookingForm" class="ink-form" method="post" action="" onsubmit="return Ink.UI.FormValidator.validate(this);">
            <fieldset>
                <div class="control-group required">
                    <p class="label"><?php echo _('Votre nom : '); ?></p>
                    <select name="uid" class="control unstyled">
                        <?php
                            foreach ($users	as $user)
                                echo "<option value=" . $user['uid'] . ">" . $user['firstname'] . " " . $user['lastname'] . "</option>";
                        ?>
                    </select>
                </div>
                <div class="control-group required">
                    <label for="amount"><?php echo _('Début de la réunion : '); ?></label>
                    <div class="control">
                        <input id="start" name="start" class="bookingink-fv-required" type="text" value="<?php echo date('Y-m-d H:\0\0:\0\0'); ?>"></input>
                    </div>
                </div>
                <div class="control-group required">
                    <label for="amount"><?php echo _('Durée de la réunion (heures) : '); ?></label>
                    <div class="control">
                        <input id="duration" name="duration" class="bookingink-fv-required" type="number" value="1"></input>
                    </div>
                </div>
            </fieldset>
            <input type="submit" name="sub" value="<?php echo _("Faire une demande de réservation"); ?>" class="ink-button success" />
        </form>
    </div>
  </section>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
