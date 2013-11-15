<?php $title = _('Accueil - laclef.cc'); ?>

<?php ob_start() ?>
<section class="column-group gutters">
  <div class="large-50 medium-60 small-100 vspace">
    <h1>laclef</h1>
    <p><?php echo _("laclef vous permet d'offrir à vos utilisateurs de nombreux services grâce à leurs badges RFID/NFC : contrôle d'accès, location de matériel, paiement..."); ?></p>
    <div class="column-group">
      <div class="large-70 push-center">
        <img src="templates/images/arch_en_US.svg" alt="Architecture">
      </div>
    </div>
  </div>
  <section class="large-50 medium-40 small-100 vspace">
    <h2><?php echo _("Fonctionnalités"); ?></h2>
    <ul class="unstyled">
      <li class="column-group gutters">
        <div class="large-30 medium-30 small-40">
          <img src="templates/images/opensource.svg" alt="Web application">
        </div>
        <div class="large-70 medium-70 small-60">
          <p><?php echo _("laclef est une application web basée sur des technologies robustes et récentes : PHP, MySQL, <a href=\"http://ink.sapo.pt/\">Ink</a> et <a href=\"http://d3js.org/\">D3.js</a>."); ?></p>
        </div>
      </li>
      <li class="column-group gutters">
        <div class="large-30 medium-30 small-40">
          <img src="templates/images/reader.svg" alt="Readers">
        </div>
        <div class="large-70 medium-70 small-60">
          <p><?php echo _("laclef est connectée à différents lecteurs de tags (RFID/NFC, QR code, code-barres...) permettant d'identifier les utilisateurs. Ces lecteurs sont basés sur <a href=\"http://arduino.cc/\">Arduino</a>."); ?></p>
        </div>
      </li>
      <li class="column-group gutters">
        <div class="large-30 medium-30 small-40">
          <img src="templates/images/rfid.svg" alt="Web application">
        </div>
        <div class="large-70 medium-70 small-60">
          <p><?php echo _("laclef offre différents services aux utilisateurs : contrôle d'accès, location de matériel, paiement..."); ?></p>
        </div>
      </li>
    </ul>
  </section>
</section>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
