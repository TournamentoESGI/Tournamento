<section class="hero-section">
  <div class="container-fluid px-4 px-lg-5">
    <div class="row align-items-stretch" style="min-height: 60vh;">

      <div class="col-12 col-lg-7 pt-2 pb-4">
        <div class="badge-platform">plateforme de tournoi n°1</div>

        <h1 class="hero-title">
          Chaque tournoi commence<br>
          <span class="text-yellow">ici</span> et chaque <span class="text-yellow">victoire</span> aussi.<br>
          Organise, joue et <span class="text-yellow">domine</span><br>
          tes adversaires.
        </h1>

        <p class="hero-subtitle">
          Tournamento est une plateforme moderne et dynamique !<br>
          Vous pouvez même parier en toute sécurité.
        </p>
      </div>

    <div class="col-12 col-lg-5 d-flex flex-row justify-content-end align-items-end pb-4 gap-3" style="min-height: 100%;">        <a href="<?php getPagePath('login') ?>" class="btn-organize">Organiser un tournoi</a>
        <a href="<?php getPagePath('signin') ?>" class="btn-discover">Découvrir</a>
    </div>

    </div>
  </div>
</section>

<div class="stats-bar">
  <div class="container-fluid px-4 px-lg-5">
    <div class="row align-items-center justify-content-around text-center">

      <div class="col">
        <h2>80 000+</h2>
        <p>d'utilisateurs inscrits</p>
      </div>

      <div class="d-none d-md-flex col-auto">
        <div class="stat-divider"></div>
      </div>

      <div class="col">
        <h2>6732+</h2>
        <p>Tournois Organisés</p>
      </div>

      <div class="d-none d-md-flex col-auto">
        <div class="stat-divider"></div>
      </div>

      <div class="col">
        <h2>93%</h2>
        <p>Sont satisfaits</p>
      </div>

      <div class="d-none d-md-flex col-auto">
        <div class="stat-divider"></div>
      </div>

      <div class="col">
        <h2>32 000+</h2>
        <p>Paries effectués</p>
      </div>

    </div>
  </div>
</div>

<section class="info-section">
  <div class="container-fluid px-4 px-lg-5">

    <div class="mb-1">
      <span class="badge-explication">Explication</span>
    </div>
    <h4>Simple, rapide, sautez dans l'arène.</h4>

    <div class="row g-4">

      <div class="col-12 col-md-6">
        <div class="info-card">
          <h5>● Organisateur</h5>
          <p>
            Crée ton tournoi → Paramètre ton tournoi en 5 minutes.<br>
            Gère les inscriptions → Valide les participants en temps réel.<br>
            Suis les paris &amp; résultats → Visualise les mises en direct.
          </p>
        </div>
      </div>

      <div class="col-12 col-md-6">
        <div class="info-card">
          <h5>● Participants</h5>
          <p>
            Trouve un tournoi → Filtre tes recherches et saute dans une arène.<br>
            Inscris-toi → Place validée, Plus qu'à se préparer.<br>
            Joue et domine → Suis ton pool et grimpe dans le classement.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="tournoi-section">
  <div class="container-fluid px-4 px-lg-5">
    <div class="row g-4 align-items-start">

      <div class="col-12 col-lg-4">
        <span class="badge-moment">En ce moment</span>
        <h4>Tendances :</h4>
        <p class="lead-sub">Les tournois qui font parler d'eux, Découvrez les !</p>
      </div>

      <div class="col-12 col-lg-8">
        <div class="tournoi-box">

          <div class="tournoi-box-title">
            <img src="./assets/yeux.png" alt="Icone Yeux" class="icone-yeux">
            <h2>● Tournois Tendances</h2>
          </div>

          <div class="d-flex gap-3">

            <div class="tournoi-card">
              <div class="img-placeholder"></div>
              <div class="card-meta">
                <div class="spect">
                  <img src="./assets/yeux.png" alt="" class="icone-spect">
                  <span>0</span>
                </div>
                <h3>Tournoi LOL Winter - Demi Final</h3>
              </div>
            </div>

            <div class="tournoi-card">
              <div class="img-placeholder" style="background: linear-gradient(135deg,#ffccbc,#f8bbd0);"></div>
              <div class="card-meta">
                <div class="spect">
                  <img src="./assets/yeux.png" alt="" class="icone-spect">
                  <span>0</span>
                </div>
                <h3>Tournoi Judo 18ème - Quart de Final</h3>
              </div>
            </div>

            <div class="tournoi-card">
              <div class="img-placeholder" style="background: linear-gradient(135deg,#b3e5fc,#b2dfdb);"></div>
              <div class="card-meta">
                <div class="spect">
                  <img src="./assets/yeux.png" alt="" class="icone-spect">
                  <span>0</span>
                </div>
                <h3>Tournoi Street basket - Quart de Final</h3>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="testimonials-section">
  <div class="container-fluid px-4 px-lg-5">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h2>Nos utilisateurs disent :</h2>
        <p class="testi-sub mb-0">Ils nous font confiance et sont satisfaits de nos services !</p>
      </div>
      <div class="rating-badge">4.7/5 Note Moyenne</div>
    </div>

    <div class="row g-3">

      <?php $testimonials = [
        ['name' => 'Marc D.', 'role' => 'Participant ● Paris', 'text' => '"Plateforme solide, service client rapide, que du bon !"'],
        ['name' => 'Marc D.', 'role' => 'Participant ● Paris', 'text' => '"Plateforme solide, service client rapide, que du bon !"'],
        ['name' => 'Marc D.', 'role' => 'Participant ● Paris', 'text' => '"Plateforme solide, service client rapide, que du bon !"'],
        ['name' => 'Marc D.', 'role' => 'Participant ● Paris', 'text' => '"Plateforme solide, service client rapide, que du bon !"'],
      ]; ?>

      <?php foreach ($testimonials as $t): ?>
      <div class="col-12 col-sm-6 col-xl-3">
        <div class="testi-card">
          <div class="stars">★ ★ ★ ★ ★</div>
          <div class="d-flex align-items-center gap-2 mb-3">
            <div class="avatar"></div>
            <div>
              <h5><?= htmlspecialchars($t['name']) ?></h5>
              <h6><?= htmlspecialchars($t['role']) ?></h6>
            </div>
          </div>
          <p><?= htmlspecialchars($t['text']) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>