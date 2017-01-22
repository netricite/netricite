<?php $this->title = "my Blog - Admin" ?>
<section class="container">
<h1 class="title--emphasis">Blog Administration</h2>

<article class="page__filler container-fluid">

    <h2>Blog statistics</h2>
    <div>
    le blog contient <?= $this->cleanup($posts) ?> post(s) et 
      <?= $this->cleanup($comments) ?> comment(s).
    </div>
    <aside class="link--immediate">
    <a href='index.php?application=blog&class=blog'>Retour au Blog</a>
    </aside>
 
 </article>
 
 <div class="page__filler"></div>
 
 </section>