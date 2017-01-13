<div id="header">
  <nav class="navbar navbar-<?=$data['navbar-type']?>">
    <div class="container-fluid">
      <div class="container">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <?php if ($data['use-sitename'] !== false): ?>
            <a
              class="navbar-brand navbar-link"
              href="<?=$data['use-sitename']['goto']?>"
            >
              <?=$data['site-name']?>
            </a>
          <?php endif; ?>

        </div>

        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">

            <?php foreach ($data['header-links'] as $content_container):?>
              <li>

                <?php if ($content_container[2] !== false): ?>
                  <img src="<?=$content_container[2]?>" class="navicon" />
                <?php endif; ?>

                <a href="<?=$content_container[1]?>" class="navbar-link">
                  <?=$content_container[0]?>
                </a>

              </li>
            <?php endforeach; ?>


            <?php foreach ($data['header-dropdowns'] as $dd_container): ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle dropdown-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <?=$dd_container[0]?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <?php foreach ($dd_container[1] as $name => $to): ?>

                    <?php if ($to == 'Seperator'): ?>
                      <li role="separator" class="divider"></li>
                    <?php else: ?>
                      <li>
                        <a href="<?=$to?>" class="navbar-link">
                          <?=$name?>
                        </a>
                      </li>
                    <?php endif; ?>

                  <?php endforeach; ?>
                </ul>
              </li>
            <?php endforeach; ?>

          </ul>


          <ul class="nav navbar-nav navbar-right">
            <?php foreach ($data['header-links-right'] as $content_container):?>
              <li>
                <?php if ($content_container[2] !== false): ?>
                  <img src="<?=$content_container[2]?>" class="navicon" />
                <?php endif; ?>

                <a href="<?=$content_container[1]?>" class="navbar-link">
                  <?=$content_container[0]?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div><!--/.nav-collapse-->

      </div><!--/.container-->
    </div><!--/.container-fluid-->
  </nav>
</div>
